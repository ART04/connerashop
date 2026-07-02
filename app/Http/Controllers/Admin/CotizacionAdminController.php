<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cotizacion;
use Illuminate\Http\Request;

/**
 * Controlador ADMIN de Cotizaciones.
 * Permite al administrador ver y gestionar las cotizaciones
 * que envian los clientes desde el sitio publico.
 */
class CotizacionAdminController extends Controller
{
    /**
     * LISTAR: muestra todas las cotizaciones recibidas.
     * Se cargan tambien sus items (productos solicitados).
     */
    public function index()
    {
        $cotizaciones = Cotizacion::with('items')
                            ->latest() // las mas recientes primero
                            ->get();

        return view('admin.cotizaciones.index', compact('cotizaciones'));
    }

    /**
     * VER DETALLE: muestra una cotizacion completa.
     */
    public function show(Cotizacion $cotizacion)
    {
        // Cargamos sus items y el cliente (si tiene cuenta)
        $cotizacion->load('items', 'cliente');

        return view('admin.cotizaciones.show', compact('cotizacion'));
    }

    /**
     * ACTUALIZAR ESTADO: cambia el estado de la cotizacion.
     * (nueva, en_proceso, enviada, aprobada, rechazada, cancelada)
     */
    public function actualizarEstado(Request $request, Cotizacion $cotizacion)
    {
        $datos = $request->validate([
            'estado' => ['required', 'string', 'in:nueva,en_proceso,enviada,aprobada,rechazada,cancelada'],
        ]);

        $cotizacion->update(['estado' => $datos['estado']]);

        return redirect()->route('admin.cotizaciones.show', $cotizacion)
                         ->with('exito', 'Estado de la cotización actualizado.');
    }

    /**
     * BORRAR: elimina una cotizacion (y sus items por cascada).
     */
    public function destroy(Cotizacion $cotizacion)
    {
        $cotizacion->delete();

        return redirect()->route('admin.cotizaciones.index')
                         ->with('exito', 'Cotización eliminada.');
    }
}
