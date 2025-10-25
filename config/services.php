<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | WuzAPI (WhatsApp API)
    |--------------------------------------------------------------------------
    |
    | Configuration for WuzAPI WhatsApp integration
    | Based on official WuzAPI documentation: https://github.com/asternic/wuzapi
    |
    */

    'wuzapi' => [
        'url' => env('WUZAPI_URL', 'http://localhost:8081'),
        'api_token' => env('WUZAPI_API_TOKEN'),
        'instance_id' => env('WUZAPI_INSTANCE_ID'),
        'webhook_url' => env('APP_URL') . '/api/webhooks/whatsapp',
        'webhook_secret' => env('WUZAPI_WEBHOOK_SECRET'),
        
        // Connection settings
        'timeout' => env('WUZAPI_TIMEOUT', 30),
        'retry_attempts' => env('WUZAPI_RETRY_ATTEMPTS', 3),
        'retry_delay' => env('WUZAPI_RETRY_DELAY', 1),
        
        // Message settings
        'message_settings' => [
            'max_retries' => 3,
            'retry_delay' => 1,
            'timeout' => 30,
        ],
        
        // Raffle-specific settings
        'raffle_notifications' => [
            'enabled' => env('WUZAPI_RAFFLE_NOTIFICATIONS', true),
            'purchase_confirmation' => env('WUZAPI_PURCHASE_CONFIRMATION', true),
            'draw_notifications' => env('WUZAPI_DRAW_NOTIFICATIONS', true),
            'winner_notifications' => env('WUZAPI_WINNER_NOTIFICATIONS', true),
        ],
    ],

];
