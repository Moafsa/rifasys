@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="relative gradient-purple-blue min-h-screen flex items-center justify-center overflow-hidden">
    <!-- Particles -->
    <div class="absolute inset-0">
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <!-- Content -->
            <div class="text-center lg:text-left animate-fadeInUp">
                       <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-6 leading-tight">
                           A <span class="text-yellow-300">Plataforma Completa</span> para Rifas Online
                       </h1>
                       <p class="text-xl sm:text-2xl text-blue-100 mb-6">
                           Crie, venda e gerencie rifas com tecnologia de ponta
                       </p>
                       <p class="text-lg text-blue-200 mb-8 max-w-2xl mx-auto lg:mx-0">
                           Da criação ao sorteio: tudo automatizado, seguro e transparente. Seja para causas sociais, eventos ou negócios
                       </p>
                
                <!-- Como Funciona - Inline na Hero -->
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8 max-w-4xl mx-auto lg:mx-0">
                    <div class="text-center">
                        <div class="bg-white/20 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-2">
                            <span class="text-xl">🎯</span>
                        </div>
                        <p class="text-white text-sm font-semibold">Crie</p>
                        <p class="text-blue-200 text-xs">2 minutos</p>
                    </div>
                    <div class="text-center">
                        <div class="bg-white/20 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-2">
                            <span class="text-xl">📢</span>
                        </div>
                        <p class="text-white text-sm font-semibold">Compartilhe</p>
                        <p class="text-blue-200 text-xs">Link único</p>
                    </div>
                    <div class="text-center">
                        <div class="bg-white/20 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-2">
                            <span class="text-xl">💰</span>
                        </div>
                        <p class="text-white text-sm font-semibold">Arrecade</p>
                        <p class="text-blue-200 text-xs">Via PIX</p>
                    </div>
                    <div class="text-center">
                        <div class="bg-white/20 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-2">
                            <span class="text-xl">🎉</span>
                        </div>
                        <p class="text-white text-sm font-semibold">Sorteie</p>
                        <p class="text-blue-200 text-xs">Automático</p>
                    </div>
                </div>
                
                <!-- CTAs -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                    <a href="{{ route('register') }}" class="bg-yellow-400 text-gray-900 px-8 py-4 rounded-xl font-bold text-lg hover:bg-yellow-300 transition-all duration-300 hover-scale flex items-center justify-center gap-2">
                        🚀 Começar Agora
                    </a>
                    <a href="{{ route('raffles.index') }}" class="border-2 border-white text-white px-8 py-4 rounded-xl font-bold text-lg hover:bg-white hover:text-gray-900 transition-all duration-300 hover-scale flex items-center justify-center gap-2">
                        💎 Ver Marketplace
                    </a>
                </div>
                
                <!-- WhatsApp Integration Links -->
                <div class="mt-6 flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                    <a href="{{ route('whatsapp.config') }}" class="bg-green-500 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-600 transition-colors flex items-center justify-center gap-2">
                        ⚙️ Configurar WhatsApp
                    </a>
                    <a href="{{ route('whatsapp.examples') }}" class="bg-blue-500 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-600 transition-colors flex items-center justify-center gap-2">
                        📱 WhatsApp Examples
                    </a>
                    <a href="{{ route('whatsapp.test') }}" class="bg-purple-500 text-white px-6 py-3 rounded-lg font-semibold hover:bg-purple-600 transition-colors flex items-center justify-center gap-2">
                        🧪 WhatsApp Tests
                    </a>
                </div>
            </div>
            
            <!-- Illustration -->
            <div class="relative animate-float">
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-8 text-center">
                    <div class="text-6xl mb-4">🎁</div>
                    <p class="text-white text-lg">Ilustração animada de pessoas segurando prêmios</p>
                </div>
            </div>
        </div>
        
        <!-- Floating Cards -->
        <div class="absolute top-32 right-8 hidden xl:block">
            <div class="bg-white/20 backdrop-blur-sm rounded-lg p-4 animate-pulse-slow hover-lift">
                <div class="text-2xl mb-2">🔒</div>
                <p class="text-white font-semibold text-sm">100% Seguro</p>
            </div>
        </div>
        
        <div class="absolute top-52 right-20 hidden xl:block">
            <div class="bg-white/20 backdrop-blur-sm rounded-lg p-4 animate-pulse-slow hover-lift" style="animation-delay: 1s;">
                <div class="text-2xl mb-2">🎲</div>
                <p class="text-white font-semibold text-sm">Sorteio Automatizado</p>
            </div>
        </div>
        
        <div class="absolute top-72 right-12 hidden xl:block">
            <div class="bg-white/20 backdrop-blur-sm rounded-lg p-4 animate-pulse-slow hover-lift" style="animation-delay: 2s;">
                <div class="text-2xl mb-2">💬</div>
                <p class="text-white font-semibold text-sm">Suporte 24/7</p>
            </div>
        </div>
    </div>
</section>

