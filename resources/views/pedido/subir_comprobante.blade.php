@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 bg-white rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-6 text-center">Subir comprobante para Pedido </h2>

    <div class="mb-6 text-center bg-gray-100 p-4 rounded-lg">
    <h3 class="text-lg font-semibold mb-2">Resumen de Pedido</h3>
    @if($pedido->tipo_entrega === 'delivery')
    <p><strong>Dirección:</strong> {{ $pedido->user->direccion }}</p>
    <p><strong>Distrito:</strong> {{ $pedido->user->distrito }}</p>
@else
    <p><strong>Recojo en tienda:</strong> El cliente contactara al negocio para coordinar el recojo.</p>
@endif

@if($pedido->mensaje)
    <p><strong>Mensaje del comprador:</strong> {{ $pedido->mensaje }}</p>
@endif

<p class="text-gray-700">Subtotal de productos: 
    <strong>S/ {{ number_format($pedido->total - $pedido->costo_delivery, 2) }}</strong>
</p>

@if($pedido->tipo_entrega === 'delivery')
    <p class="text-gray-600">Costo de delivery: 
        <strong>S/ {{ number_format($pedido->costo_delivery, 2) }}</strong>
    </p>
@endif

<p class="text-gray-800 font-bold text-lg mt-2">
    Total a pagar: 
    <span class="text-green-700">S/ {{ number_format($pedido->total, 2) }}</span>
</p>

</div>

{{-- Detalles de subpedidos y contacto con negocios --}}
@if($pedido->tipo_entrega === 'tienda')
    <div class="bg-gray-50 p-4 mb-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-4">Negocios para recojo en tienda</h3>

        @foreach ($pedido->subpedidos as $subpedido)
            <div class="p-4 bg-white rounded-lg shadow mb-4">
                <p><strong>Negocio:</strong> {{ $subpedido->negocio->nombre }}</p>
                <p><strong>Dirección:</strong> {{ $subpedido->negocio->direccion }}</p>
                <p><strong>Teléfono:</strong> {{ $subpedido->negocio->telefono }}</p>

                @php
                    $numero = preg_replace('/[^0-9]/', '', $subpedido->negocio->telefono);
                    if (!str_starts_with($numero, '51')) {
                        $numero = '51' . $numero;
                    }
                    $mensaje = urlencode("Hola, estoy coordinando el recojo de mi pedido en tienda.");
                    $link = "https://wa.me/$numero?text=$mensaje";
                @endphp

                <a href="{{ $link }}" target="_blank" class="mt-2 inline-block text-white bg-green-600 hover:bg-green-700 px-4 py-2 rounded">
                    📲 Contactar por WhatsApp
                </a>
            </div>
        @endforeach
    </div>
@endif





    <!-- Sección de información ficticia -->
    <div class="bg-gray-100 p-4 mb-6 rounded-lg">
        <h3 class="text-xl font-semibold mb-2 text-center">Información del Pago</h3>
        <div class="flex justify-center space-x-4">
            <!-- Logotipo de Yape -->
            <div class="flex flex-col items-center space-y-2">
                <img src="https://static.mercadonegro.pe/wp-content/uploads/2025/01/07154814/yape-app-1.png"  alt="Yape" class="w-12 h-12">
                <p class="text-sm">Número de YAPE: 937-212-007</p>
            </div>

            <!-- Logotipo de BCP -->
            <div class="flex flex-col items-center space-y-2">
                <img src="https://scontent.flim19-1.fna.fbcdn.net/v/t39.30808-6/218253547_4210671138989174_7834571283899497044_n.jpg?_nc_cat=1&ccb=1-7&_nc_sid=6ee11a&_nc_eui2=AeHu1h1cn4MAbFm4xtME9d2_eesZGuEpOV156xka4Sk5XWALNz8SzBFjSGELiwPq4ycJwkcxwfbvX-i7GSN5tzV_&_nc_ohc=ngXL6DxeYxwQ7kNvwGrze93&_nc_oc=AdmWvxEpjdOloBHwPQ_rWyrAX_nmaNEqjK2_r8vG2nqmiPxbg1vk59_U8DGpk1sNrO0&_nc_zt=23&_nc_ht=scontent.flim19-1.fna&_nc_gid=HcM07dJLcWw8JaaBBjz5Bw&oh=00_AfMcA2ztQPcTz2-bZklITIkfx4EW5xJ_vLDcv2WDB3rxOQ&oe=685BA4D1" alt="BCP" class="w-12 h-12">
                <p class="text-sm">Número de cuenta: 3157-0380-6010-13</p>
                <p class="text-sm">Número de cuenta interbancaria: 0023-1517-0380-6010-1306</p>
            </div>

            <!-- Logotipo de BanBif -->
            <div class="flex flex-col items-center space-y-2">
                <img src="https://scontent.flim19-1.fna.fbcdn.net/v/t39.30808-6/271935630_4930783883610793_8071414256085761683_n.jpg?_nc_cat=1&ccb=1-7&_nc_sid=6ee11a&_nc_eui2=AeFo7kn1N__twPKfrmhNCqi9AMioM5G7Hh8AyKgzkbseH2hMu5L1ECXvhxM-Gm-IWBUFhRlULXbS_KlzEHchvzHw&_nc_ohc=HTEQ51yt_moQ7kNvwFQwf1d&_nc_oc=AdlVzVvb05iU4QAjw8bWJbGAkTIzh7csLtI9kH9rjrs4g6HYx7CzyB3GFOMjWaW8PWQ&_nc_zt=23&_nc_ht=scontent.flim19-1.fna&_nc_gid=8TnwLUcFuplV-h2mHV4WTQ&oh=00_AfOnXBs_LlEL93j83bVqCFcyxYfL7h82I_66UrWV6ex9FA&oe=685BA7FB" alt="BanBif" class="w-12 h-12">
                <p class="text-sm">Número de cuenta: 1234-5678-9012-3456</p>
            </div>
        </div>
    </div>

    <!-- Formulario para subir comprobante -->
    <form action="{{ route('pedido.guardarComprobante', $pedido) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="comprobante" class="block mb-2">Comprobante (jpg, png, pdf):</label>
        <input type="file" id="comprobante" name="comprobante" required class="mb-4">
        <button type="submit" class="bg-[#C85C5C] hover:bg-[#B54B4B] text-white px-4 py-2 rounded-lg transition duration-300"> 
            Subir comprobante
        </button>
    </form>

