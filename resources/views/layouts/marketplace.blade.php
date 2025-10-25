<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Marketplace de Rifas') - {{ config('app.name', 'Rifassys') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @if(file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
    
    <!-- Additional CSS for marketplace -->
    <style>
        .marketplace-sidebar {
            transition: transform 0.3s ease-in-out;
        }
        
        .marketplace-sidebar.closed {
            transform: translateX(-100%);
        }
        
        .marketplace-content {
            transition: margin-left 0.3s ease-in-out;
        }
        
        .marketplace-content.expanded {
            margin-left: 0;
        }
        
        @media (max-width: 768px) {
            .marketplace-sidebar {
                position: fixed;
                top: 0;
                left: 0;
                height: 100vh;
                z-index: 50;
            }
            
            .marketplace-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen flex">
        <!-- Marketplace Sidebar -->
        <aside id="marketplace-sidebar" class="marketplace-sidebar w-80 bg-white shadow-lg border-r border-gray-200 flex flex-col">
            <!-- Sidebar Header -->
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-r from-purple-500 to-blue-500 rounded-lg flex items-center justify-center">
                            <span class="text-white font-bold text-lg">M</span>
                        </div>
                        <div>
                            <h1 class="text-xl font-bold text-gray-900">Marketplace</h1>
                        </div>
                    </div>
                    <button id="sidebar-toggle" class="lg:hidden p-2 rounded-lg hover:bg-gray-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Sidebar Navigation -->
            <nav class="flex-1 p-6 space-y-2">
                <!-- Main Navigation -->
                <div class="space-y-1">
                    <a href="{{ route('marketplace.index') }}" 
                       class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-purple-50 hover:text-purple-700 transition-colors {{ request()->routeIs('marketplace.index') ? 'bg-purple-100 text-purple-700' : '' }}">
                        <span class="font-medium">Home</span>
                    </a>
                    
                    <a href="{{ route('marketplace.categories') }}" 
                       class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-purple-50 hover:text-purple-700 transition-colors {{ request()->routeIs('marketplace.categories') ? 'bg-purple-100 text-purple-700' : '' }}">
                        <span class="font-medium">Categorias</span>
                    </a>
                    
                    <a href="{{ route('marketplace.search') }}" 
                       class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-purple-50 hover:text-purple-700 transition-colors {{ request()->routeIs('marketplace.search') ? 'bg-purple-100 text-purple-700' : '' }}">
                        <span class="font-medium">Buscar</span>
                    </a>
                    
                    <!-- Filtros como opções de menu -->
                    <a href="{{ route('marketplace.index', ['sort' => 'featured']) }}" 
                       class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-purple-50 hover:text-purple-700 transition-colors {{ request('sort') == 'featured' ? 'bg-purple-100 text-purple-700' : '' }}">
                        <span class="font-medium">Destaques</span>
                    </a>
                    
                    <a href="{{ route('marketplace.index', ['sort' => 'newest']) }}" 
                       class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-purple-50 hover:text-purple-700 transition-colors {{ request('sort') == 'newest' ? 'bg-purple-100 text-purple-700' : '' }}">
                        <span class="font-medium">Mais Recentes</span>
                    </a>
                    
                    <a href="{{ route('marketplace.index', ['sort' => 'ending_soon']) }}" 
                       class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-purple-50 hover:text-purple-700 transition-colors {{ request('sort') == 'ending_soon' ? 'bg-purple-100 text-purple-700' : '' }}">
                        <span class="font-medium">Terminando em Breve</span>
                    </a>
                    
                    <a href="{{ route('marketplace.index', ['sort' => 'progress']) }}" 
                       class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-purple-50 hover:text-purple-700 transition-colors {{ request('sort') == 'progress' ? 'bg-purple-100 text-purple-700' : '' }}">
                        <span class="font-medium">Mais Vendidas</span>
                    </a>
                </div>

                <!-- E-commerce Features -->
                <div class="pt-6">
                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">Loja Virtual</h3>
                    <div class="space-y-1">
                        @auth
                            <a href="{{ route('marketplace.cart') }}" 
                               class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('marketplace.cart') ? 'bg-blue-100 text-blue-700' : '' }}">
                                <span class="font-medium">Carrinho</span>
                                <span id="cart-count" class="ml-auto bg-blue-500 text-white text-xs px-2 py-1 rounded-full">0</span>
                            </a>
                            
                            <a href="{{ route('marketplace.wishlist') }}" 
                               class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-red-50 hover:text-red-700 transition-colors {{ request()->routeIs('marketplace.wishlist') ? 'bg-red-100 text-red-700' : '' }}">
                                <span class="font-medium">Lista de Desejos</span>
                                <span id="wishlist-count" class="ml-auto bg-red-500 text-white text-xs px-2 py-1 rounded-full">0</span>
                            </a>
                        @else
                            <div class="px-4 py-3 text-sm text-gray-500">
                                <a href="{{ route('login') }}" class="text-purple-600 hover:text-purple-700">🔑 Faça login</a> para acessar carrinho
                            </div>
                        @endauth
                    </div>
                </div>


                <!-- Categories Quick Access -->
                <div class="pt-6">
                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">Categorias</h3>
                    <div class="space-y-1">
                        <a href="{{ route('marketplace.category', 'social') }}" 
                           class="flex items-center gap-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-purple-50 hover:text-purple-700 transition-colors text-sm">
                            <span>Social</span>
                        </a>
                        
                        <a href="{{ route('marketplace.category', 'medical') }}" 
                           class="flex items-center gap-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-green-50 hover:text-green-700 transition-colors text-sm">
                            <span>Médico</span>
                        </a>
                        
                        <a href="{{ route('marketplace.category', 'education') }}" 
                           class="flex items-center gap-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-pink-50 hover:text-pink-700 transition-colors text-sm">
                            <span>Educação</span>
                        </a>
                        
                        <a href="{{ route('marketplace.category', 'religious') }}" 
                           class="flex items-center gap-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-blue-50 hover:text-blue-700 transition-colors text-sm">
                            <span>Religioso</span>
                        </a>
                        
                        <a href="{{ route('marketplace.category', 'sports') }}" 
                           class="flex items-center gap-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-orange-50 hover:text-orange-700 transition-colors text-sm">
                            <span>Esportes</span>
                        </a>
                    </div>
                </div>
            </nav>

            <!-- Sidebar Footer -->
            <div class="p-6 border-t border-gray-200">
                <div class="text-center">
                    <p class="text-sm text-gray-500 mb-2">Powered by</p>
                    <div class="flex items-center justify-center gap-2">
                        <div class="w-6 h-6 bg-gradient-to-r from-purple-500 to-blue-500 rounded"></div>
                        <span class="font-semibold text-gray-900">Rifassys</span>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div id="marketplace-content" class="marketplace-content flex-1 flex flex-col">
            <!-- Top Header -->
            <header class="bg-white shadow-sm border-b border-gray-200 px-6 py-4">
                <div class="flex items-center justify-between">
                    <!-- Mobile Menu Button -->
                    <button id="mobile-menu-toggle" class="lg:hidden p-2 rounded-lg hover:bg-gray-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>

                    <!-- Search Bar -->
                    <div class="flex-1 max-w-2xl mx-4">
                        <form action="{{ route('marketplace.search') }}" method="GET" class="relative">
                            <input type="text" 
                                   name="q" 
                                   value="{{ request('q') }}"
                                   placeholder="Buscar rifas..." 
                                   class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </form>
                    </div>

                    <!-- User Actions -->
                    <div class="flex items-center gap-4">
                        @auth
                            <!-- Cart Icon -->
                            <a href="{{ route('marketplace.cart') }}" class="relative p-2 rounded-lg hover:bg-gray-100">
                                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01"></path>
                                </svg>
                                <span id="header-cart-count" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">0</span>
                            </a>

                            <!-- Wishlist Icon -->
                            <a href="{{ route('marketplace.wishlist') }}" class="relative p-2 rounded-lg hover:bg-gray-100">
                                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                                <span id="header-wishlist-count" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">0</span>
                            </a>

                            <!-- User Menu -->
                            <div class="relative">
                                <button id="user-menu-toggle" class="flex items-center gap-2 p-2 rounded-lg hover:bg-gray-100">
                                    <div class="w-8 h-8 bg-gradient-to-r from-purple-500 to-blue-500 rounded-full flex items-center justify-center">
                                        <span class="text-white text-sm font-semibold">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700">{{ auth()->user()->name }}</span>
                                </button>
                                
                                <!-- User Dropdown -->
                                <div id="user-menu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-50">
                                    <a href="{{ route('home') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Dashboard</a>
                                    <a href="{{ route('marketplace.wishlist') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Lista de Desejos</a>
                                    <a href="{{ route('marketplace.cart') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Carrinho</a>
                                    <div class="border-t border-gray-200"></div>
                                    <form method="POST" action="{{ route('logout') }}" class="block">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Sair</button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900 font-medium">Login</a>
                            <a href="{{ route('register') }}" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 font-medium">Cadastrar</a>
                        @endauth
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Sidebar toggle for mobile
            const sidebarToggle = document.getElementById('sidebar-toggle');
            const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
            const sidebar = document.getElementById('marketplace-sidebar');
            const content = document.getElementById('marketplace-content');

            function toggleSidebar() {
                sidebar.classList.toggle('closed');
                content.classList.toggle('expanded');
            }

            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', toggleSidebar);
            }

            if (mobileMenuToggle) {
                mobileMenuToggle.addEventListener('click', toggleSidebar);
            }

            // User menu toggle
            const userMenuToggle = document.getElementById('user-menu-toggle');
            const userMenu = document.getElementById('user-menu');

            if (userMenuToggle && userMenu) {
                userMenuToggle.addEventListener('click', function(e) {
                    e.stopPropagation();
                    userMenu.classList.toggle('hidden');
                });

                // Close user menu when clicking outside
                document.addEventListener('click', function() {
                    userMenu.classList.add('hidden');
                });
            }

            // Load cart and wishlist counts
            loadCartCount();
            loadWishlistCount();

            // Auto-refresh counts every 30 seconds
            setInterval(function() {
                loadCartCount();
                loadWishlistCount();
            }, 30000);
        });

        function loadCartCount() {
            fetch('{{ route("marketplace.cart.count") }}')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('cart-count').textContent = data.cart_count;
                    document.getElementById('header-cart-count').textContent = data.cart_count;
                })
                .catch(error => console.error('Error loading cart count:', error));
        }

        function loadWishlistCount() {
            fetch('{{ route("marketplace.wishlist.count") }}')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('wishlist-count').textContent = data.count;
                    document.getElementById('header-wishlist-count').textContent = data.count;
                })
                .catch(error => console.error('Error loading wishlist count:', error));
        }
    </script>

    @stack('scripts')
</body>
</html>
