<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\ProductoDocumento;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

/**
 * Controlador de Productos.
 * Maneja datos generales, imagen, especificaciones tecnicas y documentos PDF.
 */
class ProductoController extends Controller
{
    /**
     * LISTAR: muestra todos los productos.
     */
    public function index()
    {
        $productos = Producto::with('categoria')
                        ->orderBy('orden')
                        ->orderBy('nombre')
                        ->get();

        return view('admin.productos.index', compact('productos'));
    }

    /**
     * CREAR: formulario vacio.
     */
    public function create()
    {
        $categorias = Categoria::where('activo', true)->orderBy('nombre')->get();

        return view('admin.productos.create', compact('categorias'));
    }

    /**
     * GUARDAR: crea el producto con sus specs y documentos.
     */
    public function store(Request $request)
    {
        $datos = $this->validarDatos($request);
        $datos['slug'] = $this->generarSlugUnico($datos['nombre']);

        if ($request->hasFile('imagen')) {
            $datos['imagen'] = $request->file('imagen')->store('productos', 'public');
        }

        $datos['activo']    = $request->boolean('activo');
        $datos['destacado'] = $request->boolean('destacado');
        $datos['orden']     = $datos['orden'] ?? 0;

        $producto = Producto::create($datos);

        $this->guardarEspecificaciones($request, $producto);
        $this->guardarDocumentos($request, $producto);

        return redirect()->route('productos.index')
                         ->with('exito', 'Producto creado correctamente.');
    }

    /**
     * EDITAR: formulario con datos cargados (incluye specs y docs).
     */
    public function edit(Producto $producto)
    {
        $categorias = Categoria::where('activo', true)->orderBy('nombre')->get();
        $producto->load('especificaciones', 'documentos');

        return view('admin.productos.edit', compact('producto', 'categorias'));
    }

    /**
     * ACTUALIZAR.
     */
    public function update(Request $request, Producto $producto)
    {
        $datos = $this->validarDatos($request);
        $datos['slug'] = $this->generarSlugUnico($datos['nombre'], $producto->id);

        if ($request->hasFile('imagen')) {
            if ($producto->imagen) {
                Storage::disk('public')->delete($producto->imagen);
            }
            $datos['imagen'] = $request->file('imagen')->store('productos', 'public');
        }

        $datos['activo']    = $request->boolean('activo');
        $datos['destacado'] = $request->boolean('destacado');
        $datos['orden']     = $datos['orden'] ?? 0;

        $producto->update($datos);

        // Las especificaciones se reemplazan por completo
        $producto->especificaciones()->delete();
        $this->guardarEspecificaciones($request, $producto);

        // Borrar los documentos que el usuario marco para borrar
        $this->borrarDocumentosMarcados($request, $producto);

        // Agregar los documentos nuevos
        $this->guardarDocumentos($request, $producto);

        return redirect()->route('productos.index')
                         ->with('exito', 'Producto actualizado correctamente.');
    }

    /**
     * BORRAR: elimina producto, su imagen y sus PDFs.
     */
    public function destroy(Producto $producto)
    {
        if ($producto->imagen) {
            Storage::disk('public')->delete($producto->imagen);
        }

        foreach ($producto->documentos as $documento) {
            Storage::disk('public')->delete($documento->archivo);
        }

        $producto->delete();

        return redirect()->route('productos.index')
                         ->with('exito', 'Producto eliminado correctamente.');
    }

    /* =================================================================
       AYUDANTES PRIVADOS
       ================================================================= */

    /**
     * Genera un slug unico a partir del nombre.
     */
    private function generarSlugUnico(string $nombre, ?int $ignorarId = null): string
    {
        $base = Str::slug($nombre);
        $slug = $base;
        $contador = 2;

        while (
            Producto::where('slug', $slug)
                ->when($ignorarId, fn ($q) => $q->where('id', '!=', $ignorarId))
                ->exists()
        ) {
            $slug = $base . '-' . $contador;
            $contador++;
        }

        return $slug;
    }

    /**
     * Reglas de validacion.
     */
    private function validarDatos(Request $request): array
    {
        return $request->validate([
            'nombre'              => ['required', 'string', 'max:255'],
            'categoria_id'        => ['nullable', 'exists:categorias,id'],
            'descripcion'         => ['nullable', 'string'],
            'precio'              => ['nullable', 'numeric', 'min:0'],
            'marca'               => ['nullable', 'string', 'max:255'],
            'imagen'              => ['nullable', 'image', 'max:2048'],
            'enlace_amazon'       => ['nullable', 'url', 'max:255'],
            'enlace_mercadolibre' => ['nullable', 'url', 'max:255'],
            'destacado'           => ['nullable', 'boolean'],
            'activo'              => ['nullable', 'boolean'],
            'orden'               => ['nullable', 'integer'],
            'spec_etiqueta'       => ['nullable', 'array'],
            'spec_valor'          => ['nullable', 'array'],
            'doc_titulo'          => ['nullable', 'array'],
            'doc_archivo'         => ['nullable', 'array'],
            'doc_archivo.*'       => ['nullable', 'file', 'mimes:pdf', 'max:5120'],
            'doc_borrar'          => ['nullable', 'array'],
        ]);
    }

    /**
     * Guarda las especificaciones tecnicas.
     */
    private function guardarEspecificaciones(Request $request, Producto $producto): void
    {
        $etiquetas = $request->input('spec_etiqueta', []);
        $valores   = $request->input('spec_valor', []);

        foreach ($etiquetas as $i => $etiqueta) {
            if (!empty($etiqueta) && !empty($valores[$i])) {
                $producto->especificaciones()->create([
                    'etiqueta' => $etiqueta,
                    'valor'    => $valores[$i],
                    'orden'    => $i,
                ]);
            }
        }
    }

    /**
     * Guarda los documentos PDF nuevos.
     */
    private function guardarDocumentos(Request $request, Producto $producto): void
    {
        $titulos  = $request->input('doc_titulo', []);
        $archivos = $request->file('doc_archivo', []);

        foreach ($titulos as $i => $titulo) {
            if (!empty($titulo) && isset($archivos[$i]) && $archivos[$i]) {
                $ruta = $archivos[$i]->store('productos/documentos', 'public');
                $producto->documentos()->create([
                    'titulo'  => $titulo,
                    'archivo' => $ruta,
                    'orden'   => $i,
                ]);
            }
        }
    }

    /**
     * Borra los documentos que el usuario marco con la casilla "Borrar".
     * Elimina tanto el registro de la base como el archivo PDF del servidor.
     */
    private function borrarDocumentosMarcados(Request $request, Producto $producto): void
    {
        $idsABorrar = $request->input('doc_borrar', []);

        foreach ($idsABorrar as $id) {
            // Buscamos el documento, asegurando que pertenezca a ESTE producto (seguridad)
            $documento = ProductoDocumento::where('id', $id)
                            ->where('producto_id', $producto->id)
                            ->first();

            if ($documento) {
                Storage::disk('public')->delete($documento->archivo); // borra el archivo
                $documento->delete();                                  // borra el registro
            }
        }
    }
}