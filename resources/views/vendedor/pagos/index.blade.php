@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Pagos Recibidos</h2>

    @if(session('success'))
        <div style="color: green;">{{ session('success') }}</div>
    @endif

    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>ID Subpedido</th>
                <th>Monto</th>
                <th>Comprobante</th>
                <th>Estado</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pagos as $pago)
            <tr>
                <td>{{ $pago->subpedido_id }}</td>
                <td>S/ {{ number_format($pago->monto, 2) }}</td>
                <td>
                    <a href="{{ asset('storage/' . $pago->comprobante) }}" target="_blank">Ver Comprobante</a>
                </td>
                <td>{{ ucfirst($pago->estado) }}</td>
                <td>
                    @if($pago->estado === 'pendiente')
                        <form action="{{ route('vendedor.pagos.aprobar', $pago) }}" method="POST">
                            @csrf
                            <button type="submit">Aprobar Pago</button>
                        </form>
                    @else
                        Aprobado
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
