<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $fillable = [
        'user_id',
        'total',
        'estado',
        'comprobante',
        'tipo_entrega',        // "delivery" o "tienda"
        'costo_delivery',      // monto en soles
        'direccion_entrega',   // dirección donde desea el delivery
        'distancia_km',        // si decides guardar los km (opcional)
    ];
    

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subpedidos()
    {
        return $this->hasMany(Subpedido::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
