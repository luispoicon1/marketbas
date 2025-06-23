<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Pedido;
use App\Policies\PedidoPolicy;
use Illuminate\Auth\Notifications\VerifyEmail;


class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Pedido::class => PedidoPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();

        // Puedes añadir gates aquí si quieres
    }
}
