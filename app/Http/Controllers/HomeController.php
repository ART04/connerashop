<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Marca;
use App\Models\Categoria;

/**
 * Controlador del SITIO PÚBLICO.
 * Prepara la informacion que veran los visitantes.
 */
class HomeController extends Controller
{
    /**
     * HOME publica.
     */
    public function index()
    {
        $destacados = Producto::where('activo', true)
                        ->where('destacado', true)
                        ->orderBy('orden')
                        ->take(8)
                        ->get();

        if ($destacados->isEmpty()) {
            $destacados = Producto::where('activo', true)
                            ->latest()
                            ->take(8)
                            ->get();
        }

        $marcas = Marca::where('activo', true)
                    ->orderBy('orden')
                    ->get();

        $categorias = Categoria::where('activo', true)
                        ->orderBy('orden')
                        ->get();

        return view('public.home', compact('destacados', 'marcas', 'categorias'));
    }

    /**
     * FICHA publica de un producto (se busca por su slug).
     */
    public function producto(string $slug)
    {
        // Buscar el producto activo con ese slug. Si no existe, error 404.
        $producto = Producto::where('slug', $slug)
                        ->where('activo', true)
                        ->with(['categoria', 'especificaciones', 'documentos'])
                        ->firstOrFail();

        // Marcas para el carrusel (igual que en la home)
        $marcas = Marca::where('activo', true)
                    ->orderBy('orden')
                    ->get();

        return view('public.producto', compact('producto', 'marcas'));
    }
}