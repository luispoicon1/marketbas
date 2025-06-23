<?php



namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;


class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_photo', // Para almacenar la ruta de la foto de perfil
        'telefono',     // Campo para contacto
        'es_premium',   // Boolean para rol premium
        'premium_desde', // Fecha inicio suscripción
        'premium_hasta', // Fecha fin suscripción
        'departamento', // 👈 Añadido: Departamento
        'provincia',   // 👈 Añadido: Provincia
        'distrito',    // 👈 Añadido: Distrito
        'direccion',   // 👈 Añadido: Dirección exacta
        'referencia',  // 👈 Opcional: Referencia adicional
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'es_premium' => 'boolean',
            'premium_desde' => 'date',
            'premium_hasta' => 'date',
        ];
    }

    /**
     * Relación: Usuario tiene un negocio (si es vendedor)
     */
    public function negocio()
    {
        return $this->hasOne(Negocio::class);
    }

    /**
     * Relación: Usuario tiene un carrito
     */
    public function carrito()
    {
        return $this->hasOne(Carrito::class);
    }

    /**
     * Verifica si el usuario es comprador premium
     */
    public function esCompradorPremium()
    {
        return $this->es_premium && $this->premium_hasta && $this->premium_hasta->isFuture();
    }

    /**
     * Relación con la suscripción premium
     */
    public function suscripcion()
    {
        return $this->hasOne(SuscripcionPremium::class);
    }
}
