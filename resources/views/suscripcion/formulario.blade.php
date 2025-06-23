@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Suscribirse como Comprador Premium</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($suscripcion)
        <p><strong>Estado:</strong> {{ ucfirst($suscripcion->estado) }}</p>
        <p>Ya enviaste tu solicitud. Espera la respuesta del administrador.</p>
    @else
        <form method="POST" action="{{ route('suscripcion.enviar') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="comprobante">Sube tu comprobante (jpg, png, pdf):</label>
                <input type="file" name="comprobante" class="form-control" required>
            </div>
            <button class="btn btn-primary mt-2">Enviar solicitud</button>
        </form>
    @endif
</div>
@endsection
