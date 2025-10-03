@extends('layouts.app')

@section('content')
<!-- Header Section -->
<section class="relative gradient-purple-blue py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center">
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-6">
                Carrinho de Compras
            </h1>
            <p class="text-xl text-blue-100 mb-8 max-w-2xl mx-auto">
                Revise seus bilhetes antes de finalizar a compra
            </p>
        </div>
    </div>
</section>

<!-- Cart Content -->
<section class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($cartItems->count() > 0)
            <div class="grid lg:grid-cols-3 gap-8">
                <!-- Cart Items -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                        <div class="p-6 border-b border-gray-200">
                            <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-3">
                                Seus Bilhetes
                            </h2>
                            <p class="text-gray-600 mt-2">{{ $cartItems->count() }} {{ $cartItems->count() == 1 ? 'rifa no carrinho' : 'rifas no carrinho' }}</p>
                        </div>
                        
                        <div class="divide-y divide-gray-200">
                            @foreach($cartItems as $item)
                                <div class="p-6 cart-item" data-cart-id="{{ $item->id }}" data-raffle-id="{{ $item->raffle->id }}">
                                    <div class="flex items-start gap-6">
                                        <!-- Raffle Image -->
                                        <div class="flex-shrink-0">
                                            <div class="w-24 h-24 bg-gradient-to-br 
                                                @switch($item->raffle->category)
                                                    @case('social') from-purple-400 to-blue-500 @break
                                                    @case('medical') from-green-400 to-blue-500 @break
                                                    @case('education') from-pink-400 to-purple-500 @break
                                                    @case('religious') from-blue-400 to-indigo-500 @break
                                                    @case('sports') from-orange-400 to-red-500 @break
                                                    @default from-purple-400 to-blue-500
                                                @endswitch
                                                rounded-lg flex items-center justify-center">
                                                <span class="text-3xl">
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
                                        </div>
                                        
                                        <!-- Raffle Info -->
                                        <div class="flex-1">
                                            <div class="flex justify-between items-start">
                                                <div class="flex-1 cursor-pointer" onclick="window.location.href='{{ route('raffles.show', $item->raffle) }}'">
                                                    <h3 class="text-lg font-bold text-gray-900 mb-2 hover:text-purple-600 transition-colors raffle-title">
                                                        {{ $item->raffle->title }}
                                                    </h3>
                                                    <p class="text-gray-600 text-sm mb-3">
                                                        {{ Str::limit($item->raffle->description, 100) }}
                                                    </p>
                                                    
                                                    <!-- Progress -->
                                                    <div class="mb-3">
                                                        <div class="flex justify-between text-sm text-gray-500 mb-1">
                                                            <span>Progresso</span>
                                                            <span>{{ number_format($item->raffle->progress_percentage, 1) }}% vendido</span>
                                                        </div>
                                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                                            <div class="bg-gradient-to-r from-purple-500 to-blue-500 h-2 rounded-full" 
                                                                 style="width: {{ $item->raffle->progress_percentage }}%"></div>
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- Price per ticket -->
                                                    <p class="text-sm text-gray-600">
                                                        <span class="font-semibold price-per-ticket">R$ {{ number_format($item->raffle->price_per_ticket, 2, ',', '.') }}</span> por número
                                                    </p>
                                                </div>
                                                
                                                <!-- Remove button -->
                                                <button onclick="removeFromCart({{ $item->id }})" 
                                                        class="text-red-500 hover:text-red-700 transition-colors">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                            
                                            <!-- Quantity and Total -->
                                            <div class="flex justify-between items-center mt-4 pt-4 border-t border-gray-200">
                                                <div class="flex items-center gap-3">
                                                    <label class="text-sm font-medium text-gray-700">Quantidade:</label>
                                                    <div class="flex items-center gap-2">
                                                        <button onclick="decreaseQuantity({{ $item->id }})" 
                                                                class="w-8 h-8 bg-gray-100 hover:bg-gray-200 rounded-lg flex items-center justify-center font-bold text-sm">
                                                            -
                                                        </button>
                                                        <span class="quantity-display w-12 text-center font-semibold">{{ $item->ticket_quantity }}</span>
                                                        <button onclick="increaseQuantity({{ $item->id }})" 
                                                                class="w-8 h-8 bg-gray-100 hover:bg-gray-200 rounded-lg flex items-center justify-center font-bold text-sm">
                                                            +
                                                        </button>
                                                    </div>
                                                </div>
                                                
                                                <div class="text-right">
                                                    <div class="text-2xl font-bold text-gray-900 item-total">
                                                        R$ {{ number_format($item->total_price, 2, ',', '.') }}
                                                    </div>
                                                    <div class="text-sm text-gray-500">
                                                        {{ $item->ticket_quantity }} {{ $item->ticket_quantity == 1 ? 'bilhete' : 'bilhetes' }}
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Action Buttons -->
                                            <div class="flex gap-3 mt-4">
                                                <button onclick="openNumberSelection({{ $item->raffle->id }}, {{ $item->raffle->total_tickets }}, 0)" 
                                                        class="flex-1 bg-gradient-to-r from-purple-500 to-blue-500 hover:from-purple-600 hover:to-blue-600 text-white py-3 px-4 rounded-lg font-semibold transition-all duration-300 flex items-center justify-center gap-2">
                                                    <span>💳</span>
                                                    <span>COMPRAR</span>
                                                </button>
                                                <a href="{{ route('raffles.show', $item->raffle) }}" 
                                                   class="px-4 py-3 border-2 border-gray-300 text-gray-700 rounded-lg font-semibold hover:border-purple-500 hover:text-purple-600 transition-all duration-300 text-center">
                                                    Ver Detalhes
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <!-- Clear Cart Button -->
                        <div class="p-6 border-t border-gray-200">
                        <button onclick="clearCart()" 
                                class="text-red-600 hover:text-red-700 font-medium text-sm transition-colors">
                            Limpar carrinho
                        </button>
                        </div>
                    </div>
                </div>
                
                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-lg p-6 sticky top-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                            Resumo do Pedido
                        </h2>
                        
                        <!-- Order Details -->
                        <div class="space-y-4 mb-6">
                            <div class="flex justify-between text-gray-600">
                                <span>{{ $cartItems->count() }} {{ $cartItems->count() == 1 ? 'rifa' : 'rifas' }}</span>
                                <span>{{ $cartItems->sum('ticket_quantity') }} {{ $cartItems->sum('ticket_quantity') == 1 ? 'bilhete' : 'bilhetes' }}</span>
                            </div>
                            
                            <div class="border-t border-gray-200 pt-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-semibold text-gray-900">Total:</span>
                                    <span id="total-amount" class="text-3xl font-bold text-purple-600">
                                        R$ {{ number_format($totalAmount, 2, ',', '.') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Checkout Button -->
                        <button onclick="proceedToCheckout()" 
                                class="w-full bg-gradient-to-r from-purple-500 to-blue-500 text-white py-4 rounded-lg font-semibold hover:from-purple-600 hover:to-blue-600 transition-all duration-300 flex items-center justify-center gap-2 mb-4">
                            Finalizar Compra
                        </button>
                        
                        <!-- Continue Shopping -->
                        <a href="{{ route('raffles.index') }}" 
                           class="w-full border-2 border-gray-300 text-gray-700 py-3 rounded-lg font-semibold hover:border-gray-400 transition-colors flex items-center justify-center gap-2">
                            Continuar Comprando
                        </a>
                        
                        <!-- Security Info -->
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <div class="flex items-center gap-3 text-sm text-gray-600 mb-2">
                                <span class="text-green-500">🔒</span>
                                <span>Pagamento 100% seguro</span>
                            </div>
                            <div class="flex items-center gap-3 text-sm text-gray-600">
                                <span class="text-blue-500">⚡</span>
                                <span>Processamento instantâneo</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- Empty Cart -->
            <div class="text-center py-16">
                <div class="text-8xl mb-6">📦</div>
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Seu carrinho está vazio</h2>
                <p class="text-gray-600 mb-8 max-w-md mx-auto">
                    Adicione alguns bilhetes ao seu carrinho para começar a participar das rifas!
                </p>
                <a href="{{ route('raffles.index') }}" 
                   class="bg-purple-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-purple-700 transition-colors">
                    IR AO MERCADO
                </a>
            </div>
        @endif
    </div>
</section>

<!-- Number Selection Modal -->
<div id="numberSelectionModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-hidden">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-purple-500 to-blue-500 text-white p-6">
                <div class="flex justify-between items-center">
                    <h2 class="text-2xl font-bold">Selecionar Números da Rifa</h2>
                    <button onclick="closeNumberSelection()" class="text-white hover:text-gray-200 transition-colors">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <p class="text-blue-100 mt-2">Clique nos números que deseja comprar</p>
            </div>
            
            <!-- Modal Content -->
            <div class="p-6 overflow-y-auto max-h-[calc(90vh-200px)]">
                <!-- Raffle Info -->
                <div id="modalRaffleInfo" class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <h3 id="modalRaffleTitle" class="text-lg font-bold text-gray-900 mb-2"></h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                        <div>
                            <span class="text-gray-600">Total de números:</span>
                            <span id="modalTotalNumbers" class="font-semibold text-gray-900"></span>
                        </div>
                        <div>
                            <span class="text-gray-600">Vendidos:</span>
                            <span id="modalSoldNumbers" class="font-semibold text-red-600"></span>
                        </div>
                        <div>
                            <span class="text-gray-600">Disponíveis:</span>
                            <span id="modalAvailableNumbers" class="font-semibold text-green-600"></span>
                        </div>
                        <div>
                            <span class="text-gray-600">Preço por número:</span>
                            <span id="modalPricePerNumber" class="font-semibold text-gray-900"></span>
                        </div>
                    </div>
                </div>
                
                <!-- Group Selection -->
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                    <h4 class="font-semibold text-green-900 mb-3">Seleção em Grupo</h4>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Intervalo de números:</label>
                            <input type="text" id="rangeInput" placeholder="Ex: 130-140, 150-200, 300" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            <p class="text-xs text-gray-500 mt-1">Suporte a intervalos: 1-10, números únicos: 100, múltiplos: 1-5, 50-60, 100</p>
                        </div>
                        <div class="flex items-end">
                            <button onclick="selectRange()" 
                                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-medium">
                                Selecionar Intervalo
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Selected Numbers Summary -->
                <div id="selectedNumbersSummary" class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg hidden">
                    <h4 class="font-semibold text-blue-900 mb-2">Números Selecionados:</h4>
                    <div class="flex flex-wrap gap-2 mb-3">
                        <div id="selectedNumbersList" class="flex flex-wrap gap-1"></div>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-blue-700">
                            Total: <span id="selectedCount">0</span> números
                        </span>
                        <span class="font-bold text-blue-900">
                            Valor Total: R$ <span id="selectedTotal">0,00</span>
                        </span>
                    </div>
                </div>
                
                <!-- Numbers Grid -->
                <div id="numbersGrid" class="grid grid-cols-10 md:grid-cols-15 lg:grid-cols-20 gap-2 mb-6">
                    <!-- Numbers will be generated by JavaScript -->
                </div>
            </div>
            
            <!-- Modal Footer -->
            <div class="bg-gray-50 p-6 border-t border-gray-200">
                <div class="flex justify-between items-center">
                    <button onclick="clearSelectedNumbers()" 
                            class="px-6 py-3 text-gray-600 hover:text-gray-800 font-medium transition-colors">
                        Limpar Seleção
                    </button>
                    <div class="flex gap-3">
                        <button onclick="closeNumberSelection()" 
                                class="px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-lg font-semibold hover:border-gray-400 transition-colors">
                            Cancelar
                        </button>
                        <button id="confirmPurchaseBtn" onclick="confirmPurchase()" 
                                class="px-6 py-3 bg-gradient-to-r from-purple-500 to-blue-500 text-white rounded-lg font-semibold hover:from-purple-600 hover:to-blue-600 transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed"
                                disabled>
                            Comprar <span id="confirmCount">0</span> Números - R$ <span id="confirmTotal">0,00</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function increaseQuantity(cartId) {
    updateQuantity(cartId, 1);
}

function decreaseQuantity(cartId) {
    updateQuantity(cartId, -1);
}

function updateQuantity(cartId, change) {
    const quantityElement = document.querySelector(`[data-cart-id="${cartId}"] .quantity-display`);
    const currentQuantity = parseInt(quantityElement.textContent);
    const newQuantity = Math.max(1, currentQuantity + change);
    
    fetch(`/cart/${cartId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            quantity: newQuantity
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            quantityElement.textContent = newQuantity;
            
            // Update item total
            const itemTotalElement = document.querySelector(`[data-cart-id="${cartId}"] .item-total`);
            if (itemTotalElement) {
                itemTotalElement.textContent = `R$ ${data.total_price.toLocaleString('pt-BR', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
            }
            
            // Reload page to update totals
            location.reload();
        } else {
            if (window.showNotification) {
                showNotification(data.error || 'Erro ao atualizar quantidade', 'error');
            } else {
                alert(data.error || 'Erro ao atualizar quantidade');
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        if (window.showNotification) {
            showNotification('Erro ao atualizar quantidade', 'error');
        } else {
            alert('Erro ao atualizar quantidade');
        }
    });
}

function removeFromCart(cartId) {
    if (!confirm('Tem certeza que deseja remover este item do carrinho?')) {
        return;
    }
    
    fetch(`/cart/${cartId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Remove item from DOM
            const itemElement = document.querySelector(`[data-cart-id="${cartId}"]`);
            if (itemElement) {
                itemElement.remove();
            }
            
            // Update cart count in header
            const cartCount = document.getElementById('cart-count');
            if (cartCount) {
                cartCount.textContent = data.cart_count;
                if (data.cart_count === 0) {
                    cartCount.classList.add('hidden');
                }
            }
            
            // Reload page if cart is empty
            if (data.cart_count === 0) {
                location.reload();
            }
            
            if (window.showNotification) {
                showNotification(data.message, 'success');
            } else {
                alert(data.message);
            }
        } else {
            if (window.showNotification) {
                showNotification(data.error || 'Erro ao remover item', 'error');
            } else {
                alert(data.error || 'Erro ao remover item');
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        if (window.showNotification) {
            showNotification('Erro ao remover item', 'error');
        } else {
            alert('Erro ao remover item');
        }
    });
}

function clearCart() {
    if (!confirm('Tem certeza que deseja limpar todo o carrinho?')) {
        return;
    }
    
    fetch('/cart', {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            if (window.showNotification) {
                showNotification(data.error || 'Erro ao limpar carrinho', 'error');
            } else {
                alert(data.error || 'Erro ao limpar carrinho');
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        if (window.showNotification) {
            showNotification('Erro ao limpar carrinho', 'error');
        } else {
            alert('Erro ao limpar carrinho');
        }
    });
}

function proceedToCheckout() {
    // TODO: Implement checkout functionality
    alert('Funcionalidade de checkout em desenvolvimento! Em breve você poderá finalizar sua compra.');
}

// Number Selection Modal Functions
let currentRaffleId = null;
let currentPricePerTicket = 0;
let selectedNumbers = [];
let soldNumbers = [];

function openNumberSelection(raffleId, totalNumbers, soldTickets) {
    currentRaffleId = raffleId;
    selectedNumbers = [];
    // Set soldTickets to 0 so all numbers are available
    soldNumbers = [];
    
    // Get raffle info from the page
    const raffleElement = document.querySelector(`[data-raffle-id="${raffleId}"]`);
    if (!raffleElement) {
        console.error('Raffle element not found');
        return;
    }
    
    // Set modal info
    document.getElementById('modalRaffleTitle').textContent = raffleElement.querySelector('.raffle-title')?.textContent || 'Rifa';
    document.getElementById('modalTotalNumbers').textContent = totalNumbers.toLocaleString();
    document.getElementById('modalSoldNumbers').textContent = '0';
    document.getElementById('modalAvailableNumbers').textContent = totalNumbers.toLocaleString();
    document.getElementById('modalPricePerNumber').textContent = raffleElement.querySelector('.price-per-ticket')?.textContent || 'R$ 0,00';
    
    // Extract price from text
    const priceText = raffleElement.querySelector('.price-per-ticket')?.textContent || 'R$ 0,00';
    currentPricePerTicket = parseFloat(priceText.replace('R$ ', '').replace(',', '.')) || 0;
    
    // Generate numbers grid
    generateNumbersGrid(totalNumbers);
    
    // Show modal
    document.getElementById('numberSelectionModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeNumberSelection() {
    document.getElementById('numberSelectionModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
    selectedNumbers = [];
    updateSelectedNumbersSummary();
}

function generateNumbersGrid(totalNumbers) {
    const grid = document.getElementById('numbersGrid');
    grid.innerHTML = '';
    
    for (let i = 1; i <= totalNumbers; i++) {
        const numberElement = document.createElement('div');
        numberElement.className = `number-seat w-12 h-12 rounded-lg flex items-center justify-center font-semibold text-sm cursor-pointer transition-all duration-200 transform hover:scale-105`;
        numberElement.textContent = i;
        numberElement.dataset.number = i;
        
        if (soldNumbers.includes(i)) {
            // Sold numbers - dark gray
            numberElement.className += ' bg-gray-400 text-gray-600 cursor-not-allowed opacity-60';
            numberElement.title = 'Número já vendido';
        } else {
            // Available numbers - light blue
            numberElement.className += ' bg-blue-100 text-blue-800 hover:bg-blue-200 border border-blue-300';
            numberElement.onclick = () => toggleNumberSelection(i);
        }
        
        grid.appendChild(numberElement);
    }
}

function toggleNumberSelection(number) {
    if (soldNumbers.includes(number)) return;
    
    const index = selectedNumbers.indexOf(number);
    if (index > -1) {
        // Remove from selection
        selectedNumbers.splice(index, 1);
    } else {
        // Add to selection
        selectedNumbers.push(number);
    }
    
    updateNumberDisplay();
    updateSelectedNumbersSummary();
}

function updateNumberDisplay() {
    document.querySelectorAll('.number-seat').forEach(element => {
        const number = parseInt(element.dataset.number);
        
        if (soldNumbers.includes(number)) {
            // Keep sold numbers as they are
            return;
        }
        
        if (selectedNumbers.includes(number)) {
            // Selected numbers - green
            element.className = element.className.replace(/bg-\w+-\d+/g, 'bg-green-500').replace(/text-\w+-\d+/g, 'text-white').replace(/border-\w+-\d+/g, 'border-green-600');
            element.className += ' border-2 border-green-600';
        } else {
            // Available numbers - light blue
            element.className = element.className.replace(/bg-\w+-\d+/g, 'bg-blue-100').replace(/text-\w+-\d+/g, 'text-blue-800').replace(/border-\w+-\d+/g, 'border-blue-300');
            element.className += ' border border-blue-300';
        }
    });
}

function updateSelectedNumbersSummary() {
    const summary = document.getElementById('selectedNumbersSummary');
    const selectedCount = document.getElementById('selectedCount');
    const selectedTotal = document.getElementById('selectedTotal');
    const confirmCount = document.getElementById('confirmCount');
    const confirmTotal = document.getElementById('confirmTotal');
    const confirmBtn = document.getElementById('confirmPurchaseBtn');
    const selectedList = document.getElementById('selectedNumbersList');
    
    if (selectedNumbers.length === 0) {
        summary.classList.add('hidden');
        confirmBtn.disabled = true;
        return;
    }
    
    summary.classList.remove('hidden');
    selectedCount.textContent = selectedNumbers.length;
    confirmCount.textContent = selectedNumbers.length;
    
    const totalPrice = selectedNumbers.length * currentPricePerTicket;
    selectedTotal.textContent = totalPrice.toLocaleString('pt-BR', {minimumFractionDigits: 2, maximumFractionDigits: 2});
    confirmTotal.textContent = totalPrice.toLocaleString('pt-BR', {minimumFractionDigits: 2, maximumFractionDigits: 2});
    
    confirmBtn.disabled = false;
    
    // Update selected numbers list
    selectedList.innerHTML = '';
    selectedNumbers.sort((a, b) => a - b).forEach(number => {
        const badge = document.createElement('span');
        badge.className = 'inline-flex items-center px-2 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full';
        badge.textContent = number;
        selectedList.appendChild(badge);
    });
}

function selectRange() {
    const rangeInput = document.getElementById('rangeInput');
    const rangeText = rangeInput.value.trim();
    
    if (!rangeText) {
        alert('Digite um intervalo de números (ex: 130-140, 150-200)');
        return;
    }
    
    try {
        const ranges = rangeText.split(',').map(range => range.trim());
        const numbersToSelect = [];
        
        // Get total numbers from the modal
        const totalNumbers = parseInt(document.getElementById('modalTotalNumbers').textContent);
        
        for (const range of ranges) {
            if (range.includes('-')) {
                // Range like "130-140"
                const [start, end] = range.split('-').map(num => parseInt(num.trim()));
                if (isNaN(start) || isNaN(end) || start > end) {
                    throw new Error(`Intervalo inválido: ${range}`);
                }
                
                for (let i = start; i <= end; i++) {
                    if (i >= 1 && i <= totalNumbers && !soldNumbers.includes(i)) {
                        numbersToSelect.push(i);
                    }
                }
            } else {
                // Single number like "100"
                const number = parseInt(range);
                if (isNaN(number)) {
                    throw new Error(`Número inválido: ${range}`);
                }
                
                if (number >= 1 && number <= totalNumbers && !soldNumbers.includes(number)) {
                    numbersToSelect.push(number);
                }
            }
        }
        
        // Add numbers to selection (avoid duplicates)
        numbersToSelect.forEach(number => {
            if (!selectedNumbers.includes(number)) {
                selectedNumbers.push(number);
            }
        });
        
        // Update display
        updateNumberDisplay();
        updateSelectedNumbersSummary();
        
        // Clear input
        rangeInput.value = '';
        
        // Show success message
        if (numbersToSelect.length > 0) {
            alert(`${numbersToSelect.length} números selecionados com sucesso!`);
        } else {
            alert('Nenhum número válido encontrado no intervalo especificado.');
        }
        
    } catch (error) {
        alert(`Erro: ${error.message}`);
    }
}

function clearSelectedNumbers() {
    selectedNumbers = [];
    updateNumberDisplay();
    updateSelectedNumbersSummary();
}

function confirmPurchase() {
    if (selectedNumbers.length === 0) {
        alert('Selecione pelo menos um número para comprar.');
        return;
    }
    
    // Check authentication
    @if(!auth()->check())
        window.location.href = '{{ route('login') }}';
        return;
    @endif
    
    // Create form data
    const formData = new FormData();
    formData.append('raffle_id', currentRaffleId);
    formData.append('selected_numbers', JSON.stringify(selectedNumbers));
    formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
    
    // Show loading state
    const confirmBtn = document.getElementById('confirmPurchaseBtn');
    const originalText = confirmBtn.innerHTML;
    confirmBtn.innerHTML = '<span class="animate-spin">⏳</span> Processando...';
    confirmBtn.disabled = true;
    
    // Submit purchase
    fetch(`/raffles/${currentRaffleId}/purchase`, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            if (window.showNotification) {
                showNotification(data.message, 'success');
            } else {
                alert(data.message);
            }
            closeNumberSelection();
            
            // Redirect to payment methods
            if (data.redirect_url) {
                window.location.href = data.redirect_url;
            } else {
                location.reload();
            }
        } else {
            if (window.showNotification) {
                showNotification(data.error || 'Erro ao processar compra', 'error');
            } else {
                alert(data.error || 'Erro ao processar compra');
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        if (window.showNotification) {
            showNotification('Erro ao processar compra', 'error');
        } else {
            alert('Erro ao processar compra');
        }
    })
    .finally(() => {
        // Restore button state
        confirmBtn.innerHTML = originalText;
        confirmBtn.disabled = false;
    });
}
</script>
@endsection
