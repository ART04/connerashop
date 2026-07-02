{{-- LISTA DE COTIZACIONES RECIBIDAS (admin) con DataTables --}}
<x-admin-layout header="Cotizaciones">

    <div class="flex items-center justify-between mb-5">
        <h2 class="text-xl font-bold text-connera-text">Cotizaciones recibidas</h2>
    </div>

    <div class="bg-white rounded-2xl shadow p-6">
        <table id="tabla-cotizaciones" class="w-full text-left display">
            <thead>
                <tr class="text-connera-text text-sm border-b">
                    <th class="px-4 py-3 font-semibold">Folio</th>
                    <th class="px-4 py-3 font-semibold">Cliente</th>
                    <th class="px-4 py-3 font-semibold">Producto(s)</th>
                    <th class="px-4 py-3 font-semibold">Estado</th>
                    <th class="px-4 py-3 font-semibold">Fecha</th>
                    <th class="px-4 py-3 font-semibold">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cotizaciones as $cotizacion)
                    <tr class="border-b border-gray-100">
                        {{-- Folio --}}
                        <td class="px-4 py-3 font-medium text-connera-blue">{{ $cotizacion->folio }}</td>

                        {{-- Cliente --}}
                        <td class="px-4 py-3">
                            <span class="font-medium text-connera-text">{{ $cotizacion->nombre }}</span>
                            <span class="block text-xs text-gray-400">{{ $cotizacion->email }}</span>
                        </td>

                        {{-- Productos solicitados (nombres de los items) --}}
                        <td class="px-4 py-3 text-gray-600 text-sm">
                            @foreach ($cotizacion->items as $item)
                                <span class="block">{{ $item->cantidad }} × {{ $item->producto_nombre }}</span>
                            @endforeach
                        </td>

                        {{-- Estado (con color segun el valor) --}}
                        <td class="px-4 py-3">
                            @php
                                // Cada estado tiene su color para identificarlo rapido
                                $colores = [
                                    'nueva'      => 'bg-blue-100 text-blue-700',
                                    'en_proceso' => 'bg-yellow-100 text-yellow-700',
                                    'enviada'    => 'bg-purple-100 text-purple-700',
                                    'aprobada'   => 'bg-green-100 text-green-700',
                                    'rechazada'  => 'bg-red-100 text-red-700',
                                    'cancelada'  => 'bg-gray-100 text-gray-500',
                                ];
                                $clase = $colores[$cotizacion->estado] ?? 'bg-gray-100 text-gray-500';
                            @endphp
                            <span class="inline-block {{ $clase }} text-xs font-medium px-2.5 py-1 rounded-full">
                                {{ ucfirst(str_replace('_', ' ', $cotizacion->estado)) }}
                            </span>
                        </td>

                        {{-- Fecha --}}
                        <td class="px-4 py-3 text-gray-500 text-sm">{{ $cotizacion->created_at->format('d/m/Y H:i') }}</td>

                        {{-- Acciones: Ver (detalle) y Borrar --}}
                        <td class="px-4 py-3 whitespace-nowrap">
                            {{-- Ver el detalle completo y cambiar el estado --}}
                            <a href="{{ route('admin.cotizaciones.show', $cotizacion) }}"
                               class="text-connera-blue font-medium hover:underline mr-3">Ver</a>

                            {{-- Borrar la cotizacion (con confirmacion SweetAlert) --}}
                            <form action="{{ route('admin.cotizaciones.destroy', $cotizacion) }}" method="POST"
                                  class="inline form-borrar" data-folio="{{ $cotizacion->folio }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 font-medium hover:underline">Borrar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Activar DataTables (buscador, orden, paginacion) --}}
    <script>
        $(document).ready(function () {
            $('#tabla-cotizaciones').DataTable({
                language: {
                    search: "Buscar:",
                    lengthMenu: "Mostrar _MENU_ cotizaciones",
                    info: "Mostrando _START_ a _END_ de _TOTAL_ cotizaciones",
                    infoEmpty: "Sin cotizaciones",
                    infoFiltered: "(filtrado de _MAX_ cotizaciones)",
                    zeroRecords: "No se encontraron cotizaciones",
                    paginate: { first: "Primero", last: "Último", next: "Siguiente", previous: "Anterior" }
                },
                pageLength: 10,
                order: [[4, 'desc']],  // ordenar por fecha, mas reciente primero
                columnDefs: [{ orderable: false, targets: 5 }]  // la columna Acciones no se ordena
            });
        });
    </script>

    {{-- Confirmacion de borrado con SweetAlert2 --}}
    <script>
        document.querySelectorAll('.form-borrar').forEach(function (formulario) {
            formulario.addEventListener('submit', function (evento) {
                evento.preventDefault(); // detenemos el envio para preguntar primero
                const folio = formulario.dataset.folio;
                Swal.fire({
                    title: '¿Borrar cotización?',
                    html: 'Vas a eliminar la cotización <strong>' + folio + '</strong>.<br>Esta acción no se puede deshacer.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, borrar',
                    cancelButtonText: 'Cancelar',
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#003B73',
                    reverseButtons: true
                }).then(function (resultado) {
                    if (resultado.isConfirmed) {
                        formulario.submit(); // si confirma, ahora si se borra
                    }
                });
            });
        });
    </script>

</x-admin-layout>