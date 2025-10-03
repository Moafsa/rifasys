@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="relative overflow-hidden bg-gradient-to-br from-purple-900 via-blue-800 to-indigo-900 py-20">
    <!-- Background Pattern -->
    <div class="absolute inset-0 bg-black/20"></div>
    <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%239C92AC" fill-opacity="0.1"%3E%3Ccircle cx="30" cy="30" r="2"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center">
            <!-- Main Title -->
            <div class="mb-8">
                <span class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-sm text-white px-4 py-2 rounded-full text-sm font-medium mb-6">
                    <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                    Marketplace Ativo
                </span>
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-white mb-6 leading-tight">
                    Marketplace de Rifas
                </h1>
                <p class="text-xl text-blue-100 mb-8 max-w-3xl mx-auto leading-relaxed">
                    Descubra, compare e participe das melhores rifas do Brasil. 
                    <span class="text-yellow-300 font-semibold">Encontre a rifa perfeita para você!</span>
                </p>
            </div>
            
            <!-- Market Insights -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 max-w-5xl mx-auto">
                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6 text-center border border-white/20 hover:bg-white/15 transition-all duration-300">
                    <div class="text-3xl font-bold text-white mb-2">2.5K+</div>
                    <div class="text-blue-200 text-sm">Rifas já Realizadas</div>
                    <div class="text-blue-300 text-xs mt-1">Com sucesso na plataforma</div>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6 text-center border border-white/20 hover:bg-white/15 transition-all duration-300">
                    <div class="text-3xl font-bold text-white mb-2">15K+</div>
                    <div class="text-blue-200 text-sm">Participantes Ativos</div>
                    <div class="text-blue-300 text-xs mt-1">Neste mês</div>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6 text-center border border-white/20 hover:bg-white/15 transition-all duration-300">
                    <div class="text-3xl font-bold text-white mb-2">98.7%</div>
                    <div class="text-blue-200 text-sm">Taxa de Sucesso</div>
                    <div class="text-blue-300 text-xs mt-1">Rifas finalizadas</div>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6 text-center border border-white/20 hover:bg-white/15 transition-all duration-300">
                    <div class="text-3xl font-bold text-white mb-2">4.9★</div>
                    <div class="text-blue-200 text-sm">Avaliação Média</div>
                    <div class="text-blue-300 text-xs mt-1">Dos organizadores</div>
                </div>
            </div>
            
            <!-- Call to Action -->
            <div class="mt-12 flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a href="#filters" class="bg-gradient-to-r from-purple-500 to-blue-500 hover:from-purple-600 hover:to-blue-600 text-white px-8 py-4 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl flex items-center gap-3">
                    <span>🔍</span>
                    <span>Explorar Rifas</span>
                </a>
                <a href="#popular" class="bg-white/20 backdrop-blur-sm hover:bg-white/30 text-white px-8 py-4 rounded-xl font-semibold transition-all duration-300 border border-white/30 flex items-center gap-3">
                    <span>🔥</span>
                    <span>Mais Populares</span>
                </a>
            </div>
        </div>
    </div>
    
    <!-- Scroll Indicator -->
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
        <div class="w-6 h-10 border-2 border-white/50 rounded-full flex justify-center">
            <div class="w-1 h-3 bg-white/70 rounded-full mt-2 animate-pulse"></div>
        </div>
    </div>
</section>

