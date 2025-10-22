@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-900 via-blue-900 to-purple-900 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-white mb-4">
                📱 Configuração WhatsApp Business
            </h1>
            <p class="text-xl text-blue-200 mb-6">
                Configure seu número WhatsApp Business para envio de verificações
            </p>
        </div>

        <!-- Status Card -->
        <div class="bg-white/10 backdrop-blur-sm rounded-lg p-6 border border-white/20 mb-8">
            <h2 class="text-2xl font-semibold text-white mb-4">📊 Status da Configuração</h2>
            <div id="config-status" class="text-blue-200">
                Verificando configuração...
            </div>
        </div>

        <!-- Configuration Form -->
        <div class="bg-white/10 backdrop-blur-sm rounded-lg p-6 border border-white/20 mb-8">
            <h3 class="text-xl font-semibold text-white mb-4">⚙️ Configurar WhatsApp Business</h3>
            
            <div class="space-y-4">
                <div>
                    <label class="block text-white text-sm font-medium mb-2">
                        Número WhatsApp Business
                    </label>
                    <input type="tel" id="whatsapp-number" 
                           placeholder="5511999999999 (DDI + DDD + Número)"
                           class="w-full px-4 py-3 bg-white/20 border border-white/30 rounded-lg text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-green-500">
                    <p class="text-blue-200 text-sm mt-2">
                        Formato: 55 + DDD + Número (ex: 5511912345678)
                    </p>
                </div>
                
                <button onclick="configurarNumero()" 
                        class="w-full bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-lg font-semibold transition-colors">
                    🔧 Configurar Número
                </button>
            </div>
        </div>

        <!-- Test Section -->
        <div class="bg-white/10 backdrop-blur-sm rounded-lg p-6 border border-white/20 mb-8">
            <h3 class="text-xl font-semibold text-white mb-4">🧪 Testar Configuração</h3>
            
            <div class="space-y-4">
                <div>
                    <label class="block text-white text-sm font-medium mb-2">
                        Número para Teste (opcional)
                    </label>
                    <input type="tel" id="test-number" 
                           placeholder="5511999999999 (ou deixe vazio para usar o configurado)"
                           class="w-full px-4 py-3 bg-white/20 border border-white/30 rounded-lg text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                
                <button onclick="testarEnvio()" 
                        class="w-full bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold transition-colors">
                    📤 Enviar Teste de Verificação
                </button>
            </div>
        </div>

        <!-- Current Configuration -->
        <div class="bg-white/10 backdrop-blur-sm rounded-lg p-6 border border-white/20 mb-8">
            <h3 class="text-xl font-semibold text-white mb-4">📋 Configuração Atual</h3>
            <div id="current-config" class="text-blue-200">
                Carregando...
            </div>
        </div>

        <!-- Log de Resultados -->
        <div class="bg-white/10 backdrop-blur-sm rounded-lg p-6 border border-white/20">
            <h3 class="text-xl font-semibold text-white mb-4">📋 Log de Atividades</h3>
            <div id="activity-log" class="bg-black/20 rounded-lg p-4 text-sm text-green-300 font-mono max-h-64 overflow-y-auto">
                <div class="text-blue-300">Sistema inicializado. Aguardando configuração...</div>
            </div>
            <button onclick="limparLog()" class="mt-4 bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition-colors">
                🗑️ Limpar Log
            </button>
        </div>

        <!-- Navigation -->
        <div class="mt-8 text-center space-x-4">
            <a href="{{ route('whatsapp.examples') }}" class="inline-flex items-center px-6 py-3 bg-green-500 text-white font-medium rounded-lg hover:bg-green-600 transition-colors">
                📱 Ver Exemplos
            </a>
            <a href="{{ route('home') }}" class="inline-flex items-center px-6 py-3 bg-white text-purple-700 font-medium rounded-lg hover:bg-purple-50 transition-colors">
                ← Voltar ao Dashboard
            </a>
        </div>
    </div>
</div>

<script>
// Log function
function logActivity(message, type = 'info') {
    const log = document.getElementById('activity-log');
    const timestamp = new Date().toLocaleTimeString();
    const color = type === 'success' ? 'text-green-400' : 
                 type === 'error' ? 'text-red-400' : 
                 type === 'warning' ? 'text-yellow-400' : 'text-blue-400';
    
    log.innerHTML += `<div class="${color}">[${timestamp}] ${message}</div>`;
    log.scrollTop = log.scrollHeight;
}

