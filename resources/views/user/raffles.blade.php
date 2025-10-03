@extends('layouts.app')

@section('content')
<!-- Header Section -->
<section class="relative gradient-purple-blue py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center">
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-6">
                🎲 Minhas Rifas
            </h1>
            <p class="text-xl text-blue-100 mb-8 max-w-2xl mx-auto">
                Gerencie suas rifas como organizador e acompanhe suas participações
            </p>
        </div>
    </div>
</section>

<!-- Statistics Section -->
<section class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-6">
            <!-- Organizer Stats -->
            <div class="bg-white rounded-xl shadow-lg p-6 text-center">
                <div class="text-3xl font-bold text-purple-600 mb-2">{{ $stats['total_organized'] }}</div>
                <div class="text-sm text-gray-600">Rifas Organizadas</div>
            </div>
            <div class="bg-white rounded-xl shadow-lg p-6 text-center">
                <div class="text-3xl font-bold text-green-600 mb-2">{{ $stats['active_organized'] }}</div>
                <div class="text-sm text-gray-600">Ativas</div>
            </div>
            <div class="bg-white rounded-xl shadow-lg p-6 text-center">
                <div class="text-3xl font-bold text-blue-600 mb-2">{{ $stats['completed_organized'] }}</div>
                <div class="text-sm text-gray-600">Concluídas</div>
            </div>
            
            <!-- Participant Stats -->
            <div class="bg-white rounded-xl shadow-lg p-6 text-center">
                <div class="text-3xl font-bold text-orange-600 mb-2">{{ $stats['total_participating'] }}</div>
                <div class="text-sm text-gray-600">Participando</div>
            </div>
            <div class="bg-white rounded-xl shadow-lg p-6 text-center">
                <div class="text-3xl font-bold text-yellow-600 mb-2">{{ $stats['total_tickets_bought'] }}</div>
                <div class="text-sm text-gray-600">Bilhetes Comprados</div>
            </div>
            <div class="bg-white rounded-xl shadow-lg p-6 text-center">
                <div class="text-3xl font-bold text-red-600 mb-2">R$ {{ number_format($stats['total_spent'], 2, ',', '.') }}</div>
                <div class="text-sm text-gray-600">Total Gasto</div>
            </div>
        </div>
    </div>
</section>

