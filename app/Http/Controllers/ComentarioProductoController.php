<?php

namespace App\Http\Controllers;

use App\Models\ComentarioProducto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ComentarioProductoController extends Controller
{
public function store(Request $request)
{
    $request->validate([
        'producto_id' => 'required|exists:productos,id',
        'comentario' => 'required|string|max:1000',
        'calificacion' => 'required|integer|min:1|max:5',
    ]);

    ComentarioProducto::create([
        'producto_id' => $request->producto_id,
        'user_id' => Auth::id(),
        'comentario' => $request->comentario,
        'calificacion' => $request->calificacion,
    ]);

    return back()->with('success', 'Comentario agregado correctamente.');
}
}


