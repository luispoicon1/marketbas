<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subpedido extends Model
{
    const ESTADO_PENDIENTE = 'pendiente';
    const ESTADO_EN_PROCESO = 'en_proceso';
    const ESTADO_ENTREGADO = 'entregado';
    const ESTADO_PENDIENTE_PAGO = 'pendiente_pago';
    
    protected $fillable = [
        'pedido_id',
        'negocio_id',
        'subtotal',
        'estado',
        'marcado_como_entregado' // Asegúrate de agregar este campo
    ];

    public function detalles()
    {
        return $this->hasMany(DetallePedido::class); 
    }

    public function pago()
    {
        return $this->hasOne(Pago::class);
    }

    public function negocio()
    {
        return $this->belongsTo(Negocio::class)->with('user');
    }

    public function pedido()
    {
        return $this->belongsTo(Pedido::class)->with('user');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }


    
}