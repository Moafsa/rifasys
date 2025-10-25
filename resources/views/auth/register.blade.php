@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 to-blue-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
               <div class="text-center mb-12">
                   <h1 class="text-4xl font-bold text-gray-900 mb-4">
                       Crie sua conta na RAFE
                   </h1>
                   <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                       Junte-se à plataforma mais completa para criar, vender e organizar rifas online
                   </p>
                    <div class="mt-4">
                        <div class="inline-flex items-center px-4 py-2 bg-red-100 text-red-800 text-sm font-medium rounded-lg">
                            Apenas contas Gmail são aceitas (@gmail.com)
                        </div>
                    </div>
               </div>

        <div class="grid lg:grid-cols-2 gap-12 items-start">
            <!-- Registration Form -->
            <div class="bg-white rounded-2xl shadow-xl p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Informações Pessoais</h2>
                
                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf
                    
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Nome Completo <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ old('name') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('name') border-red-500 @enderror"
                               placeholder="Digite seu nome completo"
                               required
                               minlength="2"
                               maxlength="255">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Gmail <span class="text-red-500">*</span>
                        </label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('email') border-red-500 @enderror"
                               placeholder="seuemail@gmail.com"
                               required
                               pattern="[a-zA-Z0-9._%+-]+@gmail\.com$"
                               title="Apenas contas Gmail são aceitas">
                        <p class="mt-1 text-xs text-gray-500">Apenas contas Gmail são aceitas</p>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                            Telefone/WhatsApp <span class="text-red-500">*</span>
                        </label>
                        <input type="tel" 
                               id="phone" 
                               name="phone" 
                               value="{{ old('phone') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('phone') border-red-500 @enderror"
                               placeholder="(11) 99999-9999"
                               required
                               minlength="10"
                               maxlength="20"
                               pattern="[0-9\(\)\-\s]+"
                               title="Digite um número de telefone válido">
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Document -->
                    <div>
                        <label for="document" class="block text-sm font-medium text-gray-700 mb-2">
                            CPF *
                        </label>
                        <input type="text" 
                               id="document" 
                               name="document" 
                               value="{{ old('document') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('document') border-red-500 @enderror"
                               placeholder="000.000.000-00"
                               required>
                        @error('document')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            Senha *
                        </label>
                        <div class="relative">
                            <input type="password" 
                                   id="password" 
                                   name="password"
                                   class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('password') border-red-500 @enderror"
                                   placeholder="Mínimo 8 caracteres"
                                   required>
                            <button type="button" 
                                    id="toggle-password"
                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path id="eye-open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path id="eye-closed" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.418 0-7.862-3.242-9.375-7 1.513-3.758 4.957-7 9.375-7 1.04 0 2.049.195 3 .55M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path id="slash" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6"></path>
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Confirmation -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                            Confirmar Senha *
                        </label>
                        <div class="relative">
                            <input type="password" 
                                   id="password_confirmation" 
                                   name="password_confirmation"
                                   class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                   placeholder="Digite a senha novamente"
                                   required>
                            <button type="button" 
                                    id="toggle-password-confirm"
                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path id="eye-open-confirm" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path id="eye-closed-confirm" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.418 0-7.862-3.242-9.375-7 1.513-3.758 4.957-7 9.375-7 1.04 0 2.049.195 3 .55M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path id="slash-confirm" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Terms -->
                    <div class="flex items-start space-x-3">
                        <input type="checkbox" 
                               id="terms" 
                               name="terms" 
                               value="1"
                               class="mt-1 h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded @error('terms') border-red-500 @enderror"
                               required>
                        <label for="terms" class="text-sm text-gray-700">
                            Eu aceito os <a href="#" class="text-purple-600 hover:text-purple-700 underline">Termos de Uso</a> 
                            e <a href="#" class="text-purple-600 hover:text-purple-700 underline">Política de Privacidade</a> *
                        </label>
                    </div>
                    @error('terms')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    <!-- Submit Button -->
                    <button type="submit" 
                            class="w-full bg-purple-600 text-white py-4 px-6 rounded-lg font-bold text-lg hover:bg-purple-700 transition-colors duration-200">
                        Criar Minha Conta
                    </button>
                </form>

                <!-- Login Link -->
                <div class="mt-6 text-center">
                    <p class="text-gray-600 mb-3">
                        Já tenho conta
                    </p>
                    <a href="{{ route('login') }}" 
                       class="inline-block bg-gray-100 text-gray-700 py-3 px-6 rounded-lg font-semibold hover:bg-gray-200 transition-colors duration-200">
                        Fazer Login
                    </a>
                </div>
            </div>

            <!-- Benefits Sidebar -->
            <div class="space-y-8">
                <!-- Why Choose RAFE -->
                <div class="bg-white rounded-2xl shadow-xl p-8">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Por que escolher a RAFE?</h3>
                    <div class="space-y-4">
                        <div class="flex items-start space-x-3">
                            <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <span class="text-purple-600 font-bold text-sm">🔒</span>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">100% Seguro</h4>
                                <p class="text-gray-600 text-sm">Pagamentos protegidos e dados criptografados</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <span class="text-blue-600 font-bold text-sm">🎯</span>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">Fácil de Usar</h4>
                                <p class="text-gray-600 text-sm">Interface intuitiva e processos automatizados</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <span class="text-green-600 font-bold text-sm">📊</span>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">Relatórios Completos</h4>
                                <p class="text-gray-600 text-sm">Acompanhe tudo em tempo real</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <span class="text-yellow-600 font-bold text-sm">💬</span>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">Suporte 24/7</h4>
                                <p class="text-gray-600 text-sm">Nossa equipe está sempre disponível</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- What You Can Do -->
                <div class="bg-gradient-to-br from-purple-600 to-blue-600 rounded-2xl shadow-xl p-8 text-white">
                    <h3 class="text-2xl font-bold mb-6">O que você pode fazer:</h3>
                    <div class="space-y-4">
                        <div class="flex items-center space-x-3">
                            <span class="text-2xl">🎲</span>
                            <span class="font-medium">Participar de rifas</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <span class="text-2xl">🎯</span>
                            <span class="font-medium">Criar suas próprias rifas</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <span class="text-2xl">💰</span>
                            <span class="font-medium">Arrecadar para causas</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <span class="text-2xl">🏆</span>
                            <span class="font-medium">Ganhar prêmios incríveis</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <span class="text-2xl">📱</span>
                            <span class="font-medium">Gerenciar tudo pelo celular</span>
                        </div>
                    </div>
                </div>

                <!-- Statistics -->
                <div class="bg-white rounded-2xl shadow-xl p-8">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Números que impressionam</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-blue-600">500+</div>
                            <div class="text-sm text-gray-600">Rifas realizadas</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-yellow-600">4.9★</div>
                            <div class="text-sm text-gray-600">Avaliação</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Phone mask
