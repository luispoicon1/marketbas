<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pago;
use App\Models\Subpedido;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class FinanzasController extends Controller
{
    public function index(Request $request)
    {
        $query = Pago::with(['subpedido.negocio', 'subpedido.pedido.user']);

        // Filtros opcionales
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('fecha_inicio')) {
            $query->whereDate('created_at', '>=', $request->fecha_inicio);
        }

        if ($request->filled('fecha_fin')) {
            $query->whereDate('created_at', '<=', $request->fecha_fin);
        }

        if ($request->filled('negocio_id')) {
            $query->whereHas('subpedido', function ($q) use ($request) {
                $q->where('negocio_id', $request->negocio_id);
            });
        }

        $pagos = $query->latest()->paginate(20);

        return view('admin.finanzas.index', compact('pagos'));
    }

    public function liquidar(Pago $pago)
{
    if ($pago->estado !== 'aprobado') {
        return back()->withErrors('Solo se pueden liquidar pagos aprobados.');
    }

    $pago->liquidado = true; // ✅ solo usamos el campo booleano existente
    $pago->save();

    return back()->with('success', 'Pago marcado como liquidado.');
}

public function exportarPDF()
{
    $pagos = Pago::with(['subpedido.negocio', 'subpedido.pedido.user'])
        ->where('estado', 'aprobado')
        ->where('liquidado', true)
        ->get();

    $pdf = Pdf::loadView('admin.finanzas.reporte_pdf', compact('pagos'));

    return $pdf->download('pagos_liquidados.pdf');
}


}
