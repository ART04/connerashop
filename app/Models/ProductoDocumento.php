<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modelo de un documento PDF descargable de un producto.
 * Ej: "Ficha tecnica" -> productos/docs/ficha.pdf
 */
class ProductoDocumento extends Model
{
    protected $table = 'producto_documentos';

    protected $fillable = [
        'producto_id',
        'titulo',
        'archivo',
        'orden',
    ];

    // Este documento pertenece a un producto
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }
}