{{-- 
  =====================================================================
  FORMULARIO PARA EDITAR UNA CATEGORÍA EXISTENTE
  Es casi igual al de crear, pero trae los datos ya cargados.
  =====================================================================
--}}
<x-admin-layout header="Editar categoría">

    <div class="max-w-2xl">

        @if ($errors->any())
            <div class="mb-4 rounded-lg bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700">
                Por favor revisa los datos. El nombre es obligatorio.
            </div>
        @endif

        <form action="{{ route('categorias.update', $categoria) }}" method="POST"
              class="bg-white rounded-2xl shadow p-8 space-y-5">
            @csrf
            @method('PUT') {{-- Indica que es una actualización --}}

            {{-- Nombre (ya trae el valor actual) --}}
            <div>
                <label class="block text-sm font-medium text-connera-text mb-1">Nombre *</label>
                <input type="text" name="nombre" value="{{ old('nombre', $categoria->nombre) }}" required
                       class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-connera-blue focus:ring-2 focus:ring-connera-blue/30 outline-none transition">
            </div>

            {{-- Descripción --}}
            <div>
                <label class="block text-sm font-medium text-connera-text mb-1">Descripción (opcional)</label>
                <textarea name="descripcion" rows="3"
                          class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-connera-blue focus:ring-2 focus:ring-connera-blue/30 outline-none transition">{{ old('descripcion', $categoria->descripcion) }}</textarea>
            </div>

            {{-- Orden --}}
            <div>
                <label class="block text-sm font-medium text-connera-text mb-1">Orden</label>
                <input type="number" name="orden" value="{{ old('orden', $categoria->orden) }}"
                       class="w-32 rounded-lg border border-gray-300 px-4 py-2.5 focus:border-connera-blue focus:ring-2 focus:ring-connera-blue/30 outline-none transition">
            </div>

            {{-- Activo --}}
            <div class="flex items-center">
                <input type="checkbox" name="activo" value="1" {{ $categoria->activo ? 'checked' : '' }}
                       class="h-4 w-4 rounded border-gray-300 text-connera-blue focus:ring-connera-blue">
                <label class="ml-2 text-sm text-gray-600">Categoría activa (visible)</label>
            </div>

            {{-- Botones --}}
            <div class="flex items-center gap-3 pt-2">
                <button type="submit"
                        class="bg-connera-yellow text-connera-blue font-bold px-6 py-2.5 rounded-lg hover:brightness-95 transition">
                    Guardar cambios
                </button>
                <a href="{{ route('categorias.index') }}"
                   class="text-gray-500 font-medium hover:underline">Cancelar</a>
            </div>
        </form>
    </div>

</x-admin-layout>