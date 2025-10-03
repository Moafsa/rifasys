<?php

/**
 * External Services Configuration
 * 
 * This file should be placed at: config/services.php
 * 
 * Add these configurations to your existing config/services.php file
 * or replace the entire file with this content.
 */

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

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Asaas Payment Gateway
    |--------------------------------------------------------------------------
    |
    | Configuration for Asaas payment integration
    | 
    | Environment options:
    | - 'sandbox' for testing (sandbox.asaas.com)
    | - 'production' for live transactions (www.asaas.com)
    |
    */

    'asaas' => [
        'api_key' => env('ASAAS_API_KEY'),
        'environment' => env('ASAAS_ENVIRONMENT', 'sandbox'),
        'url' => env('ASAAS_ENVIRONMENT', 'sandbox') === 'production' 
            ? 'https://www.asaas.com/api/v3'
            : 'https://sandbox.asaas.com/api/v3',
        
        // Platform fee configuration (percentage)
        'platform_fee_percentage' => env('ASAAS_PLATFORM_FEE', 5.0), // 5% default
        
        // PIX configuration
        'pix_expiration_minutes' => env('ASAAS_PIX_EXPIRATION', 15), // 15 minutes default
    ],

    /*
    |--------------------------------------------------------------------------
    | Wuzapi (WhatsApp API)
    |--------------------------------------------------------------------------
    |
    | Configuration for Wuzapi WhatsApp integration
    | Wuzapi runs as a Docker container service
    |
    */

    'wuzapi' => [
        'url' => env('WUZAPI_URL', 'http://wuzapi:8081'),
        'webhook_url' => env('APP_URL') . '/api/webhooks/whatsapp',
        
        // Message templates
        'templates' => [
            'purchase_confirmation' => [
                'enabled' => true,
                'delay_seconds' => 5,
            ],
            'winner_notification' => [
                'enabled' => true,
                'delay_seconds' => 0,
            ],
            'delivery_confirmation' => [
                'enabled' => true,
                'delay_seconds' => 0,
                'expiration_hours' => 48,
                'max_attempts' => 3,
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | OpenAI API
    |--------------------------------------------------------------------------
    |
    | Configuration for OpenAI integration (GPT-4)
    | Used for AI-generated regulations and chatbot responses
    |
    */

    'openai' => [
        'api_key' => env('OPENAI_API_KEY'),
        'organization' => env('OPENAI_ORGANIZATION', null),
        'model' => env('OPENAI_MODEL', 'gpt-4'),
        
        // Token limits
        'max_tokens' => [
            'regulation' => 2000,
            'chatbot' => 1000,
            'general' => 1500,
        ],
        
        // Temperature settings (0-2, lower = more focused)
        'temperature' => [
            'regulation' => 0.3, // More precise for legal text
            'chatbot' => 0.8,    // More natural for conversations
        ],
        
        // Cost tracking (USD per 1K tokens)
        'cost_per_1k_tokens' => [
            'input' => 0.03,
            'output' => 0.06,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Raffle Configuration
    |--------------------------------------------------------------------------
    |
    | Business logic configuration for raffle operations
    |
    */

    'raffle' => [
        // Number reservation timeout (minutes)
        'reservation_timeout' => env('RAFFLE_RESERVATION_TIMEOUT', 15),
        
        // Maximum numbers per purchase
        'max_numbers_per_purchase' => env('RAFFLE_MAX_NUMBERS', 50),
        
        // Minimum raffle duration (hours)
        'min_duration_hours' => env('RAFFLE_MIN_DURATION', 24),
        
        // Maximum images per raffle
        'max_images' => env('RAFFLE_MAX_IMAGES', 10),
        
        // Image upload limits
        'image_max_size_mb' => env('RAFFLE_IMAGE_MAX_SIZE', 5),
        'allowed_image_types' => ['jpg', 'jpeg', 'png', 'webp'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Transaction Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for financial transactions and custody
    |
    */

    'transaction' => [
        // CPF custody configuration
        'custody' => [
            'hold_days' => env('TRANSACTION_CUSTODY_HOLD_DAYS', 7),
            'auto_release' => env('TRANSACTION_AUTO_RELEASE', false),
        ],
        
        // CNPJ split configuration
        'split' => [
            'instant_transfer' => true,
        ],
        
        // Refund configuration
        'refund' => [
            'enabled' => true,
            'deadline_days' => env('TRANSACTION_REFUND_DEADLINE', 7),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Rate Limiting
    |--------------------------------------------------------------------------
    |
    | Configuration for API rate limiting
    |
    */

    'rate_limit' => [
        'purchase' => [
            'max_attempts' => env('RATE_LIMIT_PURCHASE', 10),
            'decay_minutes' => 60,
        ],
        'chatbot' => [
            'max_attempts' => env('RATE_LIMIT_CHATBOT', 30),
            'decay_minutes' => 1,
        ],
        'api' => [
            'max_attempts' => env('RATE_LIMIT_API', 60),
            'decay_minutes' => 1,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Lottery References
    |--------------------------------------------------------------------------
    |
    | Configuration for lottery-based draws
    |
    */

    'lottery' => [
        'sources' => [
            'federal' => [
                'name' => 'Loteria Federal',
                'api_url' => 'https://servicebus2.caixa.gov.br/portaldeloterias/api/federal',
            ],
            'mega_sena' => [
                'name' => 'Mega-Sena',
                'api_url' => 'https://servicebus2.caixa.gov.br/portaldeloterias/api/megasena',
            ],
        ],
        'fallback_to_random' => true,
    ],

];


