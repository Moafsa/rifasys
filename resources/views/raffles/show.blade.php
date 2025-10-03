@extends('layouts.app')

@section('content')
<!-- Header Section -->
<section class="relative gradient-purple-blue py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center">
            <div class="inline-flex items-center px-4 py-2 bg-white/20 text-white rounded-full text-sm font-medium mb-4">
                <span class="w-2 h-2 bg-yellow-400 rounded-full mr-2"></span>
                Rifa #{{ $raffle->id }}
            </div>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-6">
                {{ $raffle->title }}
            </h1>
            <p class="text-xl text-blue-100 mb-8 max-w-3xl mx-auto">
                {{ $raffle->description }}
            </p>
        </div>
    </div>
</section>

<!-- Main Content -->
<section class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Left Column - Main Info -->
            <div class="lg:col-span-2">
                <!-- Prize Information -->
                <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                        🎁 Prêmio Principal
                    </h2>
                    
                    <div class="grid md:grid-cols-2 gap-8">
                        <!-- Prize Image/Icon -->
                        <div class="text-center">
                            <div class="h-64 bg-gradient-to-br 
                                @switch($raffle->category)
                                    @case('social') from-purple-400 to-blue-500 @break
                                    @case('medical') from-green-400 to-blue-500 @break
                                    @case('education') from-pink-400 to-purple-500 @break
                                    @case('religious') from-blue-400 to-indigo-500 @break
                                    @case('sports') from-orange-400 to-red-500 @break
                                    @default from-purple-400 to-blue-500
                                @endswitch
                                rounded-xl flex items-center justify-center">
                                <span class="text-8xl">
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
                        </div>
                        
                        <!-- Prize Details -->
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-4">
                                {{ $raffle->prize_description }}
                            </h3>
                            
                            <div class="space-y-4">
                                <div class="flex items-center gap-3">
                                    <span class="text-green-500">💰</span>
                                    <span class="text-gray-700">
                                        <strong>Valor estimado:</strong> R$ {{ number_format($raffle->goal_amount, 2, ',', '.') }}
                                    </span>
                                </div>
                                
                                <div class="flex items-center gap-3">
                                    <span class="text-blue-500">📅</span>
                                    <span class="text-gray-700">
                                        <strong>Sorteio:</strong> {{ $raffle->draw_date->format('d/m/Y \à\s H:i') }}
                                    </span>
                                </div>
                                
                                <div class="flex items-center gap-3">
                                    <span class="text-purple-500">📍</span>
                                    <span class="text-gray-700">
                                        <strong>Local:</strong> 
                                        @if($raffle->city && $raffle->state)
                                            {{ $raffle->city }}, {{ $raffle->state }}
                                        @else
                                            Nacional
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Organizer Description -->
                @if($raffle->organizer_description)
                <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                        <span class="text-purple-500">📝</span>
                        Sobre esta Rifa
                    </h2>
                    <div class="prose prose-gray max-w-none">
                        <p class="text-gray-700 leading-relaxed text-lg">
                            {{ $raffle->organizer_description }}
                        </p>
                    </div>
                </div>
                @endif

                <!-- Additional Prizes -->
                @if($raffle->prizes->count() > 0)
                <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                        <span class="text-yellow-500">🏆</span>
                        Outros Prêmios da Rifa
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($raffle->prizes as $prize)
                        <div class="bg-gray-50 rounded-lg p-6 hover:shadow-md transition-shadow">
                            <div class="aspect-w-16 aspect-h-9 mb-4">
                                <img src="{{ $prize->image_url }}" 
                                     alt="{{ $prize->name }}" 
                                     class="w-full h-48 object-cover rounded-lg">
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">
                                {{ $prize->name }}
                            </h3>
                            @if($prize->description)
                            <p class="text-gray-600 text-sm">
                                {{ $prize->description }}
                            </p>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Organizer Information -->
                <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                        <span class="text-blue-500">👤</span>
                        Organizador da Rifa
                    </h2>
                    
                    <div class="flex flex-col md:flex-row gap-6">
                        <!-- Organizer Photo and Basic Info -->
                        <div class="flex-shrink-0">
                            <div class="w-32 h-32 mx-auto md:mx-0">
                                <img src="{{ 'https://ui-avatars.com/api/?name=' . urlencode($raffle->organizer->name) . '&background=667eea&color=ffffff&size=128' }}" 
                                     alt="{{ $raffle->organizer->name }}" 
                                     class="w-full h-full rounded-full object-cover border-4 border-purple-100">
                            </div>
                        </div>
                        
                        <!-- Organizer Details -->
                        <div class="flex-1">
                            <div class="space-y-4">
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900 mb-1">
                                        {{ $raffle->organizer->name }}
                                    </h3>
                                    <p class="text-gray-600">
                                        Organizador desde {{ $raffle->organizer->created_at->format('d/m/Y') }}
                                    </p>
                                </div>
                                
                                <!-- Contact Information -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @if($raffle->organizer->email)
                                    <div class="flex items-center gap-3">
                                        <span class="text-gray-400">📧</span>
                                        <div>
                                            <p class="text-sm text-gray-500">Email</p>
                                            <p class="text-gray-900 font-medium">{{ $raffle->organizer->email }}</p>
                                        </div>
                                    </div>
                                    @endif
                                    
                                    @if($raffle->organizer->phone)
                                    <div class="flex items-center gap-3">
                                        <span class="text-gray-400">📱</span>
                                        <div>
                                            <p class="text-sm text-gray-500">Telefone</p>
                                            <p class="text-gray-900 font-medium">{{ $raffle->organizer->phone }}</p>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                
                                <!-- Organizer Stats -->
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <h4 class="text-sm font-semibold text-gray-700 mb-3">Estatísticas do Organizador</h4>
                                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 text-center">
                                        <div>
                                            <p class="text-2xl font-bold text-purple-600">
                                                {{ $raffle->organizer->raffles()->count() }}
                                            </p>
                                            <p class="text-xs text-gray-600">Rifas Criadas</p>
                                        </div>
                                        <div>
                                            <p class="text-2xl font-bold text-green-600">
                                                {{ $raffle->organizer->raffles()->where('status', 'completed')->count() }}
                                            </p>
                                            <p class="text-xs text-gray-600">Concluídas</p>
                                        </div>
                                        <div>
                                            <p class="text-2xl font-bold text-blue-600">
                                                {{ $raffle->organizer->raffles()->where('status', 'active')->count() }}
                                            </p>
                                            <p class="text-xs text-gray-600">Ativas</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Contact Buttons -->
                                <div class="flex flex-wrap gap-3">
                                    @if($raffle->organizer->phone)
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $raffle->organizer->phone) }}" 
                                       target="_blank"
                                       class="inline-flex items-center gap-2 bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition-colors">
                                        <span>📱</span>
                                        WhatsApp
                                    </a>
                                    @endif
                                    
                                    @if($raffle->organizer->email)
                                    <a href="mailto:{{ $raffle->organizer->email }}" 
                                       class="inline-flex items-center gap-2 bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-colors">
                                        <span>📧</span>
                                        Email
                                    </a>
                                    @endif
                                    
                                    <button onclick="showOrganizerProfile()" 
                                            class="inline-flex items-center gap-2 bg-purple-500 text-white px-4 py-2 rounded-lg hover:bg-purple-600 transition-colors">
                                        <span>👤</span>
                                        Ver Perfil
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Raffle Progress -->
                <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                        📊 Progresso da Rifa
                    </h2>
                    
                    <div class="grid md:grid-cols-3 gap-6 mb-6">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-purple-600 mb-2">0</div>
                            <div class="text-gray-600">Bilhetes Vendidos</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-blue-600 mb-2">{{ $raffle->total_tickets }}</div>
                            <div class="text-gray-600">Bilhetes Restantes</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-green-600 mb-2">0%</div>
                            <div class="text-gray-600">Progresso</div>
                        </div>
                    </div>
                    
                    <!-- Progress Bar -->
                    <div class="w-full bg-gray-200 rounded-full h-4 mb-4">
                        <div class="bg-gradient-to-r from-purple-500 to-blue-500 h-4 rounded-full transition-all duration-500" 
                             style="width: 0%"></div>
                    </div>
                    
                    <div class="flex justify-between text-sm text-gray-500">
                        <span>0 bilhetes</span>
                        <span>{{ $raffle->total_tickets }} bilhetes</span>
                    </div>
                </div>

                <!-- Organizer Information -->
                <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                        👤 Organizador
                    </h2>
                    
                    <div class="flex items-start gap-4">
                        <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center">
                            <span class="text-2xl">👤</span>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $raffle->organizer->name }}</h3>
                            <p class="text-gray-600 mb-4">{{ $raffle->contact_info }}</p>
                            
                            @if($raffle->social_media_links)
                                <div class="flex gap-3">
                                    @foreach($raffle->social_media_links as $platform => $url)
                                        <a href="{{ $url }}" target="_blank" 
                                           class="bg-gray-100 hover:bg-gray-200 px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                            {{ ucfirst($platform) }}
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Terms and Conditions -->
                @if($raffle->terms_conditions)
                    <div class="bg-white rounded-xl shadow-lg p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                            📋 Termos e Condições
                        </h2>
                        <div class="prose max-w-none">
                            <p class="text-gray-700 whitespace-pre-line">{{ $raffle->terms_conditions }}</p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Right Column - Purchase Info -->
            <div class="lg:col-span-1">
                <!-- Purchase Card -->
                <div class="bg-white rounded-xl shadow-lg p-8 sticky top-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                        🎫 Participar da Rifa
                    </h2>
                    
                    <!-- Price Information -->
                    <div class="text-center mb-6">
                        <div class="text-4xl font-bold text-purple-600 mb-2">
                            R$ {{ number_format($raffle->price_per_ticket, 2, ',', '.') }}
                        </div>
                        <div class="text-gray-600">por número</div>
                    </div>
                    
                    <!-- Ticket Selection -->
                    <div class="mb-6">
                        <label for="ticket_quantity" class="block text-sm font-medium text-gray-700 mb-2">
                            Quantidade de números:
                        </label>
                        <div class="flex items-center gap-3">
                            <button type="button" onclick="decreaseQuantity()" 
                                    class="w-10 h-10 bg-gray-100 hover:bg-gray-200 rounded-lg flex items-center justify-center font-bold">
                                -
                            </button>
                            <input type="number" 
                                   id="ticket_quantity" 
                                   value="1" 
                                   min="1" 
                                   max="{{ $raffle->remaining_tickets }}"
                                   class="w-20 text-center border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            <button type="button" onclick="increaseQuantity()" 
                                    class="w-10 h-10 bg-gray-100 hover:bg-gray-200 rounded-lg flex items-center justify-center font-bold">
                                +
                            </button>
                        </div>
                        <p class="text-xs text-gray-500 mt-2">
                            Máximo {{ $raffle->remaining_tickets }} números disponíveis
                        </p>
                    </div>
                    
                    <!-- Total Price -->
                    <div class="bg-gray-50 rounded-lg p-4 mb-6">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-700">Total:</span>
                            <span id="total_price" class="text-2xl font-bold text-gray-900">
                                R$ {{ number_format($raffle->price_per_ticket, 2, ',', '.') }}
                            </span>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="space-y-3">
                        <button onclick="addToCart()" 
                                class="w-full bg-orange-500 text-white py-3 rounded-lg font-semibold hover:bg-orange-600 transition-colors flex items-center justify-center gap-2">
                            🛒 Adicionar ao Carrinho
                        </button>
                        
                        <button onclick="openNumberSelection({{ $raffle->id }}, {{ $raffle->total_tickets }}, 0)" 
                                class="w-full bg-gradient-to-r from-purple-500 to-blue-500 text-white py-3 rounded-lg font-semibold hover:from-purple-600 hover:to-blue-600 transition-all duration-300 flex items-center justify-center gap-2">
                            💳 Comprar Agora
                        </button>
                    </div>
                    
                    <!-- Payment Methods -->
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <h3 class="text-sm font-medium text-gray-700 mb-3">Métodos de pagamento:</h3>
                        <div class="flex gap-2">
                            @if($raffle->payment_methods)
                                @foreach($raffle->payment_methods as $method)
                                    <span class="bg-gray-100 px-3 py-1 rounded-full text-xs font-medium">
                                        @switch($method)
                                            @case('pix') 💳 PIX @break
                                            @case('credit_card') 💳 Cartão @break
                                            @case('debit_card') 🏦 Débito @break
                                            @default {{ ucfirst($method) }}
                                        @endswitch
                                    </span>
                                @endforeach
                            @else
                                <span class="bg-gray-100 px-3 py-1 rounded-full text-xs font-medium">💳 PIX</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Reviews Section -->