document.getElementById('phone').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value.length >= 11) {
        value = value.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
    } else if (value.length >= 7) {
        value = value.replace(/(\d{2})(\d{4})(\d{0,4})/, '($1) $2-$3');
    } else if (value.length >= 3) {
        value = value.replace(/(\d{2})(\d{0,5})/, '($1) $2');
    }
    e.target.value = value;
});

// CPF mask
document.getElementById('document').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value.length >= 11) {
        value = value.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');
    } else if (value.length >= 9) {
        value = value.replace(/(\d{3})(\d{3})(\d{3})(\d{0,2})/, '$1.$2.$3-$4');
    } else if (value.length >= 6) {
        value = value.replace(/(\d{3})(\d{3})(\d{0,3})/, '$1.$2.$3');
    } else if (value.length >= 3) {
        value = value.replace(/(\d{3})(\d{0,3})/, '$1.$2');
    }
    e.target.value = value;
});

// Toggle password visibility - Senha
document.getElementById('toggle-password').addEventListener('click', function() {
    const passwordField = document.getElementById('password');
    const eyeOpen = document.getElementById('eye-open');
    const eyeClosed = document.getElementById('eye-closed');
    const slash = document.getElementById('slash');
    
    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        eyeOpen.classList.add('hidden');
        eyeClosed.classList.remove('hidden');
        slash.classList.remove('hidden');
    } else {
        passwordField.type = 'password';
        eyeOpen.classList.remove('hidden');
        eyeClosed.classList.add('hidden');
        slash.classList.add('hidden');
    }
});

// Toggle password visibility - Confirmar Senha
document.getElementById('toggle-password-confirm').addEventListener('click', function() {
    const passwordField = document.getElementById('password_confirmation');
    const eyeOpen = document.getElementById('eye-open-confirm');
    const eyeClosed = document.getElementById('eye-closed-confirm');
    const slash = document.getElementById('slash-confirm');
    
    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        eyeOpen.classList.add('hidden');
        eyeClosed.classList.remove('hidden');
        slash.classList.remove('hidden');
    } else {
        passwordField.type = 'password';
        eyeOpen.classList.remove('hidden');
        eyeClosed.classList.add('hidden');
        slash.classList.add('hidden');
    }
});

// Validação obrigatória dos campos
document.querySelector('form').addEventListener('submit', function(e) {
    const name = document.getElementById('name').value.trim();
    const email = document.getElementById('email').value.trim();
    const phone = document.getElementById('phone').value.trim();
    
    let isValid = true;
    let errorMessage = '';
    
    // Validar Nome
    if (!name || name.length < 2) {
        isValid = false;
        errorMessage += '• Nome completo é obrigatório (mínimo 2 caracteres)\n';
    }
    
    // Validar Gmail
    if (!email || !email.endsWith('@gmail.com')) {
        isValid = false;
        errorMessage += '• Gmail é obrigatório e deve terminar com @gmail.com\n';
    }
    
    // Validar Telefone
    const phoneDigits = phone.replace(/\D/g, '');
    if (!phone || phoneDigits.length < 10) {
        isValid = false;
        errorMessage += '• Telefone é obrigatório (mínimo 10 dígitos)\n';
    }
    
    if (!isValid) {
        e.preventDefault();
        alert('Por favor, corrija os seguintes erros:\n\n' + errorMessage);
        return false;
    }
});
</script>
@endsection
