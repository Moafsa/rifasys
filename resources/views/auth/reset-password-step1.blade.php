@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white p-10 rounded-xl shadow-lg">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Verificar Código
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Digite o código de 4 dígitos enviado para seu email.
            </p>
        </div>

        @if (session('status'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('status') }}
            </div>
        @endif
        @if (session('error'))
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.verify-code') }}" class="space-y-6">
            @csrf
            
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                    Email
                </label>
                <input id="email" 
                       name="email" 
                       type="email" 
                       required
                       value="{{ old('email') }}"
                       class="appearance-none rounded-lg relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm @error('email') border-red-500 @enderror"
                       placeholder="Digite seu email">
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="reset_code" class="block text-sm font-medium text-gray-700 mb-2">
                    Código de Redefinição (4 dígitos)
                </label>
                <input id="reset_code" 
                       name="reset_code" 
                       type="text" 
                       maxlength="4" 
                       pattern="[0-9]{4}"
                       required 
                       class="appearance-none rounded-lg relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-purple-500 focus:border-purple-500 text-center text-2xl font-bold tracking-widest @error('reset_code') border-red-500 @enderror"
                       placeholder="0000">
                @error('reset_code')
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

            <div>
                <button type="submit" 
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-colors">
                    Verificar Código
                </button>
            </div>
        </form>

        <div class="text-center">
            <a href="{{ route('login') }}" 
               class="text-sm text-purple-600 hover:text-purple-500 transition-colors">
                Voltar ao Login
            </a>
        </div>

        <div class="text-center mt-4">
            <p class="text-xs text-gray-500">
                ⏰ O código expira em <strong>3 minutos</strong> por segurança.
            </p>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const codeInput = document.getElementById('reset_code');
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
            
            // Show alert or redirect
            alert('⏰ Tempo esgotado! O código expirou. Solicite um novo código.');
            return;
        }
        
        timeLeft--;
    }
    
    // Start countdown
    updateCountdown();
    const countdownInterval = setInterval(updateCountdown, 1000);
    
    codeInput.addEventListener('input', function(e) {
        this.value = this.value.replace(/[^0-9]/g, '');
        
        if (this.value.length === 4) {
            // Auto-submit when 4 digits are entered
            setTimeout(() => {
                this.form.submit();
            }, 500);
        }
    });
    
    codeInput.focus();
    
    // Prevent backspace when input is empty
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
