<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Pagos Liquidados</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 6px; text-align: left; }
        th { background-color: #f0f0f0; }
    </style>
</head>
<body>
    <h2>Pagos Liquidados</h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Negocio</th>
                <th>Cliente</th>
                <th>Monto</th>
                <th>Fecha de Pago</th>
                <th>Fecha de Liquidación</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pagos as $pago)
                <tr>
                    <td>{{ $pago->id }}</td>
                    <td>{{ $pago->subpedido->negocio->nombre ?? 'Sin nombre' }}</td>
                    <td>{{ $pago->subpedido->pedido->user->name ?? 'Sin cliente' }}</td>
                    <td>S/ {{ number_format($pago->monto, 2) }}</td>
                    <td>{{ $pago->created_at->format('Y-m-d') }}</td>
                    <td>{{ $pago->updated_at->format('Y-m-d') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
