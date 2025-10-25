<?php

return [
    /*
    |--------------------------------------------------------------------------
    | WuzAPI Manager Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for your WuzAPI Manager instance
    | URL: wuzapidiv.conext.click
    |
    */

    'manager' => [
        'url' => env('WUZAPI_MANAGER_URL', 'https://wuzapidiv.conext.click'),
        'api_token' => env('WUZAPI_MANAGER_TOKEN'),
        'instance_id' => env('WUZAPI_MANAGER_INSTANCE_ID'),
        'webhook_secret' => env('WUZAPI_MANAGER_WEBHOOK_SECRET'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Webhook Configuration
    |--------------------------------------------------------------------------
    |
    | Configure your webhook URL to receive WhatsApp events
    |
    */

    'webhook' => [
        'url' => env('WUZAPI_WEBHOOK_URL', env('APP_URL') . '/api/webhooks/whatsapp'),
        'secret' => env('WUZAPI_WEBHOOK_SECRET'),
        'events' => [
            'Message',
            'ReadReceipt', 
            'Presence',
            'HistorySync',
            'ChatPresence'
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Connection Settings
    |--------------------------------------------------------------------------
    |
    | Configure connection timeouts and retry settings
    |
    */

    'connection' => [
        'timeout' => env('WUZAPI_TIMEOUT', 30),
        'retry_attempts' => env('WUZAPI_RETRY_ATTEMPTS', 3),
        'retry_delay' => env('WUZAPI_RETRY_DELAY', 1),
        'max_retries' => env('WUZAPI_MAX_RETRIES', 3),
    ],

    /*
    |--------------------------------------------------------------------------
    | Message Settings
    |--------------------------------------------------------------------------
    |
    | Configure message sending settings
    |
    */

    'messages' => [
        'max_length' => 4096,
        'rate_limit' => env('WUZAPI_RATE_LIMIT', 100), // messages per minute
        'retry_failed' => env('WUZAPI_RETRY_FAILED', true),
        'log_all' => env('WUZAPI_LOG_ALL', true),
    ],

    /*
    |--------------------------------------------------------------------------
    | Raffle Notifications
    |--------------------------------------------------------------------------
    |
    | Configure raffle-specific notifications
    |
    */

    'raffle_notifications' => [
        'enabled' => env('WUZAPI_RAFFLE_NOTIFICATIONS', true),
        'purchase_confirmation' => env('WUZAPI_PURCHASE_CONFIRMATION', true),
        'draw_notifications' => env('WUZAPI_DRAW_NOTIFICATIONS', true),
        'winner_notifications' => env('WUZAPI_WINNER_NOTIFICATIONS', true),
        'reminder_notifications' => env('WUZAPI_REMINDER_NOTIFICATIONS', true),
        'share_notifications' => env('WUZAPI_SHARE_NOTIFICATIONS', true),
    ],

    /*
    |--------------------------------------------------------------------------
    | Security Settings
    |--------------------------------------------------------------------------
    |
    | Configure security settings for webhook validation
    |
    */

    'security' => [
        'validate_signature' => env('WUZAPI_VALIDATE_SIGNATURE', true),
        'allowed_ips' => env('WUZAPI_ALLOWED_IPS', ''),
        'rate_limit_webhook' => env('WUZAPI_WEBHOOK_RATE_LIMIT', 100), // requests per minute
    ],

    /*
    |--------------------------------------------------------------------------
    | Monitoring Settings
    |--------------------------------------------------------------------------
    |
    | Configure monitoring and health checks
    |
    */

    'monitoring' => [
        'health_check_interval' => env('WUZAPI_HEALTH_CHECK_INTERVAL', 300), // seconds
        'log_connection_status' => env('WUZAPI_LOG_CONNECTION_STATUS', true),
        'alert_on_disconnect' => env('WUZAPI_ALERT_ON_DISCONNECT', true),
        'alert_email' => env('WUZAPI_ALERT_EMAIL'),
    ],
];
