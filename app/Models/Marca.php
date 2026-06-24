<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Marca: representa una marca/fabricante.
 * Sus logos se muestran en un carrusel en el sitio publico.
 */
class Marca extends Model
{
    protected $table = 'marcas';

    protected $fillable = [
        'nombre',
        'logo',
        'sitio_web',
        'activo',
        'orden',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];
}