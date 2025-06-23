<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pago;
use Illuminate\Support\Facades\Auth;

class VendedorPagoController extends Controller
{
    public function index()
    {
        $negocio = Auth::user()->negocio;

        $pagos = Pago::whereHas('subpedido', function ($q) use ($negocio) {
            $q->where('negocio_id', $negocio->id);
        })->get();

        return view('vendedor.pagos.index', compact('pagos'));
    }

      // ✅ Método para mostrar solo pagos pendientes del negocio del vendedor
      public function pagosPendientes()
{
    $userId = Auth::id();

    // Subpedidos con pagos pendientes donde el vendedor es dueño del negocio
    $pagos = Pago::where('estado', 'pendiente')
        ->whereHas('subpedido.negocio', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        })
        ->with('subpedido.pedido.user', 'subpedido.negocio')
        ->get();

    return view('vendedor.pagos.pendientes', compact('pagos'));
}

public function aprobar(Pago $pago)
{
    $pago->estado = 'aprobado';
    $pago->save();

    return redirect()->route('vendedor.pagos.pendientes')->with('success', 'Pago aprobado correctamente.');
}
}
