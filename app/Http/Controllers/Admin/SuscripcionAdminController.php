<?php

// app/Http/Controllers/Admin/SuscripcionAdminController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SuscripcionPremium;
use App\Models\User;
use Carbon\Carbon;

class SuscripcionAdminController extends Controller
{
    public function index()
    {
        $suscripciones = SuscripcionPremium::with('user')->latest()->paginate(20);
        return view('admin.suscripciones.index', compact('suscripciones'));
    }

    public function aprobar($id)
{
    $suscripcion = SuscripcionPremium::findOrFail($id);
    $suscripcion->estado = 'aprobado';
    $suscripcion->save();

    // Obtener el usuario relacionado
    $user = $suscripcion->user;
    $user->es_premium = true;
    $user->premium_desde = Carbon::now();
    $user->premium_hasta = Carbon::now()->addMonth();
    $user->save();

    // ✅ Enviar notificación al usuario
    $user->notify(new \App\Notifications\ConfirmacionSuscripcion());

    return back()->with('success', 'Suscripción aprobada correctamente.');
}


    public function rechazar(SuscripcionPremium $suscripcion)
    {
        $suscripcion->update(['estado' => 'rechazado']);
        return back()->with('success', 'Suscripción rechazada.');
    }
}
