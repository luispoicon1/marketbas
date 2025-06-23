<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuscripcionPremium extends Model
{
    protected $table = 'suscripcion_premiums';
    protected $fillable = [
        'user_id', // y cualquier otro campo que tenga tu tabla
        'fecha_inicio',
        'fecha_fin',
        'comprobante',
        'estado'
    ];

    // Relación con el usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
