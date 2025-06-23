<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto; // Necesario para el método index()

class TiendaController extends Controller
{
    /**
     * Muestra la lista de productos disponibles en la tienda.
     * Solo incluye productos de negocios que están aprobados.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Obtener productos de negocios aprobados
        $productos = Producto::with('negocio')
            ->whereHas('negocio', function ($q) {
                $q->where('estado', 'aprobado');
            })
            ->get();

        // Retorna la vista 'tienda' con los productos
        return view('tienda', compact('productos'));
    }

    //
    // ¡¡¡ ATENCIÓN !!!
    // LOS SIGUIENTES MÉTODOS RELACIONADOS CON EL CARRITO
    // DEBEN SER ELIMINADOS DE ESTE CONTROLADOR
    // YA QUE LA LÓGICA DEL CARRITO ESTÁ CENTRALIZADA EN PedidoController
    //

    /*
    public function agregarAlCarrito(Request $request, Producto $producto)
    {
        // Esta lógica de carrito basada en sesión NO debe estar aquí.
        // La funcionalidad de agregar al carrito ahora la maneja PedidoController@agregarProducto
    }

    public function verCarrito()
    {
        // Esta lógica de carrito basada en sesión NO debe estar aquí.
        // La funcionalidad de ver el carrito ahora la maneja PedidoController@carrito
    }

    public function eliminarDelCarrito($productoId)
    {
        // Esta lógica de carrito basada en sesión NO debe estar aquí.
        // La funcionalidad de eliminar del carrito ahora la maneja PedidoController@eliminarDelCarrito
    }
    */
}