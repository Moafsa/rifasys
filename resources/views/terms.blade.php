@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 to-blue-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">
                Termos de Uso - RAFE
            </h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Conheça nossos termos e condições para uso da plataforma
            </p>
            <div class="mt-4 inline-flex items-center px-4 py-2 bg-blue-100 text-blue-800 text-sm font-medium rounded-lg">
                📅 Última atualização: {{ date('d/m/Y') }}
            </div>
        </div>

        <!-- Terms Content -->
        <div class="bg-white rounded-2xl shadow-xl p-8 space-y-8">
            
            <!-- 1. Aceitação dos Termos -->
            <section>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">1. Aceitação dos Termos</h2>
                <div class="prose prose-gray max-w-none">
                    <p class="text-gray-700 mb-4">
                        Ao utilizar a plataforma RAFE, você concorda com estes termos de uso. 
                        Se não concordar com qualquer parte destes termos, não deve usar nossa plataforma.
                    </p>
                    <ul class="list-disc list-inside text-gray-700 space-y-2">
                        <li>Você deve ter pelo menos 18 anos para usar a plataforma</li>
                        <li>É obrigatório fornecer informações verdadeiras e atualizadas</li>
                        <li>Apenas contas Gmail são aceitas para registro</li>
                        <li>Um CPF pode ter até 3 cadastros diferentes</li>
                    </ul>
                </div>
            </section>

            <!-- 2. Uso da Plataforma -->
            <section>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">2. Uso da Plataforma</h2>
                <div class="prose prose-gray max-w-none">
                    <p class="text-gray-700 mb-4">
                        A plataforma RAFE é destinada exclusivamente para criação, gerenciamento e participação em rifas legais.
                    </p>
                    
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Permitido:</h3>
                    <ul class="list-disc list-inside text-gray-700 space-y-1 mb-4">
                        <li>Criar rifas para causas sociais e beneficentes</li>
                        <li>Organizar rifas para eventos e celebrações</li>
                        <li>Participar de rifas como comprador</li>
                        <li>Usar ferramentas de marketing fornecidas</li>
                    </ul>

                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Proibido:</h3>
                    <ul class="list-disc list-inside text-gray-700 space-y-1">
                        <li>Rifas com prêmios ilegais ou proibidos</li>
                        <li>Fraude ou manipulação de sorteios</li>
                        <li>Spam ou uso inadequado das ferramentas</li>
                        <li>Violar leis locais ou nacionais</li>
                    </ul>
                </div>
            </section>

            <!-- 3. Responsabilidades -->
            <section>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">3. Responsabilidades do Usuário</h2>
                <div class="prose prose-gray max-w-none">
                    <ul class="list-disc list-inside text-gray-700 space-y-2">
                        <li>Manter suas informações de conta atualizadas</li>
                        <li>Proteger sua senha e não compartilhar com terceiros</li>
                        <li>Cumprir todas as leis aplicáveis às rifas</li>
                        <li>Ser responsável pelo conteúdo que publica</li>
                        <li>Pagar taxas aplicáveis em dia</li>
                    </ul>
                </div>
            </section>

            <!-- 4. Limitações -->
            <section>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">4. Limitações e Restrições</h2>
                <div class="prose prose-gray max-w-none">
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4">
                        <p class="text-yellow-800 font-medium">
                            ⚠️ Ações que podem resultar em suspensão ou bloqueio da conta:
                        </p>
                    </div>
                    <ul class="list-disc list-inside text-gray-700 space-y-2">
                        <li>Fornecimento de informações falsas</li>
                        <li>Tentativas de fraude ou manipulação</li>
                        <li>Uso inadequado das ferramentas da plataforma</li>
                        <li>Violar termos de uso repetidamente</li>
                        <li>Atividades que prejudiquem outros usuários</li>
                    </ul>
                </div>
            </section>

            <!-- 5. Suporte -->
            <section>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">5. Suporte e Contato</h2>
                <div class="prose prose-gray max-w-none">
                    <p class="text-gray-700 mb-4">
                        Nossa equipe está disponível para esclarecer dúvidas sobre estes termos e ajudar com questões técnicas.
                    </p>
                    
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <h3 class="text-lg font-semibold text-blue-800 mb-2">Entre em Contato:</h3>
                        <ul class="text-blue-700 space-y-1">
                            <li>📧 Email: suporte@rafe.com.br</li>
                            <li>📱 WhatsApp: (11) 99999-9999</li>
                            <li>🕒 Horário: Segunda a Sexta, 9h às 18h</li>
                        </ul>
                    </div>
                </div>
            </section>

            <!-- 6. Alterações -->
            <section>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">6. Alterações nos Termos</h2>
                <div class="prose prose-gray max-w-none">
                    <p class="text-gray-700">
                        Reservamo-nos o direito de alterar estes termos a qualquer momento. 
                        Alterações significativas serão comunicadas através da plataforma ou por email.
                    </p>
                </div>
            </section>
        </div>

        <!-- Actions -->
        <div class="mt-8 text-center space-x-4">
            <a href="{{ route('home') }}" 
               class="inline-flex items-center px-6 py-3 bg-purple-600 text-white rounded-lg font-semibold hover:bg-purple-700 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Voltar ao Início
            </a>
            
            <button onclick="window.print()" 
                    class="inline-flex items-center px-6 py-3 bg-gray-600 text-white rounded-lg font-semibold hover:bg-gray-700 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                Imprimir
            </button>
        </div>
    </div>
</div>
@endsection




