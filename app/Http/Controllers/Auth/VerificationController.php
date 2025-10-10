<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\EmailVerification;
use App\Models\WhatsAppVerification;
use App\Models\User;
use App\Services\WuzapiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class VerificationController extends Controller
{
    protected WuzapiService $wuzapiService;

    public function __construct(WuzapiService $wuzapiService)
    {
        $this->wuzapiService = $wuzapiService;
    }

    /**
     * Show verification method selection page.
     */
    public function showMethodSelection(): View
    {
        $user = auth()->user();
        
        if (!$user) {
            return redirect()->route('login')->with('error', 'Você precisa fazer login primeiro.');
        }
        
        if ($user->hasVerifiedEmail()) {
            return redirect()->route('home');
        }

        return view('auth.verification-method', compact('user'));
    }

    /**
     * Show the email verification notice.
     */
    public function notice(): View|RedirectResponse
    {
        $user = auth()->user();
        
        if (!$user) {
            return redirect()->route('login')->with('error', 'Você precisa fazer login primeiro.');
        }
        
        if ($user->hasVerifiedEmail()) {
            return redirect()->route('home');
        }

        // Check if user prefers WhatsApp verification
        if ($user->prefersWhatsAppVerification()) {
            return $this->sendWhatsAppVerification($user);
        }
        
        return view('auth.verify-email-notice', compact('user'));
    }

    /**
     * Send WhatsApp verification code.
     */
    public function sendWhatsAppVerification(User $user): View
    {
        if (!$user->hasPhone()) {
            return redirect()->route('verification.method')
                ->with('error', 'Número de telefone não configurado. Configure seu telefone para usar verificação via WhatsApp.');
        }

        // Validate phone format
        if (!$this->wuzapiService->validatePhone($user->phone)) {
            return redirect()->route('verification.method')
                ->with('error', 'Número de telefone inválido. Verifique o formato do seu número.');
        }

        // Check WuzAPI connection
        if (!$this->wuzapiService->checkConnection()) {
            return redirect()->route('verification.method')
                ->with('error', 'Serviço de WhatsApp temporariamente indisponível. Tente novamente mais tarde ou use verificação por email.');
        }

        // Create email verification record (same as email)
        $verification = EmailVerification::createForUser($user);
        
        // Generate verification link
        $verificationLink = route('verification.confirm.show', [
            'token' => $verification->token,
            'email' => $user->email
        ]);
        
        // Send WhatsApp message with link
        $result = $this->wuzapiService->sendVerificationLink($user->phone, $verificationLink, $user->name);
        
        if (!$result) {
            return redirect()->route('verification.method')
                ->with('error', 'Falha ao enviar código via WhatsApp. Tente novamente ou use verificação por email.');
        }

        return view('auth.verify-whatsapp-link', compact('user', 'verification'));
    }

    /**
     * Verify WhatsApp code.
     */
    public function verifyWhatsApp(Request $request): RedirectResponse
    {
        $request->validate([
            'code' => 'required|string|size:4',
        ]);

        $user = auth()->user();
        
        if (!$user) {
            return redirect()->route('login')->with('error', 'Você precisa fazer login primeiro.');
        }

        $verification = WhatsAppVerification::findByUserAndToken($user->id, $request->code);
        
        if (!$verification) {
            return back()->with('error', 'Código inválido ou expirado. Tente novamente.');
        }

        // Mark as verified
        $user->markEmailAsVerified();
        $verification->markAsVerified();

        return redirect()->route('home')->with('success', 'WhatsApp verificado com sucesso! Bem-vindo à RAFE!');
    }

    /**
     * Show confirmation page for email verification link.
     */
    public function showConfirm(Request $request): View
    {
        $token = $request->get('token');
        $email = $request->get('email');
        
        $user = User::where('email', $email)->first();
        
        if (!$user || !$token) {
            return redirect()->route('home')->with('error', 'Link de verificação inválido.');
        }

        return view('auth.confirm-email-verification', compact('user', 'token'));
    }

    /**
     * Confirm email verification with link.
     */
    public function confirm(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => 'required|string',
            'email' => 'required|email',
            'action' => 'required|in:confirm,deny'
        ]);

        $user = User::where('email', $request->email)->first();
        
        if (!$user) {
            return redirect()->route('home')->with('error', 'Usuário não encontrado.');
        }

        $verification = EmailVerification::where('user_id', $user->id)
            ->where('token', $request->token)
            ->where('expires_at', '>', now())
            ->whereNull('verified_at')
            ->first();

        if (!$verification) {
            return redirect()->route('home')->with('error', 'Link de verificação inválido ou expirado.');
        }

        if ($request->action === 'confirm') {
            $user->markEmailAsVerified();
            $verification->markAsVerified();
            
            // Auto login
            auth()->login($user);
            
            return redirect()->route('home')->with('success', 'Email verificado com sucesso! Bem-vindo à RAFE!');
        } else {
            // Denied - just redirect
            return redirect()->route('home')->with('info', 'Verificação cancelada. Você pode tentar novamente mais tarde.');
        }
    }

    /**
     * Resend verification notification.
     */
    public function resend(Request $request): RedirectResponse
    {
        $user = $request->user();
        
        if (!$user) {
            return redirect()->route('login')->with('error', 'Você precisa fazer login primeiro.');
        }
        
        if ($user->hasVerifiedEmail()) {
            return redirect()->route('home');
        }

        // Check user preference
        if ($user->prefersWhatsAppVerification() && $user->hasPhone()) {
            return $this->sendWhatsAppVerification($user);
        } else {
            // Send email verification
            $verification = EmailVerification::createForUser($user);
            $this->sendVerificationEmail($user, $verification);
            return back()->with('success', 'Novo link de verificação enviado para seu email!');
        }
    }

    /**
     * Set verification method preference.
     */
    public function setMethod(Request $request): RedirectResponse
    {
        $request->validate([
            'method' => 'required|in:email,whatsapp',
            'phone' => 'required_if:method,whatsapp|nullable|string|max:20'
        ]);

        $user = auth()->user();
        
        if (!$user) {
            return redirect()->route('login')->with('error', 'Você precisa fazer login primeiro.');
        }

        if ($request->method === 'whatsapp') {
            if (!$request->phone) {
                return back()->with('error', 'Número de telefone é obrigatório para verificação via WhatsApp.');
            }

            // Validate phone format
            if (!$this->wuzapiService->validatePhone($request->phone)) {
                return back()->with('error', 'Número de telefone inválido. Use o formato: (11) 99999-9999');
            }

            $user->update([
                'verification_method' => 'whatsapp',
                'phone' => $request->phone
            ]);

            return $this->sendWhatsAppVerification($user);
        } else {
            $user->update(['verification_method' => 'email']);
            
            $verification = EmailVerification::createForUser($user);
            $this->sendVerificationEmail($user, $verification);
            
            return redirect()->route('verification.notice')
                ->with('success', 'Método de verificação alterado para email. Verifique sua caixa de entrada.');
        }
    }

    /**
     * Send verification email to user with link.
     */
    private function sendVerificationEmail(User $user, EmailVerification $verification): void
    {
        $verificationLink = route('verification.confirm.show', [
            'token' => $verification->token,
            'email' => $user->email
        ]);

        Mail::send('emails.verify-email-link', [
            'user' => $user,
            'verification' => $verification,
            'verificationLink' => $verificationLink
        ], function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('Verificar Email - RAFE');
        });
    }

    /**
     * Check WuzAPI status.
     */
    public function checkWuzAPIStatus(): array
    {
        return [
            'connected' => $this->wuzapiService->checkConnection(),
            'qr_code' => $this->wuzapiService->getQRCode()
        ];
    }
}

