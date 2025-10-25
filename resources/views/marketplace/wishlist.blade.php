@extends('layouts.marketplace')

@section('title', 'Lista de Desejos')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Lista de Desejos</h1>
        <p class="text-gray-600">Suas rifas favoritas salvas para mais tarde</p>
    </div>

    @if($wishlist->count() > 0)
        <!-- Wishlist Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($wishlist as $wishlistItem)
                @include('marketplace.partials.raffle-card', ['raffle' => $wishlistItem->raffle])
            @endforeach
        </div>

        <!-- Pagination -->
        @if($wishlist->hasPages())
            <div class="mt-12">
                {{ $wishlist->links() }}
            </div>
        @endif
    @else
        <!-- Empty Wishlist -->
        <div class="text-center py-16">
            <div class="text-6xl mb-6">❤️</div>
            <h3 class="text-2xl font-bold text-gray-900 mb-4">Sua lista de desejos está vazia</h3>
            <p class="text-gray-600 mb-8 max-w-md mx-auto">
                Adicione rifas à sua lista de desejos clicando no ícone de coração.
            </p>
            <a href="{{ route('marketplace.index') }}" 
               class="bg-purple-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-purple-700 transition-colors">
                Explorar Rifas
            </a>
        </div>
    @endif
</div>
@endsection
