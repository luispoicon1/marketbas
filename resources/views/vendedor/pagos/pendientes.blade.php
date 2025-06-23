@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Pagos pendientes por aprobar</h2>

    @if($pagos->isEmpty())
        <p>No hay pagos pendientes.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Negocio</th>
                    <th>Pedido</th>
                    <th>Comprador</th>
                    <th>Monto</th>
                    <th>Comprobante</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pagos as $pago)
                    <tr>
                        <td>{{ $pago->id }}</td>
                        <td>{{ $pago->subpedido->negocio->nombre }}</td>
                        <td>#{{ $pago->subpedido->pedido_id }}</td>
                        <td>{{ $pago->subpedido->pedido->user->name }}</td>
                        <td>S/ {{ number_format($pago->subpedido->subtotal, 2) }}</td>
                        <td>
                            @if($pago->comprobante)
                                <a href="{{ asset('storage/' . $pago->comprobante) }}" target="_blank">Ver</a>
                            @else
                                No disponible
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('vendedor.pagos.aprobar', $pago->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('¿Aprobar este pago?')">Aprobar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
