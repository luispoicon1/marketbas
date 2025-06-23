<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subpedido;
use Illuminate\Support\Facades\Auth;

class DeliveryController extends Controller
{
    public function index()
    {
        // Subpedidos listos para recojo o ya asignados a este delivery
        $subpedidos = Subpedido::with('negocio', 'pedido.user', 'detalles.producto')
            ->whereIn('estado', ['listo_para_recojo', 'en_camino'])
            ->where(function ($q) {
                $q->whereNull('delivery_id')
                  ->orWhere('delivery_id', Auth::id());
            })
            ->get();

        return view('delivery.pedidos', compact('subpedidos'));
    }

    public function aceptar(Subpedido $subpedido)
    {
        if ($subpedido->estado !== 'listo_para_recojo' || $subpedido->delivery_id) {
            return back()->withErrors('Este pedido ya fue asignado.');
        }

        $subpedido->delivery_id = Auth::id();
        $subpedido->estado = 'en_camino';
        $subpedido->save();

        return back()->with('success', 'Has aceptado el pedido. Está en camino.');
    }

    public function entregar(Request $request, Subpedido $subpedido)
    {
        if ($subpedido->delivery_id !== Auth::id()) {
            abort(403, 'No autorizado.');
        }

        $request->validate([
            'foto_entrega' => 'required|image|max:2048', // máx. 2MB
        ]);

        $path = $request->file('foto_entrega')->store('entregas', 'public');

    
        $subpedido->estado = 'entregado';
        $subpedido->foto_entrega = $path;
        $subpedido->save();

        return back()->with('success', 'Pedido marcado como entregado.');
    }

    public function historial()
{
    $subpedidos = Subpedido::with('negocio', 'pedido.user', 'detalles.producto')
        ->where('delivery_id', Auth::id())
        ->whereIn('estado', ['entregado', 'entregado_confirmado'])
        ->latest()
        ->get();

    return view('delivery.historial', compact('subpedidos'));
}

}
