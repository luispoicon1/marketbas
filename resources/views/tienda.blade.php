@extends('layouts.app')

@section('content')
<div class="bg-white min-h-screen">
    
    <!-- Hero Section -->
    <div class="bg-black py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl font-bold text-white mb-4">MARKETBAS</h1>
            <p class="text-xl text-gray-300 max-w-3xl mx-auto">
                Productos esenciales
            </p>
            
            <div class="mt-10">
                <a href="#productos" class="inline-block bg-white hover:bg-gray-100 text-black font-medium py-3 px-8 rounded-lg transition duration-300">
                    EXPLORAR PRODUCTOS
                </a>
            </div>
        </div>
    </div>

    <!-- Sección de Productos -->
    <div id="productos" class="bg-gray-100 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-center text-black mb-12">PRODUCTOS</h2>
            
            <!-- Contenedor de productos destacados -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @foreach($productos->take(8) as $producto)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden flex flex-col h-full">
                        <!-- Imagen del producto -->
                        <div class="w-full h-48 bg-cover bg-center">
                            @if($producto->imagen)
                                <img src="{{ asset('storage/' . $producto->imagen) }}" alt="{{ $producto->nombre }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                    <span class="text-gray-500">SIN IMAGEN</span>
                                </div>
                            @endif
                        </div>

                        <!-- Información del producto -->
                        <div class="p-4 flex-grow">
                            <a href="{{ route('productos.show', $producto) }}" class="block text-black hover:text-red-600 transition duration-300">
                                <h3 class="text-sm font-semibold text-black mb-1">{{ $producto->nombre }}</h3>
                                <p class="text-xs text-gray-600">Por: <strong>{{ $producto->negocio->nombre }}</strong></p>
                            </a>

                            <!-- Precio -->
                            <div class="mt-2">
                                @php
                                    $esPremium = auth()->check() && auth()->user()->esCompradorPremium();
                                    $precioBase = $producto->precio;
                                    $precioDescuento = $producto->precio_descuento;
                                @endphp

                                @if ($esPremium && $precioDescuento)
                                    <p class="text-sm">
                                        <span class="text-gray-500 line-through">S/ {{ number_format($precioBase, 2) }}</span>
                                        <span class="text-red-600 fw-bold ms-2">S/ {{ number_format($precioDescuento, 2) }}</span>
                                        <span class="ml-2 bg-yellow-300 text-black px-2 py-0.5 rounded text-xs">⭐ Premium</span>
                                    </p>
                                @else
                                    <p class="fw-bold text-black">S/ {{ number_format($precioBase, 2) }}</p>
                                @endif
                            </div>
                        </div>

                        <!-- Botón "Agregar" -->
                        <form action="{{ route('pedido.agregarProducto', $producto->id) }}" method="POST" class="mt-2">
                                @csrf
                                <input type="number" name="cantidad" min="1" value="1" class="w-16 border-gray-300 rounded mr-2">
                                <button type="submit" class="...">
                                    Agregar
                                </button>
                                
                            </form>

                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div> <!-- Fin de bg-gray-100 -->

                    </div> <!-- ✅ Cierre final del div.bg-white -->
                    @endsection

                  