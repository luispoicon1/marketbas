<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'MarketBas') }}</title>

    <!-- Fuentes -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
            @apply bg-white text-gray-800;
        }
        
        /* Transiciones suaves */
        .transition-smooth {
            transition: all 0.3s cubic-bezier(0, 0, 139, 0.1);
        }
        
        /* Efecto hover para botones */
        .btn-hover {
            @apply transition-smooth hover:opacity-90;
        }
        
        /* Efecto sombra para navbar */
        .nav-shadow {
            box-shadow: 0 4px 20px rgba(255, 255, 255, 0.1);
        }
        
        /* Color azul marino */
        .bg-navy {
            background-color:rgb(255, 255, 255);
        }
        .bg-navy-light {
            background-color:rgb(255, 255, 255);
        }
        .bg-navy-dark {
            background-color:rgb(255, 255, 255);
        }
        .text-navy {
            color:rgb(0, 0, 0);
        }
        .border-navy {
            border-color:rgb(199, 199, 199);
        }
    </style>
</head>
<body class="antialiased">
    <!-- Navbar Azul Marino -->
    <nav class="bg-navy nav-shadow sticky top-0 w-full z-50 border-b border-navy-dark">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo y menú principal -->
                <div class="flex items-center space-x-10">
                    <!-- Logo -->
                    <a href="{{ url('/') }}" class="flex items-center space-x-2 btn-hover">
                       <img src="{{ asset('img/logobas2.png') }}" alt="Logo MarketBas" class="h-7 w-14">
                        <span class="text-xl font-bold text-[#004225]">MARKETBAS</span>
                    </a>
                    
                    <!-- Menú principal -->
                    <div class="hidden md:flex items-center space-x-8">
                        <a href="{{ url('/') }}" class="text-white font-medium hover:text-blue-200 transition-smooth"></a>
                        <a href="#" class="text-blue-100 hover:text-white transition-smooth"></a>
                        <a href="#" class="text-blue-100 hover:text-white transition-smooth"></a>
                        <a href="#" class="text-blue-100 hover:text-white transition-smooth"></a>
                        <a href="#" class="text-blue-100 hover:text-white transition-smooth"></a>
                    </div>
                </div>

                <!-- Menú de usuario y carrito -->         
<div class="flex items-center space-x-6">

    <!-- Botón Premium -->
    @auth
    @if (auth()->user()->esCompradorPremium())
        <div class="text-green-700 font-bold">
            💎 Ya eres suscriptor premium
        </div>
    @else
    <a href="{{ route('suscripcion.formulario') }}"
           class="hidden md:inline-block bg-yellow-400 hover:bg-yellow-200 text-black font-semibold px-4 py-2 rounded-lg shadow-sm transition-smooth">
            💎 Hazte Premium
        </a>

    @endif
@endauth

                    <!-- Botón Carrito -->
<a href="{{ route('pedido.carrito') }}" class="relative inline-flex items-center justify-center text-black hover:text-yellow-900 transition-smooth">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 9m13-9l2 9m-5-4a1 1 0 100 2 1 1 0 000-2zm-6 0a1 1 0 100 2 1 1 0 000-2z" />
    </svg>
    <span class="sr-only">Carrito</span>
