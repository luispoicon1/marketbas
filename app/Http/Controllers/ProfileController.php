<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Pedido;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
{
    $pedidos = Pedido::with('subpedidos.negocio')
        ->where('user_id', $request->user()->id)
        ->latest()
        ->get();

    return view('profile.edit', [
        'user' => $request->user(),
        'pedidos' => $pedidos,
    ]);
}


    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
{
    $user = $request->user();

    // Validación y asignación de campos de texto
    $user->fill($request->validated());

    // Procesar la foto si fue enviada
    if ($request->hasFile('profile_photo')) {
        $file = $request->file('profile_photo');
        $path = $file->store('profile_photos', 'public');
        $user->profile_photo = $path;
    }

    // Si el correo cambió, se marca como no verificado
    if ($user->isDirty('email')) {
        $user->email_verified_at = null;
    }

    // Guardar cambios
    $user->save();

    return Redirect::route('profile.edit')->with('status', 'profile-updated');
}


    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
