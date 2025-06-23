<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Boleta #{{ $subpedido->id }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }

        .header {
            text-align: center;
            padding: 15px 0;
            border-bottom: 2px solid #333;
        }

        .info {
            margin: 15px 0;
            display: flex;
            justify-content: space-between;
            font-size: 12px;
        }

        .info div {
            width: 48%;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 6px;
            text-align: left;
        }

        th {
            background-color: #f0f0f0;
        }

        .total {
            text-align: right;
            font-size: 14px;
            margin-top: 15px;
            font-weight: bold;
        }

        .footer {
            margin-top: 25px;
            font-size: 10px;
            color: #666;
            text-align: center;
        }

        .producto-imagen {
            width: 40px;
            height: auto;
        }
    </style>
</head>
<body>

<div class="header">
    <h1>Boleta de Subpedido #{{ $subpedido->id }}</h1>
    <p><strong>Mercado Local MarketBas</strong></p>
</div>

<div class="info">
    <div>
        <p><strong>Negocio:</strong> {{ $subpedido->negocio->nombre }}</p>
        <p><strong>Dirección:</strong> {{ $subpedido->negocio->direccion ?? 'No definida' }}</p>
    </div>
    <div>
        <p><strong>Cliente:</strong> {{ $subpedido->pedido->user->name }}</p>
        <p><strong>Email:</strong> {{ $subpedido->pedido->user->email }}</p>
    </div>
</div>

<table>
    <thead>
        <tr>
            <th>Imagen</th>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Precio unitario</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($subpedido->detalles as $detalle)
            <tr>
                <td>
                    @if ($detalle->producto->imagen)
                        <img src="{{ public_path('storage/' . $detalle->producto->imagen) }}" class="producto-imagen" />
                    @else
                        Sin imagen
                    @endif
                </td>
                <td>{{ $detalle->producto->nombre }}</td>
                <td>{{ $detalle->cantidad }}</td>
                <td>S/. {{ number_format($detalle->precio, 2) }}</td>
                <td>S/. {{ number_format($detalle->precio * $detalle->cantidad, 2) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="total">
    <p><strong>Total del subpedido:</strong> S/. {{ number_format($subpedido->subtotal, 2) }}</p>
</div>

<div class="footer">
    <p>Gracias por tu compra.</p>
    <p>© {{ date('Y') }} MarketBas - Todos los derechos reservados</p>
</div>

</body>
</html>