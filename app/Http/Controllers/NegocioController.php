<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Negocio;
use Illuminate\Support\Facades\Auth;

class NegocioController extends Controller
{
    public function create()
    {
        return view('negocios.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'ruc' => 'required|string|unique:negocios',
            'direccion' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'categoria' => 'required|string|max:100',
            'foto' => 'nullable|image|max:2048',
        ]);

        $negocio = new Negocio();
        $negocio->user_id = Auth::id();
        $negocio->nombre = $request->nombre;
        $negocio->ruc = $request->ruc;
        $negocio->direccion = $request->direccion;
        $negocio->descripcion = $request->descripcion;
        $negocio->categoria = $request->categoria;

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('negocios', 'public');
            $negocio->foto = $path;
        }

        $negocio->estado = 'pendiente';
        $negocio->save();

        return redirect()->route('home')->with('success', 'Negocio registrado, esperando aprobación.');
    }

    // app/Http/Controllers/NegocioController.php

public function formulario()
{
    return view('negocios.create');
}


}

