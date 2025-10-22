@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-900 via-blue-900 to-indigo-900 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-white mb-4">
                🚀 WhatsApp Integration Test
            </h1>
            <p class="text-xl text-blue-200">
                Teste todas as funcionalidades da integração WhatsApp
            </p>
        </div>

        <!-- Status Card -->
        <div class="bg-white/10 backdrop-blur-sm rounded-lg p-6 border border-white/20 mb-8">
            <h2 class="text-2xl font-semibold text-white mb-4">📊 Status da Conexão</h2>
            <div id="connection-status" class="text-blue-200">
                Verificando conexão...
            </div>
            <button onclick="verificarConexao()" class="mt-4 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition-colors">
                🔄 Verificar Novamente
            </button>
        </div>

        <!-- Test Buttons Grid -->
        <div class="grid md:grid-cols-2 gap-6">
            
            <!-- Oferta Test -->
            <div class="bg-white/10 backdrop-blur-sm rounded-lg p-6 border border-white/20">
                <h3 class="text-xl font-semibold text-white mb-4">🎉 Teste de Oferta</h3>
                <p class="text-blue-200 mb-4">Envie uma mensagem de oferta especial</p>
                <button onclick="testarOferta()" class="w-full bg-green-500 hover:bg-green-600 text-white px-4 py-3 rounded-lg transition-colors">
                    📨 Enviar Oferta
                </button>
            </div>

            <!-- Verificação Test -->
            <div class="bg-white/10 backdrop-blur-sm rounded-lg p-6 border border-white/20">
                <h3 class="text-xl font-semibold text-white mb-4">✅ Teste de Verificação</h3>
                <p class="text-blue-200 mb-4">Envie um código de verificação</p>
                <button onclick="testarVerificacao()" class="w-full bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-3 rounded-lg transition-colors">
                    🔐 Enviar Verificação
                </button>
            </div>

            <!-- Rifa Test -->
            <div class="bg-white/10 backdrop-blur-sm rounded-lg p-6 border border-white/20">
                <h3 class="text-xl font-semibold text-white mb-4">🎫 Teste de Rifa</h3>
                <p class="text-blue-200 mb-4">Envie notificação de nova rifa</p>
                <button onclick="testarRifa()" class="w-full bg-purple-500 hover:bg-purple-600 text-white px-4 py-3 rounded-lg transition-colors">
                    🎲 Enviar Rifa
                </button>
            </div>

            <!-- Confirmação de Compra Test -->
            <div class="bg-white/10 backdrop-blur-sm rounded-lg p-6 border border-white/20">
                <h3 class="text-xl font-semibold text-white mb-4">💳 Teste de Confirmação</h3>
                <p class="text-blue-200 mb-4">Envie confirmação de compra</p>
                <button onclick="testarConfirmacaoCompra()" class="w-full bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-3 rounded-lg transition-colors">
                    ✅ Enviar Confirmação
                </button>
            </div>

            <!-- Alerta Test -->
            <div class="bg-white/10 backdrop-blur-sm rounded-lg p-6 border border-white/20">
                <h3 class="text-xl font-semibold text-white mb-4">🔔 Teste de Alerta</h3>
                <p class="text-blue-200 mb-4">Envie um alerta do sistema</p>
                <button onclick="testarAlerta()" class="w-full bg-red-500 hover:bg-red-600 text-white px-4 py-3 rounded-lg transition-colors">
                    🚨 Enviar Alerta
                </button>
            </div>

            <!-- Preço Test -->
            <div class="bg-white/10 backdrop-blur-sm rounded-lg p-6 border border-white/20">
                <h3 class="text-xl font-semibold text-white mb-4">📊 Teste de Preço</h3>
                <p class="text-blue-200 mb-4">Envie atualização de preço</p>
                <button onclick="testarPreco()" class="w-full bg-orange-500 hover:bg-orange-600 text-white px-4 py-3 rounded-lg transition-colors">
                    💰 Enviar Preço
                </button>
            </div>

            <!-- Sistema de Eventos Test -->
            <div class="bg-white/10 backdrop-blur-sm rounded-lg p-6 border border-white/20">
                <h3 class="text-xl font-semibold text-white mb-4">🎯 Sistema de Eventos</h3>
                <p class="text-blue-200 mb-4">Teste o sistema de eventos integrado</p>
                <button onclick="testarEventos()" class="w-full bg-pink-500 hover:bg-pink-600 text-white px-4 py-3 rounded-lg transition-colors">
                    🚀 Testar Eventos
                </button>
            </div>

            <!-- Configurações Test -->
            <div class="bg-white/10 backdrop-blur-sm rounded-lg p-6 border border-white/20">
                <h3 class="text-xl font-semibold text-white mb-4">⚙️ Configurações</h3>
                <p class="text-blue-200 mb-4">Status do sistema de eventos</p>
                <button onclick="verificarStatusEventos()" class="w-full bg-gray-500 hover:bg-gray-600 text-white px-4 py-3 rounded-lg transition-colors">
                    📋 Ver Status
                </button>
            </div>
        </div>

        <!-- Results Log -->
        <div class="mt-8 bg-white/10 backdrop-blur-sm rounded-lg p-6 border border-white/20">
            <h3 class="text-xl font-semibold text-white mb-4">📋 Log de Resultados</h3>
            <div id="results-log" class="bg-black/20 rounded-lg p-4 text-sm text-green-300 font-mono max-h-64 overflow-y-auto">
                <div class="text-blue-300">Sistema inicializado. Aguardando testes...</div>
            </div>
            <button onclick="limparLog()" class="mt-4 bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition-colors">
                🗑️ Limpar Log
            </button>
        </div>

        <!-- Navigation -->
        <div class="mt-8 text-center">
            <a href="{{ route('home') }}" class="inline-flex items-center px-6 py-3 bg-white text-purple-700 font-medium rounded-lg hover:bg-purple-50 transition-colors">
                ← Voltar ao Dashboard
            </a>
        </div>
    </div>
