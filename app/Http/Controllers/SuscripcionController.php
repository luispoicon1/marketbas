<?php

// app/Http/Controllers/SuscripcionController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuscripcionPremium;
use Illuminate\Support\Facades\Auth;
use App\Notifications\ConfirmacionSuscripcion;


class SuscripcionController extends Controller
{
    public function formulario()
    {
        $suscripcion = Auth::user()->suscripcion;
        return view('suscripcion.formulario', compact('suscripcion'));
    }

    public function enviar(Request $request)
{
    $request->validate([
        'comprobante' => 'required|file|mimes:jpg,png,pdf|max:2048',
    ]);

    if (!$request->hasFile('comprobante')) {
        return back()->with('error', 'No se detectó el archivo comprobante.');
    }

    $path = $request->file('comprobante')->store('comprobantes_suscripcion', 'public');

    SuscripcionPremium::create([
        'user_id' => Auth::id(),
        'comprobante' => $path,
        'estado' => 'pendiente',
    ]);

    return back()->with('success', 'Solicitud enviada. Espera aprobación.');
}

}

