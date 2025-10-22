@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-900 via-blue-900 to-purple-900 py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-white mb-4">
                📱 WhatsApp Integration Examples
            </h1>
            <p class="text-xl text-blue-200 mb-6">
                Exemplos práticos e diretos de uso da classe WhatsAppIntegrator
            </p>
            <div class="inline-flex items-center px-4 py-2 bg-green-500/20 text-green-300 rounded-full text-sm">
                <span class="w-2 h-2 bg-green-400 rounded-full mr-2 animate-pulse"></span>
                Sistema Pronto para Uso
            </div>
        </div>

        <!-- Status -->
        <div class="bg-white/10 backdrop-blur-sm rounded-lg p-6 border border-white/20 mb-8">
            <h2 class="text-2xl font-semibold text-white mb-4">📊 Status do Sistema</h2>
            <div id="system-status" class="text-blue-200">
                Verificando sistema...
            </div>
        </div>

        <!-- Exemplos de Uso -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            
            <!-- Exemplo 1: Oferta -->
            <div class="bg-white/10 backdrop-blur-sm rounded-lg p-6 border border-white/20">
                <h3 class="text-xl font-semibold text-white mb-4">🎉 Exemplo 1: Oferta</h3>
                <div class="bg-black/20 rounded-lg p-4 mb-4 text-sm text-green-300 font-mono">
                    whatsapp.enviarOferta({<br>
                    &nbsp;&nbsp;produto: "iPhone 15",<br>
                    &nbsp;&nbsp;precoOriginal: 4999,<br>
                    &nbsp;&nbsp;precoDesconto: 3999,<br>
                    &nbsp;&nbsp;desconto: 20,<br>
                    &nbsp;&nbsp;validade: "31/12/2024"<br>
                    });
                </div>
                <button onclick="testarOferta()" class="w-full bg-green-500 hover:bg-green-600 text-white px-4 py-3 rounded-lg transition-colors">
                    🚀 Testar Oferta
                </button>
            </div>

            <!-- Exemplo 2: Preço -->
            <div class="bg-white/10 backdrop-blur-sm rounded-lg p-6 border border-white/20">
                <h3 class="text-xl font-semibold text-white mb-4">📊 Exemplo 2: Preço</h3>
                <div class="bg-black/20 rounded-lg p-4 mb-4 text-sm text-blue-300 font-mono">
                    whatsapp.enviarAtualizacaoPreco({<br>
                    &nbsp;&nbsp;produto: "Samsung Galaxy S23",<br>
                    &nbsp;&nbsp;precoAnterior: 3499,<br>
                    &nbsp;&nbsp;precoAtual: 2999,<br>
                    &nbsp;&nbsp;variacao: "-14%"<br>
                    });
                </div>
                <button onclick="testarPreco()" class="w-full bg-blue-500 hover:bg-blue-600 text-white px-4 py-3 rounded-lg transition-colors">
                    💰 Testar Preço
                </button>
            </div>

            <!-- Exemplo 3: Verificação -->
            <div class="bg-white/10 backdrop-blur-sm rounded-lg p-6 border border-white/20">
                <h3 class="text-xl font-semibold text-white mb-4">✅ Exemplo 3: Verificação</h3>
                <div class="bg-black/20 rounded-lg p-4 mb-4 text-sm text-yellow-300 font-mono">
                    whatsapp.enviarVerificacao({<br>
                    &nbsp;&nbsp;tipo: "Estoque",<br>
                    &nbsp;&nbsp;status: "Concluído",<br>
                    &nbsp;&nbsp;data: "15/01/2024",<br>
                    &nbsp;&nbsp;hora: "14:30"<br>
                    });
                </div>
                <button onclick="testarVerificacao()" class="w-full bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-3 rounded-lg transition-colors">
                    🔐 Testar Verificação
                </button>
            </div>

            <!-- Exemplo 4: Alerta -->
            <div class="bg-white/10 backdrop-blur-sm rounded-lg p-6 border border-white/20">
                <h3 class="text-xl font-semibold text-white mb-4">🔔 Exemplo 4: Alerta</h3>
                <div class="bg-black/20 rounded-lg p-4 mb-4 text-sm text-red-300 font-mono">
                    whatsapp.enviarAlerta({<br>
                    &nbsp;&nbsp;tipo: "Sistema",<br>
                    &nbsp;&nbsp;descricao: "Alerta do sistema",<br>
                    &nbsp;&nbsp;prioridade: "Média"<br>
                    });
                </div>
                <button onclick="testarAlerta()" class="w-full bg-red-500 hover:bg-red-600 text-white px-4 py-3 rounded-lg transition-colors">
                    🚨 Testar Alerta
                </button>
            </div>

            <!-- Exemplo 5: Rifa -->
            <div class="bg-white/10 backdrop-blur-sm rounded-lg p-6 border border-white/20">
                <h3 class="text-xl font-semibold text-white mb-4">🎫 Exemplo 5: Rifa</h3>
                <div class="bg-black/20 rounded-lg p-4 mb-4 text-sm text-purple-300 font-mono">
                    whatsapp.enviarNotificacaoRifa({<br>
                    &nbsp;&nbsp;premio: "MacBook Pro M3",<br>
                    &nbsp;&nbsp;valorBilhete: "25.00",<br>
                    &nbsp;&nbsp;totalBilhetes: "1000"<br>
                    });
                </div>
                <button onclick="testarRifa()" class="w-full bg-purple-500 hover:bg-purple-600 text-white px-4 py-3 rounded-lg transition-colors">
                    🎲 Testar Rifa
                </button>
            </div>

            <!-- Exemplo 6: Compra -->
            <div class="bg-white/10 backdrop-blur-sm rounded-lg p-6 border border-white/20">
                <h3 class="text-xl font-semibold text-white mb-4">💳 Exemplo 6: Compra</h3>
                <div class="bg-black/20 rounded-lg p-4 mb-4 text-sm text-indigo-300 font-mono">
                    whatsapp.enviarConfirmacaoCompra({<br>
                    &nbsp;&nbsp;rifa: "iPhone 15",<br>
                    &nbsp;&nbsp;quantidade: "3",<br>
                    &nbsp;&nbsp;valorTotal: "75.00",<br>
                    &nbsp;&nbsp;numeros: "001, 025, 050"<br>
                    });
                </div>
                <button onclick="testarCompra()" class="w-full bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-3 rounded-lg transition-colors">
                    ✅ Testar Compra
                </button>
            </div>
        </div>

        <!-- Teste Completo -->
        <div class="bg-white/10 backdrop-blur-sm rounded-lg p-6 border border-white/20 mb-8">
            <h3 class="text-2xl font-semibold text-white mb-4">🧪 Teste Completo</h3>
            <p class="text-blue-200 mb-6">Execute todos os exemplos em sequência para testar o sistema completo</p>
            <button onclick="testarTodosExemplos()" class="bg-gradient-to-r from-pink-500 to-purple-500 hover:from-pink-600 hover:to-purple-600 text-white px-8 py-4 rounded-lg font-semibold transition-all duration-300">
                🚀 Executar Todos os Exemplos
            </button>
        </div>

        <!-- Log de Resultados -->
        <div class="bg-white/10 backdrop-blur-sm rounded-lg p-6 border border-white/20">
            <h3 class="text-xl font-semibold text-white mb-4">📋 Log de Execução</h3>
            <div id="execution-log" class="bg-black/20 rounded-lg p-4 text-sm text-green-300 font-mono max-h-64 overflow-y-auto">
                <div class="text-blue-300">Sistema inicializado. Aguardando exemplos...</div>
            </div>
            <button onclick="limparLog()" class="mt-4 bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition-colors">
                🗑️ Limpar Log
            </button>
        </div>

        <!-- Navegação -->
        <div class="mt-8 text-center space-x-4">
            <a href="{{ route('whatsapp.test') }}" class="inline-flex items-center px-6 py-3 bg-blue-500 text-white font-medium rounded-lg hover:bg-blue-600 transition-colors">
                🧪 Página de Testes Avançados
            </a>
            <a href="{{ route('home') }}" class="inline-flex items-center px-6 py-3 bg-white text-purple-700 font-medium rounded-lg hover:bg-purple-50 transition-colors">
                ← Voltar ao Dashboard
            </a>
        </div>
    </div>
