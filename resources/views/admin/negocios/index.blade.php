@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h2 class="text-3xl font-bold text-white mb-6 bg-gradient-to-r from-black via-gray-800 to-black p-4 rounded-lg shadow-lg">Negocios Pendientes de Aprobación</h2>

    @if(session('success'))
        <div class="bg-emerald-500 text-white px-4 py-3 rounded-lg mb-6 shadow-lg transition-all duration-300">
            {{ session('success') }}
        </div>
    @endif

    @if($negocios->isEmpty())
        <div class="bg-gray-900 text-gray-300 p-6 rounded-lg shadow-lg border border-gray-700">
            <p>No hay negocios pendientes.</p>
        </div>
    @else
        <div class="overflow-x-auto rounded-lg border border-gray-700 shadow-xl">
            <table class="min-w-full bg-gray-900 text-gray-300">
                <thead class="bg-black">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-medium uppercase tracking-wider border-b border-gray-700">Nombre</th>
                        <th class="px-6 py-4 text-left text-sm font-medium uppercase tracking-wider border-b border-gray-700">RUC</th>
                        <th class="px-6 py-4 text-left text-sm font-medium uppercase tracking-wider border-b border-gray-700">Dueño</th>
                        <th class="px-6 py-4 text-left text-sm font-medium uppercase tracking-wider border-b border-gray-700">Categoría</th>
                        <th class="px-6 py-4 text-left text-sm font-medium uppercase tracking-wider border-b border-gray-700">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">
                    @foreach($negocios as $negocio)
                    <tr class="hover:bg-gray-800 transition-colors duration-200">
                        <td class="px-6 py-4 whitespace-nowrap border-b border-gray-800">{{ $negocio->nombre }}</td>
                        <td class="px-6 py-4 whitespace-nowrap border-b border-gray-800">{{ $negocio->ruc }}</td>
                        <td class="px-6 py-4 whitespace-nowrap border-b border-gray-800">{{ $negocio->user->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap border-b border-gray-800">{{ $negocio->categoria }}</td>
                        <td class="px-6 py-4 whitespace-nowrap border-b border-gray-800 space-x-2">
                            <form action="{{ route('admin.negocios.aprobar', $negocio) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg transition-all duration-300 transform hover:scale-105 shadow-lg">
                                    Aprobar
                                </button>
                            </form>

                            <form action="{{ route('admin.negocios.rechazar', $negocio) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" onclick="return confirm('¿Seguro que quieres rechazar este negocio?')" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition-all duration-300 transform hover:scale-105 shadow-lg">
                                    Rechazar
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection