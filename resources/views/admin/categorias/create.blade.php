{{-- 
  =====================================================================
  FORMULARIO PARA CREAR UNA CATEGORÍA NUEVA
  =====================================================================
--}}
<x-admin-layout header="Nueva categoría">

    <div class="max-w-2xl">

        {{-- Si hay errores de validación, se muestran aquí --}}
        @if ($errors->any())
            <div class="mb-4 rounded-lg bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700">
                Por favor revisa los datos. El nombre es obligatorio.
            </div>
        @endif

        <form action="{{ route('categorias.store') }}" method="POST"
              class="bg-white rounded-2xl shadow p-8 space-y-5">
            @csrf

            {{-- Campo: Nombre --}}
            <div>
                <label class="block text-sm font-medium text-connera-text mb-1">Nombre *</label>
                <input type="text" name="nombre" value="{{ old('nombre') }}" required
                       class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-connera-blue focus:ring-2 focus:ring-connera-blue/30 outline-none transition"
                       placeholder="Ej: Paneles solares">
            </div>

            {{-- Campo: Descripción --}}
            <div>
                <label class="block text-sm font-medium text-connera-text mb-1">Descripción (opcional)</label>
                <textarea name="descripcion" rows="3"
                          class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-connera-blue focus:ring-2 focus:ring-connera-blue/30 outline-none transition"
                          placeholder="Breve descripción de la categoría">{{ old('descripcion') }}</textarea>
            </div>

            {{-- Campo: Orden --}}
            <div>
                <label class="block text-sm font-medium text-connera-text mb-1">Orden</label>
                <input type="number" name="orden" value="{{ old('orden', 0) }}"
                       class="w-32 rounded-lg border border-gray-300 px-4 py-2.5 focus:border-connera-blue focus:ring-2 focus:ring-connera-blue/30 outline-none transition">
                <span class="text-xs text-gray-400 ml-2">Menor número = aparece primero</span>
            </div>

            {{-- Campo: Activo --}}
            <div class="flex items-center">
                <input type="checkbox" name="activo" value="1" checked
                       class="h-4 w-4 rounded border-gray-300 text-connera-blue focus:ring-connera-blue">
                <label class="ml-2 text-sm text-gray-600">Categoría activa (visible)</label>
            </div>

            {{-- Botones --}}
            <div class="flex items-center gap-3 pt-2">
                <button type="submit"
                        class="bg-connera-yellow text-connera-blue font-bold px-6 py-2.5 rounded-lg hover:brightness-95 transition">
                    Guardar categoría
                </button>
                <a href="{{ route('categorias.index') }}"
                   class="text-gray-500 font-medium hover:underline">Cancelar</a>
            </div>
        </form>
    </div>

</x-admin-layout>