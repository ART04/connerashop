<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Categoria: representa una categoría del catálogo.
 * Es el "puente" entre tu código y la tabla 'categorias' de la base de datos.
 */
class Categoria extends Model
{
    // Le decimos a Laravel a qué tabla pertenece este modelo
    protected $table = 'categorias';

    // Campos que se pueden guardar/editar de forma masiva (por seguridad)
    protected $fillable = [
        'nombre',
        'slug',
        'descripcion',
        'activo',
        'orden',
    ];

    // Convierte 'activo' a verdadero/falso real al leerlo (en vez de 1/0)
    protected $casts = [
        'activo' => 'boolean',
    ];
}