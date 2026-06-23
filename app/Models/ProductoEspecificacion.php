<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modelo de una caracteristica tecnica de un producto.
 * Ej: "Voltaje de circuito abierto" -> "48.10 Vcc"
 */
class ProductoEspecificacion extends Model
{
    // Nombre REAL de la tabla en la base de datos (confirmado con db:show)
    protected $table = 'producto_especificaciones';

    protected $fillable = [
        'producto_id',
        'etiqueta',
        'valor',
        'orden',
    ];

    // Esta caracteristica pertenece a un producto
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }
}