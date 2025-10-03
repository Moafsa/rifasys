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
                <div class="text-center">
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                        <div class="flex items-center justify-center">
                            <svg class="h-5 w-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-sm text-blue-800">
                                <strong>Passos para verificação:</strong>
                            </span>
                        </div>
                        <div class="text-sm text-blue-700 mt-2 space-y-1">
                            <p>1. Acesse seu Gmail</p>
                            <p>2. Abra o email "Verificar Email - RAFE"</p>
                            <p>3. Clique no botão "Verificar Email"</p>
                            <p>4. Confirme clicando em "Permitir"</p>
                        </div>
                    </div>
                </div>

                <div class="text-center">
                    <p class="text-sm text-gray-600 mb-3">
                        Não recebeu o email? Verifique sua pasta de spam ou
                    </p>
                    
                    <form method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" 
                                class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-colors">
                            Reenviar Link de Verificação
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
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <div class="flex items-center justify-center">
                    <svg class="h-5 w-5 text-yellow-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.268 19.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                    <span class="text-sm text-yellow-800">
                        <strong>Importante:</strong> O link de verificação expira em 3 minutos por segurança.
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

