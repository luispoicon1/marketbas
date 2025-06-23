<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $fillable = ['subpedido_id', 'monto', 'comprobante', 'estado'];

    public function subpedido()
{
    return $this->belongsTo(Subpedido::class);
}

}

