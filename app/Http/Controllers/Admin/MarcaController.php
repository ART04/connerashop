<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Marca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * Controlador de Marcas.
 * Maneja los logos que apareceran en el carrusel del sitio publico.
 */
class MarcaController extends Controller
{
    public function index()
    {
        $marcas = Marca::orderBy('orden')->orderBy('nombre')->get();
        return view('admin.marcas.index', compact('marcas'));
    }

    public function create()
    {
        return view('admin.marcas.create');
    }

    public function store(Request $request)
    {
        $datos = $this->validarDatos($request);

        // Guardar el logo (si se subio)
        if ($request->hasFile('logo')) {
            $datos['logo'] = $request->file('logo')->store('marcas', 'public');
        }

        $datos['activo'] = $request->boolean('activo');
        $datos['orden']  = $datos['orden'] ?? 0;

        Marca::create($datos);

        return redirect()->route('marcas.index')
                         ->with('exito', 'Marca creada correctamente.');
    }

    public function edit(Marca $marca)
    {
        return view('admin.marcas.edit', compact('marca'));
    }

    public function update(Request $request, Marca $marca)
    {
        $datos = $this->validarDatos($request);

        // Si suben un logo nuevo, borrar el anterior
        if ($request->hasFile('logo')) {
            if ($marca->logo) {
                Storage::disk('public')->delete($marca->logo);
            }
            $datos['logo'] = $request->file('logo')->store('marcas', 'public');
        }

        $datos['activo'] = $request->boolean('activo');
        $datos['orden']  = $datos['orden'] ?? 0;

        $marca->update($datos);

        return redirect()->route('marcas.index')
                         ->with('exito', 'Marca actualizada correctamente.');
    }

    public function destroy(Marca $marca)
    {
        // Borrar el logo del servidor
        if ($marca->logo) {
            Storage::disk('public')->delete($marca->logo);
        }

        $marca->delete();

        return redirect()->route('marcas.index')
                         ->with('exito', 'Marca eliminada correctamente.');
    }

    /**
     * Reglas de validacion.
     */
    private function validarDatos(Request $request): array
    {
        return $request->validate([
            'nombre'    => ['required', 'string', 'max:255'],
            // El logo es opcional, debe ser imagen, max 2 MB
            'logo'      => ['nullable', 'image', 'max:2048'],
            'sitio_web' => ['nullable', 'url', 'max:255'],
            'activo'    => ['nullable', 'boolean'],
            'orden'     => ['nullable', 'integer'],
        ]);
    }
}