<!-- Tabs Section -->
<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Tab Navigation -->
        <div class="flex flex-wrap gap-2 mb-8 border-b border-gray-200">
            <button onclick="showTab('organizer')" id="organizer-tab" class="tab-button active px-6 py-3 text-sm font-medium text-gray-500 hover:text-gray-700 border-b-2 border-transparent hover:border-gray-300 focus:outline-none">
                🎯 Como Organizador ({{ $organizerRaffles->total() }})
            </button>
            <button onclick="showTab('participant')" id="participant-tab" class="tab-button px-6 py-3 text-sm font-medium text-gray-500 hover:text-gray-700 border-b-2 border-transparent hover:border-gray-300 focus:outline-none">
                🎫 Como Participante ({{ $participantRaffles->total() }})
            </button>
        </div>

        <!-- Organizer Tab Content -->
        <div id="organizer-content" class="tab-content">
            @if($organizerRaffles->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($organizerRaffles as $raffle)
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300">
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
                                <div class="absolute top-4 left-4 
                                    @if($raffle->status === 'active') bg-green-500
                                    @elseif($raffle->status === 'completed') bg-blue-500
                                    @else bg-gray-500
                                    @endif text-white px-3 py-1 rounded-full text-sm font-semibold">
                                    @if($raffle->status === 'active') Ativa
                                    @elseif($raffle->status === 'completed') Concluída
                                    @else {{ ucfirst($raffle->status) }}
                                    @endif
                                </div>
                            </div>
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $raffle->title }}</h3>
                                <p class="text-gray-600 mb-4 text-sm">{{ Str::limit($raffle->description, 80) }}</p>
                                
                                <div class="mb-4">
                                    <div class="flex justify-between text-sm text-gray-500 mb-2">
                                        <span>Progresso</span>
                                        <span>{{ number_format($raffle->progress_percentage, 1) }}% vendido</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-gradient-to-r from-purple-500 to-blue-500 h-2 rounded-full" style="width: {{ $raffle->progress_percentage }}%"></div>
                                    </div>
                                </div>
                                
                                <div class="flex justify-between items-center mb-4">
                                    <div>
                                        <span class="text-2xl font-bold text-gray-900">R$ {{ number_format($raffle->price_per_ticket, 2, ',', '.') }}</span>
                                        <span class="text-sm text-gray-500">por número</span>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-sm text-gray-500">Sorteio em</div>
                                        <div class="font-semibold text-gray-900">{{ $raffle->draw_date->format('d/m/Y') }}</div>
                                    </div>
                                </div>
                                
                                <div class="flex gap-2">
                                    <a href="{{ route('raffles.show', $raffle) }}" class="flex-1 bg-gradient-to-r from-purple-500 to-blue-500 hover:from-purple-600 hover:to-blue-600 text-white py-2 rounded-lg font-semibold transition-all duration-300 text-center text-sm">
                                        Ver Rifa
                                    </a>
                                    <button class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition-all duration-300 text-sm">
                                        Editar
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                <div class="mt-8">
                    {{ $organizerRaffles->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <div class="text-6xl mb-4">🎯</div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Nenhuma rifa organizada</h3>
                    <p class="text-gray-600 mb-6">Você ainda não organizou nenhuma rifa.</p>
                    <a href="#" class="bg-gradient-to-r from-purple-500 to-blue-500 hover:from-purple-600 hover:to-blue-600 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300">
                        Criar Primeira Rifa
                    </a>
                </div>
            @endif
        </div>

        <!-- Participant Tab Content -->
        <div id="participant-content" class="tab-content hidden">
            @if($participantRaffles->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($participantRaffles as $raffle)
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300">
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
                                <div class="absolute top-4 left-4 bg-orange-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                    Participando
                                </div>
                                <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm text-gray-700 px-2 py-1 rounded-full text-xs font-medium">
                                    {{ $raffle->tickets->count() }} bilhetes
                                </div>
                            </div>
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $raffle->title }}</h3>
                                <p class="text-gray-600 mb-4 text-sm">{{ Str::limit($raffle->description, 80) }}</p>
                                
                                <div class="mb-4">
                                    <div class="flex justify-between text-sm text-gray-500 mb-2">
                                        <span>Seus bilhetes</span>
                                        <span>{{ $raffle->tickets->count() }} números</span>
                                    </div>
                                </div>
                                
                                <div class="flex justify-between items-center mb-4">
                                    <div>
                                        <span class="text-2xl font-bold text-gray-900">R$ {{ number_format($raffle->price_per_ticket, 2, ',', '.') }}</span>
                                        <span class="text-sm text-gray-500">por número</span>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-sm text-gray-500">Sorteio em</div>
                                        <div class="font-semibold text-gray-900">{{ $raffle->draw_date->format('d/m/Y') }}</div>
                                    </div>
                                </div>
                                
                                <a href="{{ route('raffles.show', $raffle) }}" class="w-full bg-gradient-to-r from-orange-500 to-red-500 hover:from-orange-600 hover:to-red-600 text-white py-2 rounded-lg font-semibold transition-all duration-300 text-center text-sm">
                                    Ver Minhas Participações
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                <div class="mt-8">
                    {{ $participantRaffles->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <div class="text-6xl mb-4">🎫</div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Nenhuma participação</h3>
                    <p class="text-gray-600 mb-6">Você ainda não participou de nenhuma rifa.</p>
                    <a href="{{ route('raffles.index') }}" class="bg-gradient-to-r from-orange-500 to-red-500 hover:from-orange-600 hover:to-red-600 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300">
                        Explorar Rifas
                    </a>
                </div>
            @endif
        </div>
    </div>
</section>

<script>
function showTab(tabName) {
    // Hide all tab contents
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.add('hidden');
    });
    
    // Remove active class from all tabs
    document.querySelectorAll('.tab-button').forEach(tab => {
        tab.classList.remove('active', 'border-purple-500', 'text-purple-600');
        tab.classList.add('text-gray-500');
    });
    
    // Show selected tab content
    document.getElementById(tabName + '-content').classList.remove('hidden');
    
    // Add active class to selected tab
    const activeTab = document.getElementById(tabName + '-tab');
    activeTab.classList.add('active', 'border-purple-500', 'text-purple-600');
    activeTab.classList.remove('text-gray-500');
}
</script>

<style>
.tab-button.active {
    border-bottom-color: #8b5cf6 !important;
    color: #8b5cf6 !important;
}
</style>
@endsection