<!-- How RAFE Works - Interactive Carousel -->
<section class="py-20 bg-gradient-to-br from-purple-50 to-blue-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16 scroll-animate">
            <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4">
                Como Funciona o Sistema RAFE
            </h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                A solução definitiva para quem quer criar, vender e organizar rifas de forma profissional
            </p>
        </div>
        
        <!-- Carousel Container -->
        <div class="relative">
            <!-- Carousel Wrapper -->
            <div id="carousel-container" class="overflow-hidden rounded-2xl">
                <div id="carousel-slides" class="flex transition-transform duration-500 ease-in-out">
                    <!-- Slide 1: Criação -->
                    <div class="w-full flex-shrink-0">
                        <div class="bg-white rounded-2xl p-8 lg:p-12 shadow-xl">
                            <div class="grid lg:grid-cols-2 gap-12 items-center">
                                <div>
                                    <div class="inline-flex items-center px-4 py-2 bg-purple-100 text-purple-800 rounded-full text-sm font-medium mb-6">
                                        <span class="w-2 h-2 bg-purple-600 rounded-full mr-2"></span>
                                        Passo 1
                                    </div>
                                    <h3 class="text-3xl font-bold text-gray-900 mb-6">Crie e Configure em Minutos</h3>
                                    <div class="space-y-4">
                                        <div class="flex items-start gap-3">
                                            <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center flex-shrink-0">
                                                <span class="text-purple-600 font-bold text-sm">1</span>
                                            </div>
                                            <p class="text-gray-600">Configure sua rifa: título, prêmio, valores e regras</p>
                                        </div>
                                        <div class="flex items-start gap-3">
                                            <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center flex-shrink-0">
                                                <span class="text-purple-600 font-bold text-sm">2</span>
                                            </div>
                                            <p class="text-gray-600">Defina preços, quantidade de números e data do sorteio</p>
                                        </div>
                                        <div class="flex items-start gap-3">
                                            <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center flex-shrink-0">
                                                <span class="text-purple-600 font-bold text-sm">3</span>
                                            </div>
                                            <p class="text-gray-600">Sistema de pagamento PIX integrado e automatizado</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <div class="bg-gradient-to-br from-purple-100 to-blue-100 rounded-2xl p-8">
                                        <div class="text-6xl mb-4">🎯</div>
                                        <h4 class="text-xl font-bold text-gray-900 mb-2">Interface Intuitiva</h4>
                                        <p class="text-gray-600">Formulário simples e guiado passo a passo</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Slide 2: Divulgação -->
                    <div class="w-full flex-shrink-0">
                        <div class="bg-white rounded-2xl p-8 lg:p-12 shadow-xl">
                            <div class="grid lg:grid-cols-2 gap-12 items-center">
                                <div>
                                    <div class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-800 rounded-full text-sm font-medium mb-6">
                                        <span class="w-2 h-2 bg-blue-600 rounded-full mr-2"></span>
                                        Passo 2
                                    </div>
                                    <h3 class="text-3xl font-bold text-gray-900 mb-6">Venda e Divulgue Automaticamente</h3>
                                    <div class="space-y-4">
                                        <div class="flex items-start gap-3">
                                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                                <span class="text-blue-600 font-bold text-sm">1</span>
                                            </div>
                                            <p class="text-gray-600">Link personalizado e página de vendas profissional</p>
                                        </div>
                                        <div class="flex items-start gap-3">
                                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                                <span class="text-blue-600 font-bold text-sm">2</span>
                                            </div>
                                            <p class="text-gray-600">Integração com WhatsApp, Instagram e Facebook</p>
                                        </div>
                                        <div class="flex items-start gap-3">
                                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                                <span class="text-blue-600 font-bold text-sm">3</span>
                                            </div>
                                            <p class="text-gray-600">QR Code e materiais de marketing prontos</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <div class="bg-gradient-to-br from-blue-100 to-green-100 rounded-2xl p-8">
                                        <div class="text-6xl mb-4">📢</div>
                                        <h4 class="text-xl font-bold text-gray-900 mb-2">Alcance Máximo</h4>
                                        <p class="text-gray-600">Ferramentas de marketing integradas</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Slide 3: Gestão -->
                    <div class="w-full flex-shrink-0">
                        <div class="bg-white rounded-2xl p-8 lg:p-12 shadow-xl">
                            <div class="grid lg:grid-cols-2 gap-12 items-center">
                                <div>
                                    <div class="inline-flex items-center px-4 py-2 bg-green-100 text-green-800 rounded-full text-sm font-medium mb-6">
                                        <span class="w-2 h-2 bg-green-600 rounded-full mr-2"></span>
                                        Passo 3
                                    </div>
                                    <h3 class="text-3xl font-bold text-gray-900 mb-6">Controle Total da Operação</h3>
                                    <div class="space-y-4">
                                        <div class="flex items-start gap-3">
                                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                                                <span class="text-green-600 font-bold text-sm">1</span>
                                            </div>
                                            <p class="text-gray-600">Painel executivo com métricas de vendas e performance</p>
                                        </div>
                                        <div class="flex items-start gap-3">
                                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                                                <span class="text-green-600 font-bold text-sm">2</span>
                                            </div>
                                            <p class="text-gray-600">Gestão completa de participantes e pagamentos</p>
                                        </div>
                                        <div class="flex items-start gap-3">
                                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                                                <span class="text-green-600 font-bold text-sm">3</span>
                                            </div>
                                            <p class="text-gray-600">Relatórios financeiros e fiscais automatizados</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <div class="bg-gradient-to-br from-green-100 to-purple-100 rounded-2xl p-8">
                                        <div class="text-6xl mb-4">📊</div>
                                        <h4 class="text-xl font-bold text-gray-900 mb-2">Controle Total</h4>
                                        <p class="text-gray-600">Acompanhe cada detalhe da sua rifa</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Slide 4: Sorteio -->
                    <div class="w-full flex-shrink-0">
                        <div class="bg-white rounded-2xl p-8 lg:p-12 shadow-xl">
                            <div class="grid lg:grid-cols-2 gap-12 items-center">
                                <div>
                                    <div class="inline-flex items-center px-4 py-2 bg-yellow-100 text-yellow-800 rounded-full text-sm font-medium mb-6">
                                        <span class="w-2 h-2 bg-yellow-600 rounded-full mr-2"></span>
                                        Passo 4
                                    </div>
                                    <h3 class="text-3xl font-bold text-gray-900 mb-6">Sorteio Automatizado e Auditável</h3>
                                    <div class="space-y-4">
                                        <div class="flex items-start gap-3">
                                            <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center flex-shrink-0">
                                                <span class="text-yellow-600 font-bold text-sm">1</span>
                                            </div>
                                            <p class="text-gray-600">Sorteio automático em data e hora programadas</p>
                                        </div>
                                        <div class="flex items-start gap-3">
                                            <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center flex-shrink-0">
                                                <span class="text-yellow-600 font-bold text-sm">2</span>
                                            </div>
                                            <p class="text-gray-600">Tecnologia blockchain para total transparência</p>
                                        </div>
                                        <div class="flex items-start gap-3">
                                            <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center flex-shrink-0">
                                                <span class="text-yellow-600 font-bold text-sm">3</span>
                                            </div>
                                            <p class="text-gray-600">Notificação automática e entrega do prêmio</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <div class="bg-gradient-to-br from-yellow-100 to-red-100 rounded-2xl p-8">
                                        <div class="text-6xl mb-4">🎉</div>
                                        <h4 class="text-xl font-bold text-gray-900 mb-2">100% Confiável</h4>
                                        <p class="text-gray-600">Transparência total no processo</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Navigation Arrows -->
            <button id="prev-btn" class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-white/90 hover:bg-white text-gray-600 hover:text-gray-900 w-12 h-12 rounded-full shadow-lg flex items-center justify-center transition-all duration-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>
            <button id="next-btn" class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-white/90 hover:bg-white text-gray-600 hover:text-gray-900 w-12 h-12 rounded-full shadow-lg flex items-center justify-center transition-all duration-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>
        </div>
        
        <!-- Dots Indicator -->
        <div class="flex justify-center mt-8 space-x-2">
            <button class="carousel-dot w-3 h-3 rounded-full bg-purple-600 transition-all duration-200" data-slide="0"></button>
            <button class="carousel-dot w-3 h-3 rounded-full bg-gray-300 transition-all duration-200" data-slide="1"></button>
            <button class="carousel-dot w-3 h-3 rounded-full bg-gray-300 transition-all duration-200" data-slide="2"></button>
            <button class="carousel-dot w-3 h-3 rounded-full bg-gray-300 transition-all duration-200" data-slide="3"></button>
        </div>
    </div>
