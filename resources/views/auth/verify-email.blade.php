@extends('layouts.app')

@section('content')
<div class="container mx-auto text-center mt-20">
    <h1 class="text-2xl font-bold mb-4">Verifica tu correo electrónico</h1>
    <p class="mb-6">Antes de continuar, por favor revisa tu bandeja de entrada para verificar tu dirección de correo.</p>

    @if (session('message'))
        <div class="text-green-600 mb-4">
            {{ session('message') }}
        </div>
    @endif

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
            Reenviar correo de verificación
        </button>
    </form>
</div>
@endsection
