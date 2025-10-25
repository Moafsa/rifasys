@extends('layouts.app')

@section('title', 'Como Usar o WuzAPI Manager')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">
                <i class="fab fa-whatsapp text-green-500"></i>
                Como Usar o WuzAPI Manager
            </h1>
            <p class="text-xl text-gray-600">
                Guia passo a passo para criar sua primeira instância
            </p>
        </div>

        <!-- Steps -->
        <div class="space-y-8">
            <!-- Step 1 -->
            <div class="bg-white rounded-lg shadow-lg p-6 border-l-4 border-blue-500">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-500 text-white rounded-full flex items-center justify-center font-bold">
                            1
                        </div>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">
                            Acesse o WuzAPI Manager
                        </h3>
                        <p class="text-gray-600 mb-4">
                            Primeiro, você precisa acessar o painel do WuzAPI Manager para obter suas credenciais.
                        </p>
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <p class="text-blue-800 font-medium mb-2">🌐 Acesse:</p>
                            <a href="https://wuzapidiv.conext.click" target="_blank" 
                               class="text-blue-600 hover:text-blue-800 underline">
                                https://wuzapidiv.conext.click
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 2 -->
            <div class="bg-white rounded-lg shadow-lg p-6 border-l-4 border-green-500">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-500 text-white rounded-full flex items-center justify-center font-bold">
                            2
                        </div>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">
                            Faça Login no WuzAPI Manager
                        </h3>
                        <p class="text-gray-600 mb-4">
                            Use seu token de acesso para fazer login no painel.
                        </p>
                        <div class="bg-green-50 p-4 rounded-lg">
                            <p class="text-green-800 font-medium mb-2">🔑 Token de Acesso:</p>
                            <p class="text-green-700">
                                Digite seu token de acesso no campo "Token de Acesso" e clique em "Entrar"
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 3 -->
            <div class="bg-white rounded-lg shadow-lg p-6 border-l-4 border-purple-500">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-purple-500 text-white rounded-full flex items-center justify-center font-bold">
                            3
                        </div>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">
                            Obtenha suas Credenciais
                        </h3>
                        <p class="text-gray-600 mb-4">
                            No painel do WuzAPI Manager, você encontrará:
                        </p>
                        <div class="bg-purple-50 p-4 rounded-lg">
                            <ul class="text-purple-800 space-y-2">
                                <li>• <strong>API Token:</strong> Token para autenticação</li>
                                <li>• <strong>Instance ID:</strong> ID da sua instância</li>
                                <li>• <strong>Webhook URL:</strong> URL para receber eventos</li>
                                <li>• <strong>Webhook Secret:</strong> Chave secreta para validação</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 4 -->
            <div class="bg-white rounded-lg shadow-lg p-6 border-l-4 border-orange-500">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-orange-500 text-white rounded-full flex items-center justify-center font-bold">
                            4
                        </div>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">
                            Crie sua Primeira Instância
                        </h3>
                        <p class="text-gray-600 mb-4">
                            Agora você pode criar sua instância no sistema de rifas.
                        </p>
                        <div class="bg-orange-50 p-4 rounded-lg">
                            <p class="text-orange-800 font-medium mb-2">📝 Preencha o formulário:</p>
                            <ul class="text-orange-700 space-y-1">
                                <li>• Nome da instância (ex: "Rifa Principal")</li>
                                <li>• Token de acesso (do WuzAPI Manager)</li>
                                <li>• URL do webhook (já preenchida automaticamente)</li>
                                <li>• Chave secreta do webhook</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 5 -->
            <div class="bg-white rounded-lg shadow-lg p-6 border-l-4 border-red-500">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-red-500 text-white rounded-full flex items-center justify-center font-bold">
                            5
                        </div>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">
                            Conecte seu WhatsApp
                        </h3>
                        <p class="text-gray-600 mb-4">
                            Após criar a instância, você precisará conectar seu WhatsApp.
                        </p>
                        <div class="bg-red-50 p-4 rounded-lg">
                            <p class="text-red-800 font-medium mb-2">📱 Processo de Conexão:</p>
                            <ol class="text-red-700 space-y-1 list-decimal list-inside">
                                <li>Clique em "Testar Conexão" na sua instância</li>
                                <li>Se conectado, aparecerá um QR code</li>
                                <li>Abra o WhatsApp no seu celular</li>
                                <li>Vá em "Dispositivos conectados"</li>
                                <li>Escaneie o QR code</li>
                                <li>Pronto! Sua instância estará ativa</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="text-center mt-8 space-x-4">
            <a href="{{ route('wuzapi-manager.instances.create') }}" 
               class="bg-green-500 text-white px-8 py-3 rounded-lg font-semibold hover:bg-green-600 transition-colors inline-flex items-center">
                <i class="fas fa-plus mr-2"></i>
                Criar Primeira Instância
            </a>
            <a href="{{ route('wuzapi-manager.dashboard') }}" 
               class="bg-blue-500 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-600 transition-colors inline-flex items-center">
                <i class="fas fa-tachometer-alt mr-2"></i>
                Ver Dashboard
            </a>
        </div>

        <!-- Help Section -->
        <div class="mt-12 bg-gray-50 rounded-lg p-6">
            <h3 class="text-xl font-semibold text-gray-900 mb-4">
                <i class="fas fa-question-circle text-blue-500"></i>
                Precisa de Ajuda?
            </h3>
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <h4 class="font-medium text-gray-900 mb-2">Problemas Comuns:</h4>
                    <ul class="text-gray-600 space-y-1">
                        <li>• Token inválido ou expirado</li>
                        <li>• QR code não aparece</li>
                        <li>• WhatsApp não conecta</li>
                        <li>• Mensagens não são enviadas</li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-medium text-gray-900 mb-2">Soluções:</h4>
                    <ul class="text-gray-600 space-y-1">
                        <li>• Verifique se o token está correto</li>
                        <li>• Aguarde alguns segundos para o QR code</li>
                        <li>• Tente desconectar e reconectar</li>
                        <li>• Verifique os logs de erro</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