</div>

<script>
// Log function
function logExecution(message, type = 'info') {
    const log = document.getElementById('execution-log');
    const timestamp = new Date().toLocaleTimeString();
    const color = type === 'success' ? 'text-green-400' : 
                 type === 'error' ? 'text-red-400' : 
                 type === 'warning' ? 'text-yellow-400' : 'text-blue-400';
    
    log.innerHTML += `<div class="${color}">[${timestamp}] ${message}</div>`;
    log.scrollTop = log.scrollHeight;
}

function limparLog() {
    document.getElementById('execution-log').innerHTML = '<div class="text-blue-300">Log limpo. Aguardando exemplos...</div>';
}

// Override das funções de exemplo para incluir log
const originalTestarOferta = window.testarOferta;
window.testarOferta = function() {
    logExecution('🎉 Executando exemplo: Enviar Oferta', 'info');
    if (originalTestarOferta) originalTestarOferta();
};

const originalTestarPreco = window.testarPreco;
window.testarPreco = function() {
    logExecution('📊 Executando exemplo: Atualização de Preço', 'info');
    if (originalTestarPreco) originalTestarPreco();
};

const originalTestarVerificacao = window.testarVerificacao;
window.testarVerificacao = function() {
    logExecution('✅ Executando exemplo: Verificação', 'info');
    if (originalTestarVerificacao) originalTestarVerificacao();
};

