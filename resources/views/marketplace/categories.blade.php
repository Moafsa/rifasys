@extends('layouts.marketplace')

@section('title', 'Categorias de Rifas')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-12">
        <h1 class="text-3xl font-bold text-gray-900 mb-4">Categorias de Rifas</h1>
        <p class="text-gray-600 max-w-2xl">
            Explore rifas por categoria e encontre exatamente o que você procura
        </p>
    </div>

    <!-- Categories Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($categories as $category)
            <a href="{{ route('marketplace.category', $category['name']) }}" 
               class="group bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                <!-- Category Header -->
                <div class="h-32 bg-gradient-to-br {{ $category['color'] }} flex items-center justify-center">
                    <span class="text-4xl">{{ $category['icon'] }}</span>
                </div>
                
                <!-- Category Content -->
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-purple-700 transition-colors">
                        {{ ucfirst($category['name']) }}
                    </h3>
                    <p class="text-gray-600 mb-4">
                        {{ $category['count'] }} {{ $category['count'] == 1 ? 'rifa disponível' : 'rifas disponíveis' }}
                    </p>
                    
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500">Ver todas</span>
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-purple-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </div>
            </a>
        @endforeach
    </div>

    <!-- Quick Stats -->
    <div class="mt-16 bg-gradient-to-r from-purple-50 to-blue-50 rounded-2xl p-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Estatísticas do Marketplace</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="text-3xl font-bold text-purple-600 mb-2">{{ $categories->sum('count') }}</div>
                <div class="text-gray-600">Total de Rifas</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-blue-600 mb-2">{{ $categories->count() }}</div>
                <div class="text-gray-600">Categorias Ativas</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-green-600 mb-2">100%</div>
                <div class="text-gray-600">Rifas Verificadas</div>
            </div>
        </div>
    </div>
</div>
@endsection
