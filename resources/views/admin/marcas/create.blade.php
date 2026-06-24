{{-- FORMULARIO PARA CREAR UNA MARCA --}}
<x-admin-layout header="Nueva marca">

    <div class="max-w-2xl">

        @if ($errors->any())
            <div class="mb-4 rounded-lg bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700">
                Revisa los datos. El nombre es obligatorio y el logo debe ser una imagen.
            </div>
        @endif

        <form action="{{ route('marcas.store') }}" method="POST" enctype="multipart/form-data"
              class="bg-white rounded-2xl shadow p-8 space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium text-connera-text mb-1">Nombre *</label>
                <input type="text" name="nombre" value="{{ old('nombre') }}" required
                       class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-connera-blue focus:ring-2 focus:ring-connera-blue/30 outline-none transition"
                       placeholder="Ej: CONNERA">
            </div>

            <div>
                <label class="block text-sm font-medium text-connera-text mb-1">Logo</label>
                <input type="file" name="logo" accept="image/*"
                       class="w-full rounded-lg border border-gray-300 px-4 py-2.5 file:mr-3 file:py-1.5 file:px-4 file:rounded-lg file:border-0 file:bg-connera-blue file:text-white file:font-medium hover:file:brightness-110">
                <span class="text-xs text-gray-400">Imagen del logo (PNG con fondo transparente recomendado). Máx 2 MB.</span>
            </div>

            <div>
                <label class="block text-sm font-medium text-connera-text mb-1">Sitio web (opcional)</label>
                <input type="url" name="sitio_web" value="{{ old('sitio_web') }}"
                       class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-connera-blue focus:ring-2 focus:ring-connera-blue/30 outline-none transition"
                       placeholder="https://...">
            </div>

            <div class="flex items-center gap-6">
                <div>
                    <label class="block text-sm font-medium text-connera-text mb-1">Orden</label>
                    <input type="number" name="orden" value="{{ old('orden', 0) }}"
                           class="w-24 rounded-lg border border-gray-300 px-4 py-2.5 focus:border-connera-blue focus:ring-2 focus:ring-connera-blue/30 outline-none transition">
                </div>
                <label class="flex items-center mt-6">
                    <input type="checkbox" name="activo" value="1" checked
                           class="h-4 w-4 rounded border-gray-300 text-connera-blue focus:ring-connera-blue">
                    <span class="ml-2 text-sm text-gray-600">Mostrar en el carrusel</span>
                </label>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit"
                        class="bg-connera-yellow text-connera-blue font-bold px-6 py-2.5 rounded-lg hover:brightness-95 transition">
                    Guardar marca
                </button>
                <a href="{{ route('marcas.index') }}" class="text-gray-500 font-medium hover:underline">Cancelar</a>
            </div>
        </form>
    </div>

</x-admin-layout>