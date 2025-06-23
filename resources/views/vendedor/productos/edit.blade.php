@extends('layouts.app')

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
    }

    label {
        display: block;
        font-weight: 500;
        margin-top: 15px;
        color: #555;
    }

    input[type="text"],
    input[type="number"],
    textarea,
    .form-control {
        width: 100%;
        padding: 10px 12px;
        margin-top: 6px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 0.95rem;
        box-sizing: border-box;
    }

    textarea {
        resize: vertical;
        min-height: 80px;
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
</style>

<div class="container">
    <h2>Editar Producto</h2>

    <form method="POST" action="{{ route('productos.update', $producto) }}">
        @csrf
        @method('PUT')

        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $producto->nombre) }}" required>

        <label for="descripcion">Descripción:</label>
        <textarea name="descripcion" id="descripcion">{{ old('descripcion', $producto->descripcion) }}</textarea>

        <label for="precio">Precio:</label>
        <input type="number" step="0.01" name="precio" id="precio" value="{{ old('precio', $producto->precio) }}" required>

        <label for="precio_descuento">Precio con descuento para suscriptores (opcional):</label>
        <input type="number" name="precio_descuento" id="precio_descuento" class="form-control"
            step="0.01" min="0" value="{{ old('precio_descuento', $producto->precio_descuento) }}">

        <label for="stock">Stock:</label>
        <input type="number" name="stock" id="stock" value="{{ old('stock', $producto->stock) }}" required>

        <button type="submit">Actualizar</button>
    </form>
</div>
@endsection