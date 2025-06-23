@extends('layouts.app')

@section('content')
<style>
    body {
        background-color: #f4f6f9;
    }

    .bg-yellow {
        background-color: #ffeb3b; /* amarillo */
    }

    .text-yellow {
        color: #ffeb3b;
    }

    .bg-green {
        background-color: #4caf50; /* verde */
    }

    .text-green {
        color: #4caf50;
    }

    .bg-red {
        background-color: #f44336; /* rojo */
    }

    .text-red {
        color: #f44336;
    }

    .badge {
        display: inline-block;
        padding: 4px 8px;
        font-size: 0.75rem;
        border-radius: 6px;
        font-weight: bold;
        color: white;
    }

    .rating-stars {
        color: gold;
        font-size: 1.2rem;
    }
</style>

<div class="max-w-5xl mx-auto py-10 px-4">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-10 bg-white p-6 rounded shadow-lg">
        <!-- Imagen -->
        <div>
            @if($producto->imagen)
                <img src="{{ asset('storage/' . $producto->imagen) }}" alt="{{ $producto->nombre }}" class="w-full h-auto rounded shadow-sm">
            @else
                <div class="w-full h-64 bg-gray-200 flex items-center justify-center rounded">
                    <span class="text-gray-500">SIN IMAGEN</span>
                </div>
            @endif
        </div>

        <!-- Detalles -->
        <div class="space-y-4">
            <h2 class="text-3xl font-bold mb-2">{{ $producto->nombre }}</h2>

            <p class="text-gray-700">{{ $producto->descripcion }}</p>

            <!-- Precio -->
            @php
                $esPremium = auth()->check() && auth()->user()->esCompradorPremium();
                $precioBase = $producto->precio;
                $precioDescuento = $producto->precio_descuento;
            @endphp

            @if ($esPremium && $precioDescuento)
                <p class="mt-4">
                    <span class="line-through text-gray-500 text-lg">S/ {{ number_format($precioBase, 2) }}</span>
                    <span class="text-green font-bold text-2xl ml-2">S/ {{ number_format($precioDescuento, 2) }}</span>
                    <span class="ml-2 badge bg-yellow text-black">⭐ Premium</span>
                </p>
            @else
                <p class="mt-4 text-2xl font-bold text-black">S/ {{ number_format($precioBase, 2) }}</p>
            @endif

            <!-- Stock -->
            <div class="mt-2">
                <strong>Stock disponible:</strong>
                <span class="ml-2 badge bg-green text-white">
                    {{ $producto->stock }} unidades
                </span>
            </div>

            <!-- Categoría -->
            @if($producto->categoria)
                <div>
                    <strong>Categoría:</strong>
                    <span class="ml-2 badge bg-yellow text-black">
                        {{ $producto->categoria->nombre }}
                    </span>
                </div>
            @endif

            <!-- Estado -->
            <div>
                <strong>Estado:</strong>
                @if($producto->activo)
                    <span class="ml-2 badge bg-green text-white">Activo</span>
                @else
                    <span class="ml-2 badge bg-red text-white">Inactivo</span>
                @endif
            </div>

            <!-- Fecha de creación -->
            <div>
                <strong>Creado el:</strong>
                <span class="ml-2 text-gray-600">
                    {{ \Carbon\Carbon::parse($producto->created_at)->format('d/m/Y') }}
                </span>
            </div>

            <!-- Calificación promedio -->
<div>
    <strong>Calificación:</strong>
    <div class="flex items-center mt-1 text-yellow-500">
        @php
            $promedio = round($producto->promedioCalificacion(), 1);
        @endphp

        @for($i = 1; $i <= 5; $i++)
            <span>{{ $i <= $promedio ? '★' : '☆' }}</span>
        @endfor

        <span class="ml-2 text-gray-600">
            ({{ $promedio ?: 'Sin calificación aún' }})
        </span>
    </div>
</div>


            <!-- Botón de compra -->
            <form action="{{ route('pedido.agregarProducto', $producto->id) }}" method="POST" class="mt-6">
                @csrf
                <div class="flex items-center gap-4">
                    <input type="number" name="cantidad" value="1" min="1" class="w-20 border border-black px-2 py-1 text-center rounded">
                    <button type="submit" class="bg-black text-white px-6 py-2 rounded hover:bg-gray-800 transition">
                        Agregar al carrito
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Sección de comentarios debajo del producto --}}
    <div class="mt-10 bg-white p-6 rounded shadow-md">
        <h3 class="text-2xl font-bold mb-4">Comentarios de este producto</h3>

        {{-- Mostrar comentarios existentes --}}
        @forelse($producto->comentarios as $comentario)
            <div class="mb-4 border-b border-gray-200 pb-4">
                <div class="flex items-center justify-between">
                    <p class="font-semibold text-[#7D8F69]">{{ $comentario->usuario->name }}</p>
                    <div class="text-yellow-500">
                        @for($i = 1; $i <= 5; $i++)
                            @if ($i <= $comentario->calificacion)
                                ★
                            @else
                                ☆
                            @endif
                        @endfor
                    </div>
                </div>
                <p class="text-gray-700 mt-1">{{ $comentario->comentario }}</p>
            </div>
        @empty
            <p class="text-gray-500">Este producto aún no tiene comentarios.</p>
        @endforelse

        {{-- Formulario para agregar comentario --}}
        @auth
            <form action="{{ route('producto.comentario.store') }}" method="POST" class="mt-6">
                @csrf
                <input type="hidden" name="producto_id" value="{{ $producto->id }}">

                <div class="mb-4">
                    <label for="calificacion" class="block font-medium mb-1">Tu calificación:</label>
                    <select name="calificacion" id="calificacion" class="form-control w-32 border border-gray-300 rounded px-3 py-2">
                        <option value="">Selecciona una calificación</option>
                        <option value="5">★★★★★ (5)</option>
                        <option value="4">★★★★☆ (4)</option>
                        <option value="3">★★★☆☆ (3)</option>
                        <option value="2">★★☆☆☆ (2)</option>
                        <option value="1">★☆☆☆☆ (1)</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="comentario" class="block font-medium mb-1">Escribe un comentario:</label>
                    <textarea name="comentario" id="comentario" rows="3"
                              class="form-control w-full border border-gray-300 rounded px-3 py-2"
                              required></textarea>
                </div>

                <button type="submit" class="bg-[#7D8F69] text-white px-4 py-2 rounded hover:bg-[#5e6f50] transition">
                    Enviar comentario
                </button>
            </form>
        @else
            <p class="text-gray-500 mt-4">
                Debes <a href="{{ route('login') }}" class="text-blue-500 underline">iniciar sesión</a> para dejar un comentario.
            </p>
        @endauth
    </div>
</div>
@endsection