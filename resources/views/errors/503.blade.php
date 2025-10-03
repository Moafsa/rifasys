<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Temporariamente Fora do Ar - RAFE</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        .animate-pulse-slow {
            animation: pulse 3s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        .animate-float {
            animation: float 3s ease-in-out infinite;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-purple-900 via-blue-900 to-indigo-900 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-2xl mx-auto text-center">
        <!-- Logo -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-white mb-2 animate-float">RAFE</h1>
            <p class="text-blue-200">Plataforma de Rifas Online</p>
        </div>

        <!-- Error Icon -->
        <div class="mb-8 animate-pulse-slow">
            <div class="w-32 h-32 mx-auto bg-red-500/20 rounded-full flex items-center justify-center border-4 border-red-500/30">
                <svg class="w-16 h-16 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.268 18.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
            </div>
        </div>

        <!-- Main Message -->
        <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-8 mb-8 border border-white/20">
            <h2 class="text-3xl font-bold text-white mb-4">Sistema Temporariamente Fora do Ar</h2>
            <p class="text-xl text-blue-100 mb-6">
                Estamos realizando manutenções para melhorar sua experiência
            </p>
            <div class="bg-yellow-500/20 border border-yellow-500/30 rounded-lg p-4 mb-6">
                <p class="text-yellow-200 font-medium">
                    ⏰ Tempo estimado: 15-30 minutos
                </p>
            </div>
        </div>

        <!-- Status Information -->
        <div class="grid md:grid-cols-3 gap-4 mb-8">
            <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4 border border-white/20">
                <div class="text-2xl mb-2">🔧</div>
                <h3 class="text-white font-semibold mb-2">Manutenção</h3>
                <p class="text-blue-200 text-sm">Atualizações em andamento</p>
            </div>
            <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4 border border-white/20">
                <div class="text-2xl mb-2">⚡</div>
                <h3 class="text-white font-semibold mb-2">Performance</h3>
                <p class="text-blue-200 text-sm">Melhorias de velocidade</p>
            </div>
            <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4 border border-white/20">
                <div class="text-2xl mb-2">🛡️</div>
                <h3 class="text-white font-semibold mb-2">Segurança</h3>
                <p class="text-blue-200 text-sm">Atualizações de segurança</p>
            </div>
        </div>

        <!-- Actions -->
        <div class="space-y-4">
            <button onclick="window.location.reload()" 
                    class="w-full md:w-auto bg-purple-600 hover:bg-purple-700 text-white px-8 py-3 rounded-lg font-semibold transition-colors duration-200 flex items-center justify-center gap-2 mx-auto">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                Tentar Novamente
            </button>
            
            <div class="text-center">
                <p class="text-blue-200 text-sm">
                    Precisa de ajuda? Entre em contato conosco
                </p>
                <div class="flex justify-center space-x-4 mt-2">
                    <a href="mailto:suporte@rafe.com.br" class="text-purple-300 hover:text-purple-200 transition-colors">
                        📧 suporte@rafe.com.br
                    </a>
                    <a href="tel:+5511999999999" class="text-purple-300 hover:text-purple-200 transition-colors">
                        📱 (11) 99999-9999
                    </a>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="mt-12 text-center">
            <p class="text-blue-300 text-sm">
                © {{ date('Y') }} RAFE. Todos os direitos reservados.
            </p>
        </div>
    </div>

    <!-- Auto-refresh script -->
    <script>
        // Auto-refresh every 30 seconds
        setTimeout(function() {
            window.location.reload();
        }, 30000);

        // Show last update time
        document.addEventListener('DOMContentLoaded', function() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('pt-BR');
            console.log('Página carregada em:', timeString);
        });
    </script>
</body>
</html>




