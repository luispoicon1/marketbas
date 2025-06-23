<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subpedido;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class BoletaController extends Controller
{
    public function generarBoleta(Subpedido $subpedido)
    {
        $user = Auth::user();


        if (
            !$user->es_admin &&
            $subpedido->negocio->user_id !== $user->id &&
            $subpedido->pedido->user_id !== $user->id // <- esta línea permite al comprador
        ) {
            abort(403, 'No autorizado para ver esta boleta.');
        }

        // Cargamos las relaciones correctas
        $subpedido->load(['negocio', 'pedido.user', 'detalles.producto']);

        $pdf = Pdf::loadView('boletas.subpedido', compact('subpedido'));

        return $pdf->stream('boleta_subpedido_' . $subpedido->id . '.pdf');
    }
}
