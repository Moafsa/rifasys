@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 to-blue-50 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div class="text-center">
            <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                Redefinir Senha
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                Digite sua nova senha para continuar
            </p>
        </div>
        
        <div class="bg-white py-8 px-6 shadow-xl rounded-lg">
            @if (session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
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
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        Nova Senha
                    </label>
                    <input id="password" 
                           name="password" 
                           type="password" 
                           autocomplete="new-password" 
                           required 
                           class="appearance-none rounded-lg relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-purple-500 focus:border-purple-500 focus:z-10 sm:text-sm @error('password') border-red-500 @enderror"
                           placeholder="Digite sua nova senha">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                        Confirmar Nova Senha
                    </label>
                    <input id="password_confirmation" 
                           name="password_confirmation" 
                           type="password" 
                           autocomplete="new-password" 
                           required 
                           class="appearance-none rounded-lg relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-purple-500 focus:border-purple-500 focus:z-10 sm:text-sm"
                           placeholder="Confirme sua nova senha">
                </div>

                <div>
                    <button type="submit" 
                            class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-colors">
                        Redefinir Senha
                    </button>
                </div>
            </form>
        </div>

        <div class="text-center">
            <a href="{{ route('login') }}" 
               class="text-sm text-purple-600 hover:text-purple-500 transition-colors">
                Voltar ao Login
            </a>
        </div>

        <div class="text-center mt-4">
            <p class="text-xs text-gray-500">
                O código de redefinição expira em 3 minutos por segurança.
            </p>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const codeInput = document.getElementById('reset_code');
    
    // Auto-format and validate code input
    codeInput.addEventListener('input', function(e) {
        // Remove non-numeric characters
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    
    // Focus on code input when page loads
    codeInput.focus();
});
</script>
@endpush
@endsection
