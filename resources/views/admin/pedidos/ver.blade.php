@extends('layouts.app')

@section('content')
<style>
    body {
        background-color: #f9f9f9;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .container {
        max-width: 800px;
        margin: 40px auto;
        padding: 30px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    h2 {
        color: #333;
        margin-bottom: 20px;
        font-weight: 600;
    }

    h3 {
        color: #444;
        margin-top: 30px;
        font-size: 1.2rem;
    }

    p {
        font-size: 1rem;
        color: #555;
    }

    strong {
        color: #222;
    }

    ul {
        list-style-type: none;
        padding-left: 0;
    }

    li {
        background: #fff8e1;
        margin: 8px 0;
        padding: 12px 16px;
        border-radius: 8px;
        border-left: 4px solid #ffeb3b; /* amarillo */
        font-size: 0.95rem;
    }

    form {
        margin-right: 10px;
    }

    button {
        padding: 10px 16px;
        border: none;
        border-radius: 6px;
        font-size: 0.9rem;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    .btn-aprobar {
        background-color: #4caf50; /* verde */
        color: white;
    }

    .btn-aprobar:hover {
        background-color: #43a047;
    }

    .btn-rechazar {
        background-color: #f44336; /* rojo */
        color: white;
    }

    .btn-rechazar:hover {
        background-color: #e53935;
    }

    .mt-4 {
        margin-top: 20px;
    }

    .btn-info {
        background-color: #ffeb3b; /* amarillo */
        color: #333;
        padding: 10px 16px;
        text-decoration: none;
        border-radius: 6px;
        display: inline-block;
        font-weight: 500;
    }

    .btn-info:hover {
        background-color: #fdd835;
    }
</style>

<div class="container">
    <h2>Pedido #{{ $pedido->id }} - Cliente: {{ $pedido->user->name }}</h2>

    <p><strong>Total:</strong> S/ {{ number_format($pedido->total, 2) }}</p>
    <p><strong>Estado:</strong> {{ $pedido->estado }}</p>
    <p><strong>Comprobante:</strong>
        @if($pedido->comprobante)
            <a href="{{ asset('storage/' . $pedido->comprobante) }}" target="_blank">Ver comprobante</a>
        @else
            No disponible
        @endif
    </p>

    <h3>Subpedidos</h3>
    <ul>
        @foreach($pedido->subpedidos as $sub)
            <li>Negocio: {{ $sub->negocio->nombre }} | Subtotal: S/ {{ number_format($sub->subtotal, 2) }}</li>
        @endforeach
    </ul>

    <form action="{{ route('admin.pedidos.aprobar', $pedido) }}" method="POST" style="display:inline;">
        @csrf
        <button type="submit" class="btn-aprobar" onclick="return confirm('¿Aprobar este pedido?')">Aprobar</button>
    </form>

    <form action="{{ route('admin.pedidos.rechazar', $pedido) }}" method="POST" style="display:inline;">
        @csrf
        <button type="submit" class="btn-rechazar" onclick="return confirm('¿Rechazar este pedido?')">Rechazar</button>
    </form>

    @if($pedido->estado == 'aprobado')
        <div class="mt-4">
            <a href="{{ route('admin.pagos.index') }}" class="btn-info">
                Gestionar Pagos a Vendedores
            </a>
        </div>
    @endif
</div>
@endsection