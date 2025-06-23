<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Services\OpenRouteService;


class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
{
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
        'telefono' => ['nullable', 'string', 'max:20'],
        'coordenadas' => ['nullable', 'regex:/^-?\d+(\.\d+)?,-?\d+(\.\d+)?$/'],
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'telefono' => $request->telefono,
        'departamento' => $request->departamento,
        'provincia' => $request->provincia,
        'distrito' => $request->distrito,
        'direccion' => $request->direccion,
        'referencia' => $request->referencia,
    ]);

    if ($request->filled('coordenadas')) {
        [$lat, $lng] = explode(',', $request->coordenadas);

        if (is_numeric($lat) && is_numeric($lng)) {
            $user->lat = floatval($lat);
            $user->lng = floatval($lng);
            $user->save();
        }
    } else {
        // No hacer nada, no usamos la dirección para geolocalizar
    }

    event(new Registered($user));
    Auth::login($user);

    return redirect(route('dashboard', absolute: false));
}

}
