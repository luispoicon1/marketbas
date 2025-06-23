<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Negocio;
use App\Models\User;

class AdminController extends Controller
{
    // Mostrar negocios pendientes
    public function index()
    {
        $negocios = Negocio::where('estado', 'pendiente')->get();
        return view('admin.negocios.index', compact('negocios'));
    }

    // Aprobar negocio
    public function aprobar(Negocio $negocio)
    {
        $negocio->estado = 'aprobado';
        $negocio->save();

        // Cambiar rol usuario a vendedor
        $user = $negocio->user;
        $user->role = 'vendedor';
        $user->save();

        return redirect()->route('admin.negocios.index')->with('success', 'Negocio aprobado.');
    }

    // Rechazar negocio
    public function rechazar(Negocio $negocio)
    {
        $negocio->estado = 'rechazado';
        $negocio->save();

        // Opcional: cambiar rol usuario a comprador si quieres
        $user = $negocio->user;
        $user->role = 'comprador';
        $user->save();

        return redirect()->route('admin.negocios.index')->with('success', 'Negocio rechazado.');
    }
}
