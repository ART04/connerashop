<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Controlador de Categorías.
 * Contiene la lógica de las acciones del módulo:
 * listar, crear, guardar, editar, actualizar y borrar.
 */
class CategoriaController extends Controller
{
    /**
     * LISTAR: muestra todas las categorías en una tabla.
     */
    public function index()
    {
        // Trae las categorías ordenadas por el campo 'orden' y luego por nombre
        $categorias = Categoria::orderBy('orden')->orderBy('nombre')->get();

        return view('admin.categorias.index', compact('categorias'));
    }

    /**
     * CREAR: muestra el formulario vacío para una categoría nueva.
     */
    public function create()
    {
        return view('admin.categorias.create');
    }

    /**
     * GUARDAR: recibe los datos del formulario de creación y los guarda.
     */
    public function store(Request $request)
    {
        // 1) Validar lo que llega del formulario
        $datos = $request->validate([
            'nombre'      => ['required', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string'],
            'orden'       => ['nullable', 'integer'],
            'activo'      => ['nullable', 'boolean'],
        ]);

        // 2) Generar el 'slug' automáticamente a partir del nombre
        //    Ej: "Paneles Solares" -> "paneles-solares"
        $datos['slug']   = Str::slug($datos['nombre']);
        $datos['activo'] = $request->boolean('activo'); // casilla marcada = true
        $datos['orden']  = $datos['orden'] ?? 0;

        // 3) Guardar en la base de datos
        Categoria::create($datos);

        // 4) Regresar a la lista con un mensaje de éxito
        return redirect()->route('categorias.index')
                         ->with('exito', 'Categoría creada correctamente.');
    }

    /**
     * EDITAR: muestra el formulario con los datos de una categoría existente.
     * Laravel encuentra la categoría automáticamente por su id.
     */
    public function edit(Categoria $categoria)
    {
        return view('admin.categorias.edit', compact('categoria'));
    }

    /**
     * ACTUALIZAR: recibe los cambios del formulario de edición y los guarda.
     */
    public function update(Request $request, Categoria $categoria)
    {
        $datos = $request->validate([
            'nombre'      => ['required', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string'],
            'orden'       => ['nullable', 'integer'],
            'activo'      => ['nullable', 'boolean'],
        ]);

        $datos['slug']   = Str::slug($datos['nombre']);
        $datos['activo'] = $request->boolean('activo');
        $datos['orden']  = $datos['orden'] ?? 0;

        // Actualiza la categoría con los datos nuevos
        $categoria->update($datos);

        return redirect()->route('categorias.index')
                         ->with('exito', 'Categoría actualizada correctamente.');
    }

    /**
     * BORRAR: elimina una categoría.
     */
    public function destroy(Categoria $categoria)
    {
        $categoria->delete();

        return redirect()->route('categorias.index')
                         ->with('exito', 'Categoría eliminada correctamente.');
    }
}