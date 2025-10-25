<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use App\Services\WuzapiService;
use Illuminate\Support\Facades\Mail;

class SystemHealthService
{
    protected WuzapiService $wuzapiService;

    public function __construct(WuzapiService $wuzapiService)
    {
        $this->wuzapiService = $wuzapiService;
    }

    /**
     * Perform comprehensive system health check
     */
    public function performHealthCheck(): array
    {
        $health = [
            'timestamp' => now()->toDateTimeString(),
            'overall_status' => 'healthy',
            'services' => []
        ];

        // Check database connection
        $health['services']['database'] = $this->checkDatabaseHealth();
        
        // Check cache system
        $health['services']['cache'] = $this->checkCacheHealth();
        
        // Check WhatsApp service
        $health['services']['whatsapp'] = $this->checkWhatsAppHealth();
        
        // Check email service
        $health['services']['email'] = $this->checkEmailHealth();
        
        // Check file system
        $health['services']['filesystem'] = $this->checkFilesystemHealth();
        
        // Check memory usage
        $health['services']['memory'] = $this->checkMemoryHealth();
        
        // Determine overall status
        $health['overall_status'] = $this->determineOverallStatus($health['services']);

        // Log health check results
        $this->logHealthCheckResults($health);

        return $health;
    }

    /**
     * Check database connection and performance
     */
    private function checkDatabaseHealth(): array
    {
        try {
            $startTime = microtime(true);
            
            // Test basic connection
            DB::connection()->getPdo();
            
            // Test a simple query
            $result = DB::select('SELECT 1 as test');
            
            $responseTime = round((microtime(true) - $startTime) * 1000, 2);
            
            // Check if response time is acceptable (less than 100ms)
            $status = $responseTime < 100 ? 'healthy' : 'degraded';
            
            return [
                'status' => $status,
                'response_time_ms' => $responseTime,
                'connection' => 'connected',
                'message' => $status === 'healthy' ? 'Database responding normally' : 'Database responding slowly'
            ];
        } catch (\Exception $e) {
            Log::error('Database health check failed', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            
            return [
                'status' => 'unhealthy',
                'response_time_ms' => null,
                'connection' => 'failed',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Check cache system health
     */
    private function checkCacheHealth(): array
    {
        try {
            $testKey = 'health_check_' . time();
            $testValue = 'test_value_' . rand(1000, 9999);
            
            $startTime = microtime(true);
            
            // Test cache write
            Cache::put($testKey, $testValue, 60);
            
            // Test cache read
            $retrievedValue = Cache::get($testKey);
            
            // Test cache delete
            Cache::forget($testKey);
            
            $responseTime = round((microtime(true) - $startTime) * 1000, 2);
            
            $status = ($retrievedValue === $testValue && $responseTime < 50) ? 'healthy' : 'degraded';
            
            return [
                'status' => $status,
                'response_time_ms' => $responseTime,
                'read_write_test' => $retrievedValue === $testValue ? 'passed' : 'failed',
                'message' => $status === 'healthy' ? 'Cache system working normally' : 'Cache system performance degraded'
            ];
        } catch (\Exception $e) {
            Log::error('Cache health check failed', [
                'error' => $e->getMessage()
            ]);
            
            return [
                'status' => 'unhealthy',
                'response_time_ms' => null,
                'read_write_test' => 'failed',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Check WhatsApp service health
     */
    private function checkWhatsAppHealth(): array
    {
        try {
            $startTime = microtime(true);
            
            $connectionStatus = $this->wuzapiService->checkConnection();
            $detailedStatus = $this->wuzapiService->getDetailedStatus();
            
            $responseTime = round((microtime(true) - $startTime) * 1000, 2);
            
            $status = $connectionStatus ? 'healthy' : 'unhealthy';
            
            return [
                'status' => $status,
                'response_time_ms' => $responseTime,
                'connection' => $connectionStatus ? 'connected' : 'disconnected',
                'details' => $detailedStatus,
                'message' => $connectionStatus ? 'WhatsApp service connected' : 'WhatsApp service unavailable'
            ];
        } catch (\Exception $e) {
            Log::error('WhatsApp health check failed', [
                'error' => $e->getMessage()
            ]);
            
            return [
                'status' => 'unhealthy',
                'response_time_ms' => null,
                'connection' => 'failed',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Check email service health
     */
    private function checkEmailHealth(): array
    {
        try {
            $startTime = microtime(true);
            
            // Test mail configuration
            $mailConfig = config('mail');
            $mailer = $mailConfig['default'];
            $mailHost = $mailConfig['mailers'][$mailer]['host'] ?? null;
            
            $responseTime = round((microtime(true) - $startTime) * 1000, 2);
            
            $status = $mailHost ? 'healthy' : 'unhealthy';
            
            return [
                'status' => $status,
                'response_time_ms' => $responseTime,
                'mailer' => $mailer,
                'host' => $mailHost,
                'message' => $status === 'healthy' ? 'Email service configured' : 'Email service not configured'
            ];
        } catch (\Exception $e) {
            Log::error('Email health check failed', [
                'error' => $e->getMessage()
            ]);
            
            return [
                'status' => 'unhealthy',
                'response_time_ms' => null,
                'mailer' => null,
                'host' => null,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Check filesystem health
     */
    private function checkFilesystemHealth(): array
    {
        try {
            $startTime = microtime(true);
            
            // Check storage directory
            $storagePath = storage_path();
            $isWritable = is_writable($storagePath);
            $freeSpace = disk_free_space($storagePath);
            $totalSpace = disk_total_space($storagePath);
            $usagePercentage = round((($totalSpace - $freeSpace) / $totalSpace) * 100, 2);
            
            $responseTime = round((microtime(true) - $startTime) * 1000, 2);
            
            $status = $isWritable && $usagePercentage < 90 ? 'healthy' : 'degraded';
            
            return [
                'status' => $status,
                'response_time_ms' => $responseTime,
                'writable' => $isWritable,
                'free_space_gb' => round($freeSpace / (1024 * 1024 * 1024), 2),
                'usage_percentage' => $usagePercentage,
                'message' => $status === 'healthy' ? 'Filesystem healthy' : 'Filesystem space low or not writable'
            ];
        } catch (\Exception $e) {
            Log::error('Filesystem health check failed', [
                'error' => $e->getMessage()
            ]);
            
            return [
                'status' => 'unhealthy',
                'response_time_ms' => null,
                'writable' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Check memory usage
     */
    private function checkMemoryHealth(): array
    {
        try {
            $memoryUsage = memory_get_usage(true);
            $memoryLimit = ini_get('memory_limit');
            $memoryLimitBytes = $this->convertToBytes($memoryLimit);
            $usagePercentage = round(($memoryUsage / $memoryLimitBytes) * 100, 2);
            
            $status = $usagePercentage < 80 ? 'healthy' : 'degraded';
            
            return [
                'status' => $status,
                'current_usage_mb' => round($memoryUsage / (1024 * 1024), 2),
                'limit_mb' => round($memoryLimitBytes / (1024 * 1024), 2),
                'usage_percentage' => $usagePercentage,
                'message' => $status === 'healthy' ? 'Memory usage normal' : 'Memory usage high'
            ];
        } catch (\Exception $e) {
            Log::error('Memory health check failed', [
                'error' => $e->getMessage()
            ]);
            
            return [
                'status' => 'unhealthy',
                'current_usage_mb' => null,
                'limit_mb' => null,
                'usage_percentage' => null,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Determine overall system status
     */
    private function determineOverallStatus(array $services): string
    {
        $unhealthyCount = 0;
        $degradedCount = 0;
        
        foreach ($services as $service) {
            if ($service['status'] === 'unhealthy') {
                $unhealthyCount++;
            } elseif ($service['status'] === 'degraded') {
                $degradedCount++;
            }
        }
        
        if ($unhealthyCount > 0) {
            return 'unhealthy';
        } elseif ($degradedCount > 0) {
            return 'degraded';
        }
        
        return 'healthy';
    }

    /**
     * Log health check results
     */
    private function logHealthCheckResults(array $health): void
    {
        $logData = [
            'overall_status' => $health['overall_status'],
            'services_status' => array_map(fn($service) => $service['status'], $health['services']),
            'timestamp' => $health['timestamp']
        ];
        
        if ($health['overall_status'] === 'healthy') {
            Log::info('System health check passed', $logData);
        } elseif ($health['overall_status'] === 'degraded') {
            Log::warning('System health check - degraded performance', $logData);
        } else {
            Log::error('System health check - unhealthy', $logData);
        }
    }

    /**
     * Convert memory limit string to bytes
     */
    private function convertToBytes(string $value): int
    {
        $value = trim($value);
        $last = strtolower($value[strlen($value) - 1]);
        $value = (int) $value;
        
        switch ($last) {
            case 'g':
                $value *= 1024;
            case 'm':
                $value *= 1024;
            case 'k':
                $value *= 1024;
        }
        
        return $value;
    }

    /**
     * Get system metrics for monitoring
     */
    public function getSystemMetrics(): array
    {
        return [
            'timestamp' => now()->toDateTimeString(),
            'memory_usage' => memory_get_usage(true),
            'memory_peak' => memory_get_peak_usage(true),
            'memory_limit' => ini_get('memory_limit'),
            'disk_free' => disk_free_space(storage_path()),
            'disk_total' => disk_total_space(storage_path()),
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
            'uptime' => $this->getSystemUptime()
        ];
    }

    /**
     * Get system uptime
     */
    private function getSystemUptime(): ?int
    {
        try {
            if (function_exists('sys_getloadavg')) {
                $load = sys_getloadavg();
                return $load[0] ?? null;
            }
            return null;
        } catch (\Exception $e) {
            return null;
        }
    }
}
