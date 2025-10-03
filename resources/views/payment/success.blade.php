@extends('layouts.app')

@section('content')
<!-- Header Section -->
<section class="relative gradient-purple-blue py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center">
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-6">
                Compra Realizada!
            </h1>
            <p class="text-xl text-blue-100 mb-8 max-w-2xl mx-auto">
                Parabéns! Sua compra foi processada com sucesso
            </p>
        </div>
    </div>
</section>

<!-- Success Content -->
<section class="py-12 bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-xl shadow-lg p-8 text-center">
            <!-- Success Icon -->
            <div class="text-8xl mb-6">🎉</div>
            
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Compra Confirmada!</h2>
            <p class="text-xl text-gray-600 mb-8">
                Seus números foram reservados com sucesso. Boa sorte no sorteio!
            </p>
            
            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('raffles.index') }}" 
                   class="bg-gradient-to-r from-purple-500 to-blue-500 text-white px-8 py-3 rounded-lg font-semibold hover:from-purple-600 hover:to-blue-600 transition-all duration-300">
                    Ver Mais Rifas
                </a>
                
                <a href="{{ route('user.raffles') }}" 
                   class="border-2 border-purple-500 text-purple-600 px-8 py-3 rounded-lg font-semibold hover:bg-purple-50 transition-colors">
                    Minhas Rifas
                </a>
            </div>
            
            <!-- Info Box -->
            <div class="mt-8 p-6 bg-green-50 border border-green-200 rounded-lg">
                <h3 class="text-lg font-semibold text-green-900 mb-2">O que acontece agora?</h3>
                <ul class="text-green-800 text-sm space-y-1">
                    <li>• Seus números foram reservados exclusivamente para você</li>
                    <li>• Você receberá um email de confirmação em breve</li>
                    <li>• O sorteio será realizado na data prevista</li>
                    <li>• Se ganhar, você será contatado imediatamente</li>
                </ul>
            </div>
        </div>
    </div>
</section>
@endsection
