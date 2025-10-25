<?php

namespace App\Http\Controllers;

use App\Models\WuzapiInstance;
use App\Models\WuzapiWebhookLog;
use App\Models\WuzapiMessageLog;
use App\Services\WuzapiService;
use App\Services\WuzapiRaffles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class WuzapiManagerController extends Controller
{
    protected WuzapiService $wuzapiService;
    protected WuzapiRaffles $wuzapiRaffles;

    public function __construct(WuzapiService $wuzapiService, WuzapiRaffles $wuzapiRaffles)
    {
        $this->wuzapiService = $wuzapiService;
        $this->wuzapiRaffles = $wuzapiRaffles;
    }

    /**
     * Show the main dashboard
     */
    public function dashboard()
    {
        $instances = WuzapiInstance::forUser(Auth::id())->get();
        $recentWebhooks = WuzapiWebhookLog::with('instance')
            ->whereIn('wuzapi_instance_id', $instances->pluck('id'))
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        $recentMessages = WuzapiMessageLog::with('instance')
            ->whereIn('wuzapi_instance_id', $instances->pluck('id'))
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $stats = [
            'total_instances' => $instances->count(),
            'active_instances' => $instances->where('status', 'connected')->count(),
            'total_messages_today' => WuzapiMessageLog::whereIn('wuzapi_instance_id', $instances->pluck('id'))
                ->whereDate('created_at', today())
                ->count(),
            'successful_messages_today' => WuzapiMessageLog::whereIn('wuzapi_instance_id', $instances->pluck('id'))
                ->whereDate('created_at', today())
                ->where('status', 'sent')
                ->count(),
        ];

        return view('wuzapi-manager.dashboard', compact('instances', 'recentWebhooks', 'recentMessages', 'stats'));
    }

    /**
     * Show instances list
     */
    public function instances()
    {
        $instances = WuzapiInstance::forUser(Auth::id())
            ->withCount(['webhookLogs', 'messageLogs'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('wuzapi-manager.instances', compact('instances'));
    }

    /**
     * Show create instance form
     */
    public function createInstance()
    {
        return view('wuzapi-manager.create-instance');
    }

    /**
     * Store new instance
     */
    public function storeInstance(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'api_token' => 'required|string',
            'webhook_url' => 'nullable|url',
            'webhook_secret' => 'nullable|string',
        ]);

        $instance = WuzapiInstance::create([
            'name' => $request->name,
            'description' => $request->description,
            'api_token' => $request->api_token,
            'instance_id' => Str::uuid(),
            'webhook_url' => $request->webhook_url,
            'webhook_secret' => $request->webhook_secret,
            'user_id' => Auth::id(),
            'status' => 'connecting',
        ]);

        return redirect()->route('wuzapi-manager.instances')
            ->with('success', 'Instância criada com sucesso!');
    }

    /**
     * Show instance details
     */
    public function showInstance(WuzapiInstance $instance)
    {
        $this->authorize('view', $instance);

        $recentWebhooks = $instance->webhookLogs()
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();

        $recentMessages = $instance->messageLogs()
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();

        $stats = [
            'total_webhooks' => $instance->webhookLogs()->count(),
            'successful_webhooks' => $instance->webhookLogs()->successful()->count(),
            'failed_webhooks' => $instance->webhookLogs()->failed()->count(),
            'total_messages' => $instance->messageLogs()->count(),
            'successful_messages' => $instance->messageLogs()->successful()->count(),
            'failed_messages' => $instance->messageLogs()->failed()->count(),
        ];

        return view('wuzapi-manager.instance-details', compact('instance', 'recentWebhooks', 'recentMessages', 'stats'));
    }

    /**
     * Test instance connection
     */
    public function testConnection(WuzapiInstance $instance)
    {
        $this->authorize('view', $instance);

        try {
            // Update service configuration for this instance
            config(['services.wuzapi.api_token' => $instance->api_token]);
            config(['services.wuzapi.instance_id' => $instance->instance_id]);
            
            $isConnected = $this->wuzapiService->isConnected();
            $status = $this->wuzapiService->getStatus();
            $qrCode = $this->wuzapiService->getQRCode();

            if ($qrCode) {
                $instance->updateQRCode($qrCode);
            }

            return response()->json([
                'success' => true,
                'connected' => $isConnected,
                'status' => $status,
                'qr_code' => $qrCode,
            ]);
        } catch (\Exception $e) {
            Log::error('WuzAPI connection test failed', [
                'instance_id' => $instance->id,
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
    public function sendTestMessage(Request $request, WuzapiInstance $instance)
    {
        $this->authorize('view', $instance);

        $request->validate([
            'phone' => 'required|string',
            'message' => 'required|string',
            'message_type' => 'required|in:text,image,button,list'
        ]);

        try {
            // Update service configuration for this instance
            config(['services.wuzapi.api_token' => $instance->api_token]);
            config(['services.wuzapi.instance_id' => $instance->instance_id]);

            $result = null;
            $messageId = Str::uuid();

            switch ($request->message_type) {
                case 'text':
                    $result = $this->wuzapiService->sendMessage($request->phone, $request->message);
                    break;
                case 'image':
                    $result = $this->wuzapiService->sendMedia($request->phone, $request->message, '', 'image');
                    break;
                case 'button':
                    $buttons = [
                        ['id' => 'confirm', 'title' => '✅ Confirmar'],
                        ['id' => 'cancel', 'title' => '❌ Cancelar']
                    ];
                    $result = $this->wuzapiService->sendButtons($request->phone, $request->message, $buttons);
                    break;
                case 'list':
                    $sections = [
                        [
                            'title' => 'Opções',
                            'rows' => [
                                ['id' => 'option1', 'title' => 'Opção 1'],
                                ['id' => 'option2', 'title' => 'Opção 2']
                            ]
                        ]
                    ];
                    $result = $this->wuzapiService->sendList($request->phone, $request->message, 'Escolher', $sections);
                    break;
            }

            // Log the message
            WuzapiMessageLog::create([
                'wuzapi_instance_id' => $instance->id,
                'message_id' => $messageId,
                'phone_number' => $request->phone,
                'message_type' => $request->message_type,
                'content' => ['text' => $request->message],
                'status' => $result ? 'sent' : 'failed',
                'response' => $result,
                'sent_at' => now(),
            ]);

            return response()->json([
                'success' => $result ? true : false,
                'message' => $result ? 'Mensagem enviada com sucesso!' : 'Falha ao enviar mensagem',
                'result' => $result
            ]);
        } catch (\Exception $e) {
            Log::error('WuzAPI test message failed', [
                'instance_id' => $instance->id,
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
     * Show webhook logs
     */
    public function webhookLogs(WuzapiInstance $instance)
    {
        $this->authorize('view', $instance);

        $logs = $instance->webhookLogs()
            ->orderBy('created_at', 'desc')
            ->paginate(50);

        return view('wuzapi-manager.webhook-logs', compact('instance', 'logs'));
    }

    /**
     * Show message logs
     */
    public function messageLogs(WuzapiInstance $instance)
    {
        $this->authorize('view', $instance);

        $logs = $instance->messageLogs()
            ->orderBy('created_at', 'desc')
            ->paginate(50);

        return view('wuzapi-manager.message-logs', compact('instance', 'logs'));
    }

    /**
     * Show analytics
     */
    public function analytics(WuzapiInstance $instance)
    {
        $this->authorize('view', $instance);

        $webhookStats = $instance->webhookLogs()
            ->selectRaw('event_type, COUNT(*) as count')
            ->groupBy('event_type')
            ->get();

        $messageStats = $instance->messageLogs()
            ->selectRaw('message_type, status, COUNT(*) as count')
            ->groupBy('message_type', 'status')
            ->get();

        $dailyStats = $instance->messageLogs()
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('wuzapi-manager.analytics', compact('instance', 'webhookStats', 'messageStats', 'dailyStats'));
    }

    /**
     * Update instance settings
     */
    public function updateSettings(Request $request, WuzapiInstance $instance)
    {
        $this->authorize('update', $instance);

        $request->validate([
            'settings' => 'required|array',
            'settings.timeout' => 'integer|min:5|max:300',
            'settings.retry_attempts' => 'integer|min:1|max:10',
            'settings.retry_delay' => 'integer|min:1|max:60',
            'settings.rate_limit' => 'integer|min:1|max:1000',
        ]);

        $instance->updateSettings($request->settings);

        return response()->json([
            'success' => true,
            'message' => 'Configurações atualizadas com sucesso!'
        ]);
    }

    /**
     * Delete instance
     */
    public function deleteInstance(WuzapiInstance $instance)
    {
        $this->authorize('delete', $instance);

        $instance->delete();

        return redirect()->route('wuzapi-manager.instances')
            ->with('success', 'Instância excluída com sucesso!');
    }
}
