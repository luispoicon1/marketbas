<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Negocio extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'nombre', 'ruc', 'direccion', 'descripcion',
        'categoria', 'foto', 'estado', 'telefono', 'numero_tienda'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function productos()
{
    return $this->hasMany(Producto::class);
}

}