</section>

<!-- Marketplace Section -->
<section id="rifas-ativas" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-12 scroll-animate">
            <div>
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-2">
                    Marketplace
                </h2>
                <p class="text-gray-600">Participe das rifas que estão acontecendo agora</p>
            </div>
            <a href="{{ route('raffles.index') }}" class="text-purple-600 hover:text-purple-700 font-semibold flex items-center gap-2">
                Ver todas →
            </a>
        </div>
        
        @if($activeRaffles->count() > 0)
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($activeRaffles as $index => $raffle)
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden hover-scale scroll-animate" style="animation-delay: {{ $index * 0.1 }}s;">
                        <div class="relative">
                            <div class="h-48 bg-gradient-to-br from-purple-400 to-blue-500 flex items-center justify-center">
                                <span class="text-6xl">
                                    @switch($raffle->category)
                                        @case('social')
                                            🐕
                                            @break
                                        @case('medical')
                                            🏥
                                            @break
                                        @case('education')
                                            🎓
                                            @break
                                        @case('religious')
                                            ⛪
                                            @break
                                        @case('sports')
                                            ⚽
                                            @break
                                        @default
                                            🎁
                                    @endswitch
                                </span>
                            </div>
                            @if($raffle->featured)
                                <div class="absolute top-4 left-4 bg-yellow-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                    Destaque
                                </div>
                            @endif
                            <div class="absolute top-4 right-4 bg-green-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                {{ $raffle->category }}
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $raffle->title }}</h3>
                            <p class="text-gray-600 mb-4 text-sm">{{ Str::limit($raffle->description, 80) }}</p>
                            
                            <div class="mb-4">
                                <div class="flex justify-between text-sm text-gray-500 mb-2">
                                    <span>Progresso</span>
                                    <span>{{ number_format($raffle->progress_percentage, 1) }}% vendido</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-3">
                                    <div class="bg-gradient-to-r from-purple-500 to-blue-500 h-3 rounded-full" style="width: {{ $raffle->progress_percentage }}%"></div>
                                </div>
                            </div>
                            
                            <div class="flex justify-between items-center mb-4">
                                <span class="text-2xl font-bold text-gray-900">R$ {{ number_format($raffle->price_per_ticket, 2, ',', '.') }}</span>
                                <span class="text-sm text-gray-500">por número</span>
                            </div>
                            
                            <div class="flex justify-between items-center mb-4 text-sm text-gray-500">
                                <span>{{ $raffle->sold_tickets }} / {{ $raffle->total_tickets }} vendidos</span>
                                <span>{{ $raffle->remaining_tickets }} restantes</span>
                            </div>
                            
                            <a href="{{ route('raffles.show', $raffle) }}" class="w-full bg-gradient-to-r from-purple-500 to-blue-500 text-white py-3 rounded-lg font-semibold hover:from-purple-600 hover:to-blue-600 transition-all duration-300 flex items-center justify-center">
                                Participar Agora
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-gray-50 rounded-xl p-8 text-center scroll-animate">
                    <div class="text-4xl mb-4">🎯</div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Marketplace</h3>
                    <p class="text-gray-600 mb-4">Em breve você poderá ver todas as rifas ativas aqui</p>
                    <button class="bg-purple-600 text-white px-6 py-2 rounded-lg font-medium hover:bg-purple-700 transition-colors">
                        Ver Rifas
                    </button>
                </div>
                
                <div class="bg-gray-50 rounded-xl p-8 text-center scroll-animate" style="animation-delay: 0.2s;">
                    <div class="text-4xl mb-4">📊</div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Estatísticas</h3>
                    <p class="text-gray-600 mb-4">Acompanhe o progresso das suas rifas favoritas</p>
                    <button class="bg-purple-600 text-white px-6 py-2 rounded-lg font-medium hover:bg-purple-700 transition-colors">
                        Ver Estatísticas
                    </button>
                </div>
                
                <div class="bg-gray-50 rounded-xl p-8 text-center scroll-animate sm:col-span-2 lg:col-span-1" style="animation-delay: 0.4s;">
                    <div class="text-4xl mb-4">🔔</div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Notificações</h3>
                    <p class="text-gray-600 mb-4">Receba atualizações das rifas que você acompanha</p>
                    <button class="bg-purple-600 text-white px-6 py-2 rounded-lg font-medium hover:bg-purple-700 transition-colors">
                        Configurar
                    </button>
                </div>
            </div>
        @endif
    </div>
