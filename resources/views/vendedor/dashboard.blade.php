@extends('layouts.app')

@section('content')
<style>
    body {
        background-color: #f4f6f9;
        font-family: 'Segoe UI', sans-serif;
    }

    .container {
        max-width: 1000px;
        margin: 30px auto;
        padding: 20px;
    }

    h2 {
        font-size: 1.8rem;
        color: #333;
        margin-bottom: 20px;
        text-align: center;
    }

    .btn-primary {
        display: inline-block;
        padding: 10px 20px;
        background-color: #ffeb3b; /* amarillo */
        color: #333;
        border-radius: 6px;
        text-decoration: none;
        font-weight: bold;
        transition: background 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #fdd835;
    }

    .alert-success {
        color: green;
        text-align: center;
        margin-bottom: 20px;
    }

    .card {
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        padding: 20px;
        margin-bottom: 30px;
    }

    .card h4 {
        font-size: 1.2rem;
        color: #444;
        margin-bottom: 15px;
        border-left: 4px solid #ffeb3b;
        padding-left: 10px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
        font-size: 0.95rem;
    }

    th, td {
        padding: 12px 15px;
        text-align: left;
        border: 1px solid #ddd;
    }

    th {
        background-color: #fafafa;
        color: #555;
    }

    ul {
        list-style-type: none;
        padding-left: 0;
        margin: 0;
    }

    li {
        padding: 2px 0;
    }

    a.btn-sm {
        display: inline-block;
        padding: 6px 12px;
        font-size: 0.85rem;
        color: #4caf50;
        border: 1px solid #4caf50;
        border-radius: 5px;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    a.btn-sm:hover {
        background-color: #e8f5e9;
    }

    form button[type="submit"] {
        background: none;
        border: none;
        color: #f44336;
        cursor: pointer;
        font-size: 0.9rem;
    }

    form button[type="submit"]:hover {
        text-decoration: underline;
    }

    .empty-message {
        color: #888;
        font-style: italic;
        text-align: center;
        padding: 20px;
    }
</style>

<div class="container">
    <h2>Dashboard de {{ $negocio->nombre }}</h2>

    <div style="text-align:center; margin-bottom: 30px;">
        <a href="{{ route('vendedor.productos.index') }}" class="btn-primary">
            Gestionar Productos
        </a>
    </div>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    <!-- Pedidos Recibidos -->
    <div class="card">
        <h4>Pedidos Recibidos</h4>
        @if($subpedidos->isEmpty())
            <p class="empty-message">No tienes pedidos aún.</p>
        @else
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Cliente</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach($subpedidos as $sp)
                <tr>
                    <td>{{ $sp->id }}</td>
                    <td>{{ $sp->pedido->usuario->name }}</td>
                    <td>S/ {{ number_format($sp->subtotal, 2) }}</td>
                    <td>{{ ucfirst($sp->estado) }}</td>
                    <td>
                        <a href="{{ route('vendedor.pedido.ver', $sp->id) }}">Ver detalles</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

    <!-- Pagos Pendientes -->
    <div class="card">
        <h4>Pagos pendientes de aprobación</h4>
        @if($pagosPendientes->isEmpty())
            <p class="empty-message">No hay pagos pendientes.</p>
        @else
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Cliente</th>
                    <th>Monto</th>
                    <th>Comprobante</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pagosPendientes as $pago)
                <tr>
                    <td>{{ $pago->id }}</td>
                    <td>{{ $pago->subpedido->pedido->usuario->name }}</td>
                    <td>S/ {{ number_format($pago->monto, 2) }}</td>
                    <td>
                        <a href="{{ asset('storage/' . $pago->comprobante) }}" target="_blank">Ver comprobante</a>
                    </td>
                    <td>
                        <form action="{{ route('vendedor.pago.aprobar', $pago->id) }}" method="POST">
                            @csrf
                            <button type="submit">Aceptar transferencia</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

    <!-- Historial de Ventas -->
    <div class="card">
        <h4>Historial de productos vendidos</h4>
        @if($historialVentas->isEmpty())
            <p class="empty-message">No hay ventas aún.</p>
        @else
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Cliente</th>
                    <th>Producto(s)</th>
                    <th>Total</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Boleta</th>
                </tr>
            </thead>
            <tbody>
                @foreach($historialVentas as $venta)
                <tr>
                    <td>{{ $venta->id }}</td>
                    <td>{{ $venta->pedido->usuario->name }}</td>
                    <td>
                        <ul>
                            @foreach($venta->detalles as $detalle)
                                <li>{{ $detalle->producto->nombre }} x{{ $detalle->cantidad }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>S/ {{ number_format($venta->subtotal, 2) }}</td>
                    <td>{{ $venta->updated_at->format('d/m/Y H:i') }}</td>
                    <td>{{ ucfirst($venta->estado) }}</td>
                    <td>
                        <a href="{{ route('boleta.subpedido', $venta->id) }}" target="_blank" class="btn-sm">
                            Ver boleta PDF
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

</div>
@endsection