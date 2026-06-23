{{-- FORMULARIO PARA CREAR UN PRODUCTO (con specs y documentos dinamicos) --}}
<x-admin-layout header="Nuevo producto">

    <div class="max-w-3xl">

        @if ($errors->any())
            <div class="mb-4 rounded-lg bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700">
                Por favor revisa los datos. Asegúrate de llenar el nombre.
            </div>
        @endif

        <form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data"
              class="space-y-6">
            @csrf

            {{-- ============ DATOS GENERALES ============ --}}
            <div class="bg-white rounded-2xl shadow p-8 space-y-5">
                <h3 class="text-lg font-bold text-connera-text border-b pb-2">Datos generales</h3>

                <div>
                    <label class="block text-sm font-medium text-connera-text mb-1">Nombre *</label>
                    <input type="text" name="nombre" value="{{ old('nombre') }}" required
                           class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-connera-blue focus:ring-2 focus:ring-connera-blue/30 outline-none transition"
                           placeholder="Ej: Célula fotovoltaica monocristalina TOPCon">
                </div>

                <div>
                    <label class="block text-sm font-medium text-connera-text mb-1">Categoría</label>
                    <select name="categoria_id"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-connera-blue focus:ring-2 focus:ring-connera-blue/30 outline-none transition">
                        <option value="">— Sin categoría —</option>
                        @foreach ($categorias as $categoria)
                            <option value="{{ $categoria->id }}" {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>
                                {{ $categoria->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-connera-text mb-1">Descripción</label>
                    <textarea name="descripcion" rows="3"
                              class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-connera-blue focus:ring-2 focus:ring-connera-blue/30 outline-none transition">{{ old('descripcion') }}</textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-connera-text mb-1">Precio</label>
                        <input type="number" step="0.01" name="precio" value="{{ old('precio', 0) }}"
                               class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-connera-blue focus:ring-2 focus:ring-connera-blue/30 outline-none transition">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-connera-text mb-1">Marca</label>
                        <input type="text" name="marca" value="{{ old('marca') }}"
                               class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-connera-blue focus:ring-2 focus:ring-connera-blue/30 outline-none transition"
                               placeholder="Ej: CONNERA">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-connera-text mb-1">Foto principal</label>
                    <input type="file" name="imagen" accept="image/*"
                           class="w-full rounded-lg border border-gray-300 px-4 py-2.5 file:mr-3 file:py-1.5 file:px-4 file:rounded-lg file:border-0 file:bg-connera-blue file:text-white file:font-medium hover:file:brightness-110">
                    <span class="text-xs text-gray-400">Opcional. Máximo 2 MB.</span>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-connera-text mb-1">Enlace Amazon</label>
                        <input type="url" name="enlace_amazon" value="{{ old('enlace_amazon') }}"
                               class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-connera-blue focus:ring-2 focus:ring-connera-blue/30 outline-none transition"
                               placeholder="https://...">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-connera-text mb-1">Enlace Mercado Libre</label>
                        <input type="url" name="enlace_mercadolibre" value="{{ old('enlace_mercadolibre') }}"
                               class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-connera-blue focus:ring-2 focus:ring-connera-blue/30 outline-none transition"
                               placeholder="https://...">
                    </div>
                </div>

                <div class="flex items-center gap-6">
                    <div>
                        <label class="block text-sm font-medium text-connera-text mb-1">Orden</label>
                        <input type="number" name="orden" value="{{ old('orden', 0) }}"
                               class="w-24 rounded-lg border border-gray-300 px-4 py-2.5 focus:border-connera-blue focus:ring-2 focus:ring-connera-blue/30 outline-none transition">
                    </div>
                    <label class="flex items-center mt-6">
                        <input type="checkbox" name="destacado" value="1" {{ old('destacado') ? 'checked' : '' }}
                               class="h-4 w-4 rounded border-gray-300 text-connera-blue focus:ring-connera-blue">
                        <span class="ml-2 text-sm text-gray-600">Destacado</span>
                    </label>
                    <label class="flex items-center mt-6">
                        <input type="checkbox" name="activo" value="1" checked
                               class="h-4 w-4 rounded border-gray-300 text-connera-blue focus:ring-connera-blue">
                        <span class="ml-2 text-sm text-gray-600">Activo</span>
                    </label>
                </div>
            </div>

            {{-- ============ ESPECIFICACIONES TECNICAS ============ --}}
            <div class="bg-white rounded-2xl shadow p-8">
                <div class="flex items-center justify-between border-b pb-2 mb-4">
                    <h3 class="text-lg font-bold text-connera-text">Especificaciones técnicas</h3>
                    <button type="button" id="btn-agregar-spec"
                            class="bg-connera-blue text-white text-sm font-medium px-3 py-1.5 rounded-lg hover:brightness-110 transition">
                        + Agregar característica
                    </button>
                </div>
                <p class="text-xs text-gray-400 mb-3">Ej: "Voltaje de circuito abierto" → "48.10 Vcc". Agrega las que necesites.</p>

                {{-- Aqui se van apilando las filas de caracteristicas --}}
                <div id="lista-specs" class="space-y-2"></div>
            </div>

            {{-- ============ DOCUMENTOS PDF ============ --}}
            <div class="bg-white rounded-2xl shadow p-8">
                <div class="flex items-center justify-between border-b pb-2 mb-4">
                    <h3 class="text-lg font-bold text-connera-text">Documentos descargables (PDF)</h3>
                    <button type="button" id="btn-agregar-doc"
                            class="bg-connera-blue text-white text-sm font-medium px-3 py-1.5 rounded-lg hover:brightness-110 transition">
                        + Agregar documento
                    </button>
                </div>
                <p class="text-xs text-gray-400 mb-3">Ej: "Ficha técnica", "Certificado IEC". Solo archivos PDF, máximo 5 MB cada uno.</p>

                <div id="lista-docs" class="space-y-2"></div>
            </div>

            {{-- ============ BOTONES ============ --}}
            <div class="flex items-center gap-3">
                <button type="submit"
                        class="bg-connera-yellow text-connera-blue font-bold px-6 py-2.5 rounded-lg hover:brightness-95 transition">
                    Guardar producto
                </button>
                <a href="{{ route('productos.index') }}" class="text-gray-500 font-medium hover:underline">Cancelar</a>
            </div>
        </form>
    </div>

    {{-- ============ SCRIPT: filas dinamicas ============ --}}
    <script>
        // ---- ESPECIFICACIONES ----
        const listaSpecs = document.getElementById('lista-specs');

        function agregarFilaSpec() {
            const fila = document.createElement('div');
            fila.className = 'flex gap-2 items-center';
            fila.innerHTML = `
                <input type="text" name="spec_etiqueta[]" placeholder="Característica (ej: Potencia máxima)"
                       class="flex-1 rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-connera-blue focus:ring-1 focus:ring-connera-blue/30 outline-none">
                <input type="text" name="spec_valor[]" placeholder="Valor (ej: 610 watts)"
                       class="flex-1 rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-connera-blue focus:ring-1 focus:ring-connera-blue/30 outline-none">
                <button type="button" class="text-red-500 hover:text-red-700 px-2 quitar-fila" title="Quitar">✕</button>
            `;
            listaSpecs.appendChild(fila);
        }

        // ---- DOCUMENTOS ----
        const listaDocs = document.getElementById('lista-docs');

        function agregarFilaDoc() {
            const fila = document.createElement('div');
            fila.className = 'flex gap-2 items-center';
            fila.innerHTML = `
                <input type="text" name="doc_titulo[]" placeholder="Título (ej: Ficha técnica)"
                       class="flex-1 rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-connera-blue focus:ring-1 focus:ring-connera-blue/30 outline-none">
                <input type="file" name="doc_archivo[]" accept="application/pdf"
                       class="flex-1 rounded-lg border border-gray-300 px-3 py-2 text-sm file:mr-2 file:py-1 file:px-3 file:rounded file:border-0 file:bg-connera-blue file:text-white">
                <button type="button" class="text-red-500 hover:text-red-700 px-2 quitar-fila" title="Quitar">✕</button>
            `;
            listaDocs.appendChild(fila);
        }

        // Botones para agregar
        document.getElementById('btn-agregar-spec').addEventListener('click', agregarFilaSpec);
        document.getElementById('btn-agregar-doc').addEventListener('click', agregarFilaDoc);

        // Quitar fila (funciona para specs y docs)
        document.addEventListener('click', function (e) {
            if (e.target.classList.contains('quitar-fila')) {
                e.target.closest('div').remove();
            }
        });

        // Arrancamos con una fila vacia de cada uno para guiar al usuario
        agregarFilaSpec();
        agregarFilaDoc();
    </script>

</x-admin-layout>