</div>

<script>
// Log function
function logResult(message, type = 'info') {
    const log = document.getElementById('results-log');
    const timestamp = new Date().toLocaleTimeString();
    const color = type === 'success' ? 'text-green-400' : 
                 type === 'error' ? 'text-red-400' : 
                 type === 'warning' ? 'text-yellow-400' : 'text-blue-400';
    
    log.innerHTML += `<div class="${color}">[${timestamp}] ${message}</div>`;
    log.scrollTop = log.scrollHeight;
}

// Connection check
async function verificarConexao() {
    logResult('Verificando conexão com WuzAPI...', 'info');
    
    try {
        const response = await fetch('http://localhost:8083/status');
        const data = await response.json();
        
        if (response.ok) {
            document.getElementById('connection-status').innerHTML = `
                <div class="text-green-400">✅ Conectado - ${data.message}</div>
                <div class="text-sm text-blue-300 mt-2">Timestamp: ${data.timestamp}</div>
            `;
            logResult('✅ Conexão verificada com sucesso', 'success');
        } else {
            throw new Error('Falha na resposta');
        }
    } catch (error) {
        document.getElementById('connection-status').innerHTML = `
            <div class="text-red-400">❌ Erro de conexão</div>
            <div class="text-sm text-red-300 mt-2">${error.message}</div>
        `;
        logResult('❌ Erro ao verificar conexão: ' + error.message, 'error');
    }
}

// Test functions
async function testarOferta() {
    logResult('Enviando teste de oferta...', 'info');
    
    const ofertaData = {
        produto: 'iPhone 15 Pro Max',
        precoOriginal: '8.999',
        precoDesconto: '7.199',
        desconto: '20',
        validade: '31/12/2025',
        descricao: 'Oferta especial de Black Friday!',
        link: 'https://rifassys.com/rifa/iphone-15',
        numeroDestino: '+5511999999999'
    };
    
    if (window.whatsappIntegrator) {
        const result = await window.whatsappIntegrator.enviarOferta(ofertaData);
        if (result.success) {
            logResult('✅ Oferta enviada com sucesso!', 'success');
        } else {
            logResult('❌ Erro ao enviar oferta: ' + result.error, 'error');
        }
    } else {
        logResult('❌ WhatsApp Integrator não carregado', 'error');
    }
}

