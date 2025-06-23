@extends('layouts.app')

@section('content')
<div class="bg-white min-h-screen py-10 px-4">
    <div class="max-w-6xl mx-auto">
        <!-- Título -->
        <h2 class="text-3xl font-bold text-[#0b6730] mb-6 text-center">Pedidos Pendientes de Verificación</h2>

        <!-- Mensaje de éxito -->
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm max-w-3xl mx-auto text-center">
                {{ session('success') }}
            </div>
        @endif

        <!-- Sin pedidos -->
        @if($pedidos->isEmpty())
            <div class="bg-gray-50 border border-dashed border-gray-300 py-12 text-center rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 00-2 2M9 5a2 2 0 01-2 2m4 0a2 2 0 104 0 2 2 0 00-4 0z" />
                </svg>
                <p class="mt-4 text-gray-600">No hay pedidos pendientes por el momento.</p>
            </div>
        @else
            <!-- Tabla de Pedidos -->
            <div class="overflow-x-auto rounded-lg shadow-md">
                <table class="min-w-full bg-white divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[#7D8F69] uppercase tracking-wider">
                                ID
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[#7D8F69] uppercase tracking-wider">
                                Cliente
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[#7D8F69] uppercase tracking-wider">
                                Total
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[#7D8F69] uppercase tracking-wider">
                                Estado
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[#7D8F69] uppercase tracking-wider">
                                Comprobante
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-[#7D8F69] uppercase tracking-wider">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($pedidos as $pedido)
                            <tr class="hover:bg-gray-50 transition duration-150">
                                <!-- ID -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-semibold text-[#7D8F69]">#{{ $pedido->id }}</span>
                                </td>

                                <!-- Cliente -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center space-x-3">
                                        <img src="{{ asset('img/avatar.png') }}" alt="Avatar" class="w-8 h-8 rounded-full">
                                        <span class="text-sm text-gray-800">{{ $pedido->user->name ?? 'Sin cliente' }}</span>
                                    </div>
                                </td>

                                <!-- Total -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm text-gray-900">S/ {{ number_format($pedido->total, 2) }}</span>
                                </td>

                                <!-- Estado -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @switch($pedido->estado)
                                        @case('pendiente_pago')
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold leading-5 rounded-full bg-yellow-100 text-yellow-800">
                                                Pendiente de Pago
                                            </span>
                                            @break
                                        @case('pendiente_verificacion')
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold leading-5 rounded-full bg-blue-100 text-blue-800">
                                                Pendiente de Verificación
                                            </span>
                                            @break
                                        @default
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold leading-5 rounded-full bg-gray-100 text-gray-800">
                                                {{ ucfirst($pedido->estado) }}
                                            </span>
                                    @endswitch
                                </td>

                                <!-- Comprobante -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($pedido->comprobante)
                                        <a href="{{ asset('storage/' . $pedido->comprobante) }}" target="_blank" class="text-[#C85C5C] hover:text-red-800 underline">
                                            Ver comprobante
                                        </a>
                                    @else
                                        <span class="text-gray-400">No disponible</span>
                                    @endif
                                </td>

                                <!-- Acciones -->
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium flex justify-end gap-2">
                                    <a href="{{ route('admin.pedidos.ver', $pedido) }}" class="text-[#7D8F69] hover:text-green-800">
                                        Ver Detalles
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection