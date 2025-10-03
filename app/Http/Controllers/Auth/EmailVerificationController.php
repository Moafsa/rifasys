<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\EmailVerification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class EmailVerificationController extends Controller
{
    /**
     * Show the email verification notice.
     */
    public function notice(): View|RedirectResponse
    {
        $user = auth()->user();
        
        if (!$user) {
            return redirect()->route('login')->with('error', 'Você precisa fazer login primeiro.');
        }
        
        $latestVerification = $user->emailVerifications()->latest()->first();
        
        return view('auth.verify-email-notice', compact('user'));
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
     * Verify email with 4-digit code (legacy method).
     */
    public function verify(Request $request): RedirectResponse
    {
        // Redirect to home since we're using links now
        return redirect()->route('home')->with('error', 'Método de verificação não suportado. Use o link enviado por email.');
    }

    /**
     * Resend the email verification notification.
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

        $verification = EmailVerification::createForUser($user);
        
        // Send verification email with link
        $this->sendVerificationEmail($user, $verification);

        return back()->with('success', 'Novo link de verificação enviado para seu Gmail!');
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
}