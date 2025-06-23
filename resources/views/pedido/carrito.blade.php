@extends('layouts.app')

@section('content')
<div class="bg-white min-h-screen">
    <!-- Hero Section -->
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <h1 class="text-left text-3xl font-bold text-black">Tu Carrito</h1>
        <p class="text-left text-black mt-2">Revisa los productos antes de confirmar tu pedido</p>
    </div>

    <!-- Contenido del carrito -->
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg shadow-sm">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg shadow-sm">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if($carrito && $carrito->productos->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white rounded-lg shadow-md overflow-hidden">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 w-1/2">Producto</th>
                            <th class="px-4 py-3 text-right text-sm font-semibold text-gray-700">Precio</th>
                            <th class="px-4 py-3 text-center text-sm font-semibold text-gray-700">Cantidad</th>
                            <th class="px-4 py-3 text-right text-sm font-semibold text-gray-700">Subtotal</th>
                            <th class="px-4 py-3 text-right text-sm font-semibold text-gray-700">Acción</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @php $totalCarrito = 0; @endphp
                        @foreach($carrito->productos as $producto)
                            @php
                                $precioUnitario = $producto->precio;
                                if (auth()->check() && auth()->user()->esCompradorPremium() && $producto->precio_descuento) {
                                    $precioUnitario = $producto->precio_descuento;
                                }
                                $subtotalLinea = $precioUnitario * $producto->pivot->cantidad;
                                $totalCarrito += $subtotalLinea;
                            @endphp

                            <tr class="hover:bg-gray-50 transition duration-150">
                                <!-- Producto + Imagen -->
                                <td class="px-4 py-4 flex items-center">
                                    <img src="{{ $producto->imagen ? asset('storage/'.$producto->imagen) : asset('img/sin-imagen.png') }}" 
                                         alt="{{ $producto->nombre }}" 
                                         class="w-16 h-16 object-cover rounded mr-4">

                                    <div>
                                        <h3 class="font-medium text-gray-800">{{ $producto->nombre }}</h3>
                                        <p class="text-xs text-gray-500">
                                            {{ optional($producto->negocio)->nombre ?? 'Sin negocio' }}
                                        </p>
                                    </div>
                                </td>

                                <!-- Precio -->
                                <td class="px-4 py-4 text-right">
                                    @if(auth()->check() && auth()->user()->esCompradorPremium() && $producto->precio_descuento)
                                        <span class="line-through text-gray-500 text-sm">S/ {{ number_format($producto->precio, 2) }}</span><br>
                                        <span class="text-green-700 font-bold">S/ {{ number_format($precioUnitario, 2) }}</span>
                                        <span class="ml-2 bg-yellow-300 text-black px-2 py-1 rounded-full text-xs">⭐ Premium</span>
                                    @else
                                        S/ {{ number_format($producto->precio, 2) }}
                                    @endif
                                </td>

                                <!-- Cantidad -->
                                <td class="px-4 py-4 text-center">
                                    <form action="{{ route('pedido.agregarProducto', $producto->id) }}" method="POST" class="flex justify-center">
                                        @csrf
                                        <input type="number" name="cantidad" value="1" min="1"
                                               class="w-16 border border-gray-300 text-center rounded px-2 py-1 focus:outline-none focus:ring-2 focus:ring-rose-500">
                                        <button type="submit"
                                                class="ml-2 text-gray-600 hover:text-rose-600 transition duration-200">
                                            ✔️
                                        </button>
                                    </form>
                                </td>

                                <!-- Subtotal -->
                                <td class="px-4 py-4 text-right">
                                    S/ {{ number_format($subtotalLinea, 2) }}
                                </td>

                                <!-- Eliminar -->
                                <td class="px-4 py-4 text-right">
                                    <form action="{{ route('pedido.eliminarDelCarrito', ['productoId' => $producto->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 transition duration-200">
                                            ❌ Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach

                        <!-- Total -->
                        <tr class="bg-gray-50">
                            <td colspan="3" class="px-4 py-4 text-right font-bold text-gray-800">Total:</td>
                            <td class="px-4 py-4 text-right font-bold text-gray-800">
                                S/ {{ number_format($totalCarrito, 2) }}
                            </td>
                            <td class="px-4 py-4 text-right"></td>
                        </tr>
                    </tbody>
                </table>
            </div>

           <!-- Botón Confirmar Pedido -->
<div class="mt-8 text-right">
    <form action="{{ route('pedido.confirmar') }}" method="POST">
        @csrf

        <div class="mb-4 text-left">
            <label class="block font-bold mb-2">¿Cómo deseas recibir tu pedido?</label>
            <div class="flex items-center gap-6">
                <label class="flex items-center">
                    <input type="radio" name="tipo_entrega" value="tienda" required>
                    <span class="ml-2">Recojo en tienda</span>
                </label>
                <label class="flex items-center">
                    <input type="radio" name="tipo_entrega" value="delivery" required>
                    <span class="ml-2">Delivery</span>
                </label>
            </div>
        </div>

        <button type="submit" class="bg-[#C85C5C] hover:bg-[#B54B4B] text-white px-6 py-2 rounded-lg shadow hover:shadow-md transition duration-300">
            Continuar con el pago
        </button>
    </form>
</div>

        @else
            <div class="bg-white shadow-md rounded-lg p-8 text-center mt-10">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <h3 class="mt-2 text-xl font-semibold text-gray-700">Tu carrito está vacío</h3>
                <p class="mt-1 text-gray-500">Agrega algunos productos para continuar.</p>
                <a href="{{ route('tienda') }}" class="inline-block mt-4 bg-[#7D8F69] hover:bg-[#6A7B58] text-white px-6 py-2 rounded-lg transition duration-300">
                    Volver a la tienda
                </a>
            </div>
        @endif
    </div>
</div>
@endsection