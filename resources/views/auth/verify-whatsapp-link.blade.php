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
                Enviamos um link de verificação para seu WhatsApp
            </p>
        </div>
        
        <div class="space-y-6">
            <!-- Instructions -->
            <div class="bg-white/10 backdrop-blur-sm rounded-lg p-6 border border-white/20">
                <div class="flex items-start space-x-3">
                    <svg class="h-6 w-6 text-green-400 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <h3 class="text-lg font-medium text-white mb-2">Instruções</h3>
                        <ol class="text-sm text-purple-200 space-y-2">
                            <li class="flex items-start">
                                <span class="inline-block w-6 h-6 bg-green-400 text-white rounded-full text-xs font-bold flex items-center justify-center mr-3 mt-0.5">1</span>
                                Verifique sua conversa do WhatsApp
                            </li>
                            <li class="flex items-start">
                                <span class="inline-block w-6 h-6 bg-green-400 text-white rounded-full text-xs font-bold flex items-center justify-center mr-3 mt-0.5">2</span>
                                Clique no link de verificação enviado
                            </li>
                            <li class="flex items-start">
                                <span class="inline-block w-6 h-6 bg-green-400 text-white rounded-full text-xs font-bold flex items-center justify-center mr-3 mt-0.5">3</span>
                                Confirme que é você acessando a plataforma
                            </li>
                        </ol>
                    </div>
                </div>
            </div>

            <!-- Countdown Timer -->
            <div class="bg-white/5 backdrop-blur-sm rounded-lg p-4 border border-white/10 text-center">
                <p class="text-sm text-purple-200 mb-2">Link expira em:</p>
                <div id="countdown" class="text-2xl font-mono text-green-400">03:00</div>
            </div>

            <!-- WhatsApp Info -->
            <div class="bg-white/5 backdrop-blur-sm rounded-lg p-4 border border-white/10">
                <div class="flex items-start space-x-3">
                    <svg class="h-5 w-5 text-green-400 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                    </svg>
                    <div>
                        <p class="text-sm text-white font-medium">Link enviado via WhatsApp</p>
                        <p class="text-xs text-purple-200 mt-1">
                            O link foi enviado para {{ $user->phone }}. 
                            Verifique sua conversa do WhatsApp.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-between">
                <a href="{{ route('verification.method') }}" class="text-purple-200 hover:text-white text-sm font-medium transition-colors duration-200">
                    ← Trocar método
                </a>
                
                <a href="{{ route('verification.resend') }}" class="text-green-400 hover:text-green-300 text-sm font-medium transition-colors duration-200">
                    Reenviar link
                </a>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const countdownElement = document.getElementById('countdown');
    let timeLeft = 180; // 3 minutes in seconds

    // Start countdown timer
    function startCountdown() {
        const countdownInterval = setInterval(() => {
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            
            countdownElement.textContent = 
                `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            
            // Change color as time runs out
            if (timeLeft <= 30) {
                countdownElement.className = 'text-2xl font-mono text-red-400 animate-pulse';
            } else if (timeLeft <= 60) {
                countdownElement.className = 'text-2xl font-mono text-yellow-400';
            } else {
                countdownElement.className = 'text-2xl font-mono text-green-400';
            }
            
            timeLeft--;
            
            if (timeLeft < 0) {
                clearInterval(countdownInterval);
                countdownElement.textContent = 'Expirado';
                countdownElement.className = 'text-2xl font-mono text-red-400';
                
                // Show message
                const container = countdownElement.parentElement;
                container.innerHTML = `
                    <p class="text-sm text-red-300 mb-2">Link expirado</p>
                    <div class="text-red-400">00:00</div>
                    <p class="text-xs text-purple-200 mt-2">
                        <a href="${window.location.href}" class="text-green-400 hover:text-green-300">
                            Solicitar novo link
                        </a>
                    </p>
                `;
            }
        }, 1000);
    }

    // Start the countdown
    startCountdown();
});
</script>
@endsection


