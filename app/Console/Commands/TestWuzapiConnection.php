<?php

namespace App\Console\Commands;

use App\Services\WuzapiService;
use App\Services\WuzapiRaffles;
use Illuminate\Console\Command;

class TestWuzapiConnection extends Command
{
    protected $signature = 'wuzapi:test';
    protected $description = 'Test WuzAPI connection and send a test message';

    public function handle()
    {
        $this->info('Testing WuzAPI connection...');
        
        $wuzapiService = app(WuzapiService::class);
        $wuzapiRaffles = app(WuzapiRaffles::class);
        
        // Test connection
        $this->info('Checking connection status...');
        $isConnected = $wuzapiService->isConnected();
        
        if ($isConnected) {
            $this->info('✅ WuzAPI is connected!');
            
            // Get QR code
            $qrCode = $wuzapiService->getQRCode();
            if ($qrCode) {
                $this->info('QR Code available for WhatsApp connection');
            }
            
            // Test message (uncomment to send)
            // $phone = $this->ask('Enter phone number to test (format: 5511999999999)');
            // if ($phone) {
            //     $result = $wuzapiRaffles->sendHelpMessage($phone);
            //     if ($result) {
            //         $this->info('✅ Test message sent successfully!');
            //     } else {
            //         $this->error('❌ Failed to send test message');
            //     }
            // }
            
        } else {
            $this->error('❌ WuzAPI is not connected');
            
            // Get detailed status
            $status = $wuzapiService->getStatus();
            $this->info('Status details: ' . json_encode($status, JSON_PRETTY_PRINT));
        }
        
        return 0;
    }
}
