@extends('layouts.app')

@section('content')
<style>
    body {
        background-color: #f4f6f9;
        font-family: 'Segoe UI', sans-serif;
    }

    .container {
        max-width: 1000px;
        margin: 40px auto;
        padding: 20px;
    }

    h2 {
        text-align: center;
        font-size: 1.8rem;
        color: #333;
        margin-bottom: 25px;
    }

    .empty-message {
        text-align: center;
        color: #888;
        font-style: italic;
        padding: 30px 0;
    }

    .card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        padding: 20px;
        margin-bottom: 20px;
        transition: transform 0.2s ease;
    }

    .card:hover {
        transform: translateY(-4px);
    }

    .pedido-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .pedido-title {
        font-size: 1.1rem;
        font-weight: bold;
        color: #333;
    }

    .badge {
        display: inline-block;
        padding: 4px 10px;
        font-size: 0.85rem;
        border-radius: 6px;
        font-weight: bold;
        color: white;
    }

    .badge-yellow {
        background-color: #ffeb3b; /* amarillo */
        color: #333;
    }

    .producto-list {
        margin: 10px 0;
    }

    .producto-item {
        display: flex;
        justify-content: space-between;
        padding: 6px 10px;
        background-color: #f9f9f9;
        border-radius: 6px;
        margin-bottom: 6px;
        font-size: 0.95rem;
    }

    .foto-entrega {
        text-align: center;
        margin-top: 10px;
    }

    .foto-entrega img {
        width: 80px;
        height: auto;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #ddd;
    }

    .btn-action {
        display: inline-block;
        margin-top: 10px;
        padding: 8px 16px;
        background-color: #ffeb3b; /* amarillo */
        color: #333;
        border: none;
        border-radius: 6px;
        font-weight: bold;
        text-decoration: none;
        transition: background 0.3s ease;
    }

    .btn-action:hover {
        background-color: #fdd835;
    }
</style>

<div class="container">
    <h2>Subpedidos pendientes de transferencia</h2>

    @if ($subpedidos->isEmpty())
        <div class="empty-message">
            No hay subpedidos pendientes de transferencia.
        </div>
    @else
        @foreach($subpedidos as $sub)
            <div class="card">
                <div class="pedido-header">
                    <div class="pedido-title">
                        📦 Subpedido #{{ $sub->id }} | Pedido #{{ $sub->pedido_id }}
                    </div>
                    <span class="badge badge-yellow">Pendiente</span>
                </div>

                <div class="producto-list">
                    @foreach ($sub->detalles as $detalle)
                        <div class="producto-item">
                            <span>{{ $detalle->producto->nombre }}</span>
                            <span>Cant: {{ $detalle->cantidad }}</span>
                            <span>S/ {{ number_format($detalle->precio, 2) }}</span>
                        </div>
                    @endforeach
                </div>

                <div class="d-flex justify-content-between align-items-center">
                    <div class="font-bold">
                        Total: S/ {{ number_format($sub->subtotal, 2) }}
                    </div>

                    <div class="foto-entrega">
                        @if ($sub->foto_entrega)
                            <a href="{{ asset('storage/' . $sub->foto_entrega) }}" target="_blank">
                                <img src="{{ asset('storage/' . $sub->foto_entrega) }}" alt="Entrega">
                            </a>
                        @else
                            <span class="text-muted">Sin foto</span>
                        @endif
                    </div>

                    <a href="{{ route('admin.pagos.crear', $sub->id) }}" class="btn-action">
                        Subir comprobante
                    </a>
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection