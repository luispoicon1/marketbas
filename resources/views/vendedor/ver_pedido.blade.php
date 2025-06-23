@extends('layouts.app')

@section('content')
<style>
    body {
        background-color: #f4f6f9;
        font-family: 'Segoe UI', sans-serif;
    }

    .container {
        max-width: 700px;
        margin: 40px auto;
        padding: 30px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    h2 {
        font-size: 1.8rem;
        color: #333;
        margin-bottom: 20px;
        text-align: center;
    }

    p {
        font-size: 1rem;
        color: #555;
        margin-bottom: 10px;
    }

    strong {
        color: #222;
        font-weight: 600;
    }

    h4 {
        color: #444;
        margin-top: 25px;
        margin-bottom: 10px;
        font-size: 1.1rem;
        border-left: 4px solid #ffeb3b; /* amarillo */
        padding-left: 10px;
    }

    ul {
        list-style-type: none;
        padding-left: 0;
        margin-top: 10px;
    }

    li {
        background: #fff8e1;
        margin: 6px 0;
        padding: 10px 14px;
        border-radius: 6px;
        font-size: 0.95rem;
        border-left: 4px solid #ffeb3b; /* amarillo */
    }

    form button {
        display: inline-block;
        padding: 10px 16px;
        border: none;
        border-radius: 6px;
        font-size: 0.9rem;
        cursor: pointer;
        transition: background 0.3s ease;
        font-weight: bold;
    }

    .btn-success {
        background-color: #4caf50; /* verde */
        color: white;
    }

    .btn-success:hover {
        background-color: #43a047;
    }

    .btn-secondary {
        background-color: #f44336; /* rojo */
        color: white;
        padding: 10px 16px;
        text-decoration: none;
        border-radius: 6px;
        display: inline-block;
        margin-top: 20px;
        font-weight: bold;
    }

    .btn-secondary:hover {
        background-color: #e53935;
    }

    .mt-3 {
        margin-top: 15px;
    }
</style>

<div class="container">
    <h2>Detalle del Pedido #{{ $subpedido->id }}</h2>

    <p><strong>Cliente:</strong> {{ $subpedido->pedido->usuario->name }}</p>
    <p><strong>Estado:</strong> {{ ucfirst($subpedido->estado) }}</p>
    <p><strong>Total:</strong> S/ {{ number_format($subpedido->subtotal, 2) }}</p>

    <h4>Productos:</h4>
    <ul>
        @foreach($subpedido->detalles as $detalle)
            <li>{{ $detalle->producto->nombre }} - {{ $detalle->cantidad }} x S/ {{ number_format($detalle->precio, 2) }}</li>
        @endforeach
    </ul>

    {{-- Botón para marcar como "Listo para recojo" si el estado es pago_verificado --}}
    @if ($subpedido->estado === 'pago_verificado')
        <form action="{{ route('vendedor.subpedido.listo', $subpedido->id) }}" method="POST">
            @csrf
            <button type="submit" class="btn-success">Marcar como listo para recojo</button>
        </form>
    @endif

    <a href="{{ route('vendedor.dashboard') }}" class="btn-secondary mt-3">Volver al Dashboard</a>
</div>
@endsection