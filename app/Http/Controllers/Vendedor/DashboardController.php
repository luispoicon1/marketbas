<?php

namespace App\Http\Controllers\Vendedor;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Negocio;
use App\Models\Subpedido;
use App\Models\Pago; 
use App\Notifications\PedidoListoParaRecojo;
use App\Models\User;

class DashboardController extends Controller
{
    // Mostrar todos los subpedidos del negocio del vendedor
    public function index()
{
    $negocio = Negocio::where('user_id', Auth::id())->first();
    $subpedidos = Subpedido::where('negocio_id', $negocio->id)
    ->whereIn('estado', ['pendiente', 'preparando', 'listo', 'en camino', 'entregado', 'pago_verificado','Listo_para_recojo','en_camino','entregado_confirmado'])
    ->latest()
    ->get();

    // Obtener los pagos pendientes relacionados a subpedidos entregados_confirmados de este negocio
    $pagosPendientes = Pago::whereHas('subpedido', function ($query) use ($negocio) {
        $query->where('negocio_id', $negocio->id)
              ->whereIn('estado', ['entregado', 'entregado_confirmado']);
    })->where('estado', 'pendiente')
      ->whereNotNull('comprobante') // <-- ESTA ES LA CLAVE
      ->get();

      // Historial de productos vendidos (subpedidos entregados con pago aprobado)
$historialVentas = Subpedido::where('negocio_id', $negocio->id)
->whereIn('estado', ['entregado', 'entregado_confirmado'])
->whereHas('pago', function ($q) {
    $q->where('estado', 'aprobado');
})
->with('pedido.usuario', 'detalles.producto') // opcional: para mostrar más detalles
->latest()
->get();

    return view('vendedor.dashboard', compact('subpedidos', 'negocio', 'pagosPendientes', 'historialVentas'));
}

    // Ver detalles de un subpedido
    public function verPedido($id)
    {
        $subpedido = Subpedido::with('detalles.producto', 'pedido.usuario')
                        ->findOrFail($id);

        return view('vendedor.ver_pedido', compact('subpedido'));
    }

    // Marcar como entregado
    public function marcarEntregado($id)
    {
        $subpedido = Subpedido::findOrFail($id);
        $subpedido->estado = 'entregado';
        $subpedido->save();

        return redirect()->back()->with('success', 'Pedido marcado como entregado.');
    }

    public function eliminar($id)
{
    $subpedido = Subpedido::findOrFail($id);

    // Opcional: verifica que el subpedido pertenezca al negocio del vendedor
    $negocio = Negocio::where('user_id', Auth::id())->first();
    if ($subpedido->negocio_id != $negocio->id) {
        abort(403, 'No autorizado.');
    }

    $subpedido->delete();

    return redirect()->route('vendedor.dashboard')->with('success', 'Subpedido eliminado correctamente.');
}


public function aprobarPago($id)
{
    $pago = Pago::findOrFail($id);
    $pago->estado = 'aprobado';
    $pago->save();

    return redirect()->back()->with('success', 'Pago aprobado correctamente.');
}

public function marcarListoParaRecojo($id)
{
    $subpedido = Subpedido::findOrFail($id);

    // Validar que el subpedido pertenezca al negocio del vendedor
    $negocio = Negocio::where('user_id', Auth::id())->first();
    if ($subpedido->negocio_id != $negocio->id) {
        abort(403, 'No autorizado.');
    }

    $subpedido->estado = 'listo_para_recojo';
    $subpedido->save();

    // Notificar a todos los deliverys
    $deliveryUsers = User::where('role', 'delivery')->get();
    foreach ($deliveryUsers as $delivery) {
        $delivery->notify(new PedidoListoParaRecojo($subpedido));
    }

    return redirect()->back()->with('success', 'Pedido marcado como listo para recojo y repartidores notificados.');
}


}

