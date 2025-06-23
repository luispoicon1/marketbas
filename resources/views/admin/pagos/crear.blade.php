@extends('layouts.admin')

@section('content')
<style>
    body {
        background-color: #f4f6f9;
        font-family: 'Segoe UI', sans-serif;
    }

    .container {
        max-width: 600px;
        margin: 50px auto;
        padding: 30px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    h2 {
        text-align: center;
        font-size: 1.8rem;
        color: #333;
        margin-bottom: 25px;
        font-weight: bold;
    }

    p {
        font-size: 1rem;
        color: #555;
        margin-bottom: 10px;
    }

    strong {
        color: #333;
        font-weight: 600;
    }

    form {
        margin-top: 20px;
    }

    label {
        display: block;
        font-weight: 500;
        margin-top: 15px;
        color: #555;
    }

    input[type="file"] {
        margin-top: 6px;
        width: 100%;
        padding: 6px;
        border: 1px solid #ddd;
        border-radius: 6px;
    }

    button[type="submit"] {
        margin-top: 25px;
        width: 100%;
        padding: 12px;
        background-color: #ffeb3b; /* amarillo */
        color: #333;
        border: none;
        border-radius: 6px;
        font-size: 1rem;
        font-weight: bold;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    button[type="submit"]:hover {
        background-color: #fdd835;
    }

    .amount-tag {
        display: inline-block;
        margin-top: 8px;
        padding: 6px 12px;
        background-color: #fff3cd;
        color: #856404;
        border: 1px solid #ffeeba;
        border-radius: 6px;
        font-weight: bold;
    }
</style>

<div class="container">
    <h2>Registrar pago al negocio</h2>

    <p><strong>Negocio:</strong> {{ $subpedido->negocio->nombre }}</p>
    <p><strong>Monto a pagar:</strong> 
        <span class="amount-tag">S/ {{ number_format($subpedido->subtotal, 2) }}</span>
    </p>

    <form action="{{ route('admin.pagos.store', $subpedido) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <input type="hidden" name="monto" value="{{ $subpedido->subtotal }}">

        <label for="comprobante">Comprobante de transferencia (imagen):</label>
        <input type="file" name="comprobante" id="comprobante" required>

        <button type="submit">Registrar pago</button>
    </form>
</div>
@endsection