</section>

<!-- Featured Raffles Section -->
<section id="rifas-destaque" class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Rifas em Destaque</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Descubra as rifas mais populares do mercado: mais vendidas, melhor avaliadas e com maior chance de ganhar
            </p>
        </div>
        
        <!-- Featured Categories -->
        <div class="space-y-16">
            <!-- Mais Vendidas -->
            <div>
                <div class="flex items-center justify-between mb-8">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-gradient-to-r from-red-500 to-orange-500 rounded-full flex items-center justify-center">
                            <span class="text-white text-xl font-bold">🔥</span>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900">Mais Vendidas</h3>
                            <p class="text-gray-600">As rifas com maior volume de vendas</p>
                        </div>
                    </div>
                    <a href="{{ route('raffles.index') }}?sort=progress" class="text-purple-600 hover:text-purple-700 font-semibold flex items-center gap-2">
                        Ver todas <span>→</span>
                    </a>
                </div>
                
                @if($bestSellingRaffles->count() > 0)
                    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($bestSellingRaffles as $index => $raffle)
                            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                                <div class="relative">
                                    <div class="h-48 bg-gradient-to-br 
                                        @switch($raffle->category)
                                            @case('social') from-purple-400 to-blue-500 @break
                                            @case('medical') from-green-400 to-blue-500 @break
                                            @case('education') from-pink-400 to-purple-500 @break
                                            @case('religious') from-blue-400 to-indigo-500 @break
                                            @case('sports') from-orange-400 to-red-500 @break
                                            @default from-purple-400 to-blue-500
                                        @endswitch
                                        flex items-center justify-center">
                                        <span class="text-6xl">
                                            @switch($raffle->category)
                                                @case('social') 🐕 @break
                                                @case('medical') 🏥 @break
                                                @case('education') 🎓 @break
                                                @case('religious') ⛪ @break
                                                @case('sports') ⚽ @break
                                                @default 🎁
                                            @endswitch
                                        </span>
                                    </div>
                                    <div class="absolute top-4 left-4 bg-red-500 text-white px-3 py-1 rounded-full text-sm font-semibold flex items-center gap-1">
                                        <span>🔥</span> Mais Vendida
                                    </div>
                                    <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm text-gray-700 px-2 py-1 rounded-full text-xs font-medium">
                                        {{ $raffle->sold_tickets }} vendidos
                                    </div>
                                </div>
                                <div class="p-6">
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="text-xs font-medium px-2 py-1 rounded-full bg-gray-100 text-gray-700">
                                            @switch($raffle->category)
                                                @case('social') 🐕 Social @break
                                                @case('medical') 🏥 Médico @break
                                                @case('education') 🎓 Educação @break
                                                @case('religious') ⛪ Religioso @break
                                                @case('sports') ⚽ Esportes @break
                                                @default 🎁 Geral
                                            @endswitch
                                        </span>
                                    </div>
                                    <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $raffle->title }}</h3>
                                    <p class="text-gray-600 mb-4 text-sm">{{ Str::limit($raffle->description, 80) }}</p>
                                    
                                    <div class="mb-4">
                                        <div class="flex justify-between text-sm text-gray-500 mb-2">
                                            <span>Progresso</span>
                                            <span>{{ number_format($raffle->progress_percentage, 1) }}% vendido</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            <div class="bg-gradient-to-r from-red-500 to-orange-500 h-2 rounded-full" style="width: {{ $raffle->progress_percentage }}%"></div>
                                        </div>
                                    </div>
                                    
                                    <div class="flex justify-between items-center mb-4">
                                        <div>
                                            <span class="text-2xl font-bold text-gray-900">R$ {{ number_format($raffle->price_per_ticket, 2, ',', '.') }}</span>
                                            <span class="text-sm text-gray-500">por número</span>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-sm text-gray-500">Sorteio em</div>
                                            <div class="font-semibold text-gray-900">{{ $raffle->draw_date->diffForHumans() }}</div>
                                        </div>
                                    </div>
                                    
                                    <a href="{{ route('raffles.show', $raffle) }}" class="w-full bg-gradient-to-r from-red-500 to-orange-500 hover:from-red-600 hover:to-orange-600 text-white py-3 rounded-lg font-semibold transition-all duration-300 flex items-center justify-center gap-2">
                                        <span>🎯</span>
                                        <span>Participar Agora</span>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12 bg-white rounded-xl">
                        <div class="text-6xl mb-4">🔥</div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Em Breve</h3>
                        <p class="text-gray-600">Novas rifas em destaque serão exibidas aqui em breve!</p>
                    </div>
                @endif
            </div>
            
            <!-- Bem Avaliadas -->
            <div>
                <div class="flex items-center justify-between mb-8">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-gradient-to-r from-yellow-500 to-orange-500 rounded-full flex items-center justify-center">
                            <span class="text-white text-xl font-bold">⭐</span>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900">Melhor Avaliadas</h3>
                            <p class="text-gray-600">Rifas com as melhores avaliações dos participantes</p>
                        </div>
                    </div>
                    <a href="{{ route('raffles.index') }}?sort=rating" class="text-purple-600 hover:text-purple-700 font-semibold flex items-center gap-2">
                        Ver todas <span>→</span>
                    </a>
                </div>
                
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($wellRatedRaffles as $index => $raffle)
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                            <div class="relative">
                                <div class="h-48 bg-gradient-to-br 
                                    @switch($raffle->category)
                                        @case('social') from-purple-400 to-blue-500 @break
                                        @case('medical') from-green-400 to-blue-500 @break
                                        @case('education') from-pink-400 to-purple-500 @break
                                        @case('religious') from-blue-400 to-indigo-500 @break
                                        @case('sports') from-orange-400 to-red-500 @break
                                        @default from-purple-400 to-blue-500
                                    @endswitch
                                    flex items-center justify-center">
                                    <span class="text-6xl">
                                        @switch($raffle->category)
                                            @case('social') 🐕 @break
                                            @case('medical') 🏥 @break
                                            @case('education') 🎓 @break
                                            @case('religious') ⛪ @break
                                            @case('sports') ⚽ @break
                                            @default 🎁
                                        @endswitch
                                    </span>
                                </div>
                                <div class="absolute top-4 left-4 bg-yellow-500 text-white px-3 py-1 rounded-full text-sm font-semibold flex items-center gap-1">
                                    <span>⭐</span> 4.9★
                                </div>
                                <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm text-gray-700 px-2 py-1 rounded-full text-xs font-medium">
                                    127 avaliações
                                </div>
                            </div>
                            <div class="p-6">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="text-xs font-medium px-2 py-1 rounded-full bg-gray-100 text-gray-700">
                                        @switch($raffle->category)
                                            @case('social') 🐕 Social @break
                                            @case('medical') 🏥 Médico @break
                                            @case('education') 🎓 Educação @break
                                            @case('religious') ⛪ Religioso @break
                                            @case('sports') ⚽ Esportes @break
                                            @default 🎁 Geral
                                        @endswitch
                                    </span>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $raffle->title }}</h3>
                                <p class="text-gray-600 mb-4 text-sm">{{ Str::limit($raffle->description, 80) }}</p>
                                
                                <!-- Rating Stars -->
                                <div class="flex items-center gap-2 mb-4">
                                    <div class="flex items-center">
                                        @for($i = 1; $i <= 5; $i++)
                                            <span class="{{ $i <= 4 ? 'text-yellow-400' : 'text-gray-300' }}">★</span>
                                        @endfor
                                    </div>
                                    <span class="text-sm text-gray-600">(4.9/5.0)</span>
                                </div>
                                
                                <div class="flex justify-between items-center mb-4">
                                    <div>
                                        <span class="text-2xl font-bold text-gray-900">R$ {{ number_format($raffle->price_per_ticket, 2, ',', '.') }}</span>
                                        <span class="text-sm text-gray-500">por número</span>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-sm text-gray-500">Sorteio em</div>
                                        <div class="font-semibold text-gray-900">{{ $raffle->draw_date->diffForHumans() }}</div>
                                    </div>
                                </div>
                                
                                <a href="{{ route('raffles.show', $raffle) }}" class="w-full bg-gradient-to-r from-yellow-500 to-orange-500 hover:from-yellow-600 hover:to-orange-600 text-white py-3 rounded-lg font-semibold transition-all duration-300 flex items-center justify-center gap-2">
                                    <span>⭐</span>
                                    <span>Participar Agora</span>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Statistics Section -->
