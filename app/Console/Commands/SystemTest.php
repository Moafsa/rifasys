<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use App\Services\WuzapiService;
use App\Services\SystemHealthService;

class SystemTest extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'system:test 
                            {--component=all : Test specific component (all, routes, database, cache, services)}
                            {--verbose : Show detailed output}';

    /**
     * The console command description.
     */
    protected $description = 'Test all system components and functionality';

    protected SystemHealthService $healthService;
    protected WuzapiService $wuzapiService;

    public function __construct(SystemHealthService $healthService, WuzapiService $wuzapiService)
    {
        parent::__construct();
        $this->healthService = $healthService;
        $this->wuzapiService = $wuzapiService;
    }

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $component = $this->option('component');
        $verbose = $this->option('verbose');
        
        $this->info('🧪 Starting system tests...');
        $this->newLine();
        
        $results = [];
        
        if ($component === 'all' || $component === 'routes') {
            $results['routes'] = $this->testRoutes($verbose);
        }
        
        if ($component === 'all' || $component === 'database') {
            $results['database'] = $this->testDatabase($verbose);
        }
        
        if ($component === 'all' || $component === 'cache') {
            $results['cache'] = $this->testCache($verbose);
        }
        
        if ($component === 'all' || $component === 'services') {
            $results['services'] = $this->testServices($verbose);
        }
        
        $this->displayResults($results);
        
        // Return exit code based on results
        $hasFailures = collect($results)->contains(fn($result) => !$result['success']);
        return $hasFailures ? 1 : 0;
    }

    /**
     * Test all routes
     */
    private function testRoutes(bool $verbose): array
    {
        $this->info('🔗 Testing routes...');
        
        $routes = Route::getRoutes();
        $tested = 0;
        $failed = 0;
        $errors = [];
        
        foreach ($routes as $route) {
            $tested++;
            
            try {
                // Test route compilation
                $route->getAction();
                
                if ($verbose) {
                    $this->line("  ✅ {$route->uri()} ({$route->methods()[0]})");
                }
            } catch (\Exception $e) {
                $failed++;
                $errors[] = "Route {$route->uri()}: " . $e->getMessage();
                
                if ($verbose) {
                    $this->error("  ❌ {$route->uri()}: {$e->getMessage()}");
                }
            }
        }
        
        return [
            'success' => $failed === 0,
            'tested' => $tested,
            'failed' => $failed,
            'errors' => $errors
        ];
    }

    /**
     * Test database connection and queries
     */
    private function testDatabase(bool $verbose): array
    {
        $this->info('🗄️ Testing database...');
        
        try {
            // Test connection
            DB::connection()->getPdo();
            
            if ($verbose) {
                $this->line('  ✅ Database connection successful');
            }
            
            // Test basic query
            $result = DB::select('SELECT 1 as test');
            
            if ($verbose) {
                $this->line('  ✅ Basic query test passed');
            }
            
            // Test table existence
            $tables = DB::select("SELECT name FROM sqlite_master WHERE type='table'");
            $tableCount = count($tables);
            
            if ($verbose) {
                $this->line("  ✅ Found {$tableCount} tables");
            }
            
            // Test specific models
            $modelTests = $this->testModels($verbose);
            
            return [
                'success' => true,
                'connection' => 'successful',
                'tables' => $tableCount,
                'model_tests' => $modelTests
            ];
            
        } catch (\Exception $e) {
            if ($verbose) {
                $this->error("  ❌ Database test failed: {$e->getMessage()}");
            }
            
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Test cache system
     */
    private function testCache(bool $verbose): array
    {
        $this->info('💾 Testing cache...');
        
        try {
            $testKey = 'system_test_' . time();
            $testValue = 'test_value_' . rand(1000, 9999);
            
            // Test write
            Cache::put($testKey, $testValue, 60);
            
            if ($verbose) {
                $this->line('  ✅ Cache write test passed');
            }
            
            // Test read
            $retrievedValue = Cache::get($testKey);
            
            if ($retrievedValue !== $testValue) {
                throw new \Exception('Cache read test failed');
            }
            
            if ($verbose) {
                $this->line('  ✅ Cache read test passed');
            }
            
            // Test delete
            Cache::forget($testKey);
            $deletedValue = Cache::get($testKey);
            
            if ($deletedValue !== null) {
                throw new \Exception('Cache delete test failed');
            }
            
            if ($verbose) {
                $this->line('  ✅ Cache delete test passed');
            }
            
            return [
                'success' => true,
                'write' => 'successful',
                'read' => 'successful',
                'delete' => 'successful'
            ];
            
        } catch (\Exception $e) {
            if ($verbose) {
                $this->error("  ❌ Cache test failed: {$e->getMessage()}");
            }
            
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Test external services
     */
    private function testServices(bool $verbose): array
    {
        $this->info('🔧 Testing services...');
        
        $results = [];
        
        // Test WhatsApp service
        try {
            $whatsappStatus = $this->wuzapiService->checkConnection();
            $results['whatsapp'] = [
                'success' => $whatsappStatus,
                'status' => $whatsappStatus ? 'connected' : 'disconnected'
            ];
            
            if ($verbose) {
                $status = $whatsappStatus ? '✅' : '⚠️';
                $this->line("  {$status} WhatsApp service: " . ($whatsappStatus ? 'Connected' : 'Disconnected (using mock mode)'));
            }
        } catch (\Exception $e) {
            $results['whatsapp'] = [
                'success' => false,
                'error' => $e->getMessage()
            ];
            
            if ($verbose) {
                $this->error("  ❌ WhatsApp service test failed: {$e->getMessage()}");
            }
        }
        
        // Test email configuration
        try {
            $mailConfig = config('mail');
            $mailer = $mailConfig['default'];
            $host = $mailConfig['mailers'][$mailer]['host'] ?? null;
            
            $results['email'] = [
                'success' => (bool) $host,
                'mailer' => $mailer,
                'host' => $host
            ];
            
            if ($verbose) {
                $status = $host ? '✅' : '⚠️';
                $this->line("  {$status} Email service: " . ($host ? "Configured ({$mailer})" : 'Not configured'));
            }
        } catch (\Exception $e) {
            $results['email'] = [
                'success' => false,
                'error' => $e->getMessage()
            ];
            
            if ($verbose) {
                $this->error("  ❌ Email service test failed: {$e->getMessage()}");
            }
        }
        
        return $results;
    }

    /**
     * Test model functionality
     */
    private function testModels(bool $verbose): array
    {
        $models = [
            'User' => \App\Models\User::class,
            'Raffle' => \App\Models\Raffle::class,
            'Ticket' => \App\Models\Ticket::class,
            'Cart' => \App\Models\Cart::class,
        ];
        
        $results = [];
        
        foreach ($models as $name => $class) {
            try {
                // Test model instantiation
                $model = new $class();
                
                // Test basic query
                $count = $class::count();
                
                $results[$name] = [
                    'success' => true,
                    'count' => $count
                ];
                
                if ($verbose) {
                    $this->line("  ✅ {$name} model: {$count} records");
                }
            } catch (\Exception $e) {
                $results[$name] = [
                    'success' => false,
                    'error' => $e->getMessage()
                ];
                
                if ($verbose) {
                    $this->error("  ❌ {$name} model test failed: {$e->getMessage()}");
                }
            }
        }
        
        return $results;
    }

    /**
     * Display test results
     */
    private function displayResults(array $results): void
    {
        $this->newLine();
        $this->info('📊 Test Results Summary');
        $this->line('═══════════════════════════════════════');
        
        $totalTests = count($results);
        $passedTests = collect($results)->filter(fn($result) => $result['success'])->count();
        
        foreach ($results as $component => $result) {
            $icon = $result['success'] ? '✅' : '❌';
            $this->line("{$icon} " . strtoupper($component) . ": " . ($result['success'] ? 'PASSED' : 'FAILED'));
            
            if (!$result['success'] && isset($result['error'])) {
                $this->line("   └─ Error: {$result['error']}");
            }
        }
        
        $this->newLine();
        $this->line("Total: {$passedTests}/{$totalTests} tests passed");
        
        if ($passedTests === $totalTests) {
            $this->info('🎉 All tests passed! System is healthy.');
        } else {
            $this->warn('⚠️ Some tests failed. Please check the issues above.');
        }
    }
}
