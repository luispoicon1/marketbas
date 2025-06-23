<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;
use App\Models\Subpedido;

class PedidoListoParaRecojo extends Notification
{
    use Queueable;

    protected $subpedido;

    public function __construct(Subpedido $subpedido)
    {
        $this->subpedido = $subpedido;
    }

    public function via($notifiable)
    {
        return ['database']; // Podrías añadir 'mail' si también quieres correo
    }

    public function toDatabase($notifiable)
    {
        return [
            'subpedido_id' => $this->subpedido->id,
            'negocio' => $this->subpedido->negocio->nombre,
            'mensaje' => 'Un nuevo pedido está listo para recojo en ' . $this->subpedido->negocio->nombre,
        ];
    }
}