<section class="py-20 bg-gradient-to-br from-purple-50 to-blue-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16 scroll-animate">
            <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4">
                Números que Impressionam
            </h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Veja o impacto positivo que nossa plataforma está gerando na comunidade
            </p>
        </div>
        
        <div class="grid md:grid-cols-3 gap-8">
            <!-- Total Rifas Ativas -->
            <div class="text-center scroll-animate hover-lift">
                <div class="bg-purple-100 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-6">
                    <span class="text-4xl">🎲</span>
                </div>
                <h3 class="text-4xl font-bold text-purple-600 mb-2">{{ $raffleStats['total_active_raffles'] }}</h3>
                <p class="text-xl font-semibold text-gray-900 mb-2">Marketplace</p>
                <p class="text-gray-600">Acontecendo agora na plataforma</p>
            </div>
            
            <!-- Total Bilhetes Vendidos -->
            <div class="text-center scroll-animate hover-lift" style="animation-delay: 0.2s;">
                <div class="bg-blue-100 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-6">
                    <span class="text-4xl">🎫</span>
                </div>
                <h3 class="text-4xl font-bold text-blue-600 mb-2">{{ number_format($raffleStats['total_tickets_sold']) }}</h3>
                <p class="text-xl font-semibold text-gray-900 mb-2">Bilhetes Vendidos</p>
                <p class="text-gray-600">Pessoas participando das rifas</p>
            </div>
            
        </div>
    </div>
