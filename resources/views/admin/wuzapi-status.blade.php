@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-600 via-purple-700 to-purple-800 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-white mb-2">Status da WuzAPI</h1>
            <p class="text-purple-200">Monitoramento da integração com WhatsApp</p>
        </div>

        <!-- Status Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <!-- Connection Status -->
            <div class="bg-white/10 backdrop-blur-sm rounded-lg p-6 border border-white/20">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-white">Status da Conexão</h3>
                    <div id="connection-status" class="w-3 h-3 rounded-full bg-yellow-400"></div>
                </div>
                <p id="connection-text" class="text-purple-200 text-sm">Verificando...</p>
                <button onclick="checkConnection()" class="mt-3 text-xs bg-white/20 hover:bg-white/30 text-white px-3 py-1 rounded transition-colors">
                    Atualizar
                </button>
            </div>

            <!-- QR Code Status -->
            <div class="bg-white/10 backdrop-blur-sm rounded-lg p-6 border border-white/20">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-white">QR Code</h3>
                    <div id="qr-status" class="w-3 h-3 rounded-full bg-yellow-400"></div>
                </div>
                <p id="qr-text" class="text-purple-200 text-sm">Carregando...</p>
                <button onclick="loadQRCode()" class="mt-3 text-xs bg-white/20 hover:bg-white/30 text-white px-3 py-1 rounded transition-colors">
                    Carregar QR
                </button>
            </div>

            <!-- Webhook Status -->
            <div class="bg-white/10 backdrop-blur-sm rounded-lg p-6 border border-white/20">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-white">Webhook</h3>
                    <div id="webhook-status" class="w-3 h-3 rounded-full bg-green-400"></div>
                </div>
                <p id="webhook-text" class="text-purple-200 text-sm">Configurado</p>
                <button onclick="testWebhook()" class="mt-3 text-xs bg-white/20 hover:bg-white/30 text-white px-3 py-1 rounded transition-colors">
                    Testar
                </button>
            </div>
        </div>

        <!-- QR Code Display -->
        <div id="qr-container" class="hidden bg-white/10 backdrop-blur-sm rounded-lg p-6 border border-white/20 mb-8">
            <h3 class="text-lg font-semibold text-white mb-4">QR Code para Conectar WhatsApp</h3>
            <div class="text-center">
                <div id="qr-image" class="inline-block p-4 bg-white rounded-lg">
                    <!-- QR Code will be loaded here -->
                </div>
                <p class="text-purple-200 text-sm mt-4">
                    Escaneie este QR Code com seu WhatsApp para conectar
                </p>
            </div>
        </div>

        <!-- Connection Details -->
        <div class="bg-white/10 backdrop-blur-sm rounded-lg p-6 border border-white/20 mb-8">
            <h3 class="text-lg font-semibold text-white mb-4">Detalhes da Conexão</h3>
            <div id="connection-details" class="space-y-2">
                <div class="flex justify-between">
                    <span class="text-purple-200">URL da API:</span>
                    <span class="text-white font-mono text-sm">{{ config('services.wuzapi.url') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-purple-200">Webhook URL:</span>
                    <span class="text-white font-mono text-sm">{{ config('services.wuzapi.webhook_url') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-purple-200">Última verificação:</span>
                    <span id="last-check" class="text-white text-sm">-</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-purple-200">Status detalhado:</span>
                    <span id="detailed-status" class="text-white text-sm">Carregando...</span>
                </div>
            </div>
        </div>

        <!-- Recent Messages Log -->
        <div class="bg-white/10 backdrop-blur-sm rounded-lg p-6 border border-white/20">
            <h3 class="text-lg font-semibold text-white mb-4">Log de Mensagens Recentes</h3>
            <div id="messages-log" class="space-y-2 max-h-64 overflow-y-auto">
                <p class="text-purple-200 text-sm">Carregando logs...</p>
            </div>
            <button onclick="loadMessagesLog()" class="mt-3 text-xs bg-white/20 hover:bg-white/30 text-white px-3 py-1 rounded transition-colors">
                Atualizar Logs
            </button>
        </div>

        <!-- Actions -->
        <div class="mt-8 text-center">
            <a href="{{ route('home') }}" class="inline-flex items-center px-6 py-3 bg-white text-purple-700 font-medium rounded-lg hover:bg-purple-50 transition-colors">
                ← Voltar ao Dashboard
            </a>
        </div>
    </div>
</div>

<script>
let checkInterval;

document.addEventListener('DOMContentLoaded', function() {
    // Initial load
    checkConnection();
    loadQRCode();
    loadMessagesLog();
    
    // Set up auto-refresh every 30 seconds
    checkInterval = setInterval(() => {
        checkConnection();
        loadQRCode();
    }, 30000);
});

function checkConnection() {
    fetch('/api/wuzapi/status')
        .then(response => response.json())
        .then(data => {
            updateConnectionStatus(data);
            document.getElementById('last-check').textContent = new Date().toLocaleTimeString();
        })
        .catch(error => {
            console.error('Error checking connection:', error);
            updateConnectionStatus({ connected: false, error: 'Erro na conexão' });
        });
}

function updateConnectionStatus(data) {
    const statusDot = document.getElementById('connection-status');
    const statusText = document.getElementById('connection-text');
    const detailedStatus = document.getElementById('detailed-status');
    
    if (data.connected) {
        statusDot.className = 'w-3 h-3 rounded-full bg-green-400';
        statusText.textContent = 'Conectado';
        detailedStatus.textContent = 'WhatsApp conectado e funcionando';
    } else {
        statusDot.className = 'w-3 h-3 rounded-full bg-red-400';
        statusText.textContent = 'Desconectado';
        detailedStatus.textContent = data.error || 'WhatsApp não conectado';
    }
}

function loadQRCode() {
    fetch('/api/wuzapi/qr')
        .then(response => response.json())
        .then(data => {
            const qrContainer = document.getElementById('qr-container');
            const qrImage = document.getElementById('qr-image');
            const qrStatus = document.getElementById('qr-status');
            const qrText = document.getElementById('qr-text');
            
            if (data.qr && data.qr !== 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg==') {
                qrImage.innerHTML = `<img src="${data.qr}" alt="QR Code" class="max-w-full h-auto">`;
                qrContainer.classList.remove('hidden');
                qrStatus.className = 'w-3 h-3 rounded-full bg-blue-400';
                qrText.textContent = 'QR Code disponível';
            } else {
                qrContainer.classList.add('hidden');
                qrStatus.className = 'w-3 h-3 rounded-full bg-gray-400';
                qrText.textContent = 'QR Code não disponível';
            }
        })
        .catch(error => {
            console.error('Error loading QR code:', error);
            document.getElementById('qr-status').className = 'w-3 h-3 rounded-full bg-red-400';
            document.getElementById('qr-text').textContent = 'Erro ao carregar';
        });
}

function testWebhook() {
    fetch('/api/webhooks/whatsapp/status')
        .then(response => response.json())
        .then(data => {
            alert('Webhook Status:\n' + JSON.stringify(data, null, 2));
        })
        .catch(error => {
            alert('Erro ao testar webhook: ' + error.message);
        });
}

function loadMessagesLog() {
    // This would typically fetch from a logs endpoint
    // For now, we'll show a placeholder
    const messagesLog = document.getElementById('messages-log');
    messagesLog.innerHTML = `
        <div class="text-purple-200 text-sm space-y-1">
            <div class="flex justify-between">
                <span>${new Date().toLocaleTimeString()}</span>
                <span>Verificação enviada para +55 11 99999-9999</span>
            </div>
            <div class="flex justify-between">
                <span>${new Date(Date.now() - 60000).toLocaleTimeString()}</span>
                <span>Mensagem de boas-vindas enviada</span>
            </div>
            <div class="flex justify-between">
                <span>${new Date(Date.now() - 120000).toLocaleTimeString()}</span>
                <span>Status de conexão verificado</span>
            </div>
        </div>
    `;
}

// Clean up interval on page unload
window.addEventListener('beforeunload', function() {
    if (checkInterval) {
        clearInterval(checkInterval);
    }
});
</script>
@endsection
