@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Solicitudes de Suscripción Premium</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Usuario</th>
                <th>Correo</th>
                <th>Estado</th>
                <th>Comprobante</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($suscripciones as $s)
                <tr>
                    <td>{{ $s->user->name }}</td>
                    <td>{{ $s->user->email }}</td>
                    <td>{{ ucfirst($s->estado) }}</td>
                    <td>
                        <a href="{{ asset('storage/' . $s->comprobante) }}" target="_blank">Ver</a>
                    </td>
                    <td>
                        @if($s->estado == 'pendiente')
                            <form action="{{ route('admin.suscripciones.aprobar', $s) }}" method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-success btn-sm">Aprobar</button>
                            </form>
                            <form action="{{ route('admin.suscripciones.rechazar', $s) }}" method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-danger btn-sm">Rechazar</button>
                            </form>
                        @else
                            <span class="text-muted">Ya revisado</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $suscripciones->links() }}
</div>
@endsection
