<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\WhatsAppVerification;
use App\Models\EmailVerification;
use App\Services\WuzapiService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class WebhookController extends Controller
{
    protected WuzapiService $wuzapiService;

    public function __construct(WuzapiService $wuzapiService)
    {
        $this->wuzapiService = $wuzapiService;
    }

    /**
     * Handle WhatsApp webhook from WuzAPI
     */
    public function handleWhatsApp(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            
            Log::info('WhatsApp Webhook Received', [
                'data' => $data,
                'headers' => $request->headers->all()
            ]);

            // Validate webhook signature if needed
            if (!$this->validateWebhookSignature($request)) {
                Log::warning('Invalid webhook signature', ['data' => $data]);
                return response()->json(['error' => 'Invalid signature'], 401);
            }

            // Process different types of webhook events
            $eventType = $data['event_type'] ?? $data['type'] ?? 'unknown';
            
            switch ($eventType) {
                case 'message':
                    return $this->handleMessage($data);
                    
                case 'button_click':
                case 'interactive_response':
                    return $this->handleButtonClick($data);
                    
                case 'status':
                case 'message_status':
                    return $this->handleMessageStatus($data);
                    
                case 'connection':
                case 'qr_code':
                    return $this->handleConnectionEvent($data);
                    
                default:
                    Log::info('Unknown webhook event type', ['type' => $eventType, 'data' => $data]);
                    return response()->json(['status' => 'ignored']);
            }

        } catch (\Exception $e) {
            Log::error('WhatsApp Webhook Error', [
                'error' => $e->getMessage(),
                'data' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json(['error' => 'Internal server error'], 500);
        }
    }

    /**
     * Handle incoming messages
     */
    private function handleMessage(array $data): JsonResponse
    {
        $phone = $this->formatPhoneFromWebhook($data['from'] ?? '');
        $message = $data['message'] ?? $data['text'] ?? '';
        
        Log::info('WhatsApp Message Received', [
            'phone' => $phone,
            'message' => $message
        ]);

        // Check if this is a verification code response
        if (preg_match('/^\d{4}$/', trim($message))) {
            return $this->handleVerificationCode($phone, trim($message));
        }

        return response()->json(['status' => 'message_processed']);
    }

    /**
     * Handle button clicks (interactive responses)
     */
    private function handleButtonClick(array $data): JsonResponse
    {
        $phone = $this->formatPhoneFromWebhook($data['from'] ?? '');
        $buttonId = $data['button_id'] ?? $data['interactive']['button_reply']['id'] ?? '';
        
        Log::info('WhatsApp Button Click Received', [
            'phone' => $phone,
            'button_id' => $buttonId
        ]);

        // Find user by phone
        $user = User::where('phone', $phone)->first();
        
        if (!$user) {
            Log::warning('User not found for button click', ['phone' => $phone]);
            return response()->json(['status' => 'user_not_found']);
        }

        // Handle different button actions
        switch ($buttonId) {
            case 'confirm_verification':
                return $this->confirmVerification($user);
                
            case 'deny_verification':
                return $this->denyVerification($user);
                
            default:
                Log::info('Unknown button ID', ['button_id' => $buttonId, 'phone' => $phone]);
                return response()->json(['status' => 'unknown_button']);
        }
    }

    /**
     * Handle message status updates
     */
    private function handleMessageStatus(array $data): JsonResponse
    {
        $messageId = $data['message_id'] ?? $data['id'] ?? '';
        $status = $data['status'] ?? '';
        
        Log::info('WhatsApp Message Status Update', [
            'message_id' => $messageId,
            'status' => $status
        ]);

        // Update message status in database if needed
        // This could be useful for tracking delivery status

        return response()->json(['status' => 'status_updated']);
    }

    /**
     * Handle connection events (QR code, connection status)
     */
    private function handleConnectionEvent(array $data): JsonResponse
    {
        $status = $data['status'] ?? $data['connection_status'] ?? '';
        $qrCode = $data['qr_code'] ?? $data['qr'] ?? null;
        
        Log::info('WhatsApp Connection Event', [
            'status' => $status,
            'has_qr' => !empty($qrCode)
        ]);

        // Store connection status for real-time updates
        // This could be cached or stored in database

        return response()->json(['status' => 'connection_updated']);
    }

    /**
     * Handle verification code input
     */
    private function handleVerificationCode(string $phone, string $code): JsonResponse
    {
        $user = User::where('phone', $phone)->first();
        
        if (!$user) {
            Log::warning('User not found for verification code', ['phone' => $phone]);
            return response()->json(['status' => 'user_not_found']);
        }

        $verification = WhatsAppVerification::findByUserAndToken($user->id, $code);
        
        if (!$verification) {
            Log::warning('Invalid verification code', [
                'phone' => $phone,
                'code' => $code,
                'user_id' => $user->id
            ]);
            
            // Send error message to user
            $this->wuzapiService->sendMessage($phone, 
                "❌ Código inválido ou expirado.\n\n" .
                "Tente novamente ou solicite um novo código."
            );
            
            return response()->json(['status' => 'invalid_code']);
        }

        // Mark as verified
        $user->markEmailAsVerified();
        $verification->markAsVerified();

        // Send success message
        $this->wuzapiService->sendMessage($phone, 
            "✅ *Verificação concluída com sucesso!*\n\n" .
            "Bem-vindo à RAFE! 🎉\n" .
            "Sua conta foi verificada e você já pode usar todos os recursos da plataforma.\n\n" .
            "Acesse: " . config('app.url')
        );

        Log::info('WhatsApp verification completed', [
            'user_id' => $user->id,
            'phone' => $phone
        ]);

        return response()->json(['status' => 'verification_completed']);
    }

    /**
     * Confirm verification via button
     */
    private function confirmVerification(User $user): JsonResponse
    {
        // Find the latest verification for this user
        $verification = EmailVerification::where('user_id', $user->id)
            ->whereNull('verified_at')
            ->where('expires_at', '>', now())
            ->latest()
            ->first();

        if (!$verification) {
            Log::warning('No pending verification found for user', ['user_id' => $user->id]);
            return response()->json(['status' => 'no_verification_found']);
        }

        // Mark as verified
        $user->markEmailAsVerified();
        $verification->markAsVerified();

        // Send success message
        $this->wuzapiService->sendMessage($user->phone, 
            "✅ *Verificação confirmada!*\n\n" .
            "Obrigado por confirmar sua identidade. Sua conta foi verificada com sucesso! 🎉\n\n" .
            "Acesse a RAFE: " . config('app.url')
        );

        Log::info('WhatsApp verification confirmed via button', [
            'user_id' => $user->id,
            'phone' => $user->phone
        ]);

        return response()->json(['status' => 'verification_confirmed']);
    }

    /**
     * Deny verification via button
     */
    private function denyVerification(User $user): JsonResponse
    {
        // Send security message
        $this->wuzapiService->sendMessage($user->phone, 
            "🔒 *Verificação negada*\n\n" .
            "Você negou a verificação. Por segurança, recomendamos:\n\n" .
            "• Verificar se foi você que tentou acessar\n" .
            "• Alterar sua senha se necessário\n" .
            "• Entrar em contato conosco se suspeitar de atividade suspeita\n\n" .
            "Suporte: " . config('app.url') . "/contact"
        );

        Log::info('WhatsApp verification denied via button', [
            'user_id' => $user->id,
            'phone' => $user->phone
        ]);

        return response()->json(['status' => 'verification_denied']);
    }

    /**
     * Validate webhook signature
     */
    private function validateWebhookSignature(Request $request): bool
    {
        // Implement webhook signature validation if required by WuzAPI
        // This depends on how WuzAPI implements webhook security
        
        $signature = $request->header('X-Hub-Signature-256') ?? $request->header('X-Wuzapi-Signature');
        $webhookSecret = config('services.wuzapi.webhook_secret');
        
        if (!$signature || !$webhookSecret) {
            // If no signature validation is configured, allow the request
            // In production, you should implement proper signature validation
            return true;
        }

        $payload = $request->getContent();
        $expectedSignature = 'sha256=' . hash_hmac('sha256', $payload, $webhookSecret);
        
        return hash_equals($expectedSignature, $signature);
    }

    /**
     * Format phone number from webhook data
     */
    private function formatPhoneFromWebhook(string $phone): string
    {
        // Remove any prefixes or formatting
        $phone = preg_replace('/[^\d]/', '', $phone);
        
        // Ensure it has the correct format
        if (strlen($phone) === 13 && substr($phone, 0, 2) === '55') {
            return $phone;
        }
        
        if (strlen($phone) === 11) {
            return '55' . $phone;
        }
        
        return $phone;
    }

    /**
     * Get webhook status for debugging
     */
    public function getWebhookStatus(): JsonResponse
    {
        return response()->json([
            'webhook_url' => config('services.wuzapi.webhook_url'),
            'webhook_secret_configured' => !empty(config('services.wuzapi.webhook_secret')),
            'last_webhook_received' => now()->toDateTimeString(), // This would be stored in cache/db
            'status' => 'active'
        ]);
    }
}
