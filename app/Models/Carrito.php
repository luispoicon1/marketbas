<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carrito extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function productos()
    {
        // Laravel inferirá 'carrito_productos' como nombre de tabla pivote
        return $this->belongsToMany(Producto::class, 'carrito_producto')
    ->withPivot('cantidad')
    ->withTimestamps();


}
}
