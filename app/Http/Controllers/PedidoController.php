<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Pedido;
use App\Models\Subpedido;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Pago;
use Carbon\Carbon;
use App\Services\OpenRouteService;


class PedidoController extends Controller
{
    // Mostrar carrito del usuario (obtiene de DB)
    public function carrito()
    {
        $user = Auth::user();
        // Carga el carrito del usuario con sus productos y los negocios asociados a esos productos
        $carrito = $user->carrito()->with('productos.negocio')->first();

        // Si no hay carrito o está vacío, $carrito será null o su colección de productos estará vacía
        return view('pedido.carrito', compact('carrito'));
    }

    // Agregar producto al carrito (guarda en DB)
    public function agregarProducto(Request $request, Producto $producto)
{

    if ($producto->negocio->user_id == auth()->id()) {
        return back()->with('error', 'No puedes comprar tus propios productos.');
    }

    if (!$this->estaEnHorarioPermitido()) {
        return back()->with('error', 'Solo puedes agregar productos al carrito entre las 8:00 a. m. y 6:00 p. m.');
    }
    


    $user = Auth::user();
    $carrito = $user->carrito()->firstOrCreate([]);

    $request->validate(['cantidad' => 'required|integer|min:1']);
    
    // Verifica si el producto ya está en el carrito
    $existente = $carrito->productos()
                        ->where('producto_id', $producto->id)
                        ->first();

    if ($existente) {
        // Actualiza la cantidad
        $nuevaCantidad = $existente->pivot->cantidad + $request->cantidad;
        $carrito->productos()->updateExistingPivot($producto->id, [
            'cantidad' => $nuevaCantidad
        ]);
    } else {
        // Agrega nuevo producto
        $carrito->productos()->attach($producto->id, [
            'cantidad' => $request->cantidad
        ]);
    }

    return back()->with('success', 'Producto agregado al carrito.');
}


    // Eliminar producto del carrito (actualiza en DB)
    public function eliminarDelCarrito($productoId)
    {
        $user = Auth::user();
        $carrito = $user->carrito()->first(); // Obtiene el carrito del usuario desde la DB

        if (!$carrito) {
            return back()->withErrors('Tu carrito está vacío o no se encontró.');
        }

        // Desasocia el producto del carrito eliminando la entrada en la tabla pivote
        $detached = $carrito->productos()->detach($productoId);

        if ($detached) {
            return back()->with('success', 'Producto eliminado del carrito correctamente.');
        } else {
            return back()->withErrors('El producto no se encontró en tu carrito.');
        }
    }

