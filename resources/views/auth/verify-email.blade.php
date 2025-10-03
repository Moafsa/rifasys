@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 to-blue-50 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div class="text-center">
            <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                Verifique seu Email
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                Enviamos um link de verificação para <strong>{{ auth()->user()->email }}</strong>
            </p>
        </div>
        
        <div class="bg-white py-8 px-6 shadow-xl rounded-lg">
            <div class="text-center mb-6">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-blue-100 mb-4">
                    <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">
                    Verificação Necessária
                </h3>
                <p class="text-gray-600 text-sm">
                    Para continuar usando a plataforma RAFE, você precisa verificar seu endereço de email.
                </p>
            </div>

            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <div class="space-y-4">
                <!-- Verification Code Form -->
                <form method="POST" action="{{ route('verification.verify') }}" class="space-y-4">
                    @csrf
                    
                        <div>
                            <label for="verification_code" class="block text-sm font-medium text-gray-700 mb-2">
                                Código de Verificação (4 dígitos)
                            </label>
                            <input id="verification_code" 
                                   name="verification_code" 
                                   type="text" 
                                   maxlength="4" 
                                   pattern="[0-9]{4}"
                                   required 
                                   class="appearance-none rounded-lg relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-purple-500 focus:border-purple-500 text-center text-2xl font-bold tracking-widest @error('verification_code') border-red-500 @enderror"
                                   placeholder="0000">
                            @error('verification_code')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            
                            <!-- Countdown Timer -->
                            <div class="mt-3 text-center">
                                <div class="inline-flex items-center justify-center bg-red-50 border border-red-200 rounded-lg px-4 py-2">
                                    <div class="flex items-center space-x-2">
                                        <div class="w-3 h-3 bg-red-500 rounded-full animate-pulse"></div>
                                        <span class="text-sm font-medium text-red-700">Tempo restante:</span>
                                        <span id="countdown-timer" class="text-lg font-bold text-red-600">03:00</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <button type="submit" 
                            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-colors">
                        Verificar Email
                    </button>
                </form>

                <div class="text-center">
                    <p class="text-sm text-gray-600 mb-3">
                        Não recebeu o código? Verifique sua pasta de spam ou
                    </p>
                    
                    <form method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" 
                                class="text-sm text-purple-600 hover:text-purple-700 transition-colors">
                            Reenviar Código
                        </button>
                    </form>
                </div>

                <div class="text-center">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" 
                                class="text-sm text-gray-600 hover:text-gray-900 transition-colors">
                            Fazer Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="text-center">
            <p class="text-xs text-gray-500">
                O código de verificação expira em 3 minutos.
            </p>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const codeInput = document.getElementById('verification_code');
    const countdownElement = document.getElementById('countdown-timer');
    
    // Countdown timer (3 minutes = 180 seconds)
    let timeLeft = 180; // 3 minutes in seconds
    
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
            
            // Disable the form and show expiration message
            codeInput.disabled = true;
            codeInput.placeholder = 'Código expirado';
            
            // Show alert
            alert('⏰ Tempo esgotado! O código expirou. Solicite um novo código.');
            return;
        }
        
        timeLeft--;
    }
    
    // Start countdown
    updateCountdown();
    const countdownInterval = setInterval(updateCountdown, 1000);
    
    // Auto-format and validate code input
    codeInput.addEventListener('input', function(e) {
        // Remove non-numeric characters
        this.value = this.value.replace(/[^0-9]/g, '');
        
        // Auto-submit when 4 digits are entered
        if (this.value.length === 4) {
            this.form.submit();
        }
    });
    
    // Focus on code input when page loads
    codeInput.focus();
    
    // Add visual feedback for typing
    codeInput.addEventListener('keydown', function(e) {
        if (e.key === 'Backspace' && this.value.length === 0) {
            e.preventDefault();
        }
    });
    
    // Clear interval when form is submitted
    document.querySelector('form').addEventListener('submit', function() {
        clearInterval(countdownInterval);
    });
});
</script>
@endpush
@endsection
