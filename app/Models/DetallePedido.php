<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetallePedido extends Model
{
    protected $fillable = ['subpedido_id', 'producto_id', 'cantidad', 'precio'];

    public function subpedido()
    {
        return $this->belongsTo(Subpedido::class);
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}

