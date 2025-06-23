@extends('layouts.app')

@section('content')
<style>
    body {
        background-color: #f4f6f9;
        font-family: 'Segoe UI', sans-serif;
    }

    .container {
        max-width: 800px;
        margin: 30px auto;
        padding: 20px;
    }

    h2 {
        text-align: center;
        font-size: 1.8rem;
        color: #333;
        margin-bottom: 20px;
    }

    .card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        padding: 20px;
        margin-bottom: 20px;
        transition: transform 0.2s ease;
    }

    .card:hover {
        transform: translateY(-4px);
    }

    .card h5 {
        color: #333;
        margin-bottom: 10px;
    }

    .card p,
    .card h6 {
        margin-bottom: 8px;
        color: #555;
    }

    hr {
        margin: 15px 0;
        border: none;
        border-top: 1px solid #eee;
    }

    .producto-item {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 10px;
    }

    .producto-item img {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 6px;
    }

    .btn-wsp {
        display: inline-block;
        padding: 8px 12px;
        font-size: 0.85rem;
        border-radius: 6px;
        text-decoration: none;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 6px;
        transition: background 0.3s ease;
    }

    .btn-wsp-success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .btn-wsp-success:hover {
        background-color: #c3e6cb;
    }

    .btn-wsp-info {
        background-color: #cce5ff;
        color: #004085;
        border: 1px solid #b8daff;
    }

    .btn-wsp-info:hover {
        background-color: #b8daff;
    }

    .actions {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .btn-primary {
        background-color: #ffeb3b; /* amarillo */
        color: #333;
        border: none;
        padding: 10px 16px;
        font-weight: bold;
        border-radius: 6px;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #fdd835;
    }

    .btn-success {
        background-color: #4caf50; /* verde */
        color: white;
        border: none;
        padding: 10px 16px;
        font-weight: bold;
        border-radius: 6px;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    .btn-success:hover {
        background-color: #43a047;
    }

    .form-control {
        border: 1px solid #ccc;
        border-radius: 6px;
        padding: 8px;
        font-size: 0.9rem;
        margin-bottom: 10px;
    }

    .history-link {
        display: block;
        text-align: right;
        margin: 10px 0 20px;
        color: #4caf50;
        font-weight: bold;
        text-decoration: none;
    }

    .history-link:hover {
        text-decoration: underline;
    }
</style>

<div class="container">
    <h2>Pedidos para entregar</h2>
    <a href="{{ route('delivery.historial') }}" class="history-link">📦 Ver historial de entregas</a>

    @foreach ($subpedidos as $subpedido)
        <div class="card">
            <!-- Negocio -->
            <h5><strong>Negocio:</strong> {{ $subpedido->negocio->nombre }}</h5>
            <p><strong>Teléfono:</strong> {{ $subpedido->negocio->telefono ?? 'No registrado' }}</p>
            <p><strong>Número de tienda:</strong> {{ $subpedido->negocio->numero_tienda ?? 'No asignado' }}</p>

            <hr>

            <!-- Cliente -->
            <h6>Cliente: {{ $subpedido->pedido->user->name }}</h6>
            <p><strong>Teléfono:</strong> {{ $subpedido->pedido->user->telefono ?? 'No registrado' }}</p>
            <p><strong>Estado:</strong> {{ ucfirst(str_replace('_', ' ', $subpedido->estado)) }}</p>

            <hr>

            <!-- Productos -->
            <h6>Productos:</h6>
            @foreach ($subpedido->detalles as $detalle)
                <div class="producto-item">
                    @if ($detalle->producto->foto)
                        <img src="{{ asset('storage/' . $detalle->producto->foto) }}" alt="Foto del producto">
                    @endif
                    <div>
                        <strong>{{ $detalle->producto->nombre }}</strong> - {{ $detalle->cantidad }} unidad(es)
                    </div>
                </div>
            @endforeach

            <hr>

            <!-- Acciones -->
            <div class="d-flex justify-content-between align-items-center">
                <!-- Botón WhatsApp Vendedor -->
@if ($subpedido->negocio->user->telefono)
    @php
        // Limpiamos cualquier cosa que no sea número
        $telefonoLimpio = preg_replace('/[^0-9]/', '', $subpedido->negocio->user->telefono);
        $linkWhatsAppVendedor = 'https://wa.me/51'  . $telefonoLimpio . '?text=' .
            urlencode('Hola, soy el repartidor de MarketBas. Estoy en camino para recoger el pedido del negocio ' . $subpedido->negocio->nombre . '.');
    @endphp

    <a href="{{ $linkWhatsAppVendedor }}" target="_blank" class="btn-wsp btn-wsp-success">
        📲 WhatsApp Vendedor
    </a>
@endif

<!-- Botón WhatsApp Cliente -->
@if ($subpedido->pedido->user->telefono)
    @php
        $telefonoCliente = preg_replace('/[^0-9]/', '', $subpedido->pedido->user->telefono);
        $linkWhatsAppCliente = 'https://wa.me/51'  . $telefonoCliente . '?text=' .
            urlencode('Hola, soy el repartidor de MarketBas. Estoy en camino para entregarte tu pedido.');
    @endphp

    <a href="{{ $linkWhatsAppCliente }}" target="_blank" class="btn-wsp btn-wsp-info">
        📞 WhatsApp Cliente
    </a>
@endif

                <!-- Botones de acción -->
                <div class="actions">
                    @if (is_null($subpedido->delivery_id))
                        <form action="{{ route('delivery.aceptar', $subpedido) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-primary">Aceptar Pedido</button>
                        </form>
                    @elseif ($subpedido->estado == 'en_camino')
                        <form action="{{ route('delivery.entregar', $subpedido) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="foto_entrega" class="form-control" accept="image/*" required>
                            <button type="submit" class="btn-success mt-2">Subir y marcar como entregado</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection