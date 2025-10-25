<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class WuzapiService
{
    protected Client $client;
    protected string $baseUrl;
    protected string $apiToken;
    protected string $instanceId;

    public function __construct()
    {
        $this->baseUrl = config('services.wuzapi.url', 'http://localhost:8081');
        $this->apiToken = config('services.wuzapi.api_token');
        $this->instanceId = config('services.wuzapi.instance_id');
        
        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'timeout' => 30,
            'connect_timeout' => 10,
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'Token' => $this->apiToken,
            ],
            'http_errors' => false,
        ]);
    }

    /**
     * Send text message via WhatsApp
     */
    public function sendMessage(string $phone, string $message): ?array
    {
        try {
            $response = $this->client->post('/api/send-message', [
                'json' => [
                    'phone' => $this->formatPhone($phone),
                    'message' => $message,
                ],
            ]);

            $result = json_decode($response->getBody()->getContents(), true);
            
            if ($response->getStatusCode() >= 200 && $response->getStatusCode() < 300) {
                Log::info('WuzAPI Message Sent', [
                    'phone' => $this->formatPhone($phone),
                    'status' => $result['status'] ?? 'unknown'
                ]);
                return $result;
            } else {
                Log::error('WuzAPI Send Message Error', [
                    'phone' => $phone,
                    'status_code' => $response->getStatusCode(),
                    'response' => $result
                ]);
                return null;
            }
        } catch (GuzzleException $e) {
            Log::error('WuzAPI Send Message Exception', [
                'phone' => $phone,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Send media message (image, document, etc.)
     */
    public function sendMedia(string $phone, string $mediaUrl, string $caption = '', string $mediaType = 'image'): ?array
    {
        try {
            $response = $this->client->post('/api/send-media', [
                'json' => [
                    'phone' => $this->formatPhone($phone),
                    'media_url' => $mediaUrl,
                    'caption' => $caption,
                    'media_type' => $mediaType,
                ],
            ]);

            $result = json_decode($response->getBody()->getContents(), true);
            
            if ($response->getStatusCode() >= 200 && $response->getStatusCode() < 300) {
                Log::info('WuzAPI Media Sent', [
                    'phone' => $this->formatPhone($phone),
                    'media_type' => $mediaType,
                    'status' => $result['status'] ?? 'unknown'
                ]);
                return $result;
            } else {
                Log::error('WuzAPI Send Media Error', [
                    'phone' => $phone,
                    'media_type' => $mediaType,
                    'status_code' => $response->getStatusCode(),
                    'response' => $result
                ]);
                return null;
            }
        } catch (GuzzleException $e) {
            Log::error('WuzAPI Send Media Exception', [
                'phone' => $phone,
                'media_type' => $mediaType,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Send location message
     */
    public function sendLocation(string $phone, float $latitude, float $longitude, string $name = '', string $address = ''): ?array
    {
        try {
            $response = $this->client->post('/api/send-location', [
                'json' => [
                    'phone' => $this->formatPhone($phone),
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                    'name' => $name,
                    'address' => $address,
                ],
            ]);

            $result = json_decode($response->getBody()->getContents(), true);
            
            if ($response->getStatusCode() >= 200 && $response->getStatusCode() < 300) {
                Log::info('WuzAPI Location Sent', [
                    'phone' => $this->formatPhone($phone),
                    'location' => "{$latitude},{$longitude}",
                    'status' => $result['status'] ?? 'unknown'
                ]);
                return $result;
            } else {
                Log::error('WuzAPI Send Location Error', [
                    'phone' => $phone,
                    'location' => "{$latitude},{$longitude}",
                    'status_code' => $response->getStatusCode(),
                    'response' => $result
                ]);
                return null;
            }
        } catch (GuzzleException $e) {
            Log::error('WuzAPI Send Location Exception', [
                'phone' => $phone,
                'location' => "{$latitude},{$longitude}",
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Send button message
     */
    public function sendButtons(string $phone, string $message, array $buttons): ?array
    {
        try {
            $response = $this->client->post('/api/send-buttons', [
                'json' => [
                    'phone' => $this->formatPhone($phone),
                    'message' => $message,
                    'buttons' => $buttons,
                ],
            ]);

            $result = json_decode($response->getBody()->getContents(), true);
            
            if ($response->getStatusCode() >= 200 && $response->getStatusCode() < 300) {
                Log::info('WuzAPI Buttons Sent', [
                    'phone' => $this->formatPhone($phone),
                    'buttons_count' => count($buttons),
                    'status' => $result['status'] ?? 'unknown'
                ]);
                return $result;
            } else {
                Log::error('WuzAPI Send Buttons Error', [
                    'phone' => $phone,
                    'buttons_count' => count($buttons),
                    'status_code' => $response->getStatusCode(),
                    'response' => $result
                ]);
                return null;
            }
        } catch (GuzzleException $e) {
            Log::error('WuzAPI Send Buttons Exception', [
                'phone' => $phone,
                'buttons' => $buttons,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Send list message
     */
    public function sendList(string $phone, string $message, string $buttonText, array $sections): ?array
    {
        try {
            $response = $this->client->post('/api/send-list', [
                'json' => [
                    'phone' => $this->formatPhone($phone),
                    'message' => $message,
                    'button_text' => $buttonText,
                    'sections' => $sections,
                ],
            ]);

            $result = json_decode($response->getBody()->getContents(), true);
            
            if ($response->getStatusCode() >= 200 && $response->getStatusCode() < 300) {
                Log::info('WuzAPI List Sent', [
                    'phone' => $this->formatPhone($phone),
                    'sections_count' => count($sections),
                    'status' => $result['status'] ?? 'unknown'
                ]);
                return $result;
            } else {
                Log::error('WuzAPI Send List Error', [
                    'phone' => $phone,
                    'sections_count' => count($sections),
                    'status_code' => $response->getStatusCode(),
                    'response' => $result
                ]);
                return null;
            }
        } catch (GuzzleException $e) {
            Log::error('WuzAPI Send List Exception', [
                'phone' => $phone,
                'sections' => $sections,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Get connection status
     */
    public function getStatus(): ?array
    {
        try {
            $response = $this->client->get('/api/status');
            $result = json_decode($response->getBody()->getContents(), true);
            
            if ($response->getStatusCode() >= 200 && $response->getStatusCode() < 300) {
                return $result;
            } else {
                Log::error('WuzAPI Get Status Error', [
                    'status_code' => $response->getStatusCode(),
                    'response' => $result
                ]);
                return null;
            }
        } catch (GuzzleException $e) {
            Log::error('WuzAPI Get Status Exception', [
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Get QR code for WhatsApp connection
     */
    public function getQRCode(): ?string
    {
        try {
            $response = $this->client->get('/api/qr');
            $result = json_decode($response->getBody()->getContents(), true);
            
            if ($response->getStatusCode() >= 200 && $response->getStatusCode() < 300) {
                return $result['qr'] ?? null;
            } else {
                Log::error('WuzAPI Get QR Code Error', [
                    'status_code' => $response->getStatusCode(),
                    'response' => $result
                ]);
                return null;
            }
        } catch (GuzzleException $e) {
            Log::error('WuzAPI Get QR Code Exception', [
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Get message status
     */
    public function getMessageStatus(string $messageId): ?array
    {
        try {
            $response = $this->client->get("/api/message/{$messageId}/status");
            $result = json_decode($response->getBody()->getContents(), true);
            
            if ($response->getStatusCode() >= 200 && $response->getStatusCode() < 300) {
                return $result;
            } else {
                Log::error('WuzAPI Get Message Status Error', [
                    'message_id' => $messageId,
                    'status_code' => $response->getStatusCode(),
                    'response' => $result
                ]);
                return null;
            }
        } catch (GuzzleException $e) {
            Log::error('WuzAPI Get Message Status Exception', [
                'message_id' => $messageId,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Check if WhatsApp is connected
     */
    public function isConnected(): bool
    {
        $status = $this->getStatus();
        return isset($status['status']) && $status['status'] === 'connected';
    }

    /**
     * Format phone number for WhatsApp (Brazil format)
     */
    private function formatPhone(string $phone): string
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
     * Validate phone number format
     */
    public function validatePhone(string $phone): bool
    {
        $formatted = $this->formatPhone($phone);
        
        // Brazilian phone numbers with country code should be 13 digits
        // Format: 55XXXXXXXXXXX (55 + 2 digit area code + 8 or 9 digit number)
        return strlen($formatted) === 13 && substr($formatted, 0, 2) === '55';
    }

    /**
     * Test connection with retry mechanism
     */
    public function testConnection(int $maxRetries = 3): bool
    {
        $retries = 0;
        
        while ($retries < $maxRetries) {
            try {
                $response = $this->client->get('/api/status', [
                    'timeout' => 10,
                    'connect_timeout' => 5
                ]);
                
                $result = json_decode($response->getBody()->getContents(), true);
                
                if (isset($result['status']) && $result['status'] === 'connected') {
                    Log::info('WuzAPI Connection Test Successful', [
                        'retries' => $retries,
                        'response_time' => $response->getHeader('X-Response-Time')[0] ?? 'unknown'
                    ]);
                    return true;
                }
                
            } catch (GuzzleException $e) {
                $retries++;
                Log::warning('WuzAPI Connection Test Failed', [
                    'attempt' => $retries,
                    'max_retries' => $maxRetries,
                    'error' => $e->getMessage()
                ]);
                
                if ($retries < $maxRetries) {
                    sleep(1); // Wait 1 second before retry
                }
            }
        }
        
        return false;
    }
}
