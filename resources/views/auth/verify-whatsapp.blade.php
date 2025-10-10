@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-600 via-purple-700 to-purple-800 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <div class="mx-auto h-12 w-12 flex items-center justify-center rounded-full bg-white/10 backdrop-blur-sm">
                <svg class="h-6 w-6 text-green-400" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                </svg>
            </div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-white">
                Verificação via WhatsApp
            </h2>
            <p class="mt-2 text-center text-sm text-purple-200">
                Enviamos um código de 4 dígitos para seu WhatsApp
            </p>
        </div>
        
        <form class="mt-8 space-y-6" method="POST" action="{{ route('whatsapp.verify-code') }}">
            @csrf
            
            <div class="space-y-4">
                <div>
                    <label for="code" class="block text-sm font-medium text-white mb-2">
                        Código de Verificação (4 dígitos)
                    </label>
                    <input id="code" type="text" name="code" required maxlength="4" minlength="4"
                           class="appearance-none rounded-lg relative block w-full px-4 py-4 border border-white/20 placeholder-purple-300 text-white bg-white/10 backdrop-blur-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent focus:z-10 sm:text-sm text-center text-2xl font-mono tracking-widest"
                           placeholder="0000" autocomplete="off" inputmode="numeric" pattern="[0-9]{4}">
                    
                    <!-- Countdown Timer -->
                    <div id="countdown-container" class="mt-3 text-center">
                        <p class="text-sm text-purple-200">
                            Código expira em: <span id="countdown" class="font-mono text-green-400">03:00</span>
                        </p>
                    </div>
                </div>

                @error('code')
                    <p class="text-red-300 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <a href="{{ route('verification.method') }}" class="text-purple-200 hover:text-white text-sm font-medium transition-colors duration-200">
                    ← Trocar método
                </a>
                
                <button type="submit" id="verify-button"
                        class="group relative w-auto flex justify-center py-3 px-8 border border-transparent text-sm font-medium rounded-lg text-purple-700 bg-white hover:bg-purple-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200">
                    Verificar Código
                </button>
            </div>
        </form>

        <!-- Resend Code -->
        <div class="text-center">
            <p class="text-sm text-purple-200">
                Não recebeu o código? 
                <a href="{{ route('verification.resend') }}" class="text-green-400 hover:text-green-300 font-medium transition-colors duration-200">
                    Reenviar
                </a>
            </p>
        </div>

        <!-- WhatsApp Info -->
        <div class="mt-6 p-4 bg-white/5 backdrop-blur-sm rounded-lg border border-white/10">
            <div class="flex items-start space-x-3">
                <svg class="h-5 w-5 text-green-400 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                </svg>
                <div>
                    <p class="text-sm text-white font-medium">Verificação via WhatsApp</p>
                    <p class="text-xs text-purple-200 mt-1">
                        O código foi enviado para {{ $user->phone }}. 
                        Verifique sua conversa do WhatsApp.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const codeInput = document.getElementById('code');
    const verifyButton = document.getElementById('verify-button');
    const countdownElement = document.getElementById('countdown');
    const countdownContainer = document.getElementById('countdown-container');
    
    let timeLeft = 180; // 3 minutes in seconds
    let countdownInterval;

    // Auto-format code input (only numbers)
    codeInput.addEventListener('input', function(e) {
        // Remove non-numeric characters
        e.target.value = e.target.value.replace(/\D/g, '');
        
        // Auto-submit when 4 digits are entered
        if (e.target.value.length === 4) {
            setTimeout(() => {
                document.querySelector('form').submit();
            }, 500);
        }
    });

    // Focus on code input
    codeInput.focus();

    // Start countdown timer
    function startCountdown() {
        countdownInterval = setInterval(() => {
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            
            countdownElement.textContent = 
                `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            
            // Change color as time runs out
            if (timeLeft <= 30) {
                countdownElement.className = 'font-mono text-red-400 animate-pulse';
            } else if (timeLeft <= 60) {
                countdownElement.className = 'font-mono text-yellow-400';
            } else {
                countdownElement.className = 'font-mono text-green-400';
            }
            
            timeLeft--;
            
            if (timeLeft < 0) {
                clearInterval(countdownInterval);
                countdownElement.textContent = 'Expirado';
                countdownElement.className = 'font-mono text-red-400';
                
                // Disable form
                codeInput.disabled = true;
                verifyButton.disabled = true;
                verifyButton.textContent = 'Código Expirado';
                verifyButton.className = verifyButton.className.replace('bg-white', 'bg-gray-400');
                
                // Show resend option
                const resendLink = document.createElement('a');
                resendLink.href = '{{ route("verification.resend") }}';
                resendLink.className = 'text-green-400 hover:text-green-300 font-medium transition-colors duration-200';
                resendLink.textContent = 'Solicitar novo código';
                
                countdownContainer.innerHTML = `
                    <p class="text-sm text-red-300">
                        Código expirado. 
                    </p>
                `;
                countdownContainer.appendChild(resendLink);
            }
        }, 1000);
    }

    // Start the countdown
    startCountdown();

    // Prevent form submission if code is expired
    document.querySelector('form').addEventListener('submit', function(e) {
        if (timeLeft <= 0) {
            e.preventDefault();
            alert('O código expirou. Solicite um novo código.');
        }
    });
});
</script>
@endsection



