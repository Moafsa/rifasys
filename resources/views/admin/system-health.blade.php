<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Health Dashboard - RAFE</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        
        .header h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }
        
        .header p {
            font-size: 1.1rem;
            opacity: 0.9;
        }
        
        .status-overview {
            display: flex;
            justify-content: center;
            gap: 30px;
            padding: 30px;
            background: #f8f9fa;
        }
        
        .status-card {
            text-align: center;
            padding: 20px;
            border-radius: 10px;
            background: white;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            min-width: 150px;
        }
        
        .status-indicator {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            margin: 0 auto 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: bold;
        }
        
        .status-healthy {
            background: #d4edda;
            color: #155724;
        }
        
        .status-degraded {
            background: #fff3cd;
            color: #856404;
        }
        
        .status-unhealthy {
            background: #f8d7da;
            color: #721c24;
        }
        
        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            padding: 30px;
        }
        
        .service-card {
            background: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            border-left: 5px solid #ddd;
        }
        
        .service-card.healthy {
            border-left-color: #28a745;
        }
        
        .service-card.degraded {
            border-left-color: #ffc107;
        }
        
        .service-card.unhealthy {
            border-left-color: #dc3545;
        }
        
        .service-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .service-name {
            font-size: 1.2rem;
            font-weight: bold;
            text-transform: capitalize;
        }
        
        .service-status {
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .service-status.healthy {
            background: #d4edda;
            color: #155724;
        }
        
        .service-status.degraded {
            background: #fff3cd;
            color: #856404;
        }
        
        .service-status.unhealthy {
            background: #f8d7da;
            color: #721c24;
        }
        
        .service-details {
            font-size: 0.9rem;
            color: #666;
            line-height: 1.6;
        }
        
        .metrics-section {
            background: #f8f9fa;
            padding: 30px;
        }
        
        .metrics-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        
        .metric-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }
        
        .metric-value {
            font-size: 2rem;
            font-weight: bold;
            color: #667eea;
            margin-bottom: 5px;
        }
        
        .metric-label {
            font-size: 0.9rem;
            color: #666;
            text-transform: uppercase;
        }
        
        .actions {
            padding: 30px;
            text-align: center;
        }
        
        .btn {
            display: inline-block;
            padding: 12px 30px;
            margin: 0 10px;
            border: none;
            border-radius: 25px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .btn-primary {
            background: #667eea;
            color: white;
        }
        
        .btn-primary:hover {
            background: #5a6fd8;
            transform: translateY(-2px);
        }
        
        .btn-secondary {
            background: #6c757d;
            color: white;
        }
        
        .btn-secondary:hover {
            background: #5a6268;
            transform: translateY(-2px);
        }
        
        .btn-success {
            background: #28a745;
            color: white;
        }
        
        .btn-success:hover {
            background: #218838;
            transform: translateY(-2px);
        }
        
        .refresh-info {
            text-align: center;
            padding: 20px;
            background: #e9ecef;
            color: #666;
            font-size: 0.9rem;
        }
        
        @media (max-width: 768px) {
            .status-overview {
                flex-direction: column;
                gap: 15px;
            }
            
            .services-grid {
                grid-template-columns: 1fr;
            }
            
            .metrics-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔧 System Health Dashboard</h1>
            <p>Monitoramento em tempo real do sistema RAFE</p>
        </div>
        
        <div class="status-overview">
            <div class="status-card">
                <div class="status-indicator status-{{ $health['overall_status'] }}">
                    @if($health['overall_status'] === 'healthy')
                        ✅
                    @elseif($health['overall_status'] === 'degraded')
                        ⚠️
                    @else
                        ❌
                    @endif
                </div>
                <h3>Overall Status</h3>
                <p>{{ ucfirst($health['overall_status']) }}</p>
            </div>
            
            <div class="status-card">
                <div class="status-indicator">
                    {{ count($health['services']) }}
                </div>
                <h3>Services</h3>
                <p>Monitored</p>
            </div>
            
            <div class="status-card">
                <div class="status-indicator">
                    {{ $health['timestamp'] }}
                </div>
                <h3>Last Check</h3>
                <p>System Status</p>
            </div>
        </div>
        
        <div class="services-grid">
            @foreach($health['services'] as $serviceName => $serviceData)
                <div class="service-card {{ $serviceData['status'] }}">
                    <div class="service-header">
                        <div class="service-name">{{ ucfirst($serviceName) }}</div>
                        <div class="service-status {{ $serviceData['status'] }}">
                            {{ ucfirst($serviceData['status']) }}
                        </div>
                    </div>
                    <div class="service-details">
                        @if(isset($serviceData['message']))
                            <p><strong>Status:</strong> {{ $serviceData['message'] }}</p>
                        @endif
                        
                        @if(isset($serviceData['response_time_ms']))
                            <p><strong>Response Time:</strong> {{ $serviceData['response_time_ms'] }}ms</p>
                        @endif
                        
                        @if(isset($serviceData['connection']))
                            <p><strong>Connection:</strong> {{ ucfirst($serviceData['connection']) }}</p>
                        @endif
                        
                        @if(isset($serviceData['error']))
                            <p style="color: #dc3545;"><strong>Error:</strong> {{ $serviceData['error'] }}</p>
                        @endif
                        
                        @if($serviceName === 'memory' && isset($serviceData['usage_percentage']))
                            <p><strong>Memory Usage:</strong> {{ $serviceData['usage_percentage'] }}%</p>
                        @endif
                        
                        @if($serviceName === 'filesystem' && isset($serviceData['usage_percentage']))
                            <p><strong>Disk Usage:</strong> {{ $serviceData['usage_percentage'] }}%</p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="metrics-section">
            <h2 style="text-align: center; margin-bottom: 20px;">📊 System Metrics</h2>
            <div class="metrics-grid">
                <div class="metric-card">
                    <div class="metric-value">{{ round($metrics['memory_usage'] / (1024 * 1024), 2) }} MB</div>
                    <div class="metric-label">Memory Usage</div>
                </div>
                <div class="metric-card">
                    <div class="metric-value">{{ round($metrics['memory_peak'] / (1024 * 1024), 2) }} MB</div>
                    <div class="metric-label">Memory Peak</div>
                </div>
                <div class="metric-card">
                    <div class="metric-value">{{ round($metrics['disk_free'] / (1024 * 1024 * 1024), 2) }} GB</div>
                    <div class="metric-label">Free Disk Space</div>
                </div>
                <div class="metric-card">
                    <div class="metric-value">{{ $metrics['php_version'] }}</div>
                    <div class="metric-label">PHP Version</div>
                </div>
                <div class="metric-card">
                    <div class="metric-value">{{ $metrics['laravel_version'] }}</div>
                    <div class="metric-label">Laravel Version</div>
                </div>
                <div class="metric-card">
                    <div class="metric-value">{{ $metrics['uptime'] ?? 'N/A' }}</div>
                    <div class="metric-label">System Load</div>
                </div>
            </div>
        </div>
        
        <div class="actions">
            <button class="btn btn-primary" onclick="refreshHealth()">🔄 Refresh Status</button>
            <button class="btn btn-secondary" onclick="testDatabase()">🗄️ Test Database</button>
            <button class="btn btn-success" onclick="cleanupSystem()">🧹 System Cleanup</button>
        </div>
        
        <div class="refresh-info">
            <p>Last updated: {{ $health['timestamp'] }}</p>
            <p>Auto-refresh every 30 seconds</p>
        </div>
    </div>
    
    <script>
        // Auto-refresh every 30 seconds
        setInterval(() => {
            location.reload();
        }, 30000);
        
        function refreshHealth() {
            location.reload();
        }
        
        async function testDatabase() {
            try {
                const response = await fetch('/admin/health/test-database');
                const result = await response.json();
                
                if (result.success) {
                    alert('Database test successful! Response time: ' + result.response_time_ms + 'ms');
                } else {
                    alert('Database test failed: ' + result.error);
                }
            } catch (error) {
                alert('Error testing database: ' + error.message);
            }
        }
        
        async function cleanupSystem() {
            if (confirm('Are you sure you want to perform system cleanup? This will clear caches and optimize memory.')) {
                try {
                    const response = await fetch('/admin/health/cleanup');
                    const result = await response.json();
                    
                    if (result.success) {
                        alert('System cleanup completed successfully!');
                        location.reload();
                    } else {
                        alert('Cleanup failed: ' + result.error);
                    }
                } catch (error) {
                    alert('Error during cleanup: ' + error.message);
                }
            }
        }
    </script>
</body>
</html>
