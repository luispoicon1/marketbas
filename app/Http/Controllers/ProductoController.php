<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Auth::user()->negocio->productos;
        return view('vendedor.productos.index', compact('productos'));
    }

    public function create()
    {
        return view('vendedor.productos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'precio' => 'required|numeric',
            'stock' => 'required|integer',
            'imagen' => 'nullable|image|max:2048',
            'precio_descuento' => 'nullable|numeric|min:0',
        ]);
    
        $imagenPath = null;
    
        if ($request->hasFile('imagen')) {
            $imagenPath = $request->file('imagen')->store('productos', 'public');
        }
    
        Producto::create([
            'nombre' => $request->nombre,
            'precio' => $request->precio,
            'stock' => $request->stock,
            'imagen' => $imagenPath,
            'negocio_id' => auth()->user()->negocio->id,
            'precio_descuento' => $request->precio_descuento,
        ]);
    
        return redirect()->route('productos.index')->with('success', 'Producto creado');
    }
    

    public function edit(Producto $producto)
    {
        $this->authorizeAccess($producto);
        return view('vendedor.productos.edit', compact('producto'));
    }

    public function show(Producto $producto)
    {
        return view('vendedor.productos.show', compact('producto'));
    }
    




    public function update(Request $request, Producto $producto)
    {
        $this->authorizeAccess($producto);

        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'precio_descuento' => 'nullable|numeric|min:0',
        ]);

        $producto->update($request->all());

        return redirect()->route('productos.index')->with('success', 'Producto actualizado.');
    }

    



    public function destroy(Producto $producto)
    {
        $this->authorizeAccess($producto);
        $producto->delete();

        return redirect()->route('productos.index')->with('success', 'Producto eliminado.');
    }

    private function authorizeAccess(Producto $producto)
    {
        if ($producto->negocio_id !== Auth::user()->negocio->id) {
            abort(403, 'No tienes permiso para acceder a este producto.');
        }
    }
}
