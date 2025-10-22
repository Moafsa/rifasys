<?php

return [
    /*
    |--------------------------------------------------------------------------
    | WhatsApp Business Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for WhatsApp Business integration
    |
    */

    'business_number' => env('WHATSAPP_BUSINESS_NUMBER', '5511999999999'),
    
    'api_url' => env('WHATSAPP_API_URL', 'http://localhost:8083'),
    
    'timeout' => env('WHATSAPP_TIMEOUT', 10),
    
    'retry_attempts' => env('WHATSAPP_RETRY_ATTEMPTS', 3),
    
    'enable_logging' => env('WHATSAPP_ENABLE_LOGGING', true),
    
    'default_messages' => [
        'verification' => '🔐 **VERIFICAÇÃO DE CADASTRO - RIFASSYS** 🔐',
        'welcome' => '🎉 **BEM-VINDO AO RIFASSYS** 🎉',
        'purchase_confirmation' => '✅ **COMPRA CONFIRMADA** ✅',
        'raffle_notification' => '🎫 **NOVA RIFA DISPONÍVEL** 🎫',
    ],
    
    'templates' => [
        'verification' => [
            'header' => '🔐 **VERIFICAÇÃO DE CADASTRO - RIFASSYS** 🔐',
            'greeting' => 'Olá {name}! 👋',
            'body' => 'Seu cadastro foi realizado com sucesso no Rifassys!',
            'action' => 'Para ativar sua conta e participar das rifas, clique no link abaixo:',
            'link' => '🔗 {link}',
            'instructions' => '📱 **Ou copie e cole no seu navegador:**',
            'validity' => '⏰ Este link é válido por 24 horas.',
            'support' => '❓ **Dúvidas?** Entre em contato conosco pelo WhatsApp.',
            'footer' => '🎫 **Rifassys - Sua plataforma de rifas online!**',
        ],
    ],
];




