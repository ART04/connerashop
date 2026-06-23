<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Producto: representa un producto del catalogo.
 */
class Producto extends Model
{
    protected $table = 'productos';

    protected $fillable = [
        'nombre',
        'slug',
        'categoria_id',
        'descripcion',
        'precio',
        'marca',
        'imagen',
        'enlace_amazon',
        'enlace_mercadolibre',
        'destacado',
        'activo',
        'orden',
    ];

    protected $casts = [
        'destacado' => 'boolean',
        'activo'    => 'boolean',
        'precio'    => 'decimal:2',
    ];

    /**
     * Cada producto pertenece a una categoria.
     */
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    /**
     * Un producto tiene muchas especificaciones tecnicas.
     * Se ordenan por el campo 'orden'.
     */
    public function especificaciones()
    {
        return $this->hasMany(ProductoEspecificacion::class, 'producto_id')->orderBy('orden');
    }

    /**
     * Un producto tiene muchos documentos PDF descargables.
     */
    public function documentos()
    {
        return $this->hasMany(ProductoDocumento::class, 'producto_id')->orderBy('orden');
    }
}