<!-- Instrucciones visuales -->
<div class="mt-10 bg-gray-50 p-6 rounded-lg shadow-inner">
    <h3 class="text-lg font-semibold mb-4 text-center">¿Cómo hacer transferencias o yape?</h3>
    <p class="text-sm text-gray-600 text-center mb-6">Sigue estos pasos para asegurarte de que tu pago sea verificado rápidamente.</p>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Paso 1 -->
        <div class="text-center">
            <img src="https://scontent.flim19-1.fna.fbcdn.net/v/t39.30808-6/348650620_741509774421868_7436454957310363897_n.png?_nc_cat=101&ccb=1-7&_nc_sid=127cfc&_nc_eui2=AeGcyuCjKPXuHHZd_1PJ9Fn3FCqLcg7qXKAUKotyDupcoPTWWdps5njiXyuLVHMYU9ZwBBrxnxx5WYtgS5uk5MOT&_nc_ohc=c-YIDX_dN5QQ7kNvwHMTSnI&_nc_oc=Adm1zSKUSI4JCKWwUUr7wbUExrUvr_yQsgv92d1-hUSv_aJaWtj1xa0y9OK4jghJmK4&_nc_zt=23&_nc_ht=scontent.flim19-1.fna&_nc_gid=-NVtQUf6bIFL6rIGzHFK1Q&oh=00_AfOw2I4cPf8a0fEKPERsANwGfUKBMaZJeKNh1FzaOjcDhQ&oe=685B9644" 
                 alt="Paso 1" class="mx-auto rounded-lg shadow-md w-full max-w-xs">
            <p class="mt-3 text-sm text-gray-700"></p>
        </div>

        <!-- Paso 2 -->
        <div class="text-center">
            <img src="https://scontent.flim19-1.fna.fbcdn.net/v/t39.30808-6/349911308_189902564002165_2338461570909479407_n.png?_nc_cat=105&ccb=1-7&_nc_sid=127cfc&_nc_eui2=AeHPPeSMVIn2DJXemrd1ic4PnvmOG-JKRZSe-Y4b4kpFlFZI_4mmCfUkwkHvyQR9ahOBdtkLxD7Xk1bBOQXbcalo&_nc_ohc=LLisLdLw_s0Q7kNvwF80sPq&_nc_oc=Adk5WtTzgcb1YCfNbM2UYsshFRK_cHTDZc448EO0Gs7m0R-IViy37f17GaUPpXG8MKI&_nc_zt=23&_nc_ht=scontent.flim19-1.fna&_nc_gid=-ROuMAZMhNmR7_THwqGIDA&oh=00_AfMCVJcw0zD2O7X1mvSFx1vdqFzcgX-zBf2Q1dyoCiBZqQ&oe=685BBB65"
                 alt="Paso 2" class="mx-auto rounded-lg shadow-md w-full max-w-xs">
            <p class="mt-3 text-sm text-gray-700"></p>
        </div>
    </div>
</div>


</div>
@endsection