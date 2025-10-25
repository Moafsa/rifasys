@extends('layouts.marketplace')

@section('title', 'Carrinho de Compras')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Carrinho de Compras</h1>
        <p class="text-gray-600">Revise seus itens antes de finalizar a compra</p>
    </div>

    @if($cartItems->count() > 0)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Cart Items -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="p-6 border-b border-gray-200">
                        <h2 class="text-xl font-semibold text-gray-900">Itens no Carrinho ({{ $totalItems }} {{ $totalItems == 1 ? 'item' : 'itens' }})</h2>
                    </div>
                    
                    <div class="divide-y divide-gray-200">
                        @foreach($cartItems as $item)
                            <div class="p-6 flex items-center gap-4">
                                <!-- Raffle Image -->
                                <div class="w-20 h-20 bg-gradient-to-br 
                                    @switch($item->raffle->category)
                                        @case('social') from-purple-400 to-blue-500 @break
                                        @case('medical') from-green-400 to-blue-500 @break
                                        @case('education') from-pink-400 to-purple-500 @break
                                        @case('religious') from-blue-400 to-indigo-500 @break
                                        @case('sports') from-orange-400 to-red-500 @break
                                        @default from-purple-400 to-blue-500
                                    @endswitch
                                    rounded-lg flex items-center justify-center">
                                    <span class="text-2xl">
                                        @switch($item->raffle->category)
                                            @case('social') 🐕 @break
                                            @case('medical') 🏥 @break
                                            @case('education') 🎓 @break
                                            @case('religious') ⛪ @break
                                            @case('sports') ⚽ @break
                                            @default 🎁
                                        @endswitch
                                    </span>
                                </div>
                                
                                <!-- Raffle Info -->
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $item->raffle->title }}</h3>
                                    <p class="text-sm text-gray-600">{{ $item->raffle->organizer->name }}</p>
                                    <div class="flex items-center gap-4 mt-2">
                                        <span class="text-sm text-gray-500">Categoria: {{ ucfirst($item->raffle->category) }}</span>
                                        <span class="text-sm text-gray-500">Sorteio: {{ $item->raffle->draw_date->format('d/m/Y') }}</span>
                                    </div>
                                </div>
                                
                                <!-- Quantity and Price -->
                                <div class="flex items-center gap-4">
                                    <div class="flex items-center gap-2">
                                        <button onclick="updateQuantity({{ $item->id }}, {{ $item->ticket_quantity - 1 }})" 
                                                class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-50">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                            </svg>
                                        </button>
                                        <span id="quantity-{{ $item->id }}" class="w-8 text-center font-medium">{{ $item->ticket_quantity }}</span>
                                        <button onclick="updateQuantity({{ $item->id }}, {{ $item->ticket_quantity + 1 }})" 
                                                class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-50">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    
                                    <div class="text-right">
                                        <div class="text-lg font-semibold text-gray-900" id="price-{{ $item->id }}">
                                            R$ {{ number_format($item->total_price, 2, ',', '.') }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            R$ {{ number_format($item->raffle->price_per_ticket, 2, ',', '.') }} cada
                                        </div>
                                    </div>
                                    
                                    <!-- Remove Button -->
                                    <button onclick="removeItem({{ $item->id }})" 
                                            class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                
                <!-- Actions -->
                <div class="mt-6 flex gap-4">
                    <button onclick="clearCart()" 
                            class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                        Limpar Carrinho
                    </button>
                    <a href="{{ route('marketplace.index') }}" 
                       class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                        Continuar Comprando
                    </a>
                </div>
            </div>
            
            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-lg p-6 sticky top-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Resumo do Pedido</h3>
                    
                    <div class="space-y-4">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Subtotal ({{ $totalItems }} {{ $totalItems == 1 ? 'item' : 'itens' }})</span>
                            <span class="font-medium">R$ {{ number_format($subtotal, 2, ',', '.') }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-gray-600">Taxa de Serviço</span>
                            <span class="font-medium">R$ 0,00</span>
                        </div>
                        
                        <div class="border-t border-gray-200 pt-4">
                            <div class="flex justify-between text-lg font-semibold">
                                <span>Total</span>
                                <span class="text-purple-600">R$ {{ number_format($subtotal, 2, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <button class="w-full mt-6 bg-gradient-to-r from-purple-500 to-blue-500 hover:from-purple-600 hover:to-blue-600 text-white py-3 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg">
                        Finalizar Compra
                    </button>
                    
                    <div class="mt-4 text-center">
                        <p class="text-sm text-gray-500">
                            🔒 Pagamento seguro via PIX
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Empty Cart -->
        <div class="text-center py-16">
            <div class="text-6xl mb-6">🛒</div>
            <h3 class="text-2xl font-bold text-gray-900 mb-4">Seu carrinho está vazio</h3>
            <p class="text-gray-600 mb-8 max-w-md mx-auto">
                Adicione algumas rifas ao seu carrinho para começar a comprar.
            </p>
            <a href="{{ route('marketplace.index') }}" 
               class="bg-purple-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-purple-700 transition-colors">
                Explorar Rifas
            </a>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
async function updateQuantity(cartId, newQuantity) {
    if (newQuantity < 1) {
        removeItem(cartId);
        return;
    }
    
    try {
        const response = await fetch(`/marketplace/cart/${cartId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ quantity: newQuantity })
        });
        
        const data = await response.json();
        
        if (data.success) {
            // Update quantity display
            document.getElementById(`quantity-${cartId}`).textContent = newQuantity;
            
            // Reload page to update prices and totals
            location.reload();
        } else {
            alert('Erro ao atualizar quantidade');
        }
    } catch (error) {
        console.error('Error updating quantity:', error);
        alert('Erro ao atualizar quantidade');
    }
}

async function removeItem(cartId) {
    if (!confirm('Tem certeza que deseja remover este item do carrinho?')) {
        return;
    }
    
    try {
        const response = await fetch(`/marketplace/cart/${cartId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });
        
        const data = await response.json();
        
        if (data.success) {
            // Remove item from DOM
            const item = document.querySelector(`[data-cart-id="${cartId}"]`);
            if (item) {
                item.remove();
            }
            
            // Reload page to update totals
            location.reload();
        } else {
            alert('Erro ao remover item');
        }
    } catch (error) {
        console.error('Error removing item:', error);
        alert('Erro ao remover item');
    }
}

async function clearCart() {
    if (!confirm('Tem certeza que deseja limpar todo o carrinho?')) {
        return;
    }
    
    try {
        const response = await fetch('/marketplace/cart', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });
        
        const data = await response.json();
        
        if (data.success) {
            location.reload();
        } else {
            alert('Erro ao limpar carrinho');
        }
    } catch (error) {
        console.error('Error clearing cart:', error);
        alert('Erro ao limpar carrinho');
    }
}
</script>
@endpush