<!-- Filters Section -->
<section id="filters" class="py-16 bg-gradient-to-br from-gray-50 to-blue-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Filtros Inteligentes</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Use nossos filtros avançados para encontrar exatamente o que você procura
            </p>
        </div>
        
        <form method="GET" action="{{ route('raffles.index') }}" class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Search by ID -->
                <div class="group">
                    <label for="raffle_id" class="block text-sm font-semibold text-gray-700 mb-3 flex items-center gap-2">
                        <span class="text-purple-500">🔍</span>
                        <span>ID da Rifa</span>
                    </label>
                    <div class="relative">
                        <input type="number" 
                               id="raffle_id" 
                               name="raffle_id" 
                               value="{{ request('raffle_id') }}"
                               placeholder="Ex: 123"
                               class="w-full px-4 py-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-300 bg-gray-50 focus:bg-white group-hover:border-purple-300">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                            <span class="text-gray-400 text-sm">#</span>
                        </div>
                    </div>
                </div>

                <!-- Category Filter -->
                <div class="group">
                    <label for="category" class="block text-sm font-semibold text-gray-700 mb-3 flex items-center gap-2">
                        <span class="text-blue-500">📂</span>
                        <span>Categoria</span>
                    </label>
                    <div class="relative">
                        <select id="category" 
                                name="category" 
                                class="w-full px-4 py-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-300 bg-gray-50 focus:bg-white group-hover:border-blue-300 appearance-none cursor-pointer">
                            <option value="all">🎯 Todas as categorias</option>
                            @foreach($categories as $category)
                                <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                    @switch($category)
                                        @case('social') 🐕 Social @break
                                        @case('medical') 🏥 Médico @break
                                        @case('education') 🎓 Educação @break
                                        @case('religious') ⛪ Religioso @break
                                        @case('sports') ⚽ Esportes @break
                                        @default 🎁 {{ ucfirst($category) }}
                                    @endswitch
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- State Filter -->
                <div class="group">
                    <label for="state" class="block text-sm font-semibold text-gray-700 mb-3 flex items-center gap-2">
                        <span class="text-green-500">🗺️</span>
                        <span>Estado</span>
                    </label>
                    <div class="relative">
                        <select id="state" 
                                name="state" 
                                class="w-full px-4 py-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-300 bg-gray-50 focus:bg-white group-hover:border-green-300 appearance-none cursor-pointer">
                            <option value="all">🇧🇷 Todos os estados</option>
                            @foreach($states as $state)
                                <option value="{{ $state->name }}" {{ request('state') == $state->name ? 'selected' : '' }}>
                                    {{ $state->name }} ({{ $state->code }})
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- City Filter -->
                <div class="group">
                    <label for="city" class="block text-sm font-semibold text-gray-700 mb-3 flex items-center gap-2">
                        <span class="text-orange-500">🏙️</span>
                        <span>Cidade</span>
                    </label>
                    <div class="relative">
                        <select id="city" 
                                name="city" 
                                class="w-full px-4 py-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-300 bg-gray-50 focus:bg-white group-hover:border-orange-300 appearance-none cursor-pointer">
                            <option value="all">🏘️ Todas as cidades</option>
                            @foreach($cities as $city)
                                <option value="{{ $city->name }}" {{ request('city') == $city->name ? 'selected' : '' }}>
                                    {{ $city->name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Price Range Filter -->
            <div class="mt-8 p-6 bg-gradient-to-r from-purple-50 to-blue-50 rounded-xl border border-purple-100">
                <div class="flex items-center gap-3 mb-6">
                    <span class="text-2xl">💰</span>
                    <h3 class="text-lg font-semibold text-gray-800">Faixa de Preço</h3>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                    <div class="group">
                        <label for="min_price" class="block text-sm font-medium text-gray-700 mb-2">Preço Mínimo</label>
                        <div class="relative">
                            <input type="number" 
                                   id="min_price" 
                                   name="min_price" 
                                   value="{{ request('min_price') }}"
                                   step="0.01"
                                   min="0"
                                   placeholder="0,00"
                                   class="w-full px-4 py-3 pl-8 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-300 bg-white group-hover:border-purple-300">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <span class="text-gray-500 text-sm font-medium">R$</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="group">
                        <label for="max_price" class="block text-sm font-medium text-gray-700 mb-2">Preço Máximo</label>
                        <div class="relative">
                            <input type="number" 
                                   id="max_price" 
                                   name="max_price" 
                                   value="{{ request('max_price') }}"
                                   step="0.01"
                                   min="0"
                                   placeholder="{{ number_format($priceRange->max_price ?? 1000, 2, ',', '.') }}"
                                   class="w-full px-4 py-3 pl-8 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-300 bg-white group-hover:border-purple-300">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <span class="text-gray-500 text-sm font-medium">R$</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex flex-col gap-2">
                        <button type="submit" 
                                class="w-full bg-gradient-to-r from-purple-500 to-blue-500 hover:from-purple-600 hover:to-blue-600 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
                            <span>🔍</span>
                            <span>Filtrar</span>
                        </button>
                        
                        <a href="{{ route('raffles.index') }}" 
                           class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2 rounded-lg font-medium transition-all duration-300 text-center text-sm">
                            Limpar Filtros
                        </a>
                    </div>
                </div>
                
                @if($priceRange)
                    <div class="mt-4 p-3 bg-white rounded-lg border border-gray-200">
                        <p class="text-sm text-gray-600 flex items-center gap-2">
                            <span class="text-green-500">📊</span>
                            <span>Faixa atual disponível: <strong>R$ {{ number_format($priceRange->min_price, 2, ',', '.') }} - R$ {{ number_format($priceRange->max_price, 2, ',', '.') }}</strong></span>
                        </p>
                    </div>
                @endif
            </div>

            <!-- Sort Options -->
            <div class="mt-8 p-6 bg-white rounded-xl border border-gray-200">
                <div class="flex flex-col sm:flex-row gap-4 items-start sm:items-center justify-between">
                    <div class="flex items-center gap-3">
                        <span class="text-lg">🔄</span>
                        <span class="text-sm font-semibold text-gray-700">Ordenar por:</span>
                    </div>
                    
                    <div class="flex flex-wrap gap-3 items-center">
                        <select name="sort" 
                                class="px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-300 bg-white hover:border-purple-300 appearance-none cursor-pointer min-w-[200px]">
                            <option value="featured" {{ request('sort') == 'featured' ? 'selected' : '' }}>⭐ Destaque</option>
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>🆕 Mais recentes</option>
                            <option value="ending_soon" {{ request('sort') == 'ending_soon' ? 'selected' : '' }}>⏰ Terminando em breve</option>
                            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>💰 Menor preço</option>
                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>💎 Maior preço</option>
                            <option value="progress" {{ request('sort') == 'progress' ? 'selected' : '' }}>🔥 Mais vendidas</option>
                        </select>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

<!-- Featured Raffles Section -->
@if($featuredRaffles->count() > 0)
<section class="py-16 bg-gradient-to-br from-purple-50 to-blue-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Rifas em Destaque</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">
                As rifas mais populares e com maior chance de ganhar
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($featuredRaffles as $raffle)
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border-2 border-transparent hover:border-purple-200">
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
                        <div class="absolute top-4 left-4 bg-gradient-to-r from-yellow-400 to-orange-500 text-white px-3 py-1 rounded-full text-sm font-semibold flex items-center gap-1">
                            <span>⭐</span> Destaque
                        </div>
                        <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm text-gray-700 px-2 py-1 rounded-full text-xs font-medium">
                            {{ $raffle->progress_percentage }}% vendido
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
                                <div class="bg-gradient-to-r from-yellow-400 to-orange-500 h-2 rounded-full" style="width: {{ $raffle->progress_percentage }}%"></div>
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
                        
                        <a href="{{ route('raffles.show', $raffle) }}" class="w-full bg-gradient-to-r from-yellow-400 to-orange-500 hover:from-yellow-500 hover:to-orange-600 text-white py-3 rounded-lg font-semibold transition-all duration-300 flex items-center justify-center gap-2">
                            <span>⭐</span>
                            <span>Participar Agora</span>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="text-center mt-12">
            <a href="{{ route('raffles.index') }}?sort=featured" class="inline-flex items-center gap-2 bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300">
                <span>Ver Todas as Rifas em Destaque</span>
                <span>→</span>
            </a>
        </div>
    </div>
</section>
@endif

<!-- Results Section -->
<section id="popular" class="py-16 bg-gradient-to-br from-white to-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Results Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-12 gap-4">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-2">
                    {{ $raffles->total() }} {{ $raffles->total() == 1 ? 'rifa encontrada' : 'rifas encontradas' }}
                </h2>
                @if(request()->hasAny(['raffle_id', 'category', 'state', 'city', 'min_price', 'max_price']))
                    <div class="flex items-center gap-2 text-gray-600">
                        <span class="text-blue-500">🔍</span>
                        <span>Filtros aplicados</span>
                    </div>
                @else
                    <p class="text-gray-600">Todas as rifas disponíveis no mercado</p>
                @endif
            </div>
            
            @if($raffles->count() > 0)
                <div class="flex items-center gap-2 text-sm text-gray-500">
                    <span>📊</span>
                    <span>Página {{ $raffles->currentPage() }} de {{ $raffles->lastPage() }}</span>
                </div>
            @endif
        </div>

        @if($raffles->count() > 0)
            <!-- Raffles Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($raffles as $raffle)
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden hover-scale transition-all duration-300 hover:shadow-xl">
                        <!-- Card Header -->
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
                            
                            <!-- Badges -->
                            <div class="absolute top-4 left-4 flex flex-col gap-2">
                                @if($raffle->featured)
                                    <span class="bg-yellow-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                        ⭐ Destaque
                                    </span>
                                @endif
                                <span class="bg-green-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                    {{ ucfirst($raffle->category) }}
                                </span>
                            </div>
                            
                            <!-- Location Badge -->
                            @if($raffle->city && $raffle->state)
                                <div class="absolute top-4 right-4">
                                    <span class="bg-white/90 text-gray-800 px-3 py-1 rounded-full text-sm font-semibold">
                                        📍 {{ $raffle->city }}, {{ $raffle->state }}
                                    </span>
                                </div>
                            @endif
                        </div>

                        <!-- Card Content -->
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-3">
                                <h3 class="text-xl font-bold text-gray-900 leading-tight">
                                    {{ $raffle->title }}
                                </h3>
                                <span class="bg-gray-100 text-gray-600 px-2 py-1 rounded text-xs font-medium ml-2">
                                    #{{ $raffle->id }}
                                </span>
                            </div>
                            
                            <p class="text-gray-600 mb-4 text-sm line-clamp-2">
                                {{ Str::limit($raffle->description, 100) }}
                            </p>
                            
                            <!-- Progress Bar -->
                            <div class="mb-4">
                                <div class="flex justify-between text-sm text-gray-500 mb-2">
                                    <span>Progresso</span>
                                    <span>{{ number_format($raffle->progress_percentage, 1) }}% vendido</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-3">
                                    <div class="bg-gradient-to-r 
                                        @switch($raffle->category)
                                            @case('social') from-purple-500 to-blue-500 @break
                                            @case('medical') from-green-500 to-blue-500 @break
                                            @case('education') from-pink-500 to-purple-500 @break
                                            @case('religious') from-blue-500 to-indigo-500 @break
                                            @case('sports') from-orange-500 to-red-500 @break
                                            @default from-purple-500 to-blue-500
                                        @endswitch
                                        h-3 rounded-full transition-all duration-300" 
                                         style="width: {{ $raffle->progress_percentage }}%"></div>
                                </div>
                            </div>
                            
                            <!-- Price and Tickets Info -->
                            <div class="flex justify-between items-center mb-4">
                                <div>
                                    <span class="text-2xl font-bold text-gray-900">R$ {{ number_format($raffle->price_per_ticket, 2, ',', '.') }}</span>
                                    <span class="text-sm text-gray-500">por número</span>
                                </div>
                                <div class="text-right text-sm text-gray-500">
                                    <div>{{ $raffle->sold_tickets }}/{{ $raffle->total_tickets }} vendidos</div>
                                    <div>{{ $raffle->remaining_tickets }} restantes</div>
                                </div>
                            </div>
                            
                            <!-- Draw Date -->
                            <div class="mb-4 text-sm text-gray-600">
                                <span class="font-semibold">🎯 Sorteio:</span> {{ $raffle->draw_date->format('d/m/Y \à\s H:i') }}
                            </div>
                            
                            <!-- Action Button -->
                            <a href="{{ route('raffles.show', $raffle) }}" 
                               class="w-full bg-gradient-to-r 
                                   @switch($raffle->category)
                                       @case('social') from-purple-500 to-blue-500 hover:from-purple-600 hover:to-blue-600 @break
                                       @case('medical') from-green-500 to-blue-500 hover:from-green-600 hover:to-blue-600 @break
                                       @case('education') from-pink-500 to-purple-500 hover:from-pink-600 hover:to-purple-600 @break
                                       @case('religious') from-blue-500 to-indigo-500 hover:from-blue-600 hover:to-indigo-600 @break
                                       @case('sports') from-orange-500 to-red-500 hover:from-orange-600 hover:to-red-600 @break
                                       @default from-purple-500 to-blue-500 hover:from-purple-600 hover:to-blue-600
                                   @endswitch
                                   text-white py-3 rounded-lg font-semibold transition-all duration-300 flex items-center justify-center gap-2">
                                🎫 Ver Detalhes
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-12">
                {{ $raffles->appends(request()->query())->links() }}
            </div>
        @else
            <!-- No Results -->
            <div class="text-center py-16">
                <div class="text-6xl mb-6">🔍</div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Nenhuma rifa encontrada</h3>
                <p class="text-gray-600 mb-8 max-w-md mx-auto">
                    Não encontramos rifas com os filtros aplicados. Tente ajustar os critérios de busca.
                </p>
                <a href="{{ route('raffles.index') }}" 
                   class="bg-purple-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-purple-700 transition-colors">
                    Ver todas as rifas
                </a>
            </div>
        @endif
    </div>
</section>

<!-- JavaScript for Dynamic City Loading -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const stateSelect = document.getElementById('state');
    const citySelect = document.getElementById('city');
    
    stateSelect.addEventListener('change', function() {
        const selectedState = this.value;
        
        // Clear city options
        citySelect.innerHTML = '<option value="all">Todas as cidades</option>';
        
        if (selectedState && selectedState !== 'all') {
            // Fetch cities for selected state
            fetch(`/api/states/${encodeURIComponent(selectedState)}/cities`)
                .then(response => response.json())
                .then(data => {
                    data.cities.forEach(city => {
                        const option = document.createElement('option');
                        option.value = city.name;
                        option.textContent = city.name;
                        citySelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Erro ao carregar cidades:', error);
                });
        }
    });
});
</script>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Dynamic city loading based on state selection
    const stateSelect = document.getElementById('state');
    const citySelect = document.getElementById('city');

    if (stateSelect && citySelect) {
        stateSelect.addEventListener('change', function() {
            const selectedState = this.value;
            
            // Reset city select
            citySelect.innerHTML = '<option value="all">🏘️ Todas as cidades</option>';
            
            if (selectedState && selectedState !== 'all') {
                // Show loading state
                citySelect.innerHTML = '<option value="">⏳ Carregando cidades...</option>';
                
                fetch(`/api/states/${encodeURIComponent(selectedState)}/cities`)
                    .then(response => response.json())
                    .then(data => {
                        citySelect.innerHTML = '<option value="all">🏘️ Todas as cidades</option>';
                        
                        data.cities.forEach(city => {
                            const option = document.createElement('option');
                            option.value = city.name;
                            option.textContent = city.name;
                            citySelect.appendChild(option);
                        });
                    })
                    .catch(error => {
                        console.error('Erro ao carregar cidades:', error);
                        citySelect.innerHTML = '<option value="all">🏘️ Todas as cidades</option>';
                        citySelect.innerHTML += '<option value="" disabled>❌ Erro ao carregar cidades</option>';
                    });
            }
        });
    }

    // Form auto-submit on filter change (optional)
    const filterInputs = document.querySelectorAll('#filters input, #filters select');
    filterInputs.forEach(input => {
        if (input.type !== 'submit' && input.type !== 'button') {
            input.addEventListener('change', function() {
                // Optional: Auto-submit form after a delay
                // setTimeout(() => {
                //     this.form.submit();
                // }, 500);
            });
        }
    });

    // Add loading animation to filter button
    const filterButton = document.querySelector('button[type="submit"]');
    if (filterButton) {
        filterButton.addEventListener('click', function() {
            const originalText = this.innerHTML;
            this.innerHTML = '<span>⏳</span><span>Filtrando...</span>';
            this.disabled = true;
            
            // Re-enable after form submission (in case of errors)
            setTimeout(() => {
                this.innerHTML = originalText;
                this.disabled = false;
            }, 3000);
        });
    }

    // Add hover effects to cards
    const cards = document.querySelectorAll('.hover-scale');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });

    // Animate elements on scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    // Observe all cards for animation
    document.querySelectorAll('.bg-white.rounded-xl.shadow-lg').forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(card);
    });
});
</script>
@endpush