async function testarVerificacao() {
    logResult('Enviando teste de verificação...', 'info');
    
    const verificacaoData = {
        tipo: 'Email',
        status: 'Sucesso',
        data: new Date().toLocaleDateString('pt-BR'),
        hora: new Date().toLocaleTimeString('pt-BR'),
        detalhes: 'Seu email foi verificado com sucesso!',
        numeroDestino: '+5511999999999'
    };
    
    if (window.whatsappIntegrator) {
        const result = await window.whatsappIntegrator.enviarVerificacao(verificacaoData);
        if (result.success) {
            logResult('✅ Verificação enviada com sucesso!', 'success');
        } else {
            logResult('❌ Erro ao enviar verificação: ' + result.error, 'error');
        }
    } else {
        logResult('❌ WhatsApp Integrator não carregado', 'error');
    }
}

async function testarRifa() {
    logResult('Enviando teste de rifa...', 'info');
    
    const rifaData = {
        premio: 'MacBook Pro M3',
        valorBilhete: '25.00',
        totalBilhetes: '1000',
        dataSorteio: '15/12/2025',
        descricao: 'Rifa beneficente para ajudar uma família!',
        link: 'https://rifassys.com/rifa/macbook-pro',
        numeroDestino: '+5511999999999'
    };
    
    if (window.whatsappIntegrator) {
        const result = await window.whatsappIntegrator.enviarNotificacaoRifa(rifaData);
        if (result.success) {
            logResult('✅ Notificação de rifa enviada com sucesso!', 'success');
        } else {
            logResult('❌ Erro ao enviar rifa: ' + result.error, 'error');
        }
    } else {
        logResult('❌ WhatsApp Integrator não carregado', 'error');
    }
}

async function testarConfirmacaoCompra() {
    logResult('Enviando teste de confirmação de compra...', 'info');
    
    const compraData = {
        rifa: 'iPhone 15 Pro Max',
        quantidade: '5',
        valorTotal: '125.00',
        numeros: '001, 025, 050, 075, 100',
        dataCompra: new Date().toLocaleDateString('pt-BR'),
        idTransacao: 'TXN-' + Math.random().toString(36).substr(2, 9).toUpperCase(),
        numeroDestino: '+5511999999999'
    };
    
    if (window.whatsappIntegrator) {
        const result = await window.whatsappIntegrator.enviarConfirmacaoCompra(compraData);
        if (result.success) {
            logResult('✅ Confirmação de compra enviada com sucesso!', 'success');
        } else {
            logResult('❌ Erro ao enviar confirmação: ' + result.error, 'error');
        }
    } else {
        logResult('❌ WhatsApp Integrator não carregado', 'error');
    }
}

async function testarAlerta() {
    logResult('Enviando teste de alerta...', 'info');
    
    const alertaData = {
        tipo: 'Sistema',
        descricao: 'Teste de alerta do sistema Rifassys',
        prioridade: 'Média',
        acao: 'Verifique o painel administrativo',
        numeroDestino: '+5511999999999'
    };
    
    if (window.whatsappIntegrator) {
        const result = await window.whatsappIntegrator.enviarAlerta(alertaData);
        if (result.success) {
            logResult('✅ Alerta enviado com sucesso!', 'success');
        } else {
            logResult('❌ Erro ao enviar alerta: ' + result.error, 'error');
        }
    } else {
        logResult('❌ WhatsApp Integrator não carregado', 'error');
    }
}

async function testarPreco() {
    logResult('Enviando teste de atualização de preço...', 'info');
    
    const precoData = {
        produto: 'Samsung Galaxy S24 Ultra',
        precoAnterior: '4.999',
        precoAtual: '4.499',
        variacao: '-10%',
        observacao: 'Promoção de fim de ano!',
        numeroDestino: '+5511999999999'
    };
    
    if (window.whatsappIntegrator) {
        const result = await window.whatsappIntegrator.enviarAtualizacaoPreco(precoData);
        if (result.success) {
            logResult('✅ Atualização de preço enviada com sucesso!', 'success');
        } else {
            logResult('❌ Erro ao enviar preço: ' + result.error, 'error');
        }
    } else {
        logResult('❌ WhatsApp Integrator não carregado', 'error');
    }
}

