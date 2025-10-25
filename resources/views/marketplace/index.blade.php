@extends('layouts.marketplace')

@section('title', 'Marketplace de Rifas')

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
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-4xl mx-auto">
                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6 text-center border border-white/20 hover:bg-white/15 transition-all duration-300">
                    <div class="text-3xl font-bold text-white mb-2">{{ number_format($stats['total_active_raffles']) }}</div>
                    <div class="text-blue-200 text-sm">Rifas Ativas</div>
                    <div class="text-blue-300 text-xs mt-1">No marketplace</div>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6 text-center border border-white/20 hover:bg-white/15 transition-all duration-300">
                    <div class="text-3xl font-bold text-white mb-2">{{ number_format($stats['total_tickets_sold']) }}</div>
                    <div class="text-blue-200 text-sm">Bilhetes Vendidos</div>
                    <div class="text-blue-300 text-xs mt-1">Este mês</div>
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
                <a href="#featured" class="bg-white/20 backdrop-blur-sm hover:bg-white/30 text-white px-8 py-4 rounded-xl font-semibold transition-all duration-300 border border-white/30 flex items-center gap-3">
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
        
        <form method="GET" action="{{ route('marketplace.index') }}" class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
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
                            @foreach($filterData['categories'] as $category)
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
                            @foreach($filterData['states'] as $state)
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
                            @foreach($filterData['cities'] as $city)
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

                <!-- Sort Options -->
                <div class="group">
                    <label for="sort" class="block text-sm font-semibold text-gray-700 mb-3 flex items-center gap-2">
                        <span class="text-purple-500">🔄</span>
                        <span>Ordenar por</span>
                    </label>
                    <div class="relative">
                        <select id="sort" 
                                name="sort" 
                                class="w-full px-4 py-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-300 bg-gray-50 focus:bg-white group-hover:border-purple-300 appearance-none cursor-pointer">
                            <option value="featured" {{ request('sort') == 'featured' ? 'selected' : '' }}>⭐ Destaque</option>
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>🆕 Mais recentes</option>
                            <option value="ending_soon" {{ request('sort') == 'ending_soon' ? 'selected' : '' }}>⏰ Terminando em breve</option>
                            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>💰 Menor preço</option>
                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>💎 Maior preço</option>
                            <option value="progress" {{ request('sort') == 'progress' ? 'selected' : '' }}>🔥 Mais vendidas</option>
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
                                   placeholder="{{ number_format($filterData['priceRange']->max_price ?? 1000, 2, ',', '.') }}"
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
                        
                        <a href="{{ route('marketplace.index') }}" 
                           class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2 rounded-lg font-medium transition-all duration-300 text-center text-sm">
                            Limpar Filtros
                        </a>
                    </div>
                </div>
                
                @if($filterData['priceRange'])
                    <div class="mt-4 p-3 bg-white rounded-lg border border-gray-200">
                        <p class="text-sm text-gray-600 flex items-center gap-2">
                            <span class="text-green-500">📊</span>
                            <span>Faixa atual disponível: <strong>R$ {{ number_format($filterData['priceRange']->min_price, 2, ',', '.') }} - R$ {{ number_format($filterData['priceRange']->max_price, 2, ',', '.') }}</strong></span>
                        </p>
                    </div>
                @endif
            </div>
        </form>
    </div>
</section>

<!-- Featured Raffles Section -->
@if($featuredRaffles->count() > 0)
<section id="featured" class="py-16 bg-gradient-to-br from-purple-50 to-blue-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Rifas em Destaque</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">
                As rifas mais populares e com maior chance de ganhar
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($featuredRaffles as $raffle)
                @include('marketplace.partials.raffle-card', ['raffle' => $raffle, 'featured' => true])
            @endforeach
        </div>
        
        <div class="text-center mt-12">
            <a href="{{ route('marketplace.index') }}?sort=featured" class="inline-flex items-center gap-2 bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300">
                <span>Ver Todas as Rifas em Destaque</span>
                <span>→</span>
            </a>
        </div>
    </div>
</section>
@endif

<!-- Results Section -->
<section class="py-16 bg-gradient-to-br from-white to-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Results Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-12 gap-4">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-2">
                    {{ $raffles->total() }} {{ $raffles->total() == 1 ? 'rifa encontrada' : 'rifas encontradas' }}
                </h2>
                @if(request()->hasAny(['category', 'state', 'city', 'min_price', 'max_price']))
                    <div class="flex items-center gap-2 text-gray-600">
                        <span class="text-blue-500">🔍</span>
                        <span>Filtros aplicados</span>
                    </div>
                @else
                    <p class="text-gray-600">Todas as rifas disponíveis no marketplace</p>
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
                    @include('marketplace.partials.raffle-card', ['raffle' => $raffle])
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
                <a href="{{ route('marketplace.index') }}" 
                   class="bg-purple-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-purple-700 transition-colors">
                    Ver todas as rifas
                </a>
            </div>
        @endif
    </div>
</section>
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
});
</script>
@endpush
