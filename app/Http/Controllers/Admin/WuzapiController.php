<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\WuzapiService;
use App\Services\WuzapiRaffles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WuzapiController extends Controller
{
    protected WuzapiService $wuzapiService;
    protected WuzapiRaffles $wuzapiRaffles;

    public function __construct(WuzapiService $wuzapiService, WuzapiRaffles $wuzapiRaffles)
    {
        $this->wuzapiService = $wuzapiService;
        $this->wuzapiRaffles = $wuzapiRaffles;
    }

    /**
     * Show WuzAPI dashboard
     */
    public function dashboard()
    {
        $status = $this->wuzapiService->getStatus();
        $isConnected = $this->wuzapiService->isConnected();
        $qrCode = $this->wuzapiService->getQRCode();

        return view('admin.wuzapi-dashboard', compact('status', 'isConnected', 'qrCode'));
    }

    /**
     * Test connection
     */
    public function testConnection()
    {
        try {
            $isConnected = $this->wuzapiService->isConnected();
            $status = $this->wuzapiService->getStatus();
            
            return response()->json([
                'success' => true,
                'connected' => $isConnected,
                'status' => $status,
                'timestamp' => now()
            ]);
        } catch (\Exception $e) {
            Log::error('WuzAPI connection test failed', [
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Send test message
     */
    public function sendTestMessage(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'message' => 'required|string'
        ]);

        try {
            $result = $this->wuzapiService->sendMessage($request->phone, $request->message);
            
            if ($result) {
                return response()->json([
                    'success' => true,
                    'message' => 'Mensagem enviada com sucesso!',
                    'result' => $result
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Falha ao enviar mensagem'
                ], 500);
            }
        } catch (\Exception $e) {
            Log::error('WuzAPI test message failed', [
                'phone' => $request->phone,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Erro ao enviar mensagem: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Send test raffle message
     */
    public function sendTestRaffleMessage(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'type' => 'required|in:verification,help,menu'
        ]);

        try {
            $result = null;
            
            switch ($request->type) {
                case 'verification':
                    $result = $this->wuzapiRaffles->sendVerificationCode(
                        $request->phone, 
                        '123456', 
                        'Usuário Teste'
                    );
                    break;
                case 'help':
                    $result = $this->wuzapiRaffles->sendHelpMessage($request->phone);
                    break;
                case 'menu':
                    $result = $this->wuzapiRaffles->sendRaffleMenu($request->phone, 'Usuário Teste');
                    break;
            }
            
            if ($result) {
                return response()->json([
                    'success' => true,
                    'message' => 'Mensagem de rifa enviada com sucesso!',
                    'result' => $result
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Falha ao enviar mensagem de rifa'
                ], 500);
            }
        } catch (\Exception $e) {
            Log::error('WuzAPI test raffle message failed', [
                'phone' => $request->phone,
                'type' => $request->type,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Erro ao enviar mensagem de rifa: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get QR code
     */
    public function getQRCode()
    {
        try {
            $qrCode = $this->wuzapiService->getQRCode();
            
            return response()->json([
                'success' => true,
                'qr_code' => $qrCode,
                'available' => !empty($qrCode)
            ]);
        } catch (\Exception $e) {
            Log::error('WuzAPI QR code failed', [
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Erro ao obter QR code: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get webhook status
     */
    public function getWebhookStatus()
    {
        try {
            $webhookUrl = config('services.wuzapi.webhook_url');
            $webhookSecret = config('services.wuzapi.webhook_secret');
            
            return response()->json([
                'success' => true,
                'webhook_url' => $webhookUrl,
                'webhook_secret_configured' => !empty($webhookSecret),
                'timestamp' => now()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao verificar webhook: ' . $e->getMessage()
            ], 500);
        }
    }
}