<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">
            ⭐ Avaliações da Rifa
        </h2>
        
        <div class="grid md:grid-cols-3 gap-8">
            <!-- Review 1 -->
            <div class="bg-gray-50 rounded-xl p-6">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-purple-500 rounded-full flex items-center justify-center text-white font-bold mr-4">
                        M
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900">Maria Silva</h4>
                        <div class="flex text-yellow-400">
                            ⭐⭐⭐⭐⭐
                        </div>
                    </div>
                </div>
                <p class="text-gray-700 italic">
                    "Ótima iniciativa! A rifa está sendo muito bem organizada e a causa é muito nobre."
                </p>
            </div>
            
            <!-- Review 2 -->
            <div class="bg-gray-50 rounded-xl p-6">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold mr-4">
                        J
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900">João Santos</h4>
                        <div class="flex text-yellow-400">
                            ⭐⭐⭐⭐⭐
                        </div>
                    </div>
                </div>
                <p class="text-gray-700 italic">
                    "Processo muito transparente e organizador sempre disponível para esclarecer dúvidas."
                </p>
            </div>
            
            <!-- Review 3 -->
            <div class="bg-gray-50 rounded-xl p-6">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center text-white font-bold mr-4">
                        A
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900">Ana Costa</h4>
                        <div class="flex text-yellow-400">
                            ⭐⭐⭐⭐
                        </div>
                    </div>
                </div>
                <p class="text-gray-700 italic">
                    "Excelente plataforma! Fácil de usar e muito segura para participar."
                </p>
            </div>
        </div>
        
        <!-- Add Review Button -->
        <div class="text-center mt-8">
            <button class="bg-purple-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-purple-700 transition-colors">
                ✍️ Avaliar esta Rifa
            </button>
        </div>
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
                    <h3 id="modalRaffleTitle" class="text-lg font-bold text-gray-900 mb-2">{{ $raffle->title }}</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                        <div>
                            <span class="text-gray-600">Total de números:</span>
                            <span id="modalTotalNumbers" class="font-semibold text-gray-900">{{ $raffle->total_tickets }}</span>
                        </div>
                        <div>
                            <span class="text-gray-600">Vendidos:</span>
                            <span id="modalSoldNumbers" class="font-semibold text-red-600">0</span>
                        </div>
                        <div>
                            <span class="text-gray-600">Disponíveis:</span>
                            <span id="modalAvailableNumbers" class="font-semibold text-green-600">{{ $raffle->total_tickets }}</span>
                        </div>
                        <div>
                            <span class="text-gray-600">Preço por número:</span>
                            <span id="modalPricePerNumber" class="font-semibold text-gray-900">R$ {{ number_format($raffle->price_per_ticket, 2, ',', '.') }}</span>
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

