<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;
use App\Models\Subpedido;

class AdminPedidoController extends Controller
{
    public function index()
    {
        $pedidos = Pedido::where('estado', 'pendiente_verificacion')->get();
        return view('admin.pedidos.index', compact('pedidos'));
    }

    public function ver(Pedido $pedido)
    {
        return view('admin.pedidos.ver', compact('pedido'));
    }

    public function aprobar(Pedido $pedido)
{
    $pedido->estado = 'aprobado';
    $pedido->save();

    // Cambiar estado de todos los subpedidos a 'pago_verificado'
    foreach ($pedido->subpedidos as $subpedido) {
        $subpedido->estado = 'pago_verificado';
        $subpedido->marcado_como_entregado = false; // si usas ese campo
        $subpedido->save();
    }

    return redirect()->route('admin.pedidos.index')
        ->with('success', 'Pedido aprobado. Subpedidos listos para entrega.');
}


    public function rechazar(Pedido $pedido)
    {
        $pedido->estado = 'rechazado';
        $pedido->save();

        return redirect()->route('admin.pedidos.index')->with('success', 'Pedido rechazado correctamente.');
    }
}
