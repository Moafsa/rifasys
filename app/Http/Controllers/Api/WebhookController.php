<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Raffle;
use App\Models\RaffleTicket;
use App\Services\WuzapiService;
use App\Services\WuzapiRaffles;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class WebhookController extends Controller
{
    protected WuzapiService $wuzapiService;
    protected WuzapiRaffles $wuzapiRaffles;

    public function __construct(WuzapiService $wuzapiService, WuzapiRaffles $wuzapiRaffles)
    {
        $this->wuzapiService = $wuzapiService;
        $this->wuzapiRaffles = $wuzapiRaffles;
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
            $eventType = $data['event'] ?? $data['type'] ?? 'unknown';
            
            switch ($eventType) {
                case 'Message':
                    return $this->handleMessageEvent($data);
                case 'ReadReceipt':
                    return $this->handleReadReceiptEvent($data);
                case 'Presence':
                    return $this->handlePresenceEvent($data);
                case 'HistorySync':
                    return $this->handleHistorySyncEvent($data);
                case 'ChatPresence':
                    return $this->handleChatPresenceEvent($data);
                default:
                    Log::info('Unknown webhook event type', ['event_type' => $eventType, 'data' => $data]);
                    return response()->json(['status' => 'received']);
            }

        } catch (\Exception $e) {
            Log::error('WhatsApp Webhook Error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'data' => $request->all()
            ]);
            
            return response()->json(['error' => 'Internal server error'], 500);
        }
    }

    /**
     * Handle message events
     */
    protected function handleMessageEvent(array $data): JsonResponse
    {
        try {
            $message = $data['message'] ?? [];
            $from = $message['from'] ?? '';
            $text = $message['text'] ?? '';
            $messageId = $message['id'] ?? '';

            Log::info('WhatsApp Message Event', [
                'from' => $from,
                'text' => $text,
                'message_id' => $messageId
            ]);

            // Process button responses
            if (isset($message['button_response'])) {
                return $this->handleButtonResponse($from, $message['button_response']);
            }

            // Process list responses
            if (isset($message['list_response'])) {
                return $this->handleListResponse($from, $message['list_response']);
            }

            // Process text messages
            if (!empty($text)) {
                return $this->handleTextMessage($from, $text);
            }

            return response()->json(['status' => 'processed']);

        } catch (\Exception $e) {
            Log::error('Message Event Processing Error', [
                'error' => $e->getMessage(),
                'data' => $data
            ]);
            return response()->json(['error' => 'Message processing failed'], 500);
        }
    }

    /**
     * Handle button responses
     */
    protected function handleButtonResponse(string $from, array $buttonResponse): JsonResponse
    {
        $buttonId = $buttonResponse['id'] ?? '';
        $buttonTitle = $buttonResponse['title'] ?? '';

        Log::info('Button Response Received', [
            'from' => $from,
            'button_id' => $buttonId,
            'button_title' => $buttonTitle
        ]);

        switch ($buttonId) {
            case 'confirm_verification':
                return $this->handleVerificationConfirmation($from, true);
            case 'deny_verification':
                return $this->handleVerificationConfirmation($from, false);
            case 'create_raffle':
                return $this->handleCreateRaffleRequest($from);
            case 'my_raffles':
                return $this->handleMyRafflesRequest($from);
            case 'buy_tickets':
                return $this->handleBuyTicketsRequest($from);
            case 'help':
                return $this->handleHelpRequest($from);
            default:
                Log::info('Unknown button response', [
                    'from' => $from,
                    'button_id' => $buttonId
                ]);
                return response()->json(['status' => 'processed']);
        }
    }

    /**
     * Handle list responses
     */
    protected function handleListResponse(string $from, array $listResponse): JsonResponse
    {
        $listId = $listResponse['id'] ?? '';
        $listTitle = $listResponse['title'] ?? '';

        Log::info('List Response Received', [
            'from' => $from,
            'list_id' => $listId,
            'list_title' => $listTitle
        ]);

        // Handle raffle selection or other list-based actions
        return response()->json(['status' => 'processed']);
    }

    /**
     * Handle text messages
     */
    protected function handleTextMessage(string $from, string $text): JsonResponse
    {
        $text = strtolower(trim($text));

        // Check for verification code
        if (preg_match('/^\d{6}$/', $text)) {
            return $this->handleVerificationCode($from, $text);
        }

        // Check for menu commands
        switch ($text) {
            case 'menu':
            case 'inicio':
            case 'start':
                return $this->handleMenuRequest($from);
            case 'ajuda':
            case 'help':
                return $this->handleHelpRequest($from);
            case 'minhas rifas':
            case 'my raffles':
                return $this->handleMyRafflesRequest($from);
            default:
                return $this->handleUnknownCommand($from, $text);
        }
    }

    /**
     * Handle verification confirmation
     */
    protected function handleVerificationConfirmation(string $from, bool $confirmed): JsonResponse
    {
        try {
            $user = User::where('phone', $this->formatPhone($from))->first();
            
            if (!$user) {
                $this->wuzapiRaffles->sendMessage($from, "❌ Usuário não encontrado. Por favor, registre-se primeiro.");
                return response()->json(['status' => 'processed']);
            }

            if ($confirmed) {
                $user->markEmailAsVerified();
                $this->wuzapiRaffles->sendMessage($from, "✅ Verificação confirmada! Sua conta foi ativada com sucesso.");
            } else {
                $this->wuzapiRaffles->sendMessage($from, "❌ Verificação negada. Sua conta não foi ativada.");
            }

            return response()->json(['status' => 'processed']);

        } catch (\Exception $e) {
            Log::error('Verification Confirmation Error', [
                'from' => $from,
                'confirmed' => $confirmed,
                'error' => $e->getMessage()
            ]);
            return response()->json(['error' => 'Verification processing failed'], 500);
        }
    }

    /**
     * Handle verification code
     */
    protected function handleVerificationCode(string $from, string $code): JsonResponse
    {
        try {
            $user = User::where('phone', $this->formatPhone($from))->first();
            
            if (!$user) {
                $this->wuzapiRaffles->sendMessage($from, "❌ Usuário não encontrado. Por favor, registre-se primeiro.");
                return response()->json(['status' => 'processed']);
            }

            // Check if code is valid (implement your verification logic here)
            if ($this->validateVerificationCode($user, $code)) {
                $user->markEmailAsVerified();
                $this->wuzapiRaffles->sendMessage($from, "✅ Código verificado com sucesso! Sua conta foi ativada.");
            } else {
                $this->wuzapiRaffles->sendMessage($from, "❌ Código inválido. Tente novamente.");
            }

            return response()->json(['status' => 'processed']);

        } catch (\Exception $e) {
            Log::error('Verification Code Error', [
                'from' => $from,
                'code' => $code,
                'error' => $e->getMessage()
            ]);
            return response()->json(['error' => 'Verification code processing failed'], 500);
        }
    }

    /**
     * Handle menu request
     */
    protected function handleMenuRequest(string $from): JsonResponse
    {
        try {
            $user = User::where('phone', $this->formatPhone($from))->first();
            $userName = $user ? $user->name : '';
            
            $this->wuzapiRaffles->sendRaffleMenu($from, $userName);
            return response()->json(['status' => 'processed']);

        } catch (\Exception $e) {
            Log::error('Menu Request Error', [
                'from' => $from,
                'error' => $e->getMessage()
            ]);
            return response()->json(['error' => 'Menu processing failed'], 500);
        }
    }

    /**
     * Handle help request
     */
    protected function handleHelpRequest(string $from): JsonResponse
    {
        try {
            $this->wuzapiRaffles->sendHelpMessage($from);
            return response()->json(['status' => 'processed']);

        } catch (\Exception $e) {
            Log::error('Help Request Error', [
                'from' => $from,
                'error' => $e->getMessage()
            ]);
            return response()->json(['error' => 'Help processing failed'], 500);
        }
    }

    /**
     * Handle my raffles request
     */
    protected function handleMyRafflesRequest(string $from): JsonResponse
    {
        try {
            $user = User::where('phone', $this->formatPhone($from))->first();
            
            if (!$user) {
                $this->wuzapiRaffles->sendMessage($from, "❌ Usuário não encontrado. Por favor, registre-se primeiro.");
                return response()->json(['status' => 'processed']);
            }

            $raffles = Raffle::where('user_id', $user->id)->get();
            
            if ($raffles->isEmpty()) {
                $this->wuzapiRaffles->sendMessage($from, "📋 Você ainda não criou nenhuma rifa. Use o menu para criar sua primeira rifa!");
            } else {
                $message = "📋 *Suas Rifas*\n\n";
                foreach ($raffles as $raffle) {
                    $message .= "🎫 *{$raffle->title}*\n";
                    $message .= "🔢 Números: {$raffle->available_tickets}/{$raffle->total_tickets}\n";
                    $message .= "📅 Sorteio: " . $raffle->draw_date->format('d/m/Y H:i') . "\n\n";
                }
                $message .= "*RAFE - Conectando pessoas através de rifas solidárias*";
                
                $this->wuzapiService->sendMessage($from, $message);
            }

            return response()->json(['status' => 'processed']);

        } catch (\Exception $e) {
            Log::error('My Raffles Request Error', [
                'from' => $from,
                'error' => $e->getMessage()
            ]);
            return response()->json(['error' => 'My raffles processing failed'], 500);
        }
    }

    /**
     * Handle create raffle request
     */
    protected function handleCreateRaffleRequest(string $from): JsonResponse
    {
        try {
            $this->wuzapiRaffles->sendMessage($from, "🎫 Para criar uma rifa, acesse nosso site: " . config('app.url') . "/raffles/create");
            return response()->json(['status' => 'processed']);

        } catch (\Exception $e) {
            Log::error('Create Raffle Request Error', [
                'from' => $from,
                'error' => $e->getMessage()
            ]);
            return response()->json(['error' => 'Create raffle processing failed'], 500);
        }
    }

    /**
     * Handle buy tickets request
     */
    protected function handleBuyTicketsRequest(string $from): JsonResponse
    {
        try {
            $this->wuzapiRaffles->sendMessage($from, "🛒 Para comprar números de rifas, acesse nosso site: " . config('app.url') . "/raffles");
            return response()->json(['status' => 'processed']);

        } catch (\Exception $e) {
            Log::error('Buy Tickets Request Error', [
                'from' => $from,
                'error' => $e->getMessage()
            ]);
            return response()->json(['error' => 'Buy tickets processing failed'], 500);
        }
    }

    /**
     * Handle unknown command
     */
    protected function handleUnknownCommand(string $from, string $text): JsonResponse
    {
        try {
            $this->wuzapiRaffles->sendMessage($from, "❓ Comando não reconhecido. Digite 'menu' para ver as opções disponíveis.");
            return response()->json(['status' => 'processed']);

        } catch (\Exception $e) {
            Log::error('Unknown Command Error', [
                'from' => $from,
                'text' => $text,
                'error' => $e->getMessage()
            ]);
            return response()->json(['error' => 'Unknown command processing failed'], 500);
        }
    }

    /**
     * Handle read receipt events
     */
    protected function handleReadReceiptEvent(array $data): JsonResponse
    {
        Log::info('Read Receipt Event', ['data' => $data]);
        return response()->json(['status' => 'processed']);
    }

    /**
     * Handle presence events
     */
    protected function handlePresenceEvent(array $data): JsonResponse
    {
        Log::info('Presence Event', ['data' => $data]);
        return response()->json(['status' => 'processed']);
    }

    /**
     * Handle history sync events
     */
    protected function handleHistorySyncEvent(array $data): JsonResponse
    {
        Log::info('History Sync Event', ['data' => $data]);
        return response()->json(['status' => 'processed']);
    }

    /**
     * Handle chat presence events
     */
    protected function handleChatPresenceEvent(array $data): JsonResponse
    {
        Log::info('Chat Presence Event', ['data' => $data]);
        return response()->json(['status' => 'processed']);
    }

    /**
     * Validate webhook signature
     */
    protected function validateWebhookSignature(Request $request): bool
    {
        $webhookSecret = config('services.wuzapi.webhook_secret');
        
        if (empty($webhookSecret)) {
            return true; // Skip validation if no secret is configured
        }

        $signature = $request->header('X-WuzAPI-Signature');
        $payload = $request->getContent();
        
        $expectedSignature = hash_hmac('sha256', $payload, $webhookSecret);
        
        return hash_equals($expectedSignature, $signature ?? '');
    }

    /**
     * Format phone number for database lookup
     */
    protected function formatPhone(string $phone): string
    {
        // Remove all non-numeric characters
        $phone = preg_replace('/\D/', '', $phone);
        
        // Add country code if not present
        if (strlen($phone) === 11 && substr($phone, 0, 2) === '11') {
            $phone = '55' . $phone;
        } elseif (strlen($phone) === 10) {
            $phone = '5511' . $phone; // Default to São Paulo if no area code
        } elseif (strlen($phone) === 13 && substr($phone, 0, 2) === '55') {
            // Already formatted correctly
        } else {
            // Assume it's a complete number and add 55 if needed
            if (strlen($phone) === 11) {
                $phone = '55' . $phone;
            }
        }
        
        return $phone;
    }

    /**
     * Validate verification code (implement your logic here)
     */
    protected function validateVerificationCode(User $user, string $code): bool
    {
        // Implement your verification code validation logic
        // This could check against a stored verification code, timestamp, etc.
        return true; // Placeholder
    }
}
