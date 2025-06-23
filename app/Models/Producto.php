<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = [
        'negocio_id',
        'nombre',
        'descripcion',
        'stock',
        'precio',
        'imagen',
        'precio_descuento',
    ];

    // Relación con negocio
    public function negocio()
    {
        return $this->belongsTo(Negocio::class);
    }

    public function detalles()
    {
        return $this->hasMany(DetallePedido::class);
    }

    public function comentarios()
{
    return $this->hasMany(ComentarioProducto::class);
}

public function promedioCalificacion()
{
    return $this->comentarios()->avg('calificacion');
}


}
