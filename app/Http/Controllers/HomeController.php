<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Marca;
use App\Models\Categoria;

/**
 * Controlador del SITIO PÚBLICO.
 * Prepara la informacion que veran los visitantes en la home.
 */
class HomeController extends Controller
{
    public function index()
    {
        // Productos destacados y activos (para la seccion principal)
        $destacados = Producto::where('activo', true)
                        ->where('destacado', true)
                        ->orderBy('orden')
                        ->take(8)
                        ->get();

        // Si no hay destacados, mostramos los productos activos mas recientes
        if ($destacados->isEmpty()) {
            $destacados = Producto::where('activo', true)
                            ->latest()
                            ->take(8)
                            ->get();
        }

        // Marcas activas (para el carrusel de logos)
        $marcas = Marca::where('activo', true)
                    ->orderBy('orden')
                    ->get();

        // Categorias activas (por si las mostramos)
        $categorias = Categoria::where('activo', true)
                        ->orderBy('orden')
                        ->get();

        return view('public.home', compact('destacados', 'marcas', 'categorias'));
    }
}