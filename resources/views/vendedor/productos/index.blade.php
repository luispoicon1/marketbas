@extends('layouts.app')

@section('content')
<style>
    body {
        background-color: #f5f7fa;
        font-family: 'Segoe UI', sans-serif;
    }

    .container {
        max-width: 900px;
        margin: 40px auto;
        padding: 20px;
    }

    h2 {
        font-size: 1.8rem;
        color: #333;
        margin-bottom: 20px;
        text-align: center;
    }

    .alert-success {
        color: green;
        text-align: center;
        margin-bottom: 20px;
        font-weight: bold;
    }

    .btn-create {
        display: inline-block;
        background-color: #ffeb3b; /* amarillo */
        color: #333;
        padding: 10px 16px;
        border-radius: 6px;
        text-decoration: none;
        font-weight: bold;
        transition: background 0.3s ease;
    }

    .btn-create:hover {
        background-color: #fdd835;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        background-color: white;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        border-radius: 10px;
        overflow: hidden;
    }

    th, td {
        padding: 14px 18px;
        text-align: left;
        border-bottom: 1px solid #eee;
        font-size: 0.95rem;
    }

    th {
        background-color: #fafafa;
        color: #555;
        font-weight: 600;
    }

    tr:last-child td {
        border-bottom: none;
    }

    .actions a {
        margin-right: 10px;
        text-decoration: none;
        color: #4caf50; /* verde */
        font-weight: 500;
        transition: color 0.3s ease;
    }

    .actions a:hover {
        color: #388e3c;
    }

    .actions button {
        background: none;
        border: none;
        color: #f44336; /* rojo */
        cursor: pointer;
        font-weight: 500;
        transition: color 0.3s ease;
    }

    .actions button:hover {
        color: #d32f2f;
    }

    .empty-message {
        text-align: center;
        color: #888;
        font-style: italic;
        padding: 30px 0;
        font-size: 1rem;
    }
</style>

<div class="container">
    <h2>Mis Productos</h2>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    <div style="text-align: right; margin-bottom: 20px;">
        <a href="{{ route('productos.create') }}" class="btn-create">➕ Nuevo Producto</a>
    </div>

    @if($productos->isEmpty())
        <div class="empty-message">No tienes productos aún.</div>
    @else
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($productos as $producto)
                <tr>
                    <td>{{ $producto->nombre }}</td>
                    <td>S/ {{ number_format($producto->precio, 2) }}</td>
                    <td>{{ $producto->stock }}</td>
                    <td class="actions">
                        <a href="{{ route('productos.edit', $producto) }}">✏️ Editar</a>
                        <form action="{{ route('productos.destroy', $producto) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('¿Eliminar este producto?')">🗑️ Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
@endsection