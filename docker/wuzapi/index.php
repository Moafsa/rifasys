<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];
$path = $_SERVER['REQUEST_URI'];

// Simple routing
switch ($path) {
    case '/api/status':
        if ($method === 'GET') {
            echo json_encode([
                'status' => 'connected',
                'message' => 'WuzAPI Mock Server is running',
                'timestamp' => date('Y-m-d H:i:s')
            ]);
        }
        break;
        
    case '/api/send-message':
        if ($method === 'POST') {
            $input = json_decode(file_get_contents('php://input'), true);
            
            // Log the message (in real implementation, this would send via WhatsApp)
            $logEntry = [
                'timestamp' => date('Y-m-d H:i:s'),
                'phone' => $input['phone'] ?? 'unknown',
                'message' => $input['message'] ?? 'no message',
                'status' => 'sent'
            ];
            
            // Write to log file
            file_put_contents('/tmp/wuzapi_messages.log', json_encode($logEntry) . "\n", FILE_APPEND);
            
            echo json_encode([
                'status' => 'sent',
                'message' => 'Message sent successfully (mock)',
                'phone' => $input['phone'] ?? 'unknown',
                'timestamp' => date('Y-m-d H:i:s')
            ]);
        }
        break;
        
    case '/api/send-buttons':
        if ($method === 'POST') {
            $input = json_decode(file_get_contents('php://input'), true);
            
            // Log the button message
            $logEntry = [
                'timestamp' => date('Y-m-d H:i:s'),
                'phone' => $input['phone'] ?? 'unknown',
                'message' => $input['message'] ?? 'no message',
                'buttons' => $input['buttons'] ?? [],
                'status' => 'sent'
            ];
            
            file_put_contents('/tmp/wuzapi_messages.log', json_encode($logEntry) . "\n", FILE_APPEND);
            
            echo json_encode([
                'status' => 'sent',
                'message' => 'Button message sent successfully (mock)',
                'phone' => $input['phone'] ?? 'unknown',
                'timestamp' => date('Y-m-d H:i:s')
            ]);
        }
        break;
        
    case '/api/qr':
        if ($method === 'GET') {
            echo json_encode([
                'qr' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg==',
                'status' => 'connected',
                'message' => 'QR Code available (mock mode)'
            ]);
        }
        break;
        
    case '/api/send-template':
        if ($method === 'POST') {
            $input = json_decode(file_get_contents('php://input'), true);
            
            $logEntry = [
                'timestamp' => date('Y-m-d H:i:s'),
                'phone' => $input['phone'] ?? 'unknown',
                'template_name' => $input['template_name'] ?? 'unknown',
                'parameters' => $input['parameters'] ?? [],
                'status' => 'sent'
            ];
            
            file_put_contents('/tmp/wuzapi_messages.log', json_encode($logEntry) . "\n", FILE_APPEND);
            
            echo json_encode([
                'status' => 'sent',
                'message' => 'Template message sent successfully (mock)',
                'phone' => $input['phone'] ?? 'unknown',
                'template' => $input['template_name'] ?? 'unknown',
                'timestamp' => date('Y-m-d H:i:s')
            ]);
        }
        break;
        
    case '/api/send-media':
        if ($method === 'POST') {
            $input = json_decode(file_get_contents('php://input'), true);
            
            $logEntry = [
                'timestamp' => date('Y-m-d H:i:s'),
                'phone' => $input['phone'] ?? 'unknown',
                'media_url' => $input['media_url'] ?? 'unknown',
                'media_type' => $input['media_type'] ?? 'unknown',
                'caption' => $input['caption'] ?? '',
                'status' => 'sent'
            ];
            
            file_put_contents('/tmp/wuzapi_messages.log', json_encode($logEntry) . "\n", FILE_APPEND);
            
            echo json_encode([
                'status' => 'sent',
                'message' => 'Media message sent successfully (mock)',
                'phone' => $input['phone'] ?? 'unknown',
                'media_type' => $input['media_type'] ?? 'unknown',
                'timestamp' => date('Y-m-d H:i:s')
            ]);
        }
        break;
        
    case '/api/send-location':
        if ($method === 'POST') {
            $input = json_decode(file_get_contents('php://input'), true);
            
            $logEntry = [
                'timestamp' => date('Y-m-d H:i:s'),
                'phone' => $input['phone'] ?? 'unknown',
                'latitude' => $input['latitude'] ?? 'unknown',
                'longitude' => $input['longitude'] ?? 'unknown',
                'name' => $input['name'] ?? '',
                'address' => $input['address'] ?? '',
                'status' => 'sent'
            ];
            
            file_put_contents('/tmp/wuzapi_messages.log', json_encode($logEntry) . "\n", FILE_APPEND);
            
            echo json_encode([
                'status' => 'sent',
                'message' => 'Location message sent successfully (mock)',
                'phone' => $input['phone'] ?? 'unknown',
                'location' => ($input['latitude'] ?? '') . ',' . ($input['longitude'] ?? ''),
                'timestamp' => date('Y-m-d H:i:s')
            ]);
        }
        break;
        
    case '/api/send-list':
        if ($method === 'POST') {
            $input = json_decode(file_get_contents('php://input'), true);
            
            $logEntry = [
                'timestamp' => date('Y-m-d H:i:s'),
                'phone' => $input['phone'] ?? 'unknown',
                'message' => $input['message'] ?? 'unknown',
                'button_text' => $input['button_text'] ?? 'unknown',
                'sections' => $input['sections'] ?? [],
                'status' => 'sent'
            ];
            
            file_put_contents('/tmp/wuzapi_messages.log', json_encode($logEntry) . "\n", FILE_APPEND);
            
            echo json_encode([
                'status' => 'sent',
                'message' => 'List message sent successfully (mock)',
                'phone' => $input['phone'] ?? 'unknown',
                'sections_count' => count($input['sections'] ?? []),
                'timestamp' => date('Y-m-d H:i:s')
            ]);
        }
        break;
        
    default:
        http_response_code(404);
        echo json_encode([
            'error' => 'Endpoint not found',
            'path' => $path,
            'method' => $method
        ]);
        break;
}
?>