</a>
                    @auth
                    <!-- Menú desplegable usuario -->
                    <div class="relative ml-3" x-data="{ open: false }">
                        <div>
                            <button @click="open = !open" type="button" class="flex items-center max-w-xs rounded-full focus:outline-none group" id="user-menu">
                                <span class="sr-only">Abrir menú de usuario</span>
                                <span class="text-text-[#004225] group-hover:text-[#004225] mr-2 hidden md:inline transition-smooth">Hola, {{ Str::limit(auth()->user()->name, 15) }}</span>
                                <div class="h-9 w-9 rounded-full bg-white flex items-center justify-center text-navy font-semibold shadow-sm group-hover:bg-blue-200 transition-smooth">
                                    {{ Str::upper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                            </button>
                        </div>
                        
                        
                        <!-- Menú desplegable -->
                        <div x-show="open" @click.away="open = false" 
                             class="origin-top-right absolute right-0 mt-2 w-48 rounded-lg shadow-lg bg-white border border-gray-200 focus:outline-none transition-smooth"
                             role="menu" aria-orientation="vertical" aria-labelledby="user-menu">
                            <div class="py-1" role="none">
                                <!-- Enlace a perfil -->
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 hover:text-navy transition-smooth flex items-center gap-2" role="menuitem">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
    </svg>
    Mi Perfil
</a>
                
                                <!-- Botón de logout -->
                                <form method="POST" action="{{ route('logout') }}" role="none">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 hover:text-navy transition-smooth flex items-center gap-2" role="menuitem">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        Cerrar sesión
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @else
                    <!-- Botones de login/register -->
                    <div class="hidden md:flex items-center space-x-3">
                        <a href="{{ route('login') }}" class="px-4 py-2 text-white font-medium hover:text-blue-200 transition-smooth">Iniciar sesión</a>
                        <a href="{{ route('register') }}" class="px-4 py-2 bg-white text-navy rounded-lg font-medium hover:bg-blue-100 transition-smooth">Registrarse</a>
                    </div>
                    @endauth
                    
                    <!-- Botón móvil -->
                    <button class="md:hidden p-2 text-blue-100 hover:text-white focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Contenido principal -->
    <main class="min-h-screen pb-12">
        @yield('content')
    </main>

    <!-- Footer -->
<footer class="bg-gray-800 text-white pt-12 pb-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Logo y descripción -->
            <div class="space-y-4">
                <div class="flex items-center space-x-2">
                    <img src="{{ asset('img/logobas.png') }}" alt="Logo MarketBas" class="h-12 w-16">
                    <span class="text-2xl font-bold text-white">MarketBas</span>
                </div>
                <p class="text-gray-300">
                    El mercado de abastos de Chincha con los mejores productos frescos y de calidad.
                </p>
                <div class="pt-2">
                    <a href="#" class="text-gray-300 hover:text-white transition duration-300 flex items-center gap-2">
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                        </svg>
                        <span>Síguenos en Facebook</span>
                    </a>
                </div>
            </div>

            <!-- Enlaces rápidos -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold">Navegación</h3>
                <ul class="space-y-2">
                    <li><a href="{{ url('/') }}" class="block text-gray-300 hover:text-white transition duration-300">Inicio</a></li>
                    <li><a href="#" class="block text-gray-300 hover:text-white transition duration-300">Productos</a></li>
                    <li><a href="#" class="block text-gray-300 hover:text-white transition duration-300">Categorías</a></li>
                    <li><a href="#" class="block text-gray-300 hover:text-white transition duration-300">Ofertas</a></li>
                </ul>
            </div>

            <!-- Información de contacto -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold">Contacto</h3>
                <ul class="space-y-3">
                    <li class="flex items-start gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span class="text-gray-300">Av. Principal, Mercado de Abastos, Chincha</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <span class="text-gray-300">contacto@marketbas.com</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        <span class="text-gray-300">+51 937 212 007</span>
                    </li>
                </ul>
            </div>

            <!-- Horario de atención -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold">Horario</h3>
                <ul class="space-y-2 text-gray-300">
                    <li class="flex justify-between">
                        <span>Lunes - Viernes:</span>
                        <span>8:00 - 20:00</span>
                    </li>
                    <li class="flex justify-between">
                        <span>Sábados:</span>
                        <span>9:00 - 18:00</span>
                    </li>
                    <li class="flex justify-between">
                        <span>Domingos:</span>
                        <span>10:00 - 15:00</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Derechos reservados -->
        <div class="mt-12 pt-6 border-t border-gray-700 text-center">
            <p class="text-sm text-gray-400">
                &copy; {{ date('Y') }} MarketBas - Mercado de Abastos de Chincha. Todos los derechos reservados.
            </p>
            <p class="text-xs text-gray-500 mt-1">
                Desde Chincha para el Perú ❤️
            </p>
        </div>
    </div>
</footer>

    <!-- Alpine JS para funcionalidad del menú -->
    <script src="//unpkg.com/alpinejs" defer></script>
    
    <!-- Script para menú móvil -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.querySelector('nav button.md\\:hidden');
            const mobileMenu = document.querySelector('nav .md\\:hidden');
            
            mobileMenuButton.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
            });
        });
    </script>
</body>
</html>