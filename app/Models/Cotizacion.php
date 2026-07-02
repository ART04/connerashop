<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Cotizacion: una solicitud de cotizacion hecha por un cliente.
 */
class Cotizacion extends Model
{
    // Nombre REAL de la tabla (confirmado con db:show)
    protected $table = 'cotizaciones';

    protected $fillable = [
        'folio',
        'user_id',
        'nombre',
        'email',
        'telefono',
        'empresa',
        'comentarios',
        'recibo_cfe',
        'estado',
    ];

    /**
     * Una cotizacion pertenece a un cliente (usuario).
     */
    public function cliente()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Una cotizacion tiene muchos items (productos solicitados).
     */
    public function items()
    {
        return $this->hasMany(CotizacionItem::class, 'cotizacion_id');
    }
}