<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NegocioController;
use App\Http\Controllers\AdminController;
use App\Models\Producto; // Puedes eliminar esto si solo lo usas en closures y prefieres no importarlo.
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\TiendaController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\VendedorController; // ¡Importación necesaria!
use App\Http\Controllers\AdminPedidoController;
use App\Http\Controllers\Vendedor\DashboardController;
use App\Http\Controllers\AdminPagoController;
use App\Http\Controllers\BoletaController;
use App\Http\Controllers\Admin\FinanzasController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\SuscripcionController;
use App\Http\Controllers\Admin\SuscripcionAdminController;
use App\Notifications\ConfirmacionSuscripcion;
use App\Http\Controllers\ComentarioProductoController;


/*
|--------------------------------------------------------------------------
| RUTA PRINCIPAL
|--------------------------------------------------------------------------
| Redirige al login si no está autenticado, si lo está, muestra selección
| de rol (comprador o vendedor).
*/
Route::get('/', function () {
    if (!Auth::check()) {
        return redirect()->route('login');
    }
    return view('welcome'); // Vista con botones para elegir rol
})->name('home');

/*
|--------------------------------------------------------------------------
| DASHBOARD GENERAL (si decides usarlo)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

/*
|--------------------------------------------------------------------------
| INICIO COMO COMPRADOR
|--------------------------------------------------------------------------
| Redirige a la tienda directamente.
*/
Route::get('/comprador/inicio', function () {
    return redirect()->route('tienda');
})->name('comprador.inicio');

/*
|--------------------------------------------------------------------------
| INICIO COMO VENDEDOR
|--------------------------------------------------------------------------
| Si el negocio fue aprobado, va al dashboard.
| Si no, redirige al formulario de registro de negocio.
*/
Route::get('/vendedor/inicio', function () {
    $user = Auth::user();
    if (!$user) return redirect()->route('login'); // Mejor usar route()

    if ($user->negocio && $user->negocio->estado === 'aprobado') {
        return redirect()->route('vendedor.dashboard'); // Esta es la ruta que buscábamos
    }
    return redirect()->route('negocio.formulario');
})->name('vendedor.inicio');

/*
|--------------------------------------------------------------------------
| TIENDA (visible a todos)
|--------------------------------------------------------------------------
*/
Route::get('/tienda', function () {
    $productos = Producto::with('negocio')->whereHas('negocio', function ($q) {
        $q->where('estado', 'aprobado');
    })->get();
    return view('tienda', compact('productos'));
})->name('tienda');

Route::get('/productos/{producto}', [ProductoController::class, 'show'])->name('productos.show');
Route::get('/productos', [ProductoController::class, 'index'])->name('productos.index');


/*
|--------------------------------------------------------------------------
| RUTAS AUTENTICADAS (Generales para cualquier usuario logueado)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    /* REGISTRO DE NEGOCIO (formulario y almacenamiento) */
    Route::get('/vendedor/registro-negocio', [NegocioController::class, 'formulario'])->name('negocio.formulario');
    Route::post('/vendedor/registro-negocio', [NegocioController::class, 'store'])->name('negocios.store');

    /* PERFIL DE USUARIO */
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


