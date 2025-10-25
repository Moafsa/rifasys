@extends('layouts.marketplace')

@section('title', 'Rifas - ' . ucfirst($category))

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center gap-4 mb-4">
            <a href="{{ route('marketplace.categories') }}" 
               class="text-purple-600 hover:text-purple-700 font-medium">
                ← Voltar às Categorias
            </a>
        </div>
        
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 bg-gradient-to-br 
                @switch($category)
                    @case('social') from-purple-400 to-blue-500 @break
                    @case('medical') from-green-400 to-blue-500 @break
                    @case('education') from-pink-400 to-purple-500 @break
                    @case('religious') from-blue-400 to-indigo-500 @break
                    @case('sports') from-orange-400 to-red-500 @break
                    @default from-purple-400 to-blue-500
                @endswitch
                rounded-xl flex items-center justify-center">
                <span class="text-3xl">
                    @switch($category)
                        @case('social') 🐕 @break
                        @case('medical') 🏥 @break
                        @case('education') 🎓 @break
                        @case('religious') ⛪ @break
                        @case('sports') ⚽ @break
                        @default 🎁
                    @endswitch
                </span>
            </div>
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ ucfirst($category) }}</h1>
                <p class="text-gray-600">{{ $raffles->total() }} {{ $raffles->total() == 1 ? 'rifa disponível' : 'rifas disponíveis' }}</p>
            </div>
        </div>
    </div>

    <!-- Category Description -->
    <div class="mb-8 bg-gradient-to-r from-gray-50 to-blue-50 rounded-xl p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-2">Sobre Rifas {{ ucfirst($category) }}</h2>
        <p class="text-gray-600">
            @switch($category)
                @case('social')
                    Rifas com foco em causas sociais, ajudando pessoas e comunidades em situação de vulnerabilidade.
                @break
                @case('medical')
                    Rifas para arrecadar fundos para tratamentos médicos, cirurgias e cuidados de saúde.
                @break
                @case('education')
                    Rifas destinadas a projetos educacionais, bolsas de estudo e melhorias em instituições de ensino.
                @break
                @case('religious')
                    Rifas organizadas por comunidades religiosas para eventos, reformas e atividades da igreja.
                @break
                @case('sports')
                    Rifas relacionadas a eventos esportivos, equipamentos e atividades atléticas.
                @break
                @default
                    Rifas diversas com diferentes propósitos e objetivos.
            @endswitch
        </p>
    </div>

    @if($raffles->count() > 0)
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
            <div class="text-6xl mb-6">
                @switch($category)
                    @case('social') 🐕 @break
                    @case('medical') 🏥 @break
                    @case('education') 🎓 @break
                    @case('religious') ⛪ @break
                    @case('sports') ⚽ @break
                    @default 🎁
                @endswitch
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-4">
                Nenhuma rifa {{ $category }} encontrada
            </h3>
            <p class="text-gray-600 mb-8 max-w-md mx-auto">
                Não há rifas disponíveis nesta categoria no momento. Tente novamente mais tarde.
            </p>
            <div class="flex gap-4 justify-center">
                <a href="{{ route('marketplace.categories') }}" 
                   class="bg-purple-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-purple-700 transition-colors">
                    Ver Outras Categorias
                </a>
                <a href="{{ route('marketplace.index') }}" 
                   class="bg-gray-100 text-gray-700 px-8 py-3 rounded-lg font-semibold hover:bg-gray-200 transition-colors">
                    Ver Todas as Rifas
                </a>
            </div>
        </div>
    @endif

    <!-- Related Categories -->
    <div class="mt-16">
        <h3 class="text-xl font-bold text-gray-900 mb-6">Outras Categorias</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @php
                $allCategories = [
                    'social' => ['icon' => '🐕', 'color' => 'from-purple-400 to-blue-500'],
                    'medical' => ['icon' => '🏥', 'color' => 'from-green-400 to-blue-500'],
                    'education' => ['icon' => '🎓', 'color' => 'from-pink-400 to-purple-500'],
                    'religious' => ['icon' => '⛪', 'color' => 'from-blue-400 to-indigo-500'],
                    'sports' => ['icon' => '⚽', 'color' => 'from-orange-400 to-red-500'],
                ];
            @endphp
            
            @foreach($allCategories as $catName => $catData)
                @if($catName !== $category)
                    <a href="{{ route('marketplace.category', $catName) }}" 
                       class="group bg-white rounded-lg shadow-md p-4 hover:shadow-lg transition-all duration-300 text-center">
                        <div class="w-12 h-12 bg-gradient-to-br {{ $catData['color'] }} rounded-lg flex items-center justify-center mx-auto mb-3">
                            <span class="text-2xl">{{ $catData['icon'] }}</span>
                        </div>
                        <h4 class="font-semibold text-gray-900 group-hover:text-purple-700 transition-colors">
                            {{ ucfirst($catName) }}
                        </h4>
                    </a>
                @endif
            @endforeach
        </div>
    </div>
</div>
@endsection
