<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Marca;
use App\Models\Categoria;
use Illuminate\Http\Request;

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
        $producto = Producto::where('slug', $slug)
                        ->where('activo', true)
                        ->with(['categoria', 'especificaciones', 'documentos'])
                        ->firstOrFail();

        $marcas = Marca::where('activo', true)
                    ->orderBy('orden')
                    ->get();

        return view('public.producto', compact('producto', 'marcas'));
    }

    /**
     * CATÁLOGO publico: lista todos los productos activos, con filtros.
     */
    public function catalogo(Request $request)
    {
        // Empezamos con los productos activos, trayendo su categoria
        $consulta = Producto::where('activo', true)->with('categoria');

        // FILTRO: por texto de busqueda (nombre o marca)
        if ($request->filled('buscar')) {
            $texto = $request->input('buscar');
            $consulta->where(function ($q) use ($texto) {
                $q->where('nombre', 'like', "%{$texto}%")
                  ->orWhere('marca', 'like', "%{$texto}%");
            });
        }

        // FILTRO: por categoria (usamos el id de la categoria)
        if ($request->filled('categoria')) {
            $consulta->where('categoria_id', $request->input('categoria'));
        }

        // Ordenar y traer los resultados (paginados de 12 en 12)
        $productos = $consulta->orderBy('orden')
                        ->orderBy('nombre')
                        ->paginate(12)
                        ->withQueryString(); // conserva los filtros al cambiar de pagina

        // Categorias para el menu de filtros
        $categorias = Categoria::where('activo', true)
                        ->orderBy('nombre')
                        ->get();

        return view('public.catalogo', compact('productos', 'categorias'));
    }
}