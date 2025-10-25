<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Marketplace de Rifas - Rifassys</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-r from-purple-500 to-blue-500 rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold text-lg">🏪</span>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-900">Marketplace</h1>
                        <p class="text-sm text-gray-500">Rifas Solidárias</p>
                    </div>
                </div>
                <nav class="flex gap-4">
                    <a href="/marketplace" class="text-gray-600 hover:text-purple-600">Home</a>
                    <a href="/marketplace/categories" class="text-gray-600 hover:text-purple-600">Categorias</a>
                    <a href="/marketplace/search" class="text-gray-600 hover:text-purple-600">Buscar</a>
                </nav>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Hero Section -->
        <section class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Marketplace de Rifas</h1>
            <p class="text-xl text-gray-600 mb-8">Descubra, compare e participe das melhores rifas do Brasil</p>
            <div class="flex gap-4 justify-center">
                <a href="/marketplace/categories" class="bg-purple-600 text-white px-6 py-3 rounded-lg hover:bg-purple-700">
                    Ver Categorias
                </a>
                <a href="/marketplace/search" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700">
                    Buscar Rifas
                </a>
            </div>
        </section>

        <!-- Stats -->
        <section class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            <div class="bg-white p-6 rounded-lg shadow">
                <div class="text-3xl font-bold text-purple-600 mb-2">2.5K+</div>
                <div class="text-gray-600">Rifas Realizadas</div>
            </div>
            <div class="bg-white p-6 rounded-lg shadow">
                <div class="text-3xl font-bold text-blue-600 mb-2">15K+</div>
                <div class="text-gray-600">Participantes</div>
            </div>
            <div class="bg-white p-6 rounded-lg shadow">
                <div class="text-3xl font-bold text-green-600 mb-2">98.7%</div>
                <div class="text-gray-600">Taxa de Sucesso</div>
            </div>
        </section>

        <!-- Quick Links -->
        <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <a href="/marketplace/category/social" class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition-shadow">
                <h3 class="text-lg font-semibold mb-2">Social</h3>
                <p class="text-gray-600 text-sm">Causas sociais e comunitárias</p>
            </a>
            <a href="/marketplace/category/medical" class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition-shadow">
                <h3 class="text-lg font-semibold mb-2">Médico</h3>
                <p class="text-gray-600 text-sm">Tratamentos e cirurgias</p>
            </a>
            <a href="/marketplace/category/education" class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition-shadow">
                <h3 class="text-lg font-semibold mb-2">Educação</h3>
                <p class="text-gray-600 text-sm">Projetos educacionais</p>
            </a>
            <a href="/marketplace/category/religious" class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition-shadow">
                <h3 class="text-lg font-semibold mb-2">Religioso</h3>
                <p class="text-gray-600 text-sm">Eventos e atividades</p>
            </a>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="text-center">
                <p class="text-gray-400">© 2025 Rifassys - Marketplace de Rifas Solidárias</p>
            </div>
        </div>
    </footer>
</body>
</html>
