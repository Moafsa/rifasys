@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 to-blue-50 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div class="text-center">
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-4">
                <svg class="h-8 w-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.268 18.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
            </div>
            <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                Link Inválido
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                Este link de redefinição de senha é inválido ou expirou
            </p>
        </div>
        
        <div class="bg-white py-8 px-6 shadow-xl rounded-lg text-center">
            <p class="text-gray-600 mb-6">
                O link que você clicou pode ter expirado ou já foi usado. 
                Solicite um novo link de redefinição de senha.
            </p>
            
            <div class="space-y-4">
                <a href="{{ route('password.request') }}" 
                   class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-colors">
                    Solicitar Novo Link
                </a>
                
                <a href="{{ route('login') }}" 
                   class="w-full flex justify-center py-3 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-colors">
                    Voltar ao Login
                </a>
            </div>
        </div>

        <div class="text-center">
            <p class="text-xs text-gray-500">
                Os links de redefinição expiram em 1 hora por segurança.
            </p>
        </div>
    </div>
</div>
@endsection

