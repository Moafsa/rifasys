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
     * Send WhatsApp verification link.
     */
    public function sendWhatsAppVerification(User $user): RedirectResponse
    {
        try {
            // Verificar se o usuário tem telefone
            if (!$user->phone) {
                return redirect()->route('verification.method')
                    ->with('error', 'Número de telefone não configurado. Configure seu telefone para usar verificação via WhatsApp.');
            }

            // Validar formato do telefone
            if (!$this->wuzapiService->validatePhone($user->phone)) {
                return redirect()->route('verification.method')
                    ->with('error', 'Número de telefone inválido. Verifique o formato do seu número.');
            }

            // Criar registro de verificação
            $verification = EmailVerification::createForUser($user);
            
            // Gerar link de verificação
            $verificationLink = route('verification.confirm.show', [
                'token' => $verification->token,
                'email' => $user->email
            ]);
            
            // Enviar via WhatsApp usando a nova implementação
            $this->sendWhatsAppVerificationMessage($user, $verificationLink);

            return redirect()->route('verification.notice')
                ->with('success', 'Link de verificação enviado via WhatsApp para ' . $user->phone . '. Verifique sua mensagem!');
                
        } catch (\Exception $e) {
            \Log::error('Failed to send WhatsApp verification', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
            
            return redirect()->route('verification.method')
                ->with('error', 'Falha ao enviar verificação via WhatsApp. Tente novamente ou use verificação por email.');
        }
    }

    /**
     * Send WhatsApp verification message.
     */
    private function sendWhatsAppVerificationMessage(User $user, string $verificationLink): void
    {
        try {
            // Formatar número para WhatsApp
            $numeroWhatsApp = $this->formatarNumeroWhatsApp($user->phone);
            
            // Preparar dados para o WhatsApp
            $dadosCliente = [
                'nome' => $user->name,
                'numeroWhatsApp' => $numeroWhatsApp,
                'linkVerificacao' => $verificationLink,
                'email' => $user->email
            ];

            // Enviar via WuzAPI
            $this->enviarWhatsAppViaAPI($dadosCliente);

            \Log::info('WhatsApp verification sent to user', [
                'user_id' => $user->id,
                'phone' => $numeroWhatsApp
            ]);

        } catch (\Exception $e) {
            \Log::error('Failed to send WhatsApp verification message', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Format phone number for WhatsApp.
     */
    private function formatarNumeroWhatsApp($phone): string
    {
        // Remove todos os caracteres não numéricos
        $numero = preg_replace('/\D/', '', $phone);
        
        // Se não começar com 55, adicionar código do Brasil
        if (!str_starts_with($numero, '55')) {
            $numero = '55' . $numero;
        }
        
        return $numero;
    }

    /**
     * Send WhatsApp message via WuzAPI.
     */
    private function enviarWhatsAppViaAPI($dadosCliente): void
    {
        try {
            $client = new \GuzzleHttp\Client();
            
            $response = $client->post('http://localhost:8083/whatsapp/enviar', [
                'json' => [
                    'numero' => $dadosCliente['numeroWhatsApp'],
                    'mensagem' => $this->formatarMensagemVerificacao($dadosCliente),
                    'tipo' => 'link_verificacao',
                    'remetente' => config('whatsapp.business_number', '5511999999999'),
                    'timestamp' => now()->toISOString()
                ],
                'timeout' => 10
            ]);

            if ($response->getStatusCode() === 200) {
                \Log::info('WhatsApp message sent successfully', [
                    'phone' => $dadosCliente['numeroWhatsApp'],
                    'response' => $response->getBody()->getContents()
                ]);
            }

        } catch (\Exception $e) {
            \Log::error('WhatsApp API error', [
                'error' => $e->getMessage(),
                'phone' => $dadosCliente['numeroWhatsApp']
            ]);
            throw $e;
        }
    }

    /**
     * Format verification message for WhatsApp.
     */
    private function formatarMensagemVerificacao($dados): string
    {
        return "🔐 **VERIFICAÇÃO DE CADASTRO - RIFASSYS** 🔐\n\n" .
               "Olá {$dados['nome']}! 👋\n\n" .
               "Seu cadastro foi realizado com sucesso no Rifassys!\n\n" .
               "Para ativar sua conta e participar das rifas, clique no link abaixo:\n\n" .
               "🔗 {$dados['linkVerificacao']}\n\n" .
               "📱 **Ou copie e cole no seu navegador:**\n" .
               "{$dados['linkVerificacao']}\n\n" .
               "⏰ Este link é válido por 24 horas.\n\n" .
               "❓ **Dúvidas?**\n" .
               "Entre em contato conosco pelo WhatsApp.\n\n" .
               "🎫 **Rifassys - Sua plataforma de rifas online!**\n\n" .
               "---\n" .
               "🌐 Site: " . config('app.url');
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
            // Se não foi fornecido um telefone, usar o telefone atual do usuário
            $phone = $request->phone ?: $user->phone;
            
            if (!$phone) {
                return back()->with('error', 'Número de telefone é obrigatório para verificação via WhatsApp.');
            }

            // Validate phone format
            if (!$this->wuzapiService->validatePhone($phone)) {
                return back()->with('error', 'Número de telefone inválido. Use o formato: (11) 99999-9999');
            }

            // Atualizar telefone se foi fornecido um novo
            if ($request->phone && $request->phone !== $user->phone) {
                $user->update(['phone' => $phone]);
            }

            $user->update(['verification_method' => 'whatsapp']);

            // Enviar verificação via WhatsApp
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

