<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Mail Configuration
    |--------------------------------------------------------------------------
    |
    | Temporary configuration to disable email sending due to SMTP issues
    | and force WhatsApp verification only.
    |
    */

    'mailer' => env('MAIL_MAILER', 'array'), // Using 'array' to disable actual sending
    'host' => env('MAIL_HOST', 'localhost'),
    'port' => env('MAIL_PORT', 2525),
    'encryption' => env('MAIL_ENCRYPTION', null),
    'username' => env('MAIL_USERNAME'),
    'password' => env('MAIL_PASSWORD'),
    'timeout' => null,
    'local_domain' => env('MAIL_EHLO_DOMAIN'),

    'stream' => [
        'ssl' => [
            'allow_self_signed' => true,
            'verify_peer' => false,
            'verify_peer_name' => false,
        ],
    ],

    'from' => [
        'address' => env('MAIL_FROM_ADDRESS', 'hello@example.com'),
        'name' => env('MAIL_FROM_NAME', 'Example'),
    ],

    // Force WhatsApp verification only
    'force_whatsapp_only' => env('FORCE_WHATSAPP_ONLY', true),
];