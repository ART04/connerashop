{{-- LISTA DE CATEGORIAS: tabla con crear, editar y borrar (borrado con SweetAlert2) --}}
<x-admin-layout header="Categorías">

    {{-- Encabezado de la seccion + boton Nueva categoria --}}
    <div class="flex items-center justify-between mb-5">
        <h2 class="text-xl font-bold text-connera-text">Tus categorías</h2>
        <a href="{{ route('categorias.create') }}"
           class="bg-connera-yellow text-connera-blue font-bold px-4 py-2.5 rounded-lg hover:brightness-95 transition">
            + Nueva categoría
        </a>
    </div>

    {{-- Tabla blanca con las categorias --}}
    <div class="bg-white rounded-2xl shadow overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-connera-bg text-connera-text text-sm">
                <tr>
                    <th class="px-6 py-3 font-semibold">Nombre</th>
                    <th class="px-6 py-3 font-semibold">Estado</th>
                    <th class="px-6 py-3 font-semibold">Orden</th>
                    <th class="px-6 py-3 font-semibold text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">

                @forelse ($categorias as $categoria)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <span class="font-medium text-connera-text">{{ $categoria->nombre }}</span>
                            @if ($categoria->descripcion)
                                <span class="block text-xs text-gray-400">{{ $categoria->descripcion }}</span>
                            @endif
                        </td>

                        <td class="px-6 py-4">
                            @if ($categoria->activo)
                                <span class="inline-block bg-green-100 text-green-700 text-xs font-medium px-2.5 py-1 rounded-full">Activa</span>
                            @else
                                <span class="inline-block bg-gray-100 text-gray-500 text-xs font-medium px-2.5 py-1 rounded-full">Inactiva</span>
                            @endif
                        </td>

                        <td class="px-6 py-4 text-gray-500">{{ $categoria->orden }}</td>

                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('categorias.edit', $categoria) }}"
                               class="text-connera-blue font-medium hover:underline mr-4">Editar</a>

                            {{-- Formulario de borrado controlado por SweetAlert2 (sin confirm gris) --}}
                            <form action="{{ route('categorias.destroy', $categoria) }}" method="POST" class="inline form-borrar"
                                  data-nombre="{{ $categoria->nombre }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 font-medium hover:underline">Borrar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-gray-400">
                            Aún no tienes categorías. Crea la primera con el botón de arriba.
                        </td>
                    </tr>
                @endforelse

            </tbody>
        </table>
    </div>

    {{-- Confirmacion de borrado con SweetAlert2 --}}
    <script>
        document.querySelectorAll('.form-borrar').forEach(function (formulario) {
            formulario.addEventListener('submit', function (evento) {
                evento.preventDefault(); // detiene el envio para preguntar primero

                const nombre = formulario.dataset.nombre;

                Swal.fire({
                    title: '¿Borrar categoría?',
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
                        formulario.submit(); // ahora si se borra
                    }
                });
            });
        });
    </script>

</x-admin-layout>