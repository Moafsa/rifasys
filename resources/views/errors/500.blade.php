<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erro Interno - RAFE</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }
        .animate-shake {
            animation: shake 0.5s ease-in-out;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-red-900 via-purple-900 to-blue-900 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-2xl mx-auto text-center">
        <!-- Logo -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-white mb-2">RAFE</h1>
            <p class="text-purple-200">Plataforma de Rifas Online</p>
        </div>

        <!-- Error Icon -->
        <div class="mb-8 animate-shake">
            <div class="w-32 h-32 mx-auto bg-red-500/20 rounded-full flex items-center justify-center border-4 border-red-500/30">
                <svg class="w-16 h-16 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>

        <!-- Main Message -->
        <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-8 mb-8 border border-white/20">
            <h2 class="text-3xl font-bold text-white mb-4">Ops! Algo deu errado</h2>
            <p class="text-xl text-purple-100 mb-6">
                Encontramos um erro inesperado. Nossa equipe foi notificada.
            </p>
            <div class="bg-red-500/20 border border-red-500/30 rounded-lg p-4 mb-6">
                <p class="text-red-200 font-medium">
                    🔧 Erro interno do servidor
                </p>
            </div>
        </div>

        <!-- What to do -->
        <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 mb-8 border border-white/20">
            <h3 class="text-xl font-bold text-white mb-4">O que você pode fazer:</h3>
            <div class="space-y-3 text-left">
                <div class="flex items-start space-x-3">
                    <span class="text-green-400 font-bold">1.</span>
                    <p class="text-purple-100">Tente recarregar a página</p>
                </div>
                <div class="flex items-start space-x-3">
                    <span class="text-green-400 font-bold">2.</span>
                    <p class="text-purple-100">Aguarde alguns minutos e tente novamente</p>
                </div>
                <div class="flex items-start space-x-3">
                    <span class="text-green-400 font-bold">3.</span>
                    <p class="text-purple-100">Se o problema persistir, entre em contato conosco</p>
                </div>
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

            <button onclick="window.history.back()" 
                    class="w-full md:w-auto bg-gray-600 hover:bg-gray-700 text-white px-8 py-3 rounded-lg font-semibold transition-colors duration-200 flex items-center justify-center gap-2 mx-auto">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Voltar
            </button>
            
            <div class="text-center">
                <p class="text-purple-200 text-sm">
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
            <p class="text-purple-300 text-sm">
                © {{ date('Y') }} RAFE. Todos os direitos reservados.
            </p>
        </div>
    </div>
</body>
</html>