function limparLog() {
    document.getElementById('results-log').innerHTML = '<div class="text-blue-300">Log limpo. Aguardando novos testes...</div>';
}

// Sistema de Eventos - Funções de teste
async function testarEventos() {
    logResult('🎯 Testando sistema de eventos integrado...', 'info');
    
    if (!window.rifassysEvents) {
        logResult('❌ Sistema de eventos não carregado', 'error');
        return;
    }

    try {
        // Teste 1: Oferta criada
        logResult('📤 Disparando evento: oferta-criada', 'info');
        window.rifassysEvents.dispararOfertaCriada({
            nome: 'Samsung Galaxy S24 Ultra',
            precoOriginal: '4999.00',
            precoPromocional: '3999.00',
            desconto: '20',
            validade: '25/12/2025',
            descricao: 'Promoção especial de Natal!'
        });
        
        // Aguardar um pouco
        await new Promise(resolve => setTimeout(resolve, 1000));
        
        // Teste 2: Rifa criada
        logResult('📤 Disparando evento: rifa-criada', 'info');
        window.rifassysEvents.dispararRifaCriada({
            premio: 'PlayStation 5',
            valorBilhete: '15.00',
            totalBilhetes: '500',
            dataSorteio: '20/12/2025',
            descricao: 'Rifa para presente de Natal!'
        });
        
        await new Promise(resolve => setTimeout(resolve, 1000));
        
        // Teste 3: Compra realizada
        logResult('📤 Disparando evento: compra-realizada', 'info');
        window.rifassysEvents.dispararCompraRealizada({
            rifa: 'PlayStation 5',
            quantidade: '3',
            valorTotal: '45.00',
            numeros: '001, 050, 100',
            dataCompra: new Date().toLocaleDateString('pt-BR'),
            idTransacao: 'TXN-' + Math.random().toString(36).substr(2, 9).toUpperCase()
        });
        
        await new Promise(resolve => setTimeout(resolve, 1000));
        
        // Teste 4: Alerta do sistema
        logResult('📤 Disparando evento: alerta-sistema', 'info');
        window.rifassysEvents.dispararAlertaSistema({
            tipo: 'Teste',
            mensagem: 'Sistema de eventos funcionando perfeitamente!',
            prioridade: 'Média',
            acaoRecomendada: 'Continue testando as funcionalidades'
        });
        
        logResult('✅ Todos os eventos foram disparados com sucesso!', 'success');
        
    } catch (error) {
        logResult('❌ Erro ao testar eventos: ' + error.message, 'error');
    }
}

function verificarStatusEventos() {
    logResult('📋 Verificando status do sistema de eventos...', 'info');
    
    if (!window.rifassysEvents) {
        logResult('❌ Sistema de eventos não carregado', 'error');
        return;
    }
    
    const status = window.rifassysEvents.obterStatus();
    
    logResult('📊 Status do Sistema de Eventos:', 'info');
    logResult(`   🔔 Notificações: ${status.ativo ? 'ATIVAS' : 'INATIVAS'}`, status.ativo ? 'success' : 'warning');
    logResult(`   📱 WhatsApp: ${status.whatsappConectado ? 'CONECTADO' : 'DESCONECTADO'}`, status.whatsappConectado ? 'success' : 'error');
    logResult(`   📞 Número Padrão: ${status.numeroPadrao}`, 'info');
    
    logResult('📋 Eventos Configurados:', 'info');
    Object.entries(status.eventos).forEach(([evento, ativo]) => {
        logResult(`   ${ativo ? '✅' : '❌'} ${evento}`, ativo ? 'success' : 'warning');
    });
}

// Auto-check connection on load
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(verificarConexao, 1000);
});
</script>
@endsection
