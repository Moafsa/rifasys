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
    | WuzAPI runs as a Docker container service
    |
    */

    'wuzapi' => [
        'url' => env('WUZAPI_URL', 'http://wuzapi:8081'),
        'webhook_url' => env('APP_URL') . '/api/webhooks/whatsapp',
        'webhook_secret' => env('WUZAPI_WEBHOOK_SECRET'),
        'api_token' => env('WUZAPI_API_TOKEN'),
        'instance_id' => env('WUZAPI_INSTANCE_ID'),
        
        // Message templates
        'templates' => [
            'verification_code' => [
                'enabled' => true,
                'expiration_minutes' => 3,
                'template_name' => env('WUZAPI_VERIFICATION_TEMPLATE', 'verification_code'),
            ],
            'verification_confirmation' => [
                'enabled' => true,
                'expiration_minutes' => 5,
                'template_name' => env('WUZAPI_CONFIRMATION_TEMPLATE', 'verification_confirmation'),
            ],
            'purchase_confirmation' => [
                'enabled' => true,
                'delay_seconds' => 5,
                'template_name' => env('WUZAPI_PURCHASE_TEMPLATE', 'purchase_confirmation'),
            ],
        ],
        
        // Connection settings
        'connection' => [
            'timeout' => env('WUZAPI_TIMEOUT', 30),
            'retry_attempts' => env('WUZAPI_RETRY_ATTEMPTS', 3),
            'retry_delay' => env('WUZAPI_RETRY_DELAY', 1),
        ],
    ],

];