<!-- JavaScript -->
<script>
let ticketQuantity = 1;
const ticketPrice = {{ $raffle->price_per_ticket }};
const maxTickets = {{ $raffle->remaining_tickets }};

function updateTotalPrice() {
    const total = ticketQuantity * ticketPrice;
    document.getElementById('total_price').textContent = 
        'R$ ' + total.toLocaleString('pt-BR', {minimumFractionDigits: 2, maximumFractionDigits: 2});
}

function increaseQuantity() {
    if (ticketQuantity < maxTickets) {
        ticketQuantity++;
        document.getElementById('ticket_quantity').value = ticketQuantity;
        updateTotalPrice();
    }
}

function decreaseQuantity() {
    if (ticketQuantity > 1) {
        ticketQuantity--;
        document.getElementById('ticket_quantity').value = ticketQuantity;
        updateTotalPrice();
    }
}

function addToCart() {
    // Check if user is authenticated
    @guest
        window.location.href = '{{ route("login") }}?redirect={{ urlencode(request()->fullUrl()) }}';
        return;
    @endguest

    const quantity = document.getElementById('ticket_quantity').value;
    
    // Create form data
    const formData = new FormData();
    formData.append('quantity', quantity);
    formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
    
    fetch('{{ route("raffles.add-to-cart", $raffle) }}', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (response.status === 401) {
            window.location.href = '{{ route("login") }}?redirect={{ urlencode(request()->fullUrl()) }}';
            return;
        }
        return response.json();
    })
    .then(data => {
        if (data && data.success) {
            // Update cart count in header
            if (data.cart_count > 0) {
                const cartCount = document.getElementById('cart-count');
                if (cartCount) {
                    cartCount.textContent = data.cart_count;
                    cartCount.classList.remove('hidden');
                }
            }
            
            // Show success message
            if (window.showNotification) {
                showNotification(data.message, 'success');
            } else {
                alert(data.message);
            }
            
            // Redirect to cart page after successful addition
            setTimeout(() => {
                window.location.href = '{{ route("cart.index") }}';
            }, 1500);
        } else if (data) {
            if (window.showNotification) {
                showNotification(data.error || 'Erro ao adicionar ao carrinho', 'error');
            } else {
                alert(data.error || 'Erro ao adicionar ao carrinho');
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        if (window.showNotification) {
            showNotification('Erro ao adicionar ao carrinho', 'error');
        } else {
            alert('Erro ao adicionar ao carrinho');
        }
    });
}


// Update total when quantity input changes
document.getElementById('ticket_quantity').addEventListener('input', function() {
    const value = parseInt(this.value);
    if (value >= 1 && value <= maxTickets) {
        ticketQuantity = value;
        updateTotalPrice();
    }
});

// Show organizer profile function
function showOrganizerProfile() {
    // For now, show an alert with organizer info
    const organizerName = '{{ $raffle->organizer->name }}';
    const organizerEmail = '{{ $raffle->organizer->email }}';
    const organizerPhone = '{{ $raffle->organizer->phone }}';
    
    let profileInfo = `👤 Perfil do Organizador\n\n`;
    profileInfo += `Nome: ${organizerName}\n`;
    if (organizerEmail) profileInfo += `Email: ${organizerEmail}\n`;
    if (organizerPhone) profileInfo += `Telefone: ${organizerPhone}\n`;
    profileInfo += `\n📊 Estatísticas:\n`;
    profileInfo += `• Rifas criadas: {{ $raffle->organizer->raffles()->count() }}\n`;
    profileInfo += `• Rifas concluídas: {{ $raffle->organizer->raffles()->where('status', 'completed')->count() }}\n`;
    profileInfo += `• Rifas ativas: {{ $raffle->organizer->raffles()->where('status', 'active')->count() }}\n`;
    
    alert(profileInfo);
    
    // TODO: In the future, this could redirect to a dedicated organizer profile page
    // window.location.href = '/organizer/{{ $raffle->organizer->id }}';
}

// Number Selection Modal Functions
let selectedNumbers = [];
let soldNumbers = [];

function openNumberSelection(raffleId, totalNumbers, soldTickets) {
    currentRaffleId = raffleId;
    selectedNumbers = [];
    // Set soldTickets to 0 so all numbers are available
    soldNumbers = [];
    
    // Generate numbers grid
    generateNumbersGrid(totalNumbers);
    
    // Show modal
    const modal = document.getElementById('numberSelectionModal');
    
    if (modal) {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
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
    
    const totalPrice = selectedNumbers.length * ticketPrice;
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

function closeNumberSelection() {
    document.getElementById('numberSelectionModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
    selectedNumbers = [];
    updateSelectedNumbersSummary();
}

function confirmPurchase() {
    if (selectedNumbers.length === 0) {
        alert('Selecione pelo menos um número para comprar.');
        return;
    }
    
    // Check authentication
    @guest
        window.location.href = '{{ route('login') }}?redirect={{ urlencode(request()->fullUrl()) }}';
        return;
    @endguest
    
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
