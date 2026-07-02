<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Cotizacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

/**
 * Controlador de COTIZACIONES (lado cliente).
 * Permite al cliente solicitar la cotizacion de un producto.
 */
class CotizacionController extends Controller
{
    /**
     * Mostrar el formulario para cotizar un producto.
     */
    public function crear(string $slug)
    {
        // Buscar el producto activo por su slug
        $producto = Producto::where('slug', $slug)
                        ->where('activo', true)
                        ->firstOrFail();

        return view('public.cotizacion.crear', compact('producto'));
    }

    /**
     * Guardar la solicitud de cotizacion.
     */
    public function guardar(Request $request, string $slug)
    {
        $producto = Producto::where('slug', $slug)
                        ->where('activo', true)
                        ->firstOrFail();

        // 1) Validar
        $datos = $request->validate([
            'nombre'        => ['required', 'string', 'max:255'],
            'email'         => ['required', 'email', 'max:255'],
            'telefono'      => ['nullable', 'string', 'max:30'],
            'empresa'       => ['nullable', 'string', 'max:255'],
            'cantidad'      => ['required', 'integer', 'min:1'],
            'comentarios'   => ['nullable', 'string'],
            // Recibo CFE opcional: PDF o imagen, max 5 MB
            'recibo_cfe'    => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
        ]);

        // 2) Generar el folio unico (ej: COT-2026-000001)
        $folio = $this->generarFolio();

        // 3) Guardar el recibo CFE si se subio
        $rutaRecibo = null;
        if ($request->hasFile('recibo_cfe')) {
            $rutaRecibo = $request->file('recibo_cfe')->store('cotizaciones/recibos', 'public');
        }

        // 4) Crear la cotizacion
        $cotizacion = Cotizacion::create([
            'folio'       => $folio,
            'user_id'     => Auth::id(), // si esta logueado, se guarda; si no, queda null
            'nombre'      => $datos['nombre'],
            'email'       => $datos['email'],
            'telefono'    => $datos['telefono'] ?? null,
            'empresa'     => $datos['empresa'] ?? null,
            'comentarios' => $datos['comentarios'] ?? null,
            'recibo_cfe'  => $rutaRecibo,
            'estado'      => 'nueva',
        ]);

        // 5) Agregar el producto solicitado como item
        $cotizacion->items()->create([
            'producto_id'     => $producto->id,
            'producto_nombre' => $producto->nombre,
            'cantidad'        => $datos['cantidad'],
            'observaciones'   => $datos['comentarios'] ?? null,
        ]);

        // 6) Confirmacion
        return redirect()->route('cotizacion.gracias', $folio);
    }

    /**
     * Pagina de agradecimiento con el folio.
     */
    public function gracias(string $folio)
    {
        $cotizacion = Cotizacion::where('folio', $folio)->firstOrFail();
        return view('public.cotizacion.gracias', compact('cotizacion'));
    }

    /**
     * Genera un folio unico tipo COT-2026-000001.
     */
    private function generarFolio(): string
    {
        $anio = date('Y');

        // Contar cuantas cotizaciones hay este ano para el consecutivo
        $consecutivo = Cotizacion::whereYear('created_at', $anio)->count() + 1;

        // Formato con ceros a la izquierda (000001)
        return 'COT-' . $anio . '-' . str_pad($consecutivo, 6, '0', STR_PAD_LEFT);
    }
}