    // Confirmar pedido: genera pedido principal y subpedidos por negocio (opera con DB)
    public function confirmarPedido(Request $request)
{
    $horaActual = Carbon::now()->format('H:i');

    if ($horaActual >= '20:00') {
        return back()->with('error', 'Los pedidos solo se pueden realizar antes de las 8:00 p. m.');
    }

    $request->validate([
    'tipo_entrega' => 'required|in:tienda,delivery',
]);


    $user = Auth::user();
    $carrito = $user->carrito()->with('productos.negocio')->first();

    if (!$carrito || $carrito->productos->isEmpty()) {
        return back()->withErrors('El carrito está vacío.');
    }

    // 👉 Calcular el costo del delivery
    $tipoEntrega = $request->tipo_entrega;
    $deliveryCosto = 0;

    if ($tipoEntrega === 'delivery' && $user->lat && $user->lng) {
        $ors = new OpenRouteService();
    
        $distanciaKm = $ors->calcularDistancia($user->lat, $user->lng); // ✅ CORRECTO
    
    
        if ($distanciaKm !== null)
        
        
        
        {
            $costoBase = 4; // base mínima
$costoPorKmExtra = 1; // 1 sol por cada km adicional después de 2 km

if ($distanciaKm <= 4) {
    $deliveryCosto = $costoBase;
} else {
    $deliveryCosto = $costoBase + ceil($distanciaKm - 3) * $costoPorKmExtra;
}
        }
}
    

    DB::beginTransaction();
    try {
        $total = 0;

        // 🛒 Crear el pedido principal
        $pedido = Pedido::create([
            'user_id' => $user->id,
            'total' => 0, // se actualizará después
            'estado' => 'pendiente_pago',
            'tipo_entrega' => $tipoEntrega,
            'costo_delivery' => $deliveryCosto,
        ]);

        // Agrupar productos por negocio
        $productosPorNegocio = $carrito->productos->groupBy('negocio_id');

        foreach ($productosPorNegocio as $negocioId => $productos) {
            $subtotal = 0;

            $subpedido = Subpedido::create([
                'pedido_id' => $pedido->id,
                'negocio_id' => $negocioId,
                'subtotal' => 0,
                'estado' => 'pendiente',
            ]);

            foreach ($productos as $producto) {
                $cantidad = $producto->pivot->cantidad;
                $precioUnitario = $producto->precio;

                if ($user->esCompradorPremium()) {
                    $precioUnitario *= 0.9;
                }

                $subtotalLinea = $precioUnitario * $cantidad;
                $subtotal += $subtotalLinea;
            }

            $subpedido->subtotal = $subtotal;
            $subpedido->save();

            Pago::create([
                'subpedido_id' => $subpedido->id,
                'monto' => $subtotal,
                'comprobante' => null,
                'estado' => 'pendiente',
            ]);

            $total += $subtotal;
        }

        // 💰 Sumar costo de delivery al total general
        $pedido->total = $total + $deliveryCosto;
        $pedido->save();

        $carrito->productos()->detach();

        DB::commit();

        return redirect()->route('pedido.subirComprobante', $pedido->id)
            ->with('success', 'Pedido creado correctamente. Por favor sube el comprobante de pago.');

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->withErrors('Error al crear el pedido: ' . $e->getMessage());
    }
}

public function calcularCostoDelivery()
{
    $cliente = auth()->user();
    $delivery = new OpenRouteService();

    // Coordenadas del mercado de Chincha Alta (ejemplo)
    $origen = [-76.1314, -13.4215]; // long, lat

    // Coordenadas del cliente — deberás geocodificarlas si solo tienes dirección
    $destino = [-76.1201, -13.4198]; // long, lat

    $distancia = $delivery->calcularDistancia($origen, $destino);

    if ($distancia <= 2) {
        $costo = 4;
    } elseif ($distancia <= 4) {
        $costo = 6;
    } else {
        $costo = 8;
    }

    return response()->json([
        'distancia_km' => $distancia,
        'costo_delivery' => $costo
    ]);
}

public function calcularCostoDesdeDireccionUsuario()
{
    $usuario = auth()->user();
    $ors = new OpenRouteService();

    $direccionCompleta = $usuario->direccion . ', ' . $usuario->distrito . ', ' . $usuario->provincia . ', ' . $usuario->departamento;

    $coordenadasDestino = $ors->obtenerCoordenadasDesdeDireccion($direccionCompleta);

    if (!$coordenadasDestino) {
        return response()->json(['error' => 'No se pudo geolocalizar la dirección'], 422);
    }

    // Coordenadas del Mercado de Abastos de Chincha Alta (ejemplo)
    $coordenadasOrigen = [-76.1314, -13.4215];

    $distancia = $ors->calcularDistancia($coordenadasOrigen, $coordenadasDestino);

    if ($distancia <= 2) {
        $costo = 4;
    } elseif ($distancia <= 4) {
        $costo = 6;
    } else {
        $costo = 8;
    }

    return response()->json([
        'direccion' => $direccionCompleta,
        'distancia_km' => $distancia,
        'costo_delivery' => $costo
    ]);
}

    // Formulario para subir comprobante
    public function subirComprobanteForm(Pedido $pedido)
    {
        // Autoriza que solo el dueño del pedido pueda ver este formulario
        $this->authorize('view', $pedido);

        return view('pedido.subir_comprobante', compact('pedido'));
    }

    // Guardar comprobante de pago
    public function guardarComprobante(Request $request, Pedido $pedido)
    {
        // Autoriza que solo el dueño del pedido pueda actualizarlo
        $this->authorize('update', $pedido);

        // Valida que se haya subido un archivo, que sea de un tipo permitido y no exceda 2MB
        $request->validate([
            'comprobante' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Almacena el archivo en el disco 'public' dentro de la carpeta 'comprobantes'
        $path = $request->file('comprobante')->store('comprobantes', 'public');
        $pedido->comprobante = $path; // Guarda la ruta del archivo en la base de datos
        $pedido->estado = 'pendiente_verificacion'; // Cambia el estado del pedido
        $pedido->save(); // Guarda los cambios en el pedido

        // Redirige al carrito con un mensaje de éxito
        return redirect()->route('pedido.carrito')->with('success', 'Comprobante subido, esperando verificación.');
    }

    public function confirmarRecepcion(Subpedido $subpedido)
{
    $subpedido->load('pedido'); // Asegura que la relación esté cargada

    
    if ($subpedido->pedido->user_id !== auth()->id()) {
        abort(403, 'No autorizado.');
    }

    if (!in_array($subpedido->estado, ['entregado'])) {
        return back()->withErrors('Este pedido no se puede confirmar aún.');
    }

    $subpedido->estado = 'entregado_confirmado';
    $subpedido->save();

    return back()->with('success', 'Has confirmado la recepción del pedido.');
}

private function estaEnHorarioPermitido()
{
    $hora = Carbon::now()->setTimezone('America/Lima')->format('H');
    return $hora >= 8 && $hora < 21;
}



}