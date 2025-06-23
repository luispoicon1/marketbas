@extends('layouts.app')

@section('content')
<style>
    body {
        background-color: #f4f6f9;
        font-family: 'Segoe UI', sans-serif;
    }

    .container {
        max-width: 900px;
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

    .badge-green {
        background-color: #4caf50; /* verde */
    }

    .badge-yellow {
        background-color: #ffeb3b; /* amarillo */
        color: #333;
    }

    .detalle-item {
        display: flex;
        justify-content: space-between;
        padding: 6px 10px;
        background-color: #f9f9f9;
        border-radius: 6px;
        margin-bottom: 6px;
        font-size: 0.95rem;
    }

    .fecha {
        font-size: 0.85rem;
        color: #777;
        margin-top: 10px;
    }
</style>

<div class="container">
    <h2>Historial de entregas</h2>

    @if($subpedidos->isEmpty())
        <div class="empty-message">
            No has realizado entregas aún.
        </div>
    @else
        @foreach($subpedidos as $sp)
            <div class="card">
                <div class="pedido-header">
                    <div class="pedido-title">
                        📦 Subpedido #{{ $sp->id }}
                    </div>
                    @if($sp->estado === 'entregado')
                        <span class="badge badge-green">Entregado</span>
                    @else
                        <span class="badge badge-yellow">{{ ucfirst(str_replace('_', ' ', $sp->estado)) }}</span>
                    @endif
                </div>

                <div class="detalle-item">
                    <strong>Negocio:</strong>
                    <span>{{ $sp->negocio->nombre }}</span>
                </div>

                <div class="detalle-item">
                    <strong>Cliente:</strong>
                    <span>{{ $sp->pedido->user->name }}</span>
                </div>

                <div class="detalle-item">
                    <strong>Total:</strong>
                    <span>S/ {{ number_format($sp->subtotal, 2) }}</span>
                </div>

                <div class="fecha">
                    Fecha: {{ $sp->updated_at->format('d/m/Y H:i') }}
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection