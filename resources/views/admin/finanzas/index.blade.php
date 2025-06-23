@extends('layouts.app')

@section('content')
<style>
    body {
        background-color: #f4f6f9;
        font-family: 'Segoe UI', sans-serif;
    }

    .container {
        max-width: 1100px;
        margin: 40px auto;
        padding: 20px;
    }

    h1 {
        text-align: center;
        font-size: 1.8rem;
        color: #333;
        margin-bottom: 30px;
    }

    .form-control {
        border: 1px solid #ccc;
        border-radius: 6px;
        padding: 8px;
        width: 100%;
    }

    .btn-primary {
        background-color: #ffeb3b; /* amarillo */
        color: #333;
        border: none;
        padding: 10px 16px;
        font-weight: bold;
        border-radius: 6px;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #fdd835;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        background-color: white;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        border-radius: 8px;
        overflow: hidden;
    }

    th, td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #eee;
        font-size: 0.95rem;
    }

    th {
        background-color: #fafafa;
        color: #555;
        font-weight: 600;
    }

    tr:hover {
        background-color: #f5f5f5;
    }

    .badge {
        display: inline-block;
        padding: 4px 10px;
        font-size: 0.85rem;
        border-radius: 6px;
        font-weight: bold;
        color: white;
    }

    .bg-success {
        background-color: #4caf50; /* verde */
    }

    .text-muted {
        color: #888;
    }

    .d-flex {
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .mt-3 {
        margin-top: 10px;
    }

    .pagination {
        margin-top: 20px;
        justify-content: center;
    }

    .pagination li {
        margin: 0 4px;
    }

    .pagination .page-link {
        color: #7D8F69;
        border: 1px solid #ddd;
    }

    .pagination .active .page-link {
        background-color: #7D8F69;
        color: white;
        border-color: #7D8F69;
    }
</style>

<div class="container">
    <h1>Panel Financiero</h1>

    <!-- Filtros -->
    <form method="GET" class="mb-4">
        <div class="row g-3">
            <div class="col-md-3">
                <label>Estado:</label>
                <select name="estado" class="form-control">
                    <option value="">Todos</option>
                    <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                    <option value="aprobado" {{ request('estado') == 'aprobado' ? 'selected' : '' }}>Aprobado</option>
                    <option value="rechazado" {{ request('estado') == 'rechazado' ? 'selected' : '' }}>Rechazado</option>
                </select>
            </div>

            <div class="col-md-3">
                <label>Desde:</label>
                <input type="date" name="fecha_inicio" class="form-control" value="{{ request('fecha_inicio') }}">
            </div>

            <div class="col-md-3">
                <label>Hasta:</label>
                <input type="date" name="fecha_fin" class="form-control" value="{{ request('fecha_fin') }}">
            </div>

            <div class="col-md-3 d-flex align-items-end">
                <button class="btn-primary">Filtrar</button>
            </div>
        </div>
    </form>

    <!-- Tabla de pagos -->
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Negocio</th>
                <th>Monto</th>
                <th>Estado</th>
                <th>Fecha</th>
                <th>Comprobante</th>
                <th>Comprador</th>
                <th>Foto Entrega</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pagos as $pago)
                <tr>
                    <td>{{ $pago->id }}</td>
                    <td>{{ $pago->subpedido->negocio->nombre ?? 'N/A' }}</td>
                    <td>S/ {{ number_format($pago->monto, 2) }}</td>
                    <td>
                        @if($pago->estado == 'pendiente')
                            <span class="badge bg-warning">{{ ucfirst($pago->estado) }}</span>
                        @elseif($pago->estado == 'aprobado')
                            <span class="badge bg-success">{{ ucfirst($pago->estado) }}</span>
                        @else
                            <span class="badge bg-danger">{{ ucfirst($pago->estado) }}</span>
                        @endif
                    </td>
                    <td>{{ $pago->created_at->format('d/m/Y') }}</td>
                    <td>
                        @if ($pago->comprobante)
                            <a href="{{ asset('storage/' . $pago->comprobante) }}" target="_blank">Ver comprobante</a>
                        @else
                            <span class="text-muted">Sin archivo</span>
                        @endif
                    </td>
                    <td>{{ $pago->subpedido->pedido->user->name ?? 'N/A' }}</td>
                    <td>
                        @if ($pago->subpedido->foto_entrega)
                            <a href="{{ asset('storage/' . $pago->subpedido->foto_entrega) }}" target="_blank">Ver foto</a>
                        @else
                            <span class="text-muted">No disponible</span>
                        @endif
                    </td>
                    <td>
                        @if($pago->liquidado)
                            <span class="badge bg-success">Liquidado</span>
                        @else
                            <form method="POST" action="{{ route('admin.finanzas.liquidar', $pago) }}">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success mt-2"
                                        onclick="return confirm('¿Estás seguro de marcar este pago como liquidado?')">
                                    Liquidar
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center text-gray-500 py-4">No hay resultados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Paginación -->
    <div class="pagination justify-content-center">
        {{ $pagos->links() }}
    </div>

    <!-- Botón de Exportar PDF -->
    @if(auth()->check() && !auth()->user()->is_premium)
        <div class="text-center mt-4">
            <a href="{{ route('admin.finanzas.exportar.pdf') }}" class="btn btn-success">
                📄 Exportar PDF
            </a>
        </div>
    @endif
</div>
@endsection