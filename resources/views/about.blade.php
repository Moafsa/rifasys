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
        <div class="text-center animate-fadeInUp">
            <div class="inline-flex items-center bg-white/20 backdrop-blur-sm rounded-full px-6 py-2 mb-8">
                <svg class="w-5 h-5 text-white mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
                <span class="text-white font-medium">Plataforma em Crescimento</span>
            </div>
            
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-white mb-8 leading-tight">
                Revolucionando o Mundo das 
                <span class="text-yellow-300">Rifas Digitais</span>
            </h1>
            
            <p class="text-xl text-blue-100 mb-8 max-w-4xl mx-auto leading-relaxed">
                Há mais de <span class="font-bold text-white">2 anos</span> transformando a maneira como as pessoas criam, gerenciam e participam de rifas, 
                unindo <span class="font-semibold">tecnologia</span> e <span class="font-semibold">praticidade</span> para causas que movem o mundo.
            </p>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register') }}" class="bg-yellow-400 text-gray-900 px-8 py-4 rounded-xl font-bold text-lg hover:bg-yellow-300 transition-all duration-300 hover-scale flex items-center justify-center gap-2">
                    🚀 Criar Minha Primeira Rifa
                </a>
                <a href="{{ route('marketplace.index') }}" class="border-2 border-white text-white px-8 py-4 rounded-xl font-bold text-lg hover:bg-white hover:text-gray-900 transition-all duration-300 hover-scale flex items-center justify-center gap-2">
                    💎 Ver Rifas Disponíveis
                </a>
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
</section>

<!-- Our Story Section -->
<section class="py-20 bg-gradient-to-br from-purple-600 via-blue-600 to-indigo-700 relative overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 bg-black/10"></div>
    <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.1"%3E%3Ccircle cx="30" cy="30" r="2"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div class="scroll-animate">
                <div class="inline-flex items-center px-4 py-2 bg-white/20 backdrop-blur-sm text-white rounded-full text-sm font-medium mb-6">
                    <span class="w-2 h-2 bg-yellow-400 rounded-full mr-2"></span>
                    Nossa História
                </div>
                
                <h2 class="text-3xl sm:text-4xl font-bold text-white mb-6">
                    De Uma Necessidade Simples a Uma 
                    <span class="text-yellow-300">Solução Completa</span>
                </h2>
                
                <div class="space-y-4 mb-8">
                    <p class="text-blue-100 text-lg">
                        Tudo começou quando identificamos as dificuldades que organizadores de rifas enfrentavam: 
                        <span class="font-semibold text-yellow-300">controles manuais propensos a erros</span>, 
                        <span class="font-semibold text-yellow-300">limitações geográficas</span>, 
                        <span class="font-semibold text-yellow-300">dificuldades em receber pagamentos</span> e a 
                        <span class="font-semibold text-yellow-300">burocracia para gerenciar sorteios</span>.
                    </p>
                    
                    <p class="text-blue-100 text-lg">
                        Decidimos criar uma plataforma que não apenas resolvesse esses problemas, mas que também 
                        oferecesse uma <span class="font-semibold text-white">experiência excepcional</span> tanto para organizadores quanto para participantes.
                    </p>
                    
                    <p class="text-blue-100 text-lg">
                        Hoje, somos referência em rifas digitais, com <span class="font-bold text-yellow-300">centenas de rifas criadas</span> e 
                        <span class="font-bold text-white">milhares de números vendidos</span>, ajudando causas sociais, esportivas, educacionais e muito mais.
                    </p>
                </div>
            </div>
            
            <div class="scroll-animate hover-lift">
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-8 shadow-2xl border border-white/20">
                    <div class="text-center mb-8">
                        <div class="bg-gradient-to-r from-yellow-400 to-orange-500 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-2">Nossos Números</h3>
                        <p class="text-blue-200">Resultados que falam por si</p>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-6">
                        <div class="text-center bg-white/10 backdrop-blur-sm rounded-xl p-4 border border-white/20">
                            <div class="text-3xl font-bold text-yellow-300 mb-2">500+</div>
                            <div class="text-sm text-blue-200 font-medium">Rifas Criadas</div>
                        </div>
                        <div class="text-center bg-white/10 backdrop-blur-sm rounded-xl p-4 border border-white/20">
                            <div class="text-3xl font-bold text-white mb-2">2.500+</div>
                            <div class="text-sm text-blue-200 font-medium">Organizadores Ativos</div>
                        </div>
                        <div class="text-center bg-white/10 backdrop-blur-sm rounded-xl p-4 border border-white/20">
                            <div class="text-3xl font-bold text-green-300 mb-2">R$ 150k+</div>
                            <div class="text-sm text-blue-200 font-medium">em Prêmios Distribuídos</div>
                    </div>
                        <div class="text-center bg-white/10 backdrop-blur-sm rounded-xl p-4 border border-white/20">
                            <div class="text-3xl font-bold text-orange-300 mb-2">1.200+</div>
                            <div class="text-sm text-blue-200 font-medium">Sorteios Realizados</div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Mission Section -->
