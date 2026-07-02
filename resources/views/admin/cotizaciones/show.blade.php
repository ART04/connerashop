{{-- DETALLE DE UNA COTIZACIÓN (admin): ver datos y cambiar estado --}}
<x-admin-layout header="Detalle de cotización">

    <div class="max-w-4xl">

        {{-- Boton volver --}}
        <a href="{{ route('admin.cotizaciones.index') }}" class="text-connera-blue font-medium hover:underline text-sm">← Volver a cotizaciones</a>

        {{-- Encabezado con folio y estado --}}
        <div class="bg-white rounded-2xl shadow p-6 mt-4 mb-6 flex items-center justify-between">
            <div>
                <span class="text-sm text-gray-500">Folio</span>
                <h2 class="text-2xl font-bold text-connera-blue">{{ $cotizacion->folio }}</h2>
                <span class="text-sm text-gray-400">Recibida el {{ $cotizacion->created_at->format('d/m/Y \a \l\a\s H:i') }}</span>
            </div>
        </div>

        <div class="grid md:grid-cols-2 gap-6">

            {{-- Datos del cliente --}}
            <div class="bg-white rounded-2xl shadow p-6">
                <h3 class="font-bold text-connera-text border-b pb-2 mb-3">Datos del solicitante</h3>
                <ul class="text-sm text-gray-600 space-y-2">
                    <li><span class="font-medium text-connera-text">Nombre:</span> {{ $cotizacion->nombre }}</li>
                    <li><span class="font-medium text-connera-text">Correo:</span> {{ $cotizacion->email }}</li>
                    @if ($cotizacion->telefono)
                        <li><span class="font-medium text-connera-text">Teléfono:</span> {{ $cotizacion->telefono }}</li>
                    @endif
                    @if ($cotizacion->empresa)
                        <li><span class="font-medium text-connera-text">Empresa:</span> {{ $cotizacion->empresa }}</li>
                    @endif
                    <li>
                        <span class="font-medium text-connera-text">Tipo:</span>
                        {{ $cotizacion->user_id ? 'Cliente registrado' : 'Visitante' }}
                    </li>
                </ul>
            </div>

            {{-- Cambiar estado --}}
            <div class="bg-white rounded-2xl shadow p-6">
                <h3 class="font-bold text-connera-text border-b pb-2 mb-3">Gestión</h3>

                <form method="POST" action="{{ route('admin.cotizaciones.estado', $cotizacion) }}">
                    @csrf
                    @method('PUT')
                    <label class="block text-sm font-medium text-connera-text mb-1">Estado de la cotización</label>
                    <select name="estado"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 mb-3 focus:border-connera-blue focus:ring-2 focus:ring-connera-blue/30 outline-none transition">
                        @foreach (['nueva' => 'Nueva', 'en_proceso' => 'En proceso', 'enviada' => 'Enviada', 'aprobada' => 'Aprobada', 'rechazada' => 'Rechazada', 'cancelada' => 'Cancelada'] as $valor => $texto)
                            <option value="{{ $valor }}" {{ $cotizacion->estado == $valor ? 'selected' : '' }}>{{ $texto }}</option>
                        @endforeach
                    </select>
                    <button type="submit"
                            class="bg-connera-yellow text-connera-blue font-bold px-5 py-2.5 rounded-lg hover:brightness-95 transition">
                        Guardar estado
                    </button>
                </form>

                {{-- Recibo CFE si lo adjunto --}}
                @if ($cotizacion->recibo_cfe)
                    <div class="mt-4 pt-4 border-t">
                        <a href="{{ asset('storage/' . $cotizacion->recibo_cfe) }}" target="_blank" rel="noopener"
                           class="text-connera-blue font-medium hover:underline text-sm">📄 Ver recibo CFE adjunto</a>
                    </div>
                @endif
            </div>
        </div>

        {{-- Productos solicitados --}}
        <div class="bg-white rounded-2xl shadow p-6 mt-6">
            <h3 class="font-bold text-connera-text border-b pb-2 mb-3">Productos solicitados</h3>
            <table class="w-full text-left">
                <thead>
                    <tr class="text-sm text-gray-500 border-b">
                        <th class="py-2 font-semibold">Producto</th>
                        <th class="py-2 font-semibold">Cantidad</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($cotizacion->items as $item)
                        <tr>
                            <td class="py-3 text-connera-text">{{ $item->producto_nombre }}</td>
                            <td class="py-3 text-gray-600">{{ $item->cantidad }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Comentarios del cliente --}}
        @if ($cotizacion->comentarios)
            <div class="bg-white rounded-2xl shadow p-6 mt-6">
                <h3 class="font-bold text-connera-text border-b pb-2 mb-3">Comentarios del cliente</h3>
                <p class="text-gray-600">{{ $cotizacion->comentarios }}</p>
            </div>
        @endif

    </div>

</x-admin-layout>