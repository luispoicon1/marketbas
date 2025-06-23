<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComentarioProducto extends Model
{
    protected $table = 'comentarios_productos';

    protected $fillable = [
        'producto_id',
        'user_id',
        'comentario',
        'calificacion',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

