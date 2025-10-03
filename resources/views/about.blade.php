@extends('layouts.app')

@section('content')
<div class="bg-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
                Sobre Nós
            </h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Somos uma plataforma dedicada a conectar pessoas através de rifas solidárias, 
                transformando sorte em esperança e ajudando causas importantes.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center mb-16">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Nossa Missão</h2>
                <p class="text-lg text-gray-600 mb-6">
                    Acreditamos que pequenas ações podem gerar grandes transformações. 
                    Nossa missão é facilitar a criação e participação em rifas solidárias, 
                    conectando pessoas que querem ajudar com aquelas que precisam de apoio.
                </p>
                <p class="text-lg text-gray-600">
                    Através da nossa plataforma, você pode criar rifas para causas importantes 
                    ou participar de rifas existentes, sabendo que cada número comprado 
                    está fazendo a diferença na vida de alguém.
                </p>
            </div>
            <div class="bg-agro-green-100 rounded-lg p-8">
                <div class="grid grid-cols-2 gap-6 text-center">
                    <div>
                        <div class="text-3xl font-bold text-agro-green-600 mb-2">500+</div>
                        <div class="text-gray-600">Rifas Criadas</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-agro-green-600 mb-2">10k+</div>
                        <div class="text-gray-600">Participantes</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-agro-green-600 mb-2">R$ 50k+</div>
                        <div class="text-gray-600">Arrecadado</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-agro-green-600 mb-2">100+</div>
                        <div class="text-gray-600">Causas Apoiadas</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-6">Nossos Valores</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="bg-agro-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-agro-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Solidariedade</h3>
                    <p class="text-gray-600">Acreditamos no poder da ajuda mútua e na importância de apoiar quem precisa.</p>
                </div>
                <div class="text-center">
                    <div class="bg-agro-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-agro-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Transparência</h3>
                    <p class="text-gray-600">Todas as nossas operações são transparentes e auditáveis pelos participantes.</p>
                </div>
                <div class="text-center">
                    <div class="bg-agro-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-agro-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Agilidade</h3>
                    <p class="text-gray-600">Processos rápidos e eficientes para que você possa focar no que realmente importa.</p>
                </div>
            </div>
        </div>

        <div class="bg-gray-50 rounded-lg p-8 text-center">
            <h2 class="text-3xl font-bold text-gray-900 mb-6">Junte-se à Nossa Causa</h2>
            <p class="text-xl text-gray-600 mb-8 max-w-3xl mx-auto">
                Seja parte de uma comunidade que acredita no poder da solidariedade. 
                Crie sua conta hoje e comece a fazer a diferença!
            </p>
            <a href="/register" class="bg-agro-green-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-agro-green-700 transition duration-150 ease-in-out">
                Criar Conta Gratuita
            </a>
        </div>
    </div>
</div>
@endsection


