<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subpedido;
use App\Models\Pago;
use Illuminate\Support\Facades\Storage;

class AdminPagoController extends Controller
{

    public function index()
{
    // Mostrar subpedidos entregados y no pagados aún
    $subpedidos = Subpedido::whereIn('estado', ['entregado', 'entregado_confirmado'])
        ->whereDoesntHave('pago', function ($q) {
            $q->where('estado', 'aprobado');
        })
        ->get();

    return view('admin.pagos.index', compact('subpedidos'));
}


    // Mostrar el formulario para subir comprobante por subpedido
public function crear(Subpedido $subpedido)
{
    return view('admin.pagos.crear', compact('subpedido'));
}

// Guardar el comprobante
public function store(Request $request, Subpedido $subpedido)
{
    if ($subpedido->pago && $subpedido->pago->comprobante) {
        return back()->with('error', 'Este subpedido ya tiene un pago registrado.');
    }

    $request->validate([
        'comprobante' => 'required|image|max:2048',
        'monto' => 'required|numeric'
    ]);

    $ruta = $request->file('comprobante')->store('pagos', 'public');

    Pago::create([
        'subpedido_id' => $subpedido->id,
        'comprobante' => $ruta,
        'estado' => 'pendiente',
        'monto' => $request->monto,
    ]);

    return redirect()->route('admin.pedidos.ver', $subpedido->pedido_id)
                     ->with('success', 'Comprobante subido correctamente.');
}


}
