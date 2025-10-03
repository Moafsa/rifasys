@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white p-10 rounded-xl shadow-lg">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Nova Senha
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Código verificado! Agora defina sua nova senha.
            </p>
        </div>

        @if (session('error'))
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
            @csrf
            
            <!-- Hidden fields -->
            <input type="hidden" name="email" value="{{ session('reset_email') }}">
            <input type="hidden" name="reset_code" value="{{ session('reset_code') }}">

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                    Nova Senha
                </label>
                <input id="password" 
                       name="password" 
                       type="password" 
                       required 
                       class="appearance-none rounded-lg relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm @error('password') border-red-500 @enderror"
                       placeholder="Digite sua nova senha">
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-gray-500">Mínimo 8 caracteres</p>
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                    Confirmar Nova Senha
                </label>
                <input id="password_confirmation" 
                       name="password_confirmation" 
                       type="password" 
                       required 
                       class="appearance-none rounded-lg relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm"
                       placeholder="Confirme sua nova senha">
            </div>

            <!-- Password strength indicator -->
            <div class="password-strength">
                <div class="flex items-center mb-2">
                    <span class="text-xs text-gray-600 mr-2">Força da senha:</span>
                    <div class="flex space-x-1">
                        <div class="h-1 w-8 bg-gray-200 rounded strength-bar"></div>
                        <div class="h-1 w-8 bg-gray-200 rounded strength-bar"></div>
                        <div class="h-1 w-8 bg-gray-200 rounded strength-bar"></div>
                        <div class="h-1 w-8 bg-gray-200 rounded strength-bar"></div>
                    </div>
                </div>
                <div class="text-xs text-gray-500">
                    <span id="strength-text">Digite uma senha</span>
                </div>
            </div>

            <div>
                <button type="submit" 
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-colors">
                    Definir Nova Senha
                </button>
            </div>
        </form>

        <div class="text-center">
            <a href="{{ route('login') }}" 
               class="text-sm text-purple-600 hover:text-purple-500 transition-colors">
                Voltar ao Login
            </a>
        </div>

        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex items-center">
                <div class="text-blue-600 mr-2">ℹ️</div>
                <div class="text-sm text-blue-800">
                    <strong>Dicas de segurança:</strong>
                    <ul class="mt-1 text-xs text-blue-700">
                        <li>• Use letras maiúsculas e minúsculas</li>
                        <li>• Inclua números e símbolos</li>
                        <li>• Evite informações pessoais</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.getElementById('password');
    const confirmInput = document.getElementById('password_confirmation');
    const strengthBars = document.querySelectorAll('.strength-bar');
    const strengthText = document.getElementById('strength-text');

    passwordInput.addEventListener('input', function() {
        const password = this.value;
        const strength = calculatePasswordStrength(password);
        updateStrengthIndicator(strength);
    });

    function calculatePasswordStrength(password) {
        let score = 0;
        
        if (password.length >= 8) score++;
        if (/[a-z]/.test(password)) score++;
        if (/[A-Z]/.test(password)) score++;
        if (/[0-9]/.test(password)) score++;
        if (/[^A-Za-z0-9]/.test(password)) score++;
        
        return Math.min(score, 4);
    }

    function updateStrengthIndicator(strength) {
        const colors = ['bg-red-500', 'bg-orange-500', 'bg-yellow-500', 'bg-green-500'];
        const texts = ['Muito fraca', 'Fraca', 'Média', 'Forte', 'Muito forte'];
        
        strengthBars.forEach((bar, index) => {
            bar.className = 'h-1 w-8 rounded strength-bar';
            if (index < strength) {
                bar.classList.add(colors[Math.min(strength - 1, 3)]);
            } else {
                bar.classList.add('bg-gray-200');
            }
        });
        
        strengthText.textContent = texts[strength];
        strengthText.className = strength < 2 ? 'text-xs text-red-600' : 
                                 strength < 3 ? 'text-xs text-orange-600' :
                                 strength < 4 ? 'text-xs text-yellow-600' : 
                                 'text-xs text-green-600';
    }

    // Real-time password confirmation validation
    confirmInput.addEventListener('input', function() {
        const password = passwordInput.value;
        const confirm = this.value;
        
        if (confirm && password !== confirm) {
            this.classList.add('border-red-500');
            this.classList.remove('border-green-500');
        } else if (confirm && password === confirm) {
            this.classList.remove('border-red-500');
            this.classList.add('border-green-500');
        } else {
            this.classList.remove('border-red-500', 'border-green-500');
        }
    });
});
</script>
@endpush
@endsection

