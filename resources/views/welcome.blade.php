@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#fafbfd] flex flex-col items-center justify-center p-4">
    <!-- Contenedor principal -->
    <div class="w-full max-w-5xl bg-white rounded-2xl shadow-lg overflow-hidden border border-[#C4A484]/50 relative">
        <!-- Cabecera con fondo de textura -->
        <div class="relative bg-[#800000] p-8 md:p-12 text-center h-60 clip-diagonal">
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/rice-paper-3.png')]  opacity-20"></div>
            <div class="relative z-10 h-full flex flex-col justify-center">
                <h1 class="text-4xl md:text-5xl font-bold text-[#FCF8F3] mb-2">MARKETBAS</h1>
                <p class="text-[#FCF8F3] font-light text-lg md:text-xl">Tu mercado local de productos frescos y diversos</p>
            </div>
        </div>

        <!-- Contenido principal -->
        <div class="relative z-10 p-6 md:p-10">
            <div class="text-center mb-10">
                <p class="text-[#7D8F69] text-2xl md:text-3xl font-medium mb-8">¿QUÉ DESEAS HACER HOY?</p>

                <!-- Botones de opción -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 max-w-4xl mx-auto">
                    <!-- COMPRAR -->
                <a href="{{ route('comprador.inicio') }}" 
                   class="group border-2 border-[#7D8F69]/40 hover:border-[#7D8F69] bg-[#F7DC6F]/20 hover:bg-[#F7DC6F]/40 rounded-2xl p-6 shadow transition-all duration-300">
                    <div class="flex flex-col items-center gap-4">
                        <div class="w-16 h-16 bg-[#C85C5C] group-hover:bg-[#7D8F69] rounded-full flex items-center justify-center transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17" />
                            </svg>
                        </div>
                        <span class="text-xl font-bold text-[#7D8F69] group-hover:text-[#C85C5C]">COMPRAR PRODUCTOS</span>
                    </div>
                </a>

                    <!-- VENDER -->
                <a href="{{ route('vendedor.inicio') }}" 
                   class="group border-2 border-[#7D8F69]/40 hover:border-[#7D8F69] bg-[#F7DC6F]/20 hover:bg-[#F7DC6F]/40 rounded-2xl p-6 shadow transition-all duration-300">
                    <div class="flex flex-col items-center gap-4">
                        <div class="w-16 h-16 bg-[#C85C5C] group-hover:bg-[#7D8F69] rounded-full flex items-center justify-center transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2" />
                            </svg>
                        </div>
                        <span class="text-xl font-bold text-[#7D8F69] group-hover:text-[#C85C5C]">VENDER PRODUCTOS</span>
                    </div>
                </a>
            </div

           
            <!-- DELIVERY -->
            <div class="mt-10 max-w-xl mx-auto">
                <a href="{{ route('delivery.pedidos') }}" 
                   class="group border-2 border-[#7D8F69]/40 hover:border-[#7D8F69] bg-[#F7DC6F]/20 hover:bg-[#F7DC6F]/40 rounded-2xl p-6 shadow transition-all duration-300 block">
                    <div class="flex flex-col items-center gap-4">
                        <div class="w-16 h-16 bg-[#C85C5C] group-hover:bg-[#7D8F69] rounded-full flex items-center justify-center transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 17v-6a2 2 0 012-2h2a2 2 0 012 2v6m-4 4h.01M6.938 4.938a8 8 0 1110.124 0" />
                            </svg>
                        </div>
                        <span class="text-xl font-bold text-[#7D8F69] group-hover:text-[#C85C5C]">ENTREGAR PEDIDOS</span>
                    </div>
                </a>
            </div>
            <!-- ADMIN -->
            @if(auth()->user()->role === 'admin')
<div class="mt-12 border-t pt-6 border-[#C4A484]/30">
    <p class="text-lg text-[#7D8F69] mb-4">ACCESOS ADMINISTRATIVOS</p>
    
    <!-- Botones principales -->
    <div class="flex flex-wrap justify-center gap-4 mb-4">
        <a href="{{ route('admin.negocios.index') }}"
           class="px-5 py-2 bg-[#7D8F69] text-white rounded-lg hover:bg-[#6C7F5C] shadow text-sm font-medium">
           NEGOCIOS
        </a>
        <a href="{{ route('admin.pedidos.index') }}"
           class="px-5 py-2 bg-[#C85C5C] text-white rounded-lg hover:bg-[#B44B4B] shadow text-sm font-medium">
           PEDIDOS
        </a>
        <a href="{{ route('admin.pagos.index') }}"
           class="px-5 py-2 bg-[#7D8F69] text-white rounded-lg hover:bg-[#5E7251] shadow text-sm font-medium">
           PAGOS
        </a>
        <a href="{{ route('admin.suscripciones.index') }}"
           class="px-5 py-2 bg-[#F7DC6F] text-[#7D8F69] border border-[#C4A484] rounded-lg hover:bg-[#F1CF3A] shadow text-sm font-medium">
           SUSCRIPCIONES
        </a>
    </div>

    <!-- Botón adicional para Finanzas -->
    <div class="text-center mt-6">
        <a href="{{ route('finanzas.index') }}"
           class="inline-block px-6 py-2 bg-[#FFA726] text-white rounded-lg hover:bg-[#FB8C00] shadow-md text-sm font-bold transition">
           PANEL FINANCIERO
        </a>
    </div>


@endif
        </div>
    </div>
</div>

<style>
    .clip-diagonal {
        clip-path: polygon(0 0, 100% 0, 100% 85%, 0 100%);
    }

    @media (max-width: 768px) {
        .clip-diagonal {
            clip-path: polygon(0 0, 100% 0, 100% 90%, 0 100%);
        }
    }
</style>
@endsection