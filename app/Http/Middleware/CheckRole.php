<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();

        // Verifica si el rol del usuario está en la lista de roles permitidos
        if (!in_array($user->role, $roles)) {
            abort(403, 'Acceso no autorizado');
        }

        return $next($request);
    }
}