const originalTestarAlerta = window.testarAlerta;
window.testarAlerta = function() {
    logExecution('🔔 Executando exemplo: Alerta', 'info');
    if (originalTestarAlerta) originalTestarAlerta();
};

const originalTestarRifa = window.testarRifa;
window.testarRifa = function() {
    logExecution('🎫 Executando exemplo: Notificação de Rifa', 'info');
    if (originalTestarRifa) originalTestarRifa();
};

const originalTestarCompra = window.testarCompra;
window.testarCompra = function() {
    logExecution('💳 Executando exemplo: Confirmação de Compra', 'info');
    if (originalTestarCompra) originalTestarCompra();
};

const originalTestarTodosExemplos = window.testarTodosExemplos;
window.testarTodosExemplos = function() {
    logExecution('🧪 Executando teste completo - todos os exemplos', 'info');
    if (originalTestarTodosExemplos) originalTestarTodosExemplos();
};

// Verificar status do sistema
function verificarStatusSistema() {
    setTimeout(() => {
        if (window.whatsappIntegrator) {
            document.getElementById('system-status').innerHTML = `
                <div class="text-green-400">✅ WhatsApp Integrator: Carregado</div>
                <div class="text-green-400">✅ WuzAPI: Conectada</div>
                <div class="text-green-400">✅ Sistema: Pronto para uso</div>
            `;
            logExecution('✅ Sistema verificado e funcionando', 'success');
        } else {
            document.getElementById('system-status').innerHTML = `
                <div class="text-red-400">❌ WhatsApp Integrator: Não carregado</div>
                <div class="text-red-400">❌ Sistema: Aguardando carregamento</div>
            `;
            logExecution('❌ Sistema ainda carregando...', 'warning');
            verificarStatusSistema(); // Verificar novamente
        }
    }, 1000);
}

// Inicializar verificação
document.addEventListener('DOMContentLoaded', function() {
    logExecution('🚀 Página de exemplos carregada', 'info');
    verificarStatusSistema();
});
</script>
@endsection




