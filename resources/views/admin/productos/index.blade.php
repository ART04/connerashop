{{-- LISTA DE PRODUCTOS con DataTables + modal de imagen --}}
<x-admin-layout header="Productos">

    {{-- Encabezado + boton Nuevo producto --}}
    <div class="flex items-center justify-between mb-5">
        <h2 class="text-xl font-bold text-connera-text">Tus productos</h2>
        <a href="{{ route('productos.create') }}"
           class="bg-connera-yellow text-connera-blue font-bold px-4 py-2.5 rounded-lg hover:brightness-95 transition">
            + Nuevo producto
        </a>
    </div>

    {{-- Tarjeta blanca que contiene la tabla --}}
    <div class="bg-white rounded-2xl shadow p-6">
        <table id="tabla-productos" class="w-full text-left display">
            <thead>
                <tr class="text-connera-text text-sm border-b">
                    <th class="px-4 py-3 font-semibold">Producto</th>
                    <th class="px-4 py-3 font-semibold">Categoría</th>
                    <th class="px-4 py-3 font-semibold">Precio</th>
                    <th class="px-4 py-3 font-semibold">Estado</th>
                    <th class="px-4 py-3 font-semibold">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($productos as $producto)
                    <tr class="border-b border-gray-100">
                        {{-- Foto + nombre --}}
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                @if ($producto->imagen)
                                    {{-- Al hacer clic, se abre la imagen en grande.
                                         'cursor-pointer' indica que se puede clicar. --}}
                                    <img src="{{ asset('storage/' . $producto->imagen) }}"
                                         alt="{{ $producto->nombre }}"
                                         data-imagen="{{ asset('storage/' . $producto->imagen) }}"
                                         data-nombre="{{ $producto->nombre }}"
                                         class="ver-imagen w-12 h-12 rounded-lg object-cover border border-gray-200 cursor-pointer hover:brightness-90 transition">
                                @else
                                    <div class="w-12 h-12 rounded-lg bg-gray-100 flex items-center justify-center text-gray-300 text-xs">Sin foto</div>
                                @endif
                                <div>
                                    <span class="font-medium text-connera-text">{{ $producto->nombre }}</span>
                                    @if ($producto->destacado)
                                        <span class="block text-xs text-connera-yellow font-semibold">★ Destacado</span>
                                    @endif
                                </div>
                            </div>
                        </td>

                        <td class="px-4 py-3 text-gray-600">{{ $producto->categoria->nombre ?? '— Sin categoría' }}</td>
                        <td class="px-4 py-3 text-gray-600">${{ number_format($producto->precio, 2) }}</td>

                        <td class="px-4 py-3">
                            @if ($producto->activo)
                                <span class="inline-block bg-green-100 text-green-700 text-xs font-medium px-2.5 py-1 rounded-full">Activo</span>
                            @else
                                <span class="inline-block bg-gray-100 text-gray-500 text-xs font-medium px-2.5 py-1 rounded-full">Inactivo</span>
                            @endif
                        </td>

                        <td class="px-4 py-3">
                            <a href="{{ route('productos.edit', $producto) }}"
                               class="text-connera-blue font-medium hover:underline mr-3">Editar</a>
                            <form action="{{ route('productos.destroy', $producto) }}" method="POST" class="inline form-borrar"
                                  data-nombre="{{ $producto->nombre }}">
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

    {{-- Activar DataTables --}}
    <script>
        $(document).ready(function () {
            $('#tabla-productos').DataTable({
                language: {
                    search: "Buscar:",
                    lengthMenu: "Mostrar _MENU_ productos",
                    info: "Mostrando _START_ a _END_ de _TOTAL_ productos",
                    infoEmpty: "Sin productos",
                    infoFiltered: "(filtrado de _MAX_ productos)",
                    zeroRecords: "No se encontraron productos",
                    paginate: { first: "Primero", last: "Último", next: "Siguiente", previous: "Anterior" }
                },
                pageLength: 10,
                order: [],
                columnDefs: [
                    { orderable: false, targets: 4 }
                ]
            });
        });
    </script>

    {{-- MODAL DE IMAGEN: al hacer clic en una miniatura, se ve en grande --}}
    <script>
        document.querySelectorAll('.ver-imagen').forEach(function (img) {
            img.addEventListener('click', function () {
                Swal.fire({
                    title: this.dataset.nombre,
                    imageUrl: this.dataset.imagen,
                    imageAlt: this.dataset.nombre,
                    width: 600,
                    confirmButtonText: 'Cerrar',
                    confirmButtonColor: '#003B73'
                });
            });
        });
    </script>

    {{-- Confirmacion de borrado con SweetAlert2 --}}
    <script>
        document.querySelectorAll('.form-borrar').forEach(function (formulario) {
            formulario.addEventListener('submit', function (evento) {
                evento.preventDefault();
                const nombre = formulario.dataset.nombre;
                Swal.fire({
                    title: '¿Borrar producto?',
                    html: 'Vas a eliminar <strong>' + nombre + '</strong>.<br>Esta acción no se puede deshacer.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, borrar',
                    cancelButtonText: 'Cancelar',
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#003B73',
                    reverseButtons: true
                }).then(function (resultado) {
                    if (resultado.isConfirmed) {
                        formulario.submit();
                    }
                });
            });
        });
    </script>

</x-admin-layout>