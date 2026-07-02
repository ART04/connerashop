<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modelo CotizacionItem: un producto solicitado dentro de una cotizacion.
 */
class CotizacionItem extends Model
{
    protected $table = 'cotizacion_items';

    protected $fillable = [
        'cotizacion_id',
        'producto_id',
        'producto_nombre',
        'cantidad',
        'observaciones',
    ];

    /**
     * Este item pertenece a una cotizacion.
     */
    public function cotizacion()
    {
        return $this->belongsTo(Cotizacion::class, 'cotizacion_id');
    }

    /**
     * Este item apunta a un producto (si aun existe).
     */
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }
}