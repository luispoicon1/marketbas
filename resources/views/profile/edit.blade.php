@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 flex items-center justify-center p-4">
    <!-- Contenedor principal -->
    <div class="w-full max-w-md bg-white rounded-xl shadow-md overflow-hidden">
        <!-- Encabezado -->
        <div class="bg-gray-800 text-white p-6 text-center">
            <h1 class="text-2xl font-bold">MI PERFIL</h1>
            <p class="text-gray-300">Administra tu información personal</p>
        </div>

        <!-- Contenido -->
        <div class="p-6">
            <!-- Información del usuario -->
            <div class="flex items-center space-x-4 mb-6">
                <div class="bg-gray-200 w-16 h-16 rounded-full flex items-center justify-center text-2xl font-bold text-gray-700">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div>
                    <h2 class="font-bold text-lg">{{ auth()->user()->name }}</h2>
                    <p class="text-gray-600">{{ auth()->user()->email }}</p>
                    <span class="text-xs bg-gray-200 text-gray-700 px-2 py-1 rounded-full">
                        Miembro desde {{ auth()->user()->created_at->format('M Y') }}
                    </span>
                </div>
            </div>

            <!-- Formulario -->
            <form class="space-y-4" method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PUT')
                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-1">Nombre completo</label>
                    <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" 
    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-400">
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-1">Correo electrónico</label>
                    <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" 
    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-400">
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-1">Teléfono</label>
                    <input type="text" name="telefono" value="{{ old('telefono', auth()->user()->telefono) }}" 
       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-400">
                </div>


                <div>
    <label class="block text-gray-700 text-sm font-medium mb-1">Dirección</label>
    <input type="text" name="direccion" value="{{ old('direccion', auth()->user()->direccion) }}"
           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-400">
</div>

<div class="grid grid-cols-2 gap-4">
    <div>
        <label class="block text-gray-700 text-sm font-medium mb-1">Departamento</label>
        <input type="text" name="departamento" value="{{ old('departamento', auth()->user()->departamento) }}"
               class="w-full px-4 py-2 border border-gray-300 rounded-lg">
    </div>
    <div>
        <label class="block text-gray-700 text-sm font-medium mb-1">Provincia</label>
        <input type="text" name="provincia" value="{{ old('provincia', auth()->user()->provincia) }}"
               class="w-full px-4 py-2 border border-gray-300 rounded-lg">
    </div>
</div>

<div>
    <label class="block text-gray-700 text-sm font-medium mb-1">Distrito</label>
    <input type="text" name="distrito" value="{{ old('distrito', auth()->user()->distrito) }}"
           class="w-full px-4 py-2 border border-gray-300 rounded-lg">
</div>




                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-1">Fecha de registro</label>
                        <input type="text" value="{{ auth()->user()->created_at->format('d/m/Y H:i') }}" readonly
                               class="w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-lg">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-1">Último acceso</label>
                        <input type="text" value="{{ now()->format('d/m/Y H:i') }}" readonly
                               class="w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-lg">
                    </div>
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-1">Foto de perfil</label>
                    <div class="flex items-center space-x-2">
                        <label class="cursor-pointer bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg transition duration-200">
                            Seleccionar archivo
                            <input type="file" class="hidden">
                        </label>
                        <span class="text-sm text-gray-500">Sin archivos seleccionados</span>
                    </div>
                </div>

                <button type="submit" class="w-full bg-gray-800 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                    Guardar cambios
                </button>
            </form>

            <!-- Historial de compras -->
            @if ($pedidos->isEmpty())
    <p class="text-gray-600 text-sm">No tienes pedidos registrados.</p>
@else
    @foreach ($pedidos as $pedido)
        <div class="mb-4 p-4 bg-gray-50 rounded-lg shadow">
            <p class="text-sm text-gray-700 mb-1">
                <strong>Pedido #{{ $pedido->id }}</strong> - Total: S/ {{ number_format($pedido->total, 2) }}
            </p>

            @foreach ($pedido->subpedidos as $subpedido)
                <div class="border border-gray-200 p-3 rounded mb-2">
                    <p><strong>Negocio:</strong> {{ $subpedido->negocio->nombre }}</p>
                    <p><strong>Estado:</strong> {{ ucfirst(str_replace('_', ' ', $subpedido->estado)) }}</p>
                    <p><strong>Subtotal:</strong> S/ {{ number_format($subpedido->subtotal, 2) }}</p>
                    <a href="{{ route('boleta.subpedido', $subpedido->id) }}" target="_blank"
   class="inline-block mt-2 bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm">
   Ver boleta PDF
</a>

                    @if ($subpedido->estado === 'entregado')
                    <form method="POST" action="{{ route('subpedidos.confirmar_recepcion', $subpedido->id) }}">
                    @csrf
        <button type="submit" class="mt-2 bg-green-600 hover:bg-green-700 text-white px-4 py-1 rounded text-sm">
            Confirmar recepción
        </button>
    </form>
@elseif ($subpedido->estado === 'entregado_confirmado')
    <span class="text-green-700 text-sm">✔ Confirmado</span>
@endif


                </div>
            @endforeach
        </div>
    @endforeach
@endif

            

            <!-- Configuración -->
            <div class="mt-6 pt-4 border-t border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800 mb-2">Configuración</h2>
                <div class="space-y-2">
                    <a href="#" class="block py-2 text-gray-700 hover:text-gray-900 transition duration-200">
                        <i class="fas fa-bell mr-2"></i> Notificaciones
                    </a>
                    <a href="#" class="block py-2 text-gray-700 hover:text-gray-900 transition duration-200">
                        <i class="fas fa-shield-alt mr-2"></i> Seguridad
                    </a>
                    <a href="#" class="block py-2 text-gray-700 hover:text-gray-900 transition duration-200">
                        <i class="fas fa-palette mr-2"></i> Apariencia
                    </a>
                    <a href="#" class="block py-2 text-red-600 hover:text-red-800 transition duration-200">
                        <i class="fas fa-sign-out-alt mr-2"></i> Cerrar sesión
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection