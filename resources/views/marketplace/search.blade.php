@extends('layouts.marketplace')

@section('title', 'Buscar Rifas')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Buscar Rifas</h1>
        @if(request('q'))
            <p class="text-gray-600">Resultados para: <span class="font-semibold text-purple-600">"{{ request('q') }}"</span></p>
        @else
            <p class="text-gray-600">Encontre a rifa perfeita para você</p>
        @endif
    </div>

    <!-- Search Form -->
    <div class="mb-8">
        <form method="GET" action="{{ route('marketplace.search') }}" class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex gap-4">
                <div class="flex-1">
                    <input type="text" 
                           name="q" 
                           value="{{ request('q') }}"
                           placeholder="Digite o nome da rifa, descrição ou organizador..." 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                </div>
                <button type="submit" 
                        class="bg-purple-600 text-white px-6 py-3 rounded-lg hover:bg-purple-700 transition-colors font-semibold">
                    🔍 Buscar
                </button>
            </div>
        </form>
    </div>

    @if($raffles->count() > 0)
        <!-- Results Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">
                    {{ $raffles->total() }} {{ $raffles->total() == 1 ? 'rifa encontrada' : 'rifas encontradas' }}
                </h2>
                @if(request('q'))
                    <p class="text-gray-600">Resultados para "{{ request('q') }}"</p>
                @endif
            </div>
            
            <div class="flex items-center gap-2 text-sm text-gray-500">
                <span>📊</span>
                <span>Página {{ $raffles->currentPage() }} de {{ $raffles->lastPage() }}</span>
            </div>
        </div>

        <!-- Results Grid -->
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
            <h3 class="text-2xl font-bold text-gray-900 mb-4">
                @if(request('q'))
                    Nenhuma rifa encontrada para "{{ request('q') }}"
                @else
                    Nenhuma rifa encontrada
                @endif
            </h3>
            <p class="text-gray-600 mb-8 max-w-md mx-auto">
                @if(request('q'))
                    Tente usar termos diferentes ou verifique a ortografia.
                @else
                    Tente ajustar os filtros de busca.
                @endif
            </p>
            <div class="flex gap-4 justify-center">
                <a href="{{ route('marketplace.index') }}" 
                   class="bg-purple-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-purple-700 transition-colors">
                    Ver Todas as Rifas
                </a>
                @if(request('q'))
                    <a href="{{ route('marketplace.search') }}" 
                       class="bg-gray-100 text-gray-700 px-8 py-3 rounded-lg font-semibold hover:bg-gray-200 transition-colors">
                        Nova Busca
                    </a>
                @endif
            </div>
        </div>
    @endif

    <!-- Search Tips -->
    <div class="mt-16 bg-gradient-to-r from-blue-50 to-purple-50 rounded-2xl p-8">
        <h3 class="text-xl font-bold text-gray-900 mb-4">💡 Dicas de Busca</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h4 class="font-semibold text-gray-800 mb-2">Termos de Busca</h4>
                <ul class="text-sm text-gray-600 space-y-1">
                    <li>• Use palavras-chave específicas</li>
                    <li>• Tente termos relacionados à categoria</li>
                    <li>• Busque por nome do organizador</li>
                    <li>• Use termos do prêmio ou descrição</li>
                </ul>
            </div>
            <div>
                <h4 class="font-semibold text-gray-800 mb-2">Filtros Úteis</h4>
                <ul class="text-sm text-gray-600 space-y-1">
                    <li>• Filtre por categoria</li>
                    <li>• Selecione sua região</li>
                    <li>• Defina faixa de preço</li>
                    <li>• Ordene por relevância</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
