<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'RAFE') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=roboto:300,400,500,700" rel="stylesheet" />

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Tailwind Config -->
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        'purple': {
                            50: '#faf5ff',
                            100: '#f3e8ff',
                            200: '#e9d5ff',
                            300: '#d8b4fe',
                            400: '#c084fc',
                            500: '#a855f7',
                            600: '#9333ea',
                            700: '#7c3aed',
                            800: '#6b21a8',
                            900: '#581c87',
                        }
                    }
                }
            }
        }
    </script>
    
    <style>
        body { font-family: 'Roboto', sans-serif; }
        
        /* Animations */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        @keyframes particle-float {
            0%, 100% { transform: translateY(0px) rotate(0deg); opacity: 0.7; }
            50% { transform: translateY(-100px) rotate(180deg); opacity: 1; }
        }
        
        .animate-float { animation: float 6s ease-in-out infinite; }
        .animate-fadeInUp { animation: fadeInUp 0.8s ease-out; }
        .animate-pulse-slow { animation: pulse 3s ease-in-out infinite; }
        
        /* Particle effects */
        .particle {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: particle-float 8s linear infinite;
        }
        
        .particle:nth-child(1) { width: 4px; height: 4px; left: 10%; animation-delay: 0s; }
        .particle:nth-child(2) { width: 6px; height: 6px; left: 20%; animation-delay: 1s; }
        .particle:nth-child(3) { width: 3px; height: 3px; left: 30%; animation-delay: 2s; }
        .particle:nth-child(4) { width: 5px; height: 5px; left: 40%; animation-delay: 3s; }
        .particle:nth-child(5) { width: 4px; height: 4px; left: 50%; animation-delay: 4s; }
        .particle:nth-child(6) { width: 7px; height: 7px; left: 60%; animation-delay: 5s; }
        .particle:nth-child(7) { width: 3px; height: 3px; left: 70%; animation-delay: 6s; }
        .particle:nth-child(8) { width: 5px; height: 5px; left: 80%; animation-delay: 7s; }
        .particle:nth-child(9) { width: 4px; height: 4px; left: 90%; animation-delay: 8s; }
        
        /* Hover effects */
        .hover-scale:hover { transform: scale(1.05); transition: transform 0.3s ease; }
        .hover-lift:hover { transform: translateY(-5px); transition: transform 0.3s ease; }
        
        /* Gradient backgrounds */
        .gradient-purple-blue {
            background: linear-gradient(135deg, #a855f7 0%, #3b82f6 100%);
        }
        
        .gradient-purple-blue-dark {
            background: linear-gradient(135deg, #9333ea 0%, #1d4ed8 100%);
        }
        
        /* Scroll animations */
        .scroll-animate {
            opacity: 0;
            transform: translateY(50px);
            transition: all 0.8s ease;
        }
        
        .scroll-animate.animate {
            opacity: 1;
            transform: translateY(0);
        }
        
        /* Header always white background with black text */
        #header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        }
        
        /* Header text always black */
        .header-text {
            color: #1f2937 !important;
        }
        
        .header-link {
            color: #4b5563 !important;
        }
        
        .header-link:hover {
            color: #1f2937 !important;
        }
    </style>
</head>
<body class="font-roboto bg-gray-50 text-gray-900">
    <!-- Header -->
    <header id="header" class="fixed top-0 left-0 right-0 z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-3">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="text-2xl font-bold header-text text-white">
                        RAFE
                    </a>
                </div>
                
                <!-- Navigation -->
                <nav class="hidden md:flex space-x-8">
                        <a href="{{ route('home') }}" class="header-link text-white hover:text-purple-300 transition-colors">Home</a>
                        <a href="{{ route('raffles.index') }}" class="header-link text-white hover:text-purple-300 transition-colors">Marketplace</a>
                        <a href="{{ route('about') }}" class="header-link text-white hover:text-purple-300 transition-colors">Sobre Nós</a>
                        <a href="{{ route('contact') }}" class="header-link text-white hover:text-purple-300 transition-colors">Contato</a>
                </nav>
                
                <!-- Auth Buttons / User Menu -->
                <div class="flex items-center space-x-4">
                    @guest
                    <!-- Not logged in -->
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('login') }}" class="header-link text-white hover:text-purple-300 transition-colors">Login</a>
                        <a href="{{ route('register') }}" class="bg-purple-600 text-white px-6 py-2 rounded-lg font-medium hover:bg-purple-700 transition-colors">
                            CADASTRAR
                        </a>
                    </div>
                    @else
                    <!-- Logged in user menu -->
                    <div class="flex items-center space-x-4">
                        <!-- Shopping Cart -->
                        <a href="{{ route('cart.index') }}" id="cart-button" class="relative header-link text-white hover:text-purple-300 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                            <span id="cart-count" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center hidden">0</span>
                        </a>
                        
                        <!-- Organizador Button -->
                        <button class="bg-gradient-to-r from-purple-600 to-blue-600 text-white px-4 py-2 rounded-lg font-medium hover:from-purple-700 hover:to-blue-700 transition-all duration-200 flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            <span class="hidden sm:inline">Organizador</span>
                        </button>
                        
                        <!-- Settings Icon -->
                        <button class="header-link text-white hover:text-purple-300 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </button>
                        
                        <!-- User Avatar & Email -->
                        <div class="relative">
                            <button id="user-dropdown-button" class="flex items-center space-x-2 header-link text-white hover:text-purple-300 transition-colors">
                                <img id="user-avatar" src="{{ 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=667eea&color=ffffff&size=32' }}" alt="User Avatar" class="w-8 h-8 rounded-full">
                                <span id="user-name" class="text-sm font-medium">{{ Auth::user()->name }}</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            
                            <!-- User Dropdown Menu -->
                            <div id="user-dropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-1 z-50">
                                <div class="px-4 py-2 border-b border-gray-200">
                                    <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                                </div>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Minha Conta</a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Minhas Rifas</a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Histórico</a>
                                <hr class="my-1">
                                <form method="POST" action="{{ route('logout') }}" class="block">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Sair</button>
                </form>
                            </div>
                        </div>
                    </div>
                    @endguest
                </div>
                
                <!-- Mobile menu button -->
                <button id="mobile-menu-button" class="md:hidden text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
        
        <!-- Mobile Menu -->
        <div id="mobile-menu" class="md:hidden bg-white border-t border-gray-200 hidden">
            <div class="px-4 py-4 space-y-4">
                <a href="{{ route('home') }}" class="block text-gray-700 hover:text-purple-600 transition-colors">Home</a>
                <a href="{{ route('raffles.index') }}" class="block text-gray-700 hover:text-purple-600 transition-colors">Marketplace</a>
                <a href="{{ route('about') }}" class="block text-gray-700 hover:text-purple-600 transition-colors">Sobre Nós</a>
                <a href="{{ route('contact') }}" class="block text-gray-700 hover:text-purple-600 transition-colors">Contato</a>
                
                @guest
                <!-- Mobile Auth Section -->
                <div class="pt-4 border-t border-gray-200 space-y-2">
                    <a href="{{ route('login') }}" class="block text-gray-700 hover:text-purple-600 transition-colors">Login</a>
                    <a href="{{ route('register') }}" class="block bg-purple-600 text-white px-4 py-2 rounded-lg font-medium text-center hover:bg-purple-700 transition-colors">
                        CADASTRAR
                    </a>
                </div>
                @else
                <!-- Mobile User Menu -->
                <div class="pt-4 border-t border-gray-200 space-y-2">
                    <div class="flex items-center space-x-3 pb-2">
                        <img src="{{ 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=667eea&color=ffffff&size=40' }}" alt="User Avatar" class="w-10 h-10 rounded-full">
                        <div>
                            <p class="font-medium text-gray-900">{{ Auth::user()->name }}</p>
                            <p class="text-sm text-gray-500">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                    <button class="w-full bg-gradient-to-r from-purple-600 to-blue-600 text-white px-4 py-3 rounded-lg font-medium hover:from-purple-700 hover:to-blue-700 transition-all duration-200 flex items-center justify-center space-x-2 mb-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        <span>Organizador</span>
                    </button>
                    <a href="#" class="block text-gray-700 hover:text-purple-600 transition-colors">Minha Conta</a>
                    <a href="#" class="block text-gray-700 hover:text-purple-600 transition-colors">Minhas Rifas</a>
                    <a href="#" class="block text-gray-700 hover:text-purple-600 transition-colors">Histórico</a>
                    <a href="{{ route('logout') }}" class="block text-gray-700 hover:text-purple-600 transition-colors">Sair</a>
                </div>
                @endguest
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="pt-16">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Plataforma -->
                <div>
                    <h3 class="text-sm font-semibold mb-4">Plataforma</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-300 hover:text-white text-sm transition-colors">Sobre nós</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white text-sm transition-colors">Blog</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white text-sm transition-colors">Carreiras</a></li>
                        <li><a href="{{ route('contact') }}" class="text-gray-300 hover:text-white text-sm transition-colors">Contato</a></li>
                    </ul>
                </div>
                
                <!-- Recursos -->
                <div>
                    <h3 class="text-sm font-semibold mb-4">Recursos</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-300 hover:text-white text-sm transition-colors">Central de Ajuda</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white text-sm transition-colors">Termos de Uso</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white text-sm transition-colors">Política de Privacidade</a></li>
                    </ul>
                </div>
                
                <!-- Para Organizadores -->
                <div>
                    <h3 class="text-sm font-semibold mb-4">Para Organizadores</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-300 hover:text-white text-sm transition-colors">Criar Rifa</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white text-sm transition-colors">Planos</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white text-sm transition-colors">API</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white text-sm transition-colors">Documentação</a></li>
                    </ul>
                </div>
                
                <!-- Contato -->
                <div>
                    <h3 class="text-sm font-semibold mb-4">Contato</h3>
                    <div class="space-y-3">
                        <div class="flex items-center gap-2">
                            <span class="text-gray-400">📧</span>
                            <a href="mailto:contato@rifasolidaria.com" class="text-gray-300 hover:text-white text-sm transition-colors">
                                contato@rifasolidaria.com
                            </a>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-gray-400">📱</span>
                            <a href="https://wa.me/5511999999999" class="text-gray-300 hover:text-white text-sm transition-colors">
                                (11) 99999-9999
                            </a>
                        </div>
                        <div class="flex gap-3 mt-4">
                            <a href="#" class="text-gray-400 hover:text-white transition-colors">
                                <span class="sr-only">Facebook</span>
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-white transition-colors">
                                <span class="sr-only">Instagram</span>
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 6.62 5.367 11.987 11.988 11.987 6.62 0 11.987-5.367 11.987-11.987C24.014 5.367 18.637.001 12.017.001zM8.449 16.988c-1.297 0-2.448-.49-3.323-1.297C4.198 14.895 3.708 13.744 3.708 12.447s.49-2.448 1.297-3.323c.875-.807 2.026-1.297 3.323-1.297s2.448.49 3.323 1.297c.807.875 1.297 2.026 1.297 3.323s-.49 2.448-1.297 3.323c-.875.807-2.026 1.297-3.323 1.297zm7.718-1.297c-.875.807-2.026 1.297-3.323 1.297s-2.448-.49-3.323-1.297c-.807-.875-1.297-2.026-1.297-3.323s.49-2.448 1.297-3.323c.875-.807 2.026-1.297 3.323-1.297s2.448.49 3.323 1.297c.807.875 1.297 2.026 1.297 3.323s-.49 2.448-1.297 3.323z"/>
                                </svg>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-white transition-colors">
                                <span class="sr-only">LinkedIn</span>
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 c0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Copyright -->
            <div class="mt-8 pt-8 border-t border-gray-800">
                <div class="text-center space-y-2">
                           <p class="text-gray-400 text-xs sm:text-sm">
                               © {{ date('Y') }} RAFE. Todos os direitos reservados.
                           </p>
                           <p class="text-gray-500 text-xs">
                               A plataforma completa para rifas online
                           </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const header = document.getElementById('header');
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');


            // Mobile menu toggle
            mobileMenuButton.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
            });

            // Scroll animations
            function animateOnScroll() {
                const elements = document.querySelectorAll('.scroll-animate');
                
                elements.forEach(element => {
                    const elementTop = element.getBoundingClientRect().top;
                    const elementVisible = 150;
                    
                    if (elementTop < window.innerHeight - elementVisible) {
                        element.classList.add('animate');
                    }
                });
            }

            // FAQ accordion functionality
            function initFAQ() {
                const faqButtons = document.querySelectorAll('.faq-button');
                
                faqButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const content = this.nextElementSibling;
                        const icon = this.querySelector('.faq-icon');
                        
                        if (content && content.classList.contains('hidden')) {
                            // Close all other FAQ items
                            document.querySelectorAll('.faq-content').forEach(item => {
                                if (item !== content) {
                                    item.classList.add('hidden');
                                    item.previousElementSibling.querySelector('.faq-icon').textContent = '+';
                                }
                            });
                            
                            // Toggle current item
                            content.classList.remove('hidden');
                            icon.textContent = '−';
                        } else if (content) {
                            content.classList.add('hidden');
                            icon.textContent = '+';
                        }
                    });
                });
            }

            // Smooth scroll for anchor links
            function initSmoothScroll() {
                document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                    anchor.addEventListener('click', function (e) {
                        e.preventDefault();
                        const target = document.querySelector(this.getAttribute('href'));
                        if (target) {
                            target.scrollIntoView({
                                behavior: 'smooth',
                                block: 'start'
                            });
                        }
                    });
                });
            }

        // User dropdown functionality
        function initUserDropdown() {
            const userDropdownButton = document.getElementById('user-dropdown-button');
            const userDropdown = document.getElementById('user-dropdown');
            
            if (userDropdownButton && userDropdown) {
                userDropdownButton.addEventListener('click', function(e) {
                    e.stopPropagation();
                    userDropdown.classList.toggle('hidden');
                });
                
                // Close dropdown when clicking outside
                document.addEventListener('click', function(e) {
                    if (!userDropdownButton.contains(e.target) && !userDropdown.contains(e.target)) {
                        userDropdown.classList.add('hidden');
                    }
                });
            }
        }
        
        // Cart functionality
        function initCart() {
            const cartCount = document.getElementById('cart-count');
            
            function updateCartDisplay() {
                fetch('{{ route("cart.count") }}')
                    .then(response => response.json())
                    .then(data => {
                        if (data.count > 0) {
                            cartCount.textContent = data.count;
                            cartCount.classList.remove('hidden');
                        } else {
                            cartCount.classList.add('hidden');
                        }
                    })
                    .catch(error => {
                        console.error('Error loading cart count:', error);
                    });
            }
            
            // Update cart display on page load
            updateCartDisplay();
        }
        
        // Function to add item to cart (for testing)
        window.addToCart = function() {
            const cartCount = document.getElementById('cart-count');
            if (cartCount) {
                let currentCount = parseInt(cartCount.textContent) || 0;
                currentCount++;
                cartCount.textContent = currentCount;
                cartCount.classList.remove('hidden');
            }
        };

        // Initialize all functionality
        animateOnScroll();
        initFAQ();
        initSmoothScroll();
        initUserDropdown();
        initCart();
        
        // Animate on scroll
        window.addEventListener('scroll', animateOnScroll);
        
        // Initial animation check
        setTimeout(animateOnScroll, 100);
        });
    </script>

    <!-- Notification System -->
    <div id="notification-container" class="fixed top-4 right-4 z-50 space-y-2">
        <!-- Notifications will be added here dynamically -->
    </div>

    <!-- Notification Script -->
    <script>
        // Notification system
        function showNotification(message, type = 'error', duration = 5000) {
            const container = document.getElementById('notification-container');
            
            // Create notification element
            const notification = document.createElement('div');
            notification.className = `notification bg-white rounded-lg shadow-lg border-l-4 p-4 max-w-sm transform translate-x-full transition-transform duration-300 ease-in-out ${
                type === 'error' ? 'border-red-500' : 
                type === 'success' ? 'border-green-500' : 
                type === 'warning' ? 'border-yellow-500' : 'border-blue-500'
            }`;
            
            // Create icon based on type
            let icon = '';
            if (type === 'error') {
                icon = `<svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>`;
            } else if (type === 'success') {
                icon = `<svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>`;
            } else if (type === 'warning') {
                icon = `<svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.268 18.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>`;
            } else {
                icon = `<svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>`;
            }
            
            notification.innerHTML = `
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0">
                        ${icon}
                    </div>
                    <div class="flex-1">
                        <div class="text-sm font-medium text-gray-900">${message}</div>
                    </div>
                    <div class="flex-shrink-0">
                        <button onclick="closeNotification(this)" class="text-gray-400 hover:text-gray-600 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            `;
            
            // Add to container
            container.appendChild(notification);
            
            // Animate in
            setTimeout(() => {
                notification.classList.remove('translate-x-full');
            }, 100);
            
            // Auto remove after duration
            if (duration > 0) {
                setTimeout(() => {
                    closeNotification(notification.querySelector('button'));
                }, duration);
            }
        }
        
        function closeNotification(button) {
            const notification = button.closest('.notification');
            notification.classList.add('translate-x-full');
            setTimeout(() => {
                notification.remove();
            }, 300);
        }
        
        // Make functions globally available
        window.showNotification = showNotification;
        window.closeNotification = closeNotification;
        
        // Show notifications from Laravel session
        @if(session('error'))
            showNotification('{{ session('error') }}', 'error');
        @endif
        
        @if(session('success'))
            showNotification('{{ session('success') }}', 'success');
        @endif
        
        @if(session('warning'))
            showNotification('{{ session('warning') }}', 'warning');
        @endif
    </script>
    
    <!-- WhatsApp Integration -->
    <script src="{{ asset('js/whatsapp-integrator.js') }}"></script>
    <script src="{{ asset('js/rifassys-events.js') }}"></script>
    <script src="{{ asset('js/whatsapp-examples.js') }}"></script>
    
    <script>
        // WhatsApp integration functions
        document.addEventListener('DOMContentLoaded', function() {
            console.log('WhatsApp integration scripts loaded - ready to use when needed');
        });
        
        // Global functions for easy access from other scripts
        function testarWhatsApp() {
            if (window.enviarVerificacaoCliente) {
                window.enviarVerificacaoCliente({
                    numeroWhatsApp: '5511999999999',
                    nome: 'Teste',
                    linkVerificacao: 'https://localhost:8084/verificar/teste'
                });
            }
        }
        
        // Function to initialize WhatsApp when needed
        function inicializarWhatsAppQuandoNecessario() {
            if (window.inicializarWhatsApp) {
                window.inicializarWhatsApp();
                console.log('WhatsApp initialized on demand');
            }
        }
    </script>
</body>
</html>