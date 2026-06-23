<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Categoria: representa una categoria del catalogo.
 * Es el puente entre tu codigo y la tabla 'categorias'.
 */
class Categoria extends Model
{
    protected $table = 'categorias';

    protected $fillable = [
        'nombre',
        'slug',
        'descripcion',
        'activo',
        'orden',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    /**
     * RELACION: una categoria tiene muchos productos.
     * Permite hacer  $categoria->productos  para ver todos
     * los productos que pertenecen a esta categoria.
     */
    public function productos()
    {
        return $this->hasMany(Producto::class, 'categoria_id');
    }
}