</section>

<!-- For Organizers Section -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div class="scroll-animate">
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-6">
                    Sua central de comando para rifas
                </h2>
                <div class="space-y-4 mb-8">
                    <div class="flex items-start gap-3">
                        <div class="text-green-500 text-xl">✅</div>
                        <p class="text-gray-700 text-lg">Painel executivo com métricas em tempo real</p>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="text-green-500 text-xl">✅</div>
                        <p class="text-gray-700 text-lg">Relatórios financeiros e fiscais completos</p>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="text-green-500 text-xl">✅</div>
                        <p class="text-gray-700 text-lg">Gestão completa de participantes e vendas</p>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="text-green-500 text-xl">✅</div>
                        <p class="text-gray-700 text-lg">Suporte especializado e consultoria</p>
                    </div>
                </div>
                <a href="{{ route('register') }}" class="bg-gradient-to-r from-purple-500 to-blue-500 text-white px-8 py-4 rounded-xl font-bold text-lg hover:from-purple-600 hover:to-blue-600 transition-all duration-300 hover-scale inline-flex items-center gap-2">
                    Começar Agora
                </a>
            </div>
            
            <div class="scroll-animate hover-lift">
                <div class="bg-gray-100 rounded-2xl p-8 text-center">
                    <div class="text-6xl mb-4">📊</div>
                    <p class="text-gray-600 text-lg">Screenshot do Dashboard</p>
                    <p class="text-gray-500 text-sm mt-2">Interface intuitiva e fácil de usar</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Security and Reliability Section -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16 scroll-animate">
            <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4">
                Por que somos a escolha certa?
            </h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Tecnologia avançada e compromisso com a segurança dos nossos usuários
            </p>
        </div>
        
        <div class="grid md:grid-cols-3 gap-8">
            <!-- Security -->
            <div class="text-center scroll-animate hover-lift">
                <div class="bg-blue-100 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-6">
                    <span class="text-4xl">🔒</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Pagamentos Seguros</h3>
                <ul class="text-gray-600 space-y-2">
                    <li>• Integração com PIX</li>
                    <li>• Valores em custódia</li>
                    <li>• Proteção antifraude</li>
                </ul>
            </div>
            
            <!-- Legal -->
            <div class="text-center scroll-animate hover-lift" style="animation-delay: 0.2s;">
                <div class="bg-green-100 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-6">
                    <span class="text-4xl">⚖️</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Conformidade Legal</h3>
                <ul class="text-gray-600 space-y-2">
                    <li>• Regulamento automático</li>
                    <li>• Respeito à legislação</li>
                    <li>• Transparência total</li>
                </ul>
            </div>
            
            <!-- Technology -->
            <div class="text-center scroll-animate hover-lift" style="animation-delay: 0.4s;">
                <div class="bg-purple-100 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-6">
                    <span class="text-4xl">🤖</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Tecnologia Inteligente</h3>
                <ul class="text-gray-600 space-y-2">
                    <li>• IA para suporte 24h</li>
                    <li>• Sorteios auditáveis</li>
                    <li>• Automação completa</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16 scroll-animate">
            <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4">
                O que nossos usuários dizem
            </h2>
            <p class="text-xl text-gray-600">Depoimentos reais de quem já transformou vidas</p>
        </div>
        
        <div class="grid md:grid-cols-3 gap-8">
            <!-- Testimonial 1 -->
            <div class="bg-gray-50 rounded-2xl p-8 scroll-animate hover-lift">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-purple-500 rounded-full flex items-center justify-center text-white font-bold">
                        M
                    </div>
                    <div class="ml-4">
                        <h4 class="font-bold text-gray-900">Maria Silva</h4>
                        <p class="text-gray-600 text-sm">Organizadora de ONG</p>
                    </div>
                </div>
                <p class="text-gray-700 italic">
                    "Arrecadamos R$15.000 para tratamento médico em 2 semanas! A plataforma facilitou todo o processo."
                </p>
            </div>
            
            <!-- Testimonial 2 -->
            <div class="bg-gray-50 rounded-2xl p-8 scroll-animate hover-lift" style="animation-delay: 0.2s;">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold">
                        J
                    </div>
                    <div class="ml-4">
                        <h4 class="font-bold text-gray-900">João Santos</h4>
                        <p class="text-gray-600 text-sm">Participante</p>
                    </div>
                </div>
                <p class="text-gray-700 italic">
                    "Ganhei um celular e ainda ajudei uma causa incrível! O processo é muito transparente."
                </p>
            </div>
            
            <!-- Testimonial 3 -->
            <div class="bg-gray-50 rounded-2xl p-8 scroll-animate hover-lift" style="animation-delay: 0.4s;">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center text-white font-bold">
                        A
                    </div>
                    <div class="ml-4">
                        <h4 class="font-bold text-gray-900">Ana Costa</h4>
                        <p class="text-gray-600 text-sm">Criadora de rifa</p>
                    </div>
                </div>
                <p class="text-gray-700 italic">
                    "A plataforma facilitou tudo, desde a criação até o pagamento. Recomendo muito!"
                </p>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="py-20 bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16 scroll-animate">
            <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4">
                Tire suas dúvidas
            </h2>
            <p class="text-xl text-gray-600">Perguntas frequentes sobre nossa plataforma</p>
        </div>
        
        <div class="space-y-4">
            <!-- FAQ 1 -->
            <div class="bg-white rounded-xl shadow-sm scroll-animate">
                <button class="w-full p-6 text-left flex justify-between items-center hover:bg-gray-50 transition-colors faq-button">
                    <span class="text-lg font-semibold text-gray-900">Como funciona o pagamento?</span>
                    <span class="text-2xl text-gray-400 faq-icon">+</span>
                </button>
                <div class="px-6 pb-6 text-gray-600 hidden faq-content">
                    <p>Utilizamos PIX para todos os pagamentos, garantindo segurança e rapidez. Os valores ficam em custódia até o sorteio ser realizado.</p>
                </div>
            </div>
            
            <!-- FAQ 2 -->
            <div class="bg-white rounded-xl shadow-sm scroll-animate" style="animation-delay: 0.1s;">
                <button class="w-full p-6 text-left flex justify-between items-center hover:bg-gray-50 transition-colors faq-button">
                    <span class="text-lg font-semibold text-gray-900">O sorteio é realmente aleatório?</span>
                    <span class="text-2xl text-gray-400 faq-icon">+</span>
                </button>
                <div class="px-6 pb-6 text-gray-600 hidden faq-content">
                    <p>Sim! Utilizamos algoritmos criptograficamente seguros para garantir total aleatoriedade nos sorteios. Todo o processo é auditável.</p>
                </div>
            </div>
            
            <!-- FAQ 3 -->
            <div class="bg-white rounded-xl shadow-sm scroll-animate" style="animation-delay: 0.2s;">
                <button class="w-full p-6 text-left flex justify-between items-center hover:bg-gray-50 transition-colors faq-button">
                    <span class="text-lg font-semibold text-gray-900">Posso confiar na plataforma?</span>
                    <span class="text-2xl text-gray-400 faq-icon">+</span>
                </button>
                <div class="px-6 pb-6 text-gray-600 hidden faq-content">
                    <p>Absolutamente! Somos uma empresa registrada, seguimos todas as normas legais e temos milhares de rifas realizadas com sucesso.</p>
                </div>
            </div>
            
            <!-- FAQ 4 -->
            <div class="bg-white rounded-xl shadow-sm scroll-animate" style="animation-delay: 0.3s;">
                <button class="w-full p-6 text-left flex justify-between items-center hover:bg-gray-50 transition-colors faq-button">
                    <span class="text-lg font-semibold text-gray-900">Quanto custa para criar uma rifa?</span>
                    <span class="text-2xl text-gray-400 faq-icon">+</span>
                </button>
                <div class="px-6 pb-6 text-gray-600 hidden faq-content">
                    <p>Criar uma rifa é completamente gratuito! Cobramos apenas uma pequena taxa sobre as vendas, apenas quando a rifa é bem-sucedida.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Final CTA Banner -->
