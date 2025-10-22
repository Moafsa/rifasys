@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-600 via-purple-700 to-purple-800 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <div class="mx-auto h-12 w-12 flex items-center justify-center rounded-full bg-white/10 backdrop-blur-sm">
                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                </svg>
            </div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-white">
                Escolha o método de verificação
            </h2>
            <p class="mt-2 text-center text-sm text-purple-200">
                Como você gostaria de receber seu código de verificação?
            </p>
        </div>
        
        <form class="mt-8 space-y-6" method="POST" action="{{ route('verification.set-method') }}">
            @csrf
            
            <div class="space-y-4">
                @unless(config('mail_temp.force_whatsapp_only', false))
                <!-- Email Option -->
                <div class="relative">
                    <input id="email-method" type="radio" name="method" value="email" class="sr-only" 
                           {{ old('method', 'email') === 'email' ? 'checked' : '' }}>
                    <label for="email-method" class="flex items-center p-4 bg-white/10 backdrop-blur-sm rounded-lg border border-white/20 cursor-pointer hover:bg-white/20 transition-all duration-200">
                        <div class="flex-shrink-0">
                            <div class="w-5 h-5 bg-white rounded-full border-2 border-white/50 flex items-center justify-center">
                                <div class="w-2 h-2 bg-purple-600 rounded-full opacity-0 transition-opacity duration-200"></div>
                            </div>
                        </div>
                        <div class="ml-3 flex-1">
                            <div class="flex items-center">
                                <svg class="h-6 w-6 text-white mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                <div>
                                    <p class="text-sm font-medium text-white">Email</p>
                                    <p class="text-xs text-purple-200">Enviar link para {{ $user->email }}</p>
                                </div>
                            </div>
                        </div>
                    </label>
                </div>
                @else
                <!-- Email Option Disabled -->
                <div class="relative opacity-50">
                    <div class="flex items-center p-4 bg-gray-500/10 backdrop-blur-sm rounded-lg border border-gray-500/20">
                        <div class="flex-shrink-0">
                            <div class="w-5 h-5 bg-gray-500 rounded-full border-2 border-gray-500/50 flex items-center justify-center">
                                <div class="w-2 h-2 bg-gray-600 rounded-full"></div>
                            </div>
                        </div>
                        <div class="ml-3 flex-1">
                            <div class="flex items-center">
                                <svg class="h-6 w-6 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                <div>
                                    <p class="text-sm font-medium text-gray-400">Email</p>
                                    <p class="text-xs text-gray-500">Temporariamente indisponível</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endunless

                <!-- WhatsApp Option -->
                <div class="relative">
                    <input id="whatsapp-method" type="radio" name="method" value="whatsapp" class="sr-only" 
                           {{ old('method', config('mail_temp.force_whatsapp_only', false) ? 'whatsapp' : '') === 'whatsapp' ? 'checked' : '' }}>
                    <label for="whatsapp-method" class="flex items-center p-4 bg-white/10 backdrop-blur-sm rounded-lg border border-white/20 cursor-pointer hover:bg-white/20 transition-all duration-200">
                        <div class="flex-shrink-0">
                            <div class="w-5 h-5 bg-white rounded-full border-2 border-white/50 flex items-center justify-center">
                                <div class="w-2 h-2 bg-purple-600 rounded-full opacity-0 transition-opacity duration-200"></div>
                            </div>
                        </div>
                        <div class="ml-3 flex-1">
                            <div class="flex items-center">
                                <svg class="h-6 w-6 text-green-400 mr-3" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                                </svg>
                                <div>
                                    <p class="text-sm font-medium text-white">WhatsApp</p>
                                    <p class="text-xs text-purple-200">Enviar link para {{ $user->phone }}</p>
                                </div>
                            </div>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Phone Input (shown when WhatsApp is selected) -->
            <div id="phone-input" class="hidden">
                <div>
                    <label for="phone" class="block text-sm font-medium text-white mb-2">
                        Número do WhatsApp (opcional - alterar)
                    </label>
                    <input id="phone" type="tel" name="phone" 
                           value="{{ old('phone', $user->phone) }}"
                           placeholder="(11) 99999-9999"
                           class="appearance-none rounded-lg relative block w-full px-3 py-3 border border-white/20 placeholder-purple-300 text-white bg-white/10 backdrop-blur-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent focus:z-10 sm:text-sm">
                    <p class="mt-1 text-xs text-purple-200">
                        Deixe como está ou altere se necessário. Formato: (11) 99999-9999
                    </p>
                </div>
            </div>

            @error('method')
                <p class="text-red-300 text-sm">{{ $message }}</p>
            @enderror
            
            @error('phone')
                <p class="text-red-300 text-sm">{{ $message }}</p>
            @enderror

            <div class="flex items-center justify-between">
                <a href="{{ route('login') }}" class="text-purple-200 hover:text-white text-sm font-medium transition-colors duration-200">
                    ← Voltar ao login
                </a>
                
                <button type="submit" class="group relative w-auto flex justify-center py-3 px-8 border border-transparent text-sm font-medium rounded-lg text-purple-700 bg-white hover:bg-purple-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-all duration-200">
                    Continuar
                </button>
            </div>
        </form>

        <!-- WuzAPI Status -->
        <div class="mt-6 p-4 bg-white/5 backdrop-blur-sm rounded-lg border border-white/10">
            <div class="flex items-center justify-between">
                <span class="text-sm text-purple-200">Status do WhatsApp:</span>
                <div class="flex items-center">
                    <div id="wuzapi-status" class="w-2 h-2 bg-yellow-400 rounded-full mr-2"></div>
                    <span id="wuzapi-text" class="text-xs text-purple-200">Verificando...</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const emailMethod = document.getElementById('email-method');
    const whatsappMethod = document.getElementById('whatsapp-method');
    const phoneInput = document.getElementById('phone-input');
    const phoneField = document.getElementById('phone');

    // Show/hide phone input based on selection
    function togglePhoneInput() {
        if (whatsappMethod.checked) {
            phoneInput.classList.remove('hidden');
            phoneField.required = true;
        } else {
            phoneInput.classList.add('hidden');
            phoneField.required = false;
        }
    }

    // Add event listeners
    emailMethod.addEventListener('change', togglePhoneInput);
    whatsappMethod.addEventListener('change', togglePhoneInput);
    
    // Initial state
    togglePhoneInput();

    // Update radio button visual state
    function updateRadioVisuals() {
        document.querySelectorAll('input[name="method"]').forEach(radio => {
            const label = radio.closest('label');
            const dot = label.querySelector('.w-2.h-2');
            
            if (radio.checked) {
                dot.classList.remove('opacity-0');
                label.classList.add('ring-2', 'ring-purple-400', 'ring-opacity-50');
            } else {
                dot.classList.add('opacity-0');
                label.classList.remove('ring-2', 'ring-purple-400', 'ring-opacity-50');
            }
        });
    }

    // Add click handlers for visual feedback
    document.querySelectorAll('input[name="method"]').forEach(radio => {
        radio.addEventListener('change', updateRadioVisuals);
    });

    // Initial visual state
    updateRadioVisuals();

    // Phone formatting
    phoneField.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        
        if (value.length >= 2) {
            value = `(${value.substring(0, 2)}) ${value.substring(2)}`;
        }
        
        if (value.length >= 10) {
            value = value.substring(0, 10) + '-' + value.substring(10, 14);
        }
        
        e.target.value = value;
    });

    // Check WuzAPI status
    async function checkWuzAPIStatus() {
        try {
            const response = await fetch('/api/wuzapi/status');
            const data = await response.json();
            
            const statusDot = document.getElementById('wuzapi-status');
            const statusText = document.getElementById('wuzapi-text');
            
            if (data.connected) {
                statusDot.className = 'w-2 h-2 bg-green-400 rounded-full mr-2';
                statusText.textContent = 'Conectado';
            } else {
                statusDot.className = 'w-2 h-2 bg-red-400 rounded-full mr-2';
                statusText.textContent = 'Desconectado';
            }
        } catch (error) {
            const statusDot = document.getElementById('wuzapi-status');
            const statusText = document.getElementById('wuzapi-text');
            
            statusDot.className = 'w-2 h-2 bg-red-400 rounded-full mr-2';
            statusText.textContent = 'Erro na conexão';
        }
    }

    // Check status on load
    checkWuzAPIStatus();
});
</script>
@endsection



