<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel del Vendedor - MarketBas</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <nav style="background: #333; color: white; padding: 10px;">
        <a href="{{ route('vendedor.dashboard') }}" style="color: white;">Inicio</a> |
        <a href="{{ route('vendedor.pagos.pendientes') }}" style="color: white;">Pagos</a>
    </nav>

    <div class="container mt-4">
        @yield('content')
    </div>
</body>
</html>