<section class="py-20 gradient-purple-blue-dark relative overflow-hidden">
    <div class="absolute inset-0 bg-black/20"></div>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
        <div class="scroll-animate">
            <h2 class="text-3xl sm:text-4xl font-bold text-white mb-6">
                Pronto para revolucionar suas rifas?
            </h2>
            <p class="text-xl text-blue-100 mb-8 max-w-2xl mx-auto">
                Junte-se a milhares de organizadores que já descobriram o poder da tecnologia em rifas
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="#" class="bg-yellow-400 text-gray-900 px-8 py-4 rounded-xl font-bold text-lg hover:bg-yellow-300 transition-all duration-300 hover-scale">
                    Começar Agora
                </a>
                <a href="#" class="border-2 border-white text-white px-8 py-4 rounded-xl font-bold text-lg hover:bg-white hover:text-gray-900 transition-all duration-300 hover-scale">
                    Falar com Especialista
                </a>
            </div>
        </div>
    </div>
</section>
@endsection

<script>
// Carousel functionality
document.addEventListener('DOMContentLoaded', function() {
    const carouselSlides = document.getElementById('carousel-slides');
    const prevBtn = document.getElementById('prev-btn');
    const nextBtn = document.getElementById('next-btn');
    const dots = document.querySelectorAll('.carousel-dot');
    
    let currentSlide = 0;
    const totalSlides = 4;
    
    function updateCarousel() {
        carouselSlides.style.transform = `translateX(-${currentSlide * 100}%)`;
        
        // Update dots
        dots.forEach((dot, index) => {
            if (index === currentSlide) {
                dot.classList.remove('bg-gray-300');
                dot.classList.add('bg-purple-600');
            } else {
                dot.classList.remove('bg-purple-600');
                dot.classList.add('bg-gray-300');
            }
        });
    }
    
    function nextSlide() {
        currentSlide = (currentSlide + 1) % totalSlides;
        updateCarousel();
    }
    
    function prevSlide() {
        currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
        updateCarousel();
    }
    
    // Event listeners
    nextBtn.addEventListener('click', nextSlide);
    prevBtn.addEventListener('click', prevSlide);
    
    // Dot navigation
    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            currentSlide = index;
            updateCarousel();
        });
    });
    
    // Auto-play carousel (optional)
    setInterval(nextSlide, 8000); // Change slide every 8 seconds
    
    // Keyboard navigation
    document.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowLeft') prevSlide();
        if (e.key === 'ArrowRight') nextSlide();
    });
    
    // Touch/swipe support for mobile
    let startX = 0;
    let endX = 0;
    
    carouselSlides.addEventListener('touchstart', (e) => {
        startX = e.touches[0].clientX;
    });
    
    carouselSlides.addEventListener('touchend', (e) => {
        endX = e.changedTouches[0].clientX;
        handleSwipe();
    });
    
    function handleSwipe() {
        const threshold = 50;
        const diff = startX - endX;
        
        if (Math.abs(diff) > threshold) {
            if (diff > 0) {
                nextSlide(); // Swipe left - next slide
            } else {
                prevSlide(); // Swipe right - previous slide
            }
        }
    }
});
</script> 