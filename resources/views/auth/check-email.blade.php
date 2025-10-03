@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 to-blue-50 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div class="text-center">
            <div class="mx-auto h-16 w-16 bg-green-100 rounded-full flex items-center justify-center mb-4">
                <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
            </div>
            
            <h2 class="text-3xl font-extrabold text-gray-900 mb-2">
                Verifique sua caixa de entrada
            </h2>
            
            <p class="text-lg text-gray-600 mb-8">
                Enviamos um link para redefinir sua senha
            </p>
        </div>
        
        <div class="bg-white py-8 px-6 shadow-xl rounded-lg">
            <div class="text-center space-y-6">
                <!-- Email info -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex items-center justify-center">
                        <svg class="h-5 w-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <span class="text-sm font-medium text-blue-800">
                            Enviado para: <strong>{{ session('reset_email') ?? 'seu@email.com' }}</strong>
                        </span>
                    </div>
                </div>

                <!-- Instructions -->
                <div class="space-y-3">
                    <p class="text-gray-700 font-medium">
                        📧 Acesse o link enviado por email
                    </p>
                    <p class="text-sm text-gray-600">
                        Clique no link que enviamos para continuar com a redefinição de senha
                    </p>
                </div>

                <!-- Countdown Timer -->
                <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                    <div class="flex items-center justify-center space-x-2">
                        <div class="w-3 h-3 bg-red-500 rounded-full animate-pulse"></div>
                        <span class="text-sm font-medium text-red-700">Tempo restante:</span>
                        <span id="countdown-timer" class="text-xl font-bold text-red-600">03:00</span>
                    </div>
                </div>

                <!-- Resend button -->
                <div class="pt-4">
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <input type="hidden" name="email" value="{{ session('reset_email') }}">
                        <button type="submit" 
                                class="text-sm text-purple-600 hover:text-purple-700 transition-colors underline">
                            Não recebeu? Reenviar email
                        </button>
                    </form>
                </div>

                <!-- Back to login -->
                <div class="pt-4 border-t">
                    <a href="{{ route('login') }}" 
                       class="text-sm text-gray-600 hover:text-gray-900 transition-colors">
                        ← Voltar ao Login
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const countdownElement = document.getElementById('countdown-timer');
    
    // Countdown timer (3 minutes = 180 seconds)
    let timeLeft = 180;
    
    function updateCountdown() {
        const minutes = Math.floor(timeLeft / 60);
        const seconds = timeLeft % 60;
        
        countdownElement.textContent = 
            minutes.toString().padStart(2, '0') + ':' + 
            seconds.toString().padStart(2, '0');
        
        // Change color when less than 1 minute
        if (timeLeft <= 60) {
            countdownElement.classList.remove('text-red-600');
            countdownElement.classList.add('text-red-800');
        }
        
        // Change color when less than 30 seconds
        if (timeLeft <= 30) {
            countdownElement.classList.remove('text-red-800');
            countdownElement.classList.add('text-red-900');
            countdownElement.classList.add('animate-pulse');
        }
        
        if (timeLeft <= 0) {
            countdownElement.textContent = '00:00';
            countdownElement.classList.add('text-red-900', 'animate-pulse');
            
            // Show expiration message
            alert('⏰ Tempo esgotado! O link expirou. Solicite um novo link.');
            return;
        }
        
        timeLeft--;
    }
    
    // Start countdown
    updateCountdown();
    const countdownInterval = setInterval(updateCountdown, 1000);
});
</script>
@endpush
@endsection

