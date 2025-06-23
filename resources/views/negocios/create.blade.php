@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-900 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
        <!-- Card Container -->
        <div class="bg-gray-800 rounded-2xl shadow-2xl overflow-hidden border border-gray-700">
            <!-- Header -->
            <div class="bg-black py-6 px-8 border-b border-gray-700">
                <h2 class="text-3xl font-bold text-white">
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-gray-200 to-gray-400">
                        Registrar Nuevo Negocio
                    </span>
                </h2>
                <p class="mt-1 text-gray-400">Completa los datos para unirte a MarketBas</p>
            </div>

            <!-- Form -->
            <div class="p-8">
                @if ($errors->any())
                    <div class="mb-6 p-4 bg-gray-900 rounded-lg border border-red-500/50">
                        <ul class="text-red-400">
                            @foreach ($errors->all() as $error)
                                <li class="flex items-center py-1">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $error }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('negocios.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- Grid de 2 columnas -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nombre del Negocio -->
                        <div>
                            <label class="block text-gray-300 text-sm font-medium mb-2">Nombre del negocio</label>
                            <input type="text" name="nombre" value="{{ old('nombre') }}" required
                                   class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent text-white placeholder-gray-400 transition duration-200">
                        </div>

                        <!-- RUC/DNI -->
                        <div>
                            <label class="block text-gray-300 text-sm font-medium mb-2">RUC/DNI</label>
                            <input type="text" name="ruc" value="{{ old('ruc') }}" required
                                   class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent text-white placeholder-gray-400 transition duration-200">
                        </div>

                        <!-- Dirección -->
                        <div class="md:col-span-2">
                            <label class="block text-gray-300 text-sm font-medium mb-2">Dirección</label>
                            <input type="text" name="direccion" value="{{ old('direccion') }}" required
                                   class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent text-white placeholder-gray-400 transition duration-200">
                        </div>

                        <!-- Descripción -->
                        <div class="md:col-span-2">
                            <label class="block text-gray-300 text-sm font-medium mb-2">Descripción</label>
                            <textarea name="descripcion" rows="3"
                                      class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent text-white placeholder-gray-400 transition duration-200">{{ old('descripcion') }}</textarea>
                        </div>

                        <!-- Categoría -->
                        <div>
                            <label class="block text-gray-300 text-sm font-medium mb-2">Categoría</label>
                            <input type="text" name="categoria" value="{{ old('categoria') }}" required
                                   class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent text-white placeholder-gray-400 transition duration-200">
                        </div>

                        <!-- Foto del Negocio -->
                        <div>
                            <label class="block text-gray-300 text-sm font-medium mb-2">Foto del negocio</label>
                            <div class="relative">
                                <input type="file" name="foto" accept="image/*" id="file-upload"
                                       class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                <label for="file-upload" 
                                       class="flex items-center justify-between px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg cursor-pointer hover:bg-gray-600 transition duration-200">
                                    <span class="text-gray-300 truncate">Seleccionar archivo</span>
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                    </svg>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Botón de Submit -->
                    <div class="pt-4">
                        <button type="submit"
                                class="w-full px-6 py-4 bg-gradient-to-r from-gray-700 to-gray-900 hover:from-gray-600 hover:to-gray-800 text-white font-bold rounded-lg shadow-lg hover:shadow-xl transition duration-300 border border-gray-600 hover:border-gray-500 flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Registrar Negocio
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection