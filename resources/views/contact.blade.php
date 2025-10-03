@extends('layouts.app')

@section('content')
<div class="bg-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
                Entre em Contato
            </h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Tem alguma dúvida ou sugestão? Estamos aqui para ajudar! 
                Entre em contato conosco e responderemos o mais rápido possível.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Contact Form -->
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Envie uma Mensagem</h2>
                <form class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nome</label>
                            <input type="text" id="name" name="name" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-agro-green-500 focus:border-agro-green-500" placeholder="Seu nome completo">
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">E-mail</label>
                            <input type="email" id="email" name="email" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-agro-green-500 focus:border-agro-green-500" placeholder="seu@email.com">
                        </div>
                    </div>
                    
                    <div>
                        <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Assunto</label>
                        <select id="subject" name="subject" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-agro-green-500 focus:border-agro-green-500">
                            <option value="">Selecione um assunto</option>
                            <option value="duvida">Dúvida sobre rifas</option>
                            <option value="sugestao">Sugestão</option>
                            <option value="problema">Reportar problema</option>
                            <option value="parceria">Proposta de parceria</option>
                            <option value="outro">Outro</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Mensagem</label>
                        <textarea id="message" name="message" rows="6" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-agro-green-500 focus:border-agro-green-500" placeholder="Digite sua mensagem aqui..."></textarea>
                    </div>
                    
                    <button type="submit" class="w-full bg-agro-green-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-agro-green-700 transition duration-150 ease-in-out">
                        Enviar Mensagem
                    </button>
                </form>
            </div>

            <!-- Contact Information -->
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Informações de Contato</h2>
                
                <div class="space-y-6">
                    <div class="flex items-start">
                        <div class="bg-agro-green-100 p-3 rounded-lg">
                            <svg class="w-6 h-6 text-agro-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-900">E-mail</h3>
                            <p class="text-gray-600">contato@rifassolidarias.com</p>
                            <p class="text-gray-600">suporte@rifassolidarias.com</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="bg-agro-green-100 p-3 rounded-lg">
                            <svg class="w-6 h-6 text-agro-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-900">Telefone</h3>
                            <p class="text-gray-600">(11) 99999-9999</p>
                            <p class="text-gray-600">Segunda a Sexta: 9h às 18h</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="bg-agro-green-100 p-3 rounded-lg">
                            <svg class="w-6 h-6 text-agro-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-900">Endereço</h3>
                            <p class="text-gray-600">São Paulo, SP - Brasil</p>
                            <p class="text-gray-600">Atendimento 100% online</p>
                        </div>
                    </div>
                </div>

                <div class="mt-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Redes Sociais</h3>
                    <div class="flex space-x-4">
                        <a href="#" class="bg-gray-100 p-3 rounded-lg hover:bg-gray-200 transition duration-150 ease-in-out">
                            <svg class="w-6 h-6 text-gray-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                            </svg>
                        </a>
                        <a href="#" class="bg-gray-100 p-3 rounded-lg hover:bg-gray-200 transition duration-150 ease-in-out">
                            <svg class="w-6 h-6 text-gray-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z"/>
                            </svg>
                        </a>
                        <a href="#" class="bg-gray-100 p-3 rounded-lg hover:bg-gray-200 transition duration-150 ease-in-out">
                            <svg class="w-6 h-6 text-gray-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.174-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.099.12.112.225.085.345-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.402.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.357-.629-2.748-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24.009 12.017 24.009c6.624 0 11.99-5.367 11.99-11.988C24.007 5.367 18.641.001 12.017.001z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- FAQ Section -->
        <div class="mt-16">
            <h2 class="text-3xl font-bold text-gray-900 text-center mb-12">Perguntas Frequentes</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Como funciona o sistema de rifas?</h3>
                    <p class="text-gray-600">Nossa plataforma permite criar rifas de forma fácil e segura. Você define o prêmio, o número de bilhetes e o preço, e nós cuidamos do resto.</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Os sorteios são realmente aleatórios?</h3>
                    <p class="text-gray-600">Sim! Utilizamos um sistema de sorteio transparente e auditável, com transmissão ao vivo para garantir a integridade do processo.</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Como recebo meu prêmio?</h3>
                    <p class="text-gray-600">O prêmio é entregue através de transferência bancária ou PIX, conforme acordado no momento da criação da rifa.</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">É seguro participar das rifas?</h3>
                    <p class="text-gray-600">Sim! Todas as transações são protegidas com criptografia e utilizamos sistemas de pagamento confiáveis e seguros.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


