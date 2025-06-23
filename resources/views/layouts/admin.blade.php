<!-- resources/views/layouts/admin.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Panel Admin - MarketBas</title>
</head>
<body>
    <header>
        <h1>Panel de Administrador</h1>
        <nav>
            <a href="{{ route('admin.pedidos.index') }}">Pedidos</a> |
            <a href="{{ route('admin.pagos.index') }}">Pagos</a> |
            <a href="{{ route('admin.negocios.index') }}">Negocios</a>
        </nav>
        <hr>
    </header>

    <main>
        @yield('content')
    </main>
</body>
</html>
