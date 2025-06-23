<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Delivery - MarketBas</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js']) {{-- si usas Vite --}}
</head>
<body>
    <div class="d-flex" style="min-height: 100vh;">
        {{-- Sidebar --}}
        <div class="bg-dark text-white p-3" style="width: 250px;">
            <h4 class="mb-4">MarketBas Delivery</h4>
            <ul class="nav flex-column">
                <li class="nav-item mb-2">
                    <a class="nav-link text-white" href="{{ route('delivery.pedidos') }}">
                        <i class="fas fa-truck"></i> Pedidos asignados
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link text-white" href="{{ route('delivery.historial') }}">
                        <i class="fas fa-box-open"></i> Historial de entregas
                    </a>
                </li>
                <li class="nav-item mt-4">
                    <a class="nav-link text-white" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i> Cerrar sesión
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>

        {{-- Contenido principal --}}
        <div class="flex-grow-1 p-4">
            @yield('content')
        </div>
    </div>
</body>
</html>