/*
|--------------------------------------------------------------------------
| RUTAS PARA VENDEDORES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:vendedor'])->prefix('vendedor')->group(function () {
    // Definimos la ruta del dashboard del vendedor
    Route::get('/dashboard', [VendedorController::class, 'dashboard'])->name('vendedor.dashboard');

    // Rutas de productos (usando Route::resource)
    Route::resource('productos', ProductoController::class)->except(['show']);
});

Route::middleware(['auth', 'role:vendedor'])->group(function () {
    Route::get('/vendedor/pagos', [App\Http\Controllers\VendedorPagoController::class, 'index'])->name('vendedor.pagos.index');
    Route::post('/vendedor/pagos/{pago}/aprobar', [App\Http\Controllers\VendedorPagoController::class, 'aprobar'])->name('vendedor.pagos.aprobar');
    Route::get('/vendedor/dashboard', [DashboardController::class, 'index'])->name('vendedor.dashboard');
    Route::delete('/vendedor/pedidos/{id}/eliminar', [DashboardController::class, 'eliminar'])->name('vendedor.pedido.eliminar');
    Route::get('/vendedor/pedidos/{id}', [DashboardController::class, 'verPedido'])->name('vendedor.pedido.ver');
    Route::get('/vendedor/pagos/pendientes', [App\Http\Controllers\VendedorPagoController::class, 'pagosPendientes'])->name('vendedor.pagos.pendientes');
    Route::post('/vendedor/subpedido/{id}/listo', [DashboardController::class, 'marcarListoParaRecojo'])->name('vendedor.subpedido.listo');
    Route::post('/vendedor/pedidos/{id}/entregar', [DashboardController::class, 'marcarEntregado'])->name('vendedor.pedido.entregar');
    Route::post('/vendedor/pago/{id}/aprobar', [DashboardController::class, 'aprobarPago'])->name('vendedor.pago.aprobar'); 
    Route::get('/vendedor/productos', [ProductoController::class, 'index'])->name('vendedor.productos.index');
    Route::post('/vendedor/subpedido/{id}/listo', [DashboardController::class, 'marcarListoParaRecojo'])->name('vendedor.subpedido.listo');
});

Route::get('/boleta/{subpedido}', [BoletaController::class, 'generarBoleta'])
    ->middleware(['auth']) // Asegura que esté logueado
    ->name('boleta.subpedido');

/*
|--------------------------------------------------------------------------
| PANEL DE ADMINISTRADOR
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    // Negocios
    Route::get('/negocios', [AdminController::class, 'index'])->name('admin.negocios.index');
    Route::post('/negocios/{negocio}/aprobar', [AdminController::class, 'aprobar'])->name('admin.negocios.aprobar');
    Route::post('/negocios/{negocio}/rechazar', [AdminController::class, 'rechazar'])->name('admin.negocios.rechazar');
    
    // Pedidos
    Route::get('/pedidos', [AdminPedidoController::class, 'index'])->name('admin.pedidos.index');
    Route::get('/pedidos/{pedido}', [AdminPedidoController::class, 'ver'])->name('admin.pedidos.ver');
    Route::post('/pedidos/{pedido}/aprobar', [AdminPedidoController::class, 'aprobar'])->name('admin.pedidos.aprobar');
    Route::post('/pedidos/{pedido}/rechazar', [AdminPedidoController::class, 'rechazar'])->name('admin.pedidos.rechazar');
    
    // Pagos
    Route::get('/pagos', [AdminPagoController::class, 'index'])->name('admin.pagos.index');
    Route::get('/pagos/{subpedido}/crear', [AdminPagoController::class, 'crear'])->name('admin.pagos.crear');
    Route::post('/pagos/{subpedido}', [AdminPagoController::class, 'store'])->name('admin.pagos.store');
    
    // 👉 Ruta del Panel Financiero
    Route::post('/finanzas/{pago}/liquidar', [FinanzasController::class, 'liquidar'])->name('admin.finanzas.liquidar');
    Route::get('/finanzas', [FinanzasController::class, 'index'])->name('finanzas.index');
    Route::get('/admin/finanzas/exportar-pdf', [FinanzasController::class, 'exportarPDF'])->name('admin.finanzas.exportar.pdf');
    
     // Suscripciones
     Route::get('/suscripciones', [SuscripcionAdminController::class, 'index'])->name('admin.suscripciones.index');
     Route::post('/suscripciones/{suscripcion}/aprobar', [SuscripcionAdminController::class, 'aprobar'])->name('admin.suscripciones.aprobar');
     Route::post('/suscripciones/{suscripcion}/rechazar', [SuscripcionAdminController::class, 'rechazar'])->name('admin.suscripciones.rechazar');

  
});


// routes/web.php
Route::middleware(['auth', 'role:comprador'])->group(function () {
    Route::get('/suscribirse', [SuscripcionController::class, 'formulario'])->name('suscripcion.formulario');
    Route::post('/suscribirse', [SuscripcionController::class, 'enviar'])->name('suscripcion.enviar');
});


    
/*
|--------------------------------------------------------------------------
| RUTAS DE PEDIDOS Y CARRITO (Consolidado)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:comprador,vendedor,admin'])->group(function () {
    
    Route::get('/carrito', [PedidoController::class, 'carrito'])->name('pedido.carrito');
    Route::post('/carrito/agregar/{producto}', [PedidoController::class, 'agregarProducto'])->name('pedido.agregarProducto');
    Route::delete('/carrito/eliminar/{productoId}', [PedidoController::class, 'eliminarDelCarrito'])->name('pedido.eliminarDelCarrito');
    Route::post('/pedido/confirmar', [PedidoController::class, 'confirmarPedido'])->name('pedido.confirmar');
    Route::get('/pedido/{pedido}/comprobante', [PedidoController::class, 'subirComprobanteForm'])->name('pedido.subirComprobante');
    Route::post('/pedido/{pedido}/comprobante', [PedidoController::class, 'guardarComprobante'])->name('pedido.guardarComprobante');
    Route::post('/subpedidos/{subpedido}/confirmar-recepcion', [PedidoController::class, 'confirmarRecepcion'])->name('subpedidos.confirmar_recepcion');
    Route::post('/producto/comentario', [ComentarioProductoController::class, 'store'])->name('producto.comentario.store')->middleware('auth');

});
/*
|--------------------------------------------------------------------------
| RUTAS DELIVERY
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:delivery'])->group(function () {
    Route::get('/delivery/pedidos', [DeliveryController::class, 'index'])->name('delivery.pedidos');
    Route::post('/delivery/aceptar/{subpedido}', [DeliveryController::class, 'aceptar'])->name('delivery.aceptar');
    Route::get('/delivery/historial', [DeliveryController::class, 'historial'])->name('delivery.historial');
    Route::post('/delivery/entregar/{subpedido}', [DeliveryController::class, 'entregar'])->name('delivery.entregar');
});




/*
|--------------------------------------------------------------------------
| RUTAS DE AUTENTICACIÓN (login, registro, etc.)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

// Muestra el aviso "verifica tu correo"
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

// Verifica el correo cuando el usuario da clic en el link
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill(); // Marca como verificado
    return redirect('/dashboard'); // Puedes cambiar esta ruta
})->middleware(['auth', 'signed'])->name('verification.verify');

// Reenvía el correo de verificación
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', '¡Correo de verificación reenviado!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');
