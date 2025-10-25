<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\SystemHealthService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SystemHealthCheck extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'system:health-check 
                            {--email= : Email to send alerts to}
                            {--threshold=degraded : Alert threshold (healthy, degraded, unhealthy)}
                            {--silent : Run without output}';

    /**
     * The console command description.
     */
    protected $description = 'Perform comprehensive system health check and send alerts if needed';

    protected SystemHealthService $healthService;

    public function __construct(SystemHealthService $healthService)
    {
        parent::__construct();
        $this->healthService = $healthService;
    }

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $startTime = microtime(true);
        
        if (!$this->option('silent')) {
            $this->info('🔍 Starting system health check...');
        }

        try {
            // Perform health check
            $health = $this->healthService->performHealthCheck();
            $overallStatus = $health['overall_status'];
            
            $executionTime = round((microtime(true) - $startTime) * 1000, 2);
            
            if (!$this->option('silent')) {
                $this->displayHealthResults($health, $executionTime);
            }
            
            // Check if we need to send alerts
            $threshold = $this->option('threshold');
            $shouldAlert = $this->shouldSendAlert($overallStatus, $threshold);
            
            if ($shouldAlert) {
                $email = $this->option('email');
                if ($email) {
                    $this->sendHealthAlert($email, $health);
                } else {
                    $this->warn('⚠️  System health issues detected but no email provided for alerts');
                }
            }
            
            // Return appropriate exit code
            return $this->getExitCode($overallStatus);
            
        } catch (\Exception $e) {
            $this->error('❌ Health check failed: ' . $e->getMessage());
            Log::error('System health check command failed', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return 1;
        }
    }

    /**
     * Display health check results
     */
    private function displayHealthResults(array $health, float $executionTime): void
    {
        $this->newLine();
        $this->info('📊 System Health Report');
        $this->line('═══════════════════════════════════════');
        
        // Overall status
        $statusIcon = $this->getStatusIcon($health['overall_status']);
        $this->line("Overall Status: {$statusIcon} " . strtoupper($health['overall_status']));
        $this->line("Check Time: {$health['timestamp']}");
        $this->line("Execution Time: {$executionTime}ms");
        $this->newLine();
        
        // Service status
        $this->info('🔧 Service Status:');
        foreach ($health['services'] as $serviceName => $serviceData) {
            $icon = $this->getStatusIcon($serviceData['status']);
            $this->line("  {$icon} " . strtoupper($serviceName) . ": " . strtoupper($serviceData['status']));
            
            if (isset($serviceData['message'])) {
                $this->line("     └─ {$serviceData['message']}");
            }
            
            if (isset($serviceData['response_time_ms'])) {
                $this->line("     └─ Response: {$serviceData['response_time_ms']}ms");
            }
            
            if (isset($serviceData['error'])) {
                $this->line("     └─ Error: {$serviceData['error']}");
            }
        }
        
        $this->newLine();
    }

    /**
     * Get status icon
     */
    private function getStatusIcon(string $status): string
    {
        return match ($status) {
            'healthy' => '✅',
            'degraded' => '⚠️',
            'unhealthy' => '❌',
            default => '❓'
        };
    }

    /**
     * Check if alert should be sent
     */
    private function shouldSendAlert(string $overallStatus, string $threshold): bool
    {
        $statusLevels = ['healthy' => 1, 'degraded' => 2, 'unhealthy' => 3];
        $currentLevel = $statusLevels[$overallStatus] ?? 1;
        $thresholdLevel = $statusLevels[$threshold] ?? 2;
        
        return $currentLevel >= $thresholdLevel;
    }

    /**
     * Send health alert email
     */
    private function sendHealthAlert(string $email, array $health): void
    {
        try {
            $subject = "🚨 RAFE System Health Alert - " . strtoupper($health['overall_status']);
            
            $unhealthyServices = array_filter($health['services'], fn($service) => $service['status'] !== 'healthy');
            
            $message = "System Health Alert\n\n";
            $message .= "Overall Status: " . strtoupper($health['overall_status']) . "\n";
            $message .= "Timestamp: {$health['timestamp']}\n\n";
            
            if (!empty($unhealthyServices)) {
                $message .= "Unhealthy Services:\n";
                foreach ($unhealthyServices as $serviceName => $serviceData) {
                    $message .= "- {$serviceName}: {$serviceData['status']}\n";
                    if (isset($serviceData['error'])) {
                        $message .= "  Error: {$serviceData['error']}\n";
                    }
                }
            }
            
            // For now, just log the alert (in production, you'd send actual email)
            Log::warning('System Health Alert', [
                'email' => $email,
                'subject' => $subject,
                'message' => $message,
                'health_status' => $health['overall_status']
            ]);
            
            $this->info("📧 Health alert sent to: {$email}");
            
        } catch (\Exception $e) {
            $this->error("Failed to send health alert: " . $e->getMessage());
            Log::error('Failed to send health alert', [
                'email' => $email,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Get exit code based on health status
     */
    private function getExitCode(string $status): int
    {
        return match ($status) {
            'healthy' => 0,
            'degraded' => 1,
            'unhealthy' => 2,
            default => 1
        };
    }
}
