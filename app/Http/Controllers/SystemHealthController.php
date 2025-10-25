<?php

namespace App\Http\Controllers;

use App\Services\SystemHealthService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class SystemHealthController extends Controller
{
    protected SystemHealthService $healthService;

    public function __construct(SystemHealthService $healthService)
    {
        $this->healthService = $healthService;
    }

    /**
     * Display system health dashboard
     */
    public function dashboard(): View
    {
        $health = $this->healthService->performHealthCheck();
        $metrics = $this->healthService->getSystemMetrics();
        
        return view('admin.system-health', compact('health', 'metrics'));
    }

    /**
     * Get system health status (API endpoint)
     */
    public function status(): JsonResponse
    {
        $health = $this->healthService->performHealthCheck();
        
        return response()->json($health);
    }

    /**
     * Get system metrics (API endpoint)
     */
    public function metrics(): JsonResponse
    {
        $metrics = $this->healthService->getSystemMetrics();
        
        return response()->json($metrics);
    }

    /**
     * Get detailed health check for specific service
     */
    public function serviceHealth(Request $request): JsonResponse
    {
        $service = $request->get('service', 'all');
        $health = $this->healthService->performHealthCheck();
        
        if ($service === 'all') {
            return response()->json($health);
        }
        
        if (!isset($health['services'][$service])) {
            return response()->json([
                'error' => 'Service not found',
                'available_services' => array_keys($health['services'])
            ], 404);
        }
        
        return response()->json([
            'service' => $service,
            'status' => $health['services'][$service],
            'timestamp' => $health['timestamp']
        ]);
    }

    /**
     * Force garbage collection and memory cleanup
     */
    public function cleanup(): JsonResponse
    {
        try {
            // Force garbage collection
            gc_collect_cycles();
            
            // Clear application cache
            \Artisan::call('cache:clear');
            
            // Clear config cache
            \Artisan::call('config:clear');
            
            // Clear route cache
            \Artisan::call('route:clear');
            
            // Clear view cache
            \Artisan::call('view:clear');
            
            $memoryBefore = memory_get_usage(true);
            $memoryAfter = memory_get_usage(true);
            
            return response()->json([
                'success' => true,
                'message' => 'System cleanup completed successfully',
                'memory_before_mb' => round($memoryBefore / (1024 * 1024), 2),
                'memory_after_mb' => round($memoryAfter / (1024 * 1024), 2),
                'timestamp' => now()->toDateTimeString()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
                'timestamp' => now()->toDateTimeString()
            ], 500);
        }
    }

    /**
     * Test database connection
     */
    public function testDatabase(): JsonResponse
    {
        try {
            $startTime = microtime(true);
            
            // Test basic connection
            \DB::connection()->getPdo();
            
            // Test a simple query
            $result = \DB::select('SELECT 1 as test, NOW() as current_time');
            
            $responseTime = round((microtime(true) - $startTime) * 1000, 2);
            
            return response()->json([
                'success' => true,
                'message' => 'Database connection successful',
                'response_time_ms' => $responseTime,
                'test_result' => $result[0] ?? null,
                'timestamp' => now()->toDateTimeString()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
                'timestamp' => now()->toDateTimeString()
            ], 500);
        }
    }

    /**
     * Test cache system
     */
    public function testCache(): JsonResponse
    {
        try {
            $testKey = 'health_test_' . time();
            $testValue = 'test_value_' . rand(1000, 9999);
            
            $startTime = microtime(true);
            
            // Test cache operations
            \Cache::put($testKey, $testValue, 60);
            $retrievedValue = \Cache::get($testKey);
            \Cache::forget($testKey);
            
            $responseTime = round((microtime(true) - $startTime) * 1000, 2);
            
            $success = $retrievedValue === $testValue;
            
            return response()->json([
                'success' => $success,
                'message' => $success ? 'Cache system working correctly' : 'Cache system test failed',
                'response_time_ms' => $responseTime,
                'test_passed' => $success,
                'timestamp' => now()->toDateTimeString()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
                'timestamp' => now()->toDateTimeString()
            ], 500);
        }
    }

    /**
     * Test external services
     */
    public function testExternalServices(): JsonResponse
    {
        $results = [];
        
        // Test WhatsApp service
        try {
            $wuzapiService = app(\App\Services\WuzapiService::class);
            $whatsappStatus = $wuzapiService->checkConnection();
            $results['whatsapp'] = [
                'status' => $whatsappStatus ? 'connected' : 'disconnected',
                'success' => $whatsappStatus
            ];
        } catch (\Exception $e) {
            $results['whatsapp'] = [
                'status' => 'error',
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
        
        // Test email configuration
        try {
            $mailConfig = config('mail');
            $mailer = $mailConfig['default'];
            $host = $mailConfig['mailers'][$mailer]['host'] ?? null;
            $results['email'] = [
                'status' => $host ? 'configured' : 'not_configured',
                'success' => (bool) $host,
                'mailer' => $mailer,
                'host' => $host
            ];
        } catch (\Exception $e) {
            $results['email'] = [
                'status' => 'error',
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
        
        return response()->json([
            'success' => true,
            'results' => $results,
            'timestamp' => now()->toDateTimeString()
        ]);
    }
}