function limparLog() {
    document.getElementById('activity-log').innerHTML = '<div class="text-blue-300">Log limpo. Aguardando atividades...</div>';
}

// Configurar número WhatsApp
function configurarNumero() {
    const numero = document.getElementById('whatsapp-number').value.trim();
    
    if (!numero) {
        logActivity('❌ Por favor, digite um número WhatsApp', 'error');
        return;
    }
    
    // Validar formato
    const numeroLimpo = numero.replace(/\D/g, '');
    const regex = /^55\d{10,11}$/;
    
    if (!regex.test(numeroLimpo)) {
        logActivity('❌ Formato inválido. Use: 55 + DDD + Número', 'error');
        return;
    }
    
    // Salvar no localStorage
    localStorage.setItem('whatsapp-business-number', numeroLimpo);
    
    // Atualizar sistema se estiver carregado
    if (window.whatsappIntegrator) {
        window.whatsappIntegrator.configuracoes.numeroWhatsApp = numeroLimpo;
        logActivity(`✅ Número configurado: ${numeroLimpo}`, 'success');
    } else {
        logActivity(`✅ Número salvo: ${numeroLimpo} (será aplicado na próxima página)`, 'success');
    }
    
    verificarConfiguracao();
}

// Testar envio
async function testarEnvio() {
    const numeroTeste = document.getElementById('test-number').value.trim();
    const numeroConfigurado = localStorage.getItem('whatsapp-business-number');
    
    if (!numeroConfigurado && !numeroTeste) {
        logActivity('❌ Configure um número WhatsApp primeiro', 'error');
        return;
    }
    
    const numeroDestino = numeroTeste || numeroConfigurado;
    
    if (window.whatsappIntegrator) {
        logActivity(`📤 Enviando teste para: ${numeroDestino}`, 'info');
        
        const resultado = await window.whatsappIntegrator.enviarVerificacaoCliente({
            nome: 'Cliente Teste',
            numeroWhatsApp: numeroDestino,
            linkVerificacao: window.location.origin + '/verification/test-link',
            email: 'teste@exemplo.com'
        });
        
        if (resultado.success) {
            logActivity('✅ Teste enviado com sucesso!', 'success');
        } else {
            logActivity(`❌ Erro no teste: ${resultado.error}`, 'error');
        }
    } else {
        logActivity('❌ WhatsApp Integrator não carregado', 'error');
    }
}

// Verificar configuração atual
function verificarConfiguracao() {
    const numeroSalvo = localStorage.getItem('whatsapp-business-number');
    const statusDiv = document.getElementById('config-status');
    const configDiv = document.getElementById('current-config');
    
    if (numeroSalvo) {
        statusDiv.innerHTML = `
            <div class="text-green-400">✅ WhatsApp Business Configurado</div>
            <div class="text-sm text-blue-300 mt-2">Número: ${numeroSalvo}</div>
        `;
        
        configDiv.innerHTML = `
            <div class="space-y-2">
                <div class="flex justify-between">
                    <span class="text-white">Número WhatsApp Business:</span>
                    <span class="text-green-400">${numeroSalvo}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-white">Status:</span>
                    <span class="text-green-400">Configurado</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-white">Última atualização:</span>
                    <span class="text-blue-300">${new Date().toLocaleString()}</span>
                </div>
            </div>
        `;
        
        logActivity('📋 Configuração verificada', 'info');
    } else {
        statusDiv.innerHTML = `
            <div class="text-yellow-400">⚠️ WhatsApp Business Não Configurado</div>
            <div class="text-sm text-blue-300 mt-2">Configure seu número acima</div>
        `;
        
        configDiv.innerHTML = `
            <div class="text-yellow-400">⚠️ Nenhuma configuração encontrada</div>
            <div class="text-blue-300 text-sm mt-2">Use o formulário acima para configurar</div>
        `;
    }
}

// Inicializar página
document.addEventListener('DOMContentLoaded', function() {
    logActivity('🚀 Página de configuração carregada', 'info');
    
    // Carregar número salvo no campo
    const numeroSalvo = localStorage.getItem('whatsapp-business-number');
    if (numeroSalvo) {
        document.getElementById('whatsapp-number').value = numeroSalvo;
    }
    
    // Verificar configuração
    setTimeout(verificarConfiguracao, 500);
});
</script>
@endsection