<section class="py-20 bg-gradient-to-br from-gray-50 via-white to-blue-50 relative overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width="40" height="40" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="%23e5e7eb" fill-opacity="0.3"%3E%3Cpath d="M20 20c0-5.5-4.5-10-10-10s-10 4.5-10 10 4.5 10 10 10 10-4.5 10-10zm10 0c0-5.5-4.5-10-10-10s-10 4.5-10 10 4.5 10 10 10 10-4.5 10-10z"/%3E%3C/g%3E%3C/svg%3E');"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-16 scroll-animate">
            <div class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-purple-100 to-blue-100 text-purple-800 rounded-full text-sm font-medium mb-6">
                <span class="w-2 h-2 bg-purple-600 rounded-full mr-2"></span>
                Nossa Missão
            </div>
            
            <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4">
                Digitalizar e Democratizar as 
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-blue-600">Rifas no Brasil</span>
            </h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Transformamos a maneira como as pessoas criam e participam de rifas, 
                tornando o processo <span class="font-semibold text-purple-600">simples</span>, 
                <span class="font-semibold text-blue-600">seguro</span> e 
                <span class="font-semibold text-green-600">acessível</span> para todos.
            </p>
        </div>
        
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="text-center scroll-animate hover-lift group">
                <div class="bg-gradient-to-br from-purple-500 to-purple-600 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                    <span class="text-4xl">🔗</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Conectar</h3>
                <p class="text-gray-600">organizadores e participantes de forma segura e eficiente</p>
            </div>
            
            <div class="text-center scroll-animate hover-lift group" style="animation-delay: 0.2s;">
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                    <span class="text-4xl">🚀</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Simplificar</h3>
                <p class="text-gray-600">o processo de criação e gerenciamento de rifas</p>
            </div>
            
            <div class="text-center scroll-animate hover-lift group" style="animation-delay: 0.4s;">
                <div class="bg-gradient-to-br from-green-500 to-green-600 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                    <span class="text-4xl">💡</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Inovar</h3>
                <p class="text-gray-600">constantemente na experiência do usuário</p>
            </div>
            
            <div class="text-center scroll-animate hover-lift group" style="animation-delay: 0.6s;">
                <div class="bg-gradient-to-br from-orange-500 to-orange-600 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                    <span class="text-4xl">🤝</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Contribuir</h3>
                <p class="text-gray-600">para o sucesso de causas e projetos diversos</p>
            </div>
        </div>
    </div>
</section>

<!-- Technology Section -->
<section class="py-20 bg-gradient-to-br from-indigo-900 via-purple-900 to-pink-900 relative overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 bg-black/20"></div>
    <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.05"%3E%3Ccircle cx="30" cy="30" r="2"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-16 scroll-animate">
            <div class="inline-flex items-center px-4 py-2 bg-white/20 backdrop-blur-sm text-white rounded-full text-sm font-medium mb-6">
                <span class="w-2 h-2 bg-yellow-400 rounded-full mr-2"></span>
                Por que somos a escolha certa?
            </div>
            
            <h2 class="text-3xl sm:text-4xl font-bold text-white mb-4">
                Tecnologia que Faz a 
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-300 to-orange-300">Diferença</span>
            </h2>
            <p class="text-xl text-blue-100 max-w-2xl mx-auto">
                Tecnologia avançada e compromisso com a segurança dos nossos usuários
            </p>
        </div>
        
        <div class="grid md:grid-cols-3 gap-8">
            <!-- Security -->
            <div class="text-center scroll-animate hover-lift group">
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300 shadow-xl">
                    <span class="text-4xl">🔒</span>
                </div>
                <h3 class="text-2xl font-bold text-white mb-4">Pagamentos Seguros</h3>
                <ul class="text-blue-200 space-y-2">
                    <li>• Integração com PIX</li>
                    <li>• Valores em custódia</li>
                    <li>• Proteção antifraude</li>
                </ul>
            </div>
            
            <!-- Legal -->
            <div class="text-center scroll-animate hover-lift group" style="animation-delay: 0.2s;">
                <div class="bg-gradient-to-br from-green-500 to-green-600 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300 shadow-xl">
                    <span class="text-4xl">⚖️</span>
                </div>
                <h3 class="text-2xl font-bold text-white mb-4">Conformidade Legal</h3>
                <ul class="text-blue-200 space-y-2">
                    <li>• Regulamento automático</li>
                    <li>• Respeito à legislação</li>
                    <li>• Transparência total</li>
                </ul>
            </div>
            
            <!-- Technology -->
            <div class="text-center scroll-animate hover-lift group" style="animation-delay: 0.4s;">
                <div class="bg-gradient-to-br from-purple-500 to-purple-600 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300 shadow-xl">
                    <span class="text-4xl">🤖</span>
                </div>
                <h3 class="text-2xl font-bold text-white mb-4">Tecnologia Inteligente</h3>
                <ul class="text-blue-200 space-y-2">
                    <li>• IA para suporte 24h</li>
                    <li>• Sorteios auditáveis</li>
                    <li>• Automação completa</li>
                </ul>
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
                <a href="{{ route('register') }}" class="bg-yellow-400 text-gray-900 px-8 py-4 rounded-xl font-bold text-lg hover:bg-yellow-300 transition-all duration-300 hover-scale">
                    Começar Agora
                </a>
                <a href="{{ route('contact') }}" class="border-2 border-white text-white px-8 py-4 rounded-xl font-bold text-lg hover:bg-white hover:text-gray-900 transition-all duration-300 hover-scale">
                    Falar com Especialista
                </a>
            </div>
        </div>
    </div>
</section>
@endsection