{{-- LISTA DE MARCAS con DataTables + modal de logo --}}
<x-admin-layout header="Marcas">

    <div class="flex items-center justify-between mb-5">
        <h2 class="text-xl font-bold text-connera-text">Tus marcas</h2>
        <a href="{{ route('marcas.create') }}"
           class="bg-connera-yellow text-connera-blue font-bold px-4 py-2.5 rounded-lg hover:brightness-95 transition">
            + Nueva marca
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow p-6">
        <table id="tabla-marcas" class="w-full text-left display">
            <thead>
                <tr class="text-connera-text text-sm border-b">
                    <th class="px-4 py-3 font-semibold">Logo</th>
                    <th class="px-4 py-3 font-semibold">Nombre</th>
                    <th class="px-4 py-3 font-semibold">Estado</th>
                    <th class="px-4 py-3 font-semibold">Orden</th>
                    <th class="px-4 py-3 font-semibold">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($marcas as $marca)
                    <tr class="border-b border-gray-100">
                        <td class="px-4 py-3">
                            @if ($marca->logo)
                                <img src="{{ asset('storage/' . $marca->logo) }}"
                                     alt="{{ $marca->nombre }}"
                                     data-imagen="{{ asset('storage/' . $marca->logo) }}"
                                     data-nombre="{{ $marca->nombre }}"
                                     class="ver-imagen h-12 w-auto object-contain cursor-pointer hover:brightness-90 transition">
                            @else
                                <div class="h-12 w-20 rounded bg-gray-100 flex items-center justify-center text-gray-300 text-xs">Sin logo</div>
                            @endif
                        </td>
                        <td class="px-4 py-3 font-medium text-connera-text">{{ $marca->nombre }}</td>
                        <td class="px-4 py-3">
                            @if ($marca->activo)
                                <span class="inline-block bg-green-100 text-green-700 text-xs font-medium px-2.5 py-1 rounded-full">Activa</span>
                            @else
                                <span class="inline-block bg-gray-100 text-gray-500 text-xs font-medium px-2.5 py-1 rounded-full">Inactiva</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-gray-500">{{ $marca->orden }}</td>
                        <td class="px-4 py-3">
                            <a href="{{ route('marcas.edit', $marca) }}"
                               class="text-connera-blue font-medium hover:underline mr-3">Editar</a>
                            <form action="{{ route('marcas.destroy', $marca) }}" method="POST" class="inline form-borrar"
                                  data-nombre="{{ $marca->nombre }}">
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

    <script>
        $(document).ready(function () {
            $('#tabla-marcas').DataTable({
                language: {
                    search: "Buscar:",
                    lengthMenu: "Mostrar _MENU_ marcas",
                    info: "Mostrando _START_ a _END_ de _TOTAL_ marcas",
                    infoEmpty: "Sin marcas",
                    infoFiltered: "(filtrado de _MAX_ marcas)",
                    zeroRecords: "No se encontraron marcas",
                    paginate: { first: "Primero", last: "Último", next: "Siguiente", previous: "Anterior" }
                },
                pageLength: 10,
                order: [],
                columnDefs: [{ orderable: false, targets: [0, 4] }]
            });
        });
    </script>

    {{-- Modal de logo --}}
    <script>
        document.querySelectorAll('.ver-imagen').forEach(function (img) {
            img.addEventListener('click', function () {
                Swal.fire({
                    title: this.dataset.nombre,
                    imageUrl: this.dataset.imagen,
                    imageAlt: this.dataset.nombre,
                    width: 500,
                    confirmButtonText: 'Cerrar',
                    confirmButtonColor: '#003B73'
                });
            });
        });
    </script>

    {{-- Confirmacion de borrado --}}
    <script>
        document.querySelectorAll('.form-borrar').forEach(function (formulario) {
            formulario.addEventListener('submit', function (evento) {
                evento.preventDefault();
                const nombre = formulario.dataset.nombre;
                Swal.fire({
                    title: '¿Borrar marca?',
                    html: 'Vas a eliminar <strong>' + nombre + '</strong>.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, borrar',
                    cancelButtonText: 'Cancelar',
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#003B73',
                    reverseButtons: true
                }).then(function (r) {
                    if (r.isConfirmed) { formulario.submit(); }
                });
            });
        });
    </script>

</x-admin-layout>