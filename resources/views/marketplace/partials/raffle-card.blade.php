@php
    $featured = $featured ?? false;
    $categoryColors = [
        'social' => 'from-purple-400 to-blue-500',
        'medical' => 'from-green-400 to-blue-500',
        'education' => 'from-pink-400 to-purple-500',
        'religious' => 'from-blue-400 to-indigo-500',
        'sports' => 'from-orange-400 to-red-500',
    ];
    $categoryIcons = [
        'social' => 'S',
        'medical' => 'M',
        'education' => 'E',
        'religious' => 'R',
        'sports' => 'E',
    ];
    $defaultColor = 'from-purple-400 to-blue-500';
    $defaultIcon = 'G';
    $bgColor = $categoryColors[$raffle->category] ?? $defaultColor;
    $icon = $categoryIcons[$raffle->category] ?? $defaultIcon;
@endphp

<div class="bg-white rounded-xl shadow-lg overflow-hidden hover-scale transition-all duration-300 hover:shadow-xl border-2 border-transparent hover:border-purple-200 group">
    <!-- Card Header -->
    <div class="relative">
        <div class="h-48 bg-gradient-to-br {{ $bgColor }} flex items-center justify-center">
            <span class="text-6xl">{{ $icon }}</span>
        </div>
        
        <!-- Badges -->
        <div class="absolute top-4 left-4 flex flex-col gap-2">
            @if($featured || $raffle->featured)
                <span class="bg-gradient-to-r from-yellow-400 to-orange-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                    Destaque
                </span>
            @endif
            <span class="bg-white/90 backdrop-blur-sm text-gray-700 px-3 py-1 rounded-full text-sm font-semibold">
                {{ ucfirst($raffle->category) }}
            </span>
        </div>
        
        <!-- Location Badge -->
        @if($raffle->city && $raffle->state)
            <div class="absolute top-4 right-4">
                <span class="bg-white/90 text-gray-800 px-3 py-1 rounded-full text-sm font-semibold">
                    {{ $raffle->city }}, {{ $raffle->state }}
                </span>
            </div>
        @endif

        <!-- Progress Badge -->
        <div class="absolute bottom-4 right-4">
            <span class="bg-white/90 text-gray-800 px-3 py-1 rounded-full text-sm font-semibold">
                {{ number_format($raffle->progress_percentage, 1) }}% vendido
            </span>
        </div>
    </div>

    <!-- Card Content -->
    <div class="p-6">
        <div class="flex justify-between items-start mb-3">
            <h3 class="text-xl font-bold text-gray-900 leading-tight group-hover:text-purple-700 transition-colors">
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
                <div class="bg-gradient-to-r {{ $bgColor }} h-3 rounded-full transition-all duration-300" 
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
            <span class="font-semibold">Sorteio:</span> {{ $raffle->draw_date->format('d/m/Y \à\s H:i') }}
        </div>
        
        <!-- Action Buttons -->
        <div class="flex gap-2">
            <a href="{{ route('raffles.show', $raffle) }}" 
               class="flex-1 bg-gradient-to-r {{ $bgColor }} hover:opacity-90 text-white py-3 rounded-lg font-semibold transition-all duration-300 flex items-center justify-center gap-2">
                <span>🔍 Ver Detalhes</span>
            </a>
            
            @auth
                <!-- Wishlist Button -->
                <button onclick="toggleWishlist({{ $raffle->id }})" 
                        id="wishlist-btn-{{ $raffle->id }}"
                        class="p-3 border-2 border-gray-200 rounded-lg hover:border-red-300 hover:bg-red-50 transition-all duration-300 group">
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </button>
                
                <!-- Add to Cart Button -->
                <button onclick="addToCart({{ $raffle->id }})" 
                        class="p-3 border-2 border-gray-200 rounded-lg hover:border-blue-300 hover:bg-blue-50 transition-all duration-300 group">
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01"></path>
                    </svg>
                </button>
            @else
                <div class="text-center text-sm text-gray-500 p-3">
                    <a href="{{ route('login') }}" class="text-purple-600 hover:text-purple-700 font-medium">Login</a> para adicionar à lista de desejos
                </div>
            @endauth
        </div>
    </div>
</div>

@auth
<script>
// Check if raffle is in wishlist on page load
document.addEventListener('DOMContentLoaded', function() {
    checkWishlistStatus({{ $raffle->id }});
});

async function toggleWishlist(raffleId) {
    try {
        const response = await fetch(`/marketplace/wishlist/${raffleId}/toggle`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });
        
        const data = await response.json();
        
        if (data.success) {
            const btn = document.getElementById(`wishlist-btn-${raffleId}`);
            const svg = btn.querySelector('svg');
            
            if (data.action === 'added') {
                svg.classList.add('text-red-500', 'fill-current');
                svg.classList.remove('text-gray-400');
            } else {
                svg.classList.remove('text-red-500', 'fill-current');
                svg.classList.add('text-gray-400');
            }
            
            // Update wishlist count
            loadWishlistCount();
        }
    } catch (error) {
        console.error('Error toggling wishlist:', error);
    }
}

async function addToCart(raffleId) {
    const quantity = prompt('Quantos bilhetes deseja adicionar ao carrinho?', '1');
    
    if (!quantity || quantity < 1) return;
    
    try {
        const response = await fetch(`/marketplace/cart/${raffleId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ quantity: parseInt(quantity) })
        });
        
        const data = await response.json();
        
        if (data.success) {
            alert(data.message);
            loadCartCount();
        } else {
            alert(data.error || 'Erro ao adicionar ao carrinho');
        }
    } catch (error) {
        console.error('Error adding to cart:', error);
        alert('Erro ao adicionar ao carrinho');
    }
}

async function checkWishlistStatus(raffleId) {
    try {
        const response = await fetch(`/marketplace/wishlist/check/${raffleId}`);
        const data = await response.json();
        
        if (data.in_wishlist) {
            const btn = document.getElementById(`wishlist-btn-${raffleId}`);
            const svg = btn.querySelector('svg');
            svg.classList.add('text-red-500', 'fill-current');
            svg.classList.remove('text-gray-400');
        }
    } catch (error) {
        console.error('Error checking wishlist status:', error);
    }
}
</script>
@endauth
