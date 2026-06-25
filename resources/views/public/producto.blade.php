{{-- FICHA PÚBLICA DE UN PRODUCTO (estilo CONNERA: imagen + info + pestañas) --}}
<x-public-layout>

    <div class="max-w-7xl mx-auto px-4 py-10">

        {{-- Migaja de navegacion --}}
        <nav class="text-sm text-gray-500 mb-6">
            <a href="{{ route('home') }}" class="hover:text-connera-blue">Inicio</a>
            <span class="mx-2">/</span>
            @if ($producto->categoria)
                <span>{{ $producto->categoria->nombre }}</span>
                <span class="mx-2">/</span>
            @endif
            <span class="text-connera-text font-medium">{{ $producto->nombre }}</span>
        </nav>

        {{-- ===================== PARTE SUPERIOR: IMAGEN + INFO ===================== --}}
        <div class="grid md:grid-cols-2 gap-10 mb-12">

            {{-- Imagen del producto (clic para ver en grande) --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8 flex items-center justify-center">
                @if ($producto->imagen)
                    <img src="{{ asset('storage/' . $producto->imagen) }}" alt="{{ $producto->nombre }}"
                         data-imagen="{{ asset('storage/' . $producto->imagen) }}"
                         data-nombre="{{ $producto->nombre }}"
                         class="ver-imagen max-h-[420px] w-auto object-contain cursor-zoom-in hover:brightness-95 transition">
                @else
                    <div class="text-gray-300 py-32">Sin imagen</div>
                @endif
            </div>

            {{-- Informacion del producto --}}
            <div>
                @if ($producto->categoria)
                    <span class="inline-block bg-connera-bg text-connera-blue text-xs font-semibold px-3 py-1 rounded-full mb-3">
                        {{ $producto->categoria->nombre }}
                    </span>
                @endif

                <h1 class="text-3xl font-bold text-connera-text mb-3">{{ $producto->nombre }}</h1>

                @if ($producto->marca)
                    <p class="text-sm text-gray-500 mb-4">Marca: <span class="font-semibold text-connera-text">{{ $producto->marca }}</span></p>
                @endif

                @if ($producto->descripcion)
                    <p class="text-gray-600 leading-relaxed mb-6">{{ $producto->descripcion }}</p>
                @endif

                @if ($producto->precio > 0)
                    <p class="text-3xl font-bold text-connera-blue mb-6">${{ number_format($producto->precio, 2) }}</p>
                @endif

                {{-- Botones de accion --}}
                <div class="flex flex-wrap gap-3 mb-6">
                    <a href="#" class="bg-connera-yellow text-connera-blue font-bold px-6 py-3 rounded-lg hover:brightness-95 transition">
                        Solicitar cotización
                    </a>
                    @if ($producto->enlace_amazon)
                        <a href="{{ $producto->enlace_amazon }}" target="_blank" rel="noopener"
                           class="border border-gray-300 text-connera-text font-medium px-6 py-3 rounded-lg hover:bg-gray-50 transition">
                            Ver en Amazon
                        </a>
                    @endif
                    @if ($producto->enlace_mercadolibre)
                        <a href="{{ $producto->enlace_mercadolibre }}" target="_blank" rel="noopener"
                           class="border border-gray-300 text-connera-text font-medium px-6 py-3 rounded-lg hover:bg-gray-50 transition">
                            Ver en Mercado Libre
                        </a>
                    @endif
                </div>
            </div>
        </div>

        {{-- ===================== PESTAÑAS (Características / Documentos) ===================== --}}
        {{-- Cambiamos de pestaña con JavaScript simple (sin depender de Alpine) --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

            {{-- Cabecera de pestañas --}}
            <div class="flex border-b border-gray-200">
                <button type="button" data-tab="caracteristicas"
                        class="boton-tab px-6 py-4 font-semibold border-b-2 border-connera-blue text-connera-blue transition">
                    Características
                </button>
                <button type="button" data-tab="documentos"
                        class="boton-tab px-6 py-4 font-semibold border-b-2 border-transparent text-gray-500 transition">
                    Documentos descargables
                </button>
            </div>

            {{-- Contenido: CARACTERÍSTICAS --}}
            <div id="panel-caracteristicas" class="panel-tab p-6">
                @if ($producto->especificaciones->count())
                    <table class="w-full text-left">
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($producto->especificaciones as $spec)
                                <tr>
                                    <td class="py-3 pr-4 font-semibold text-connera-text w-1/3">{{ $spec->etiqueta }}</td>
                                    <td class="py-3 text-gray-600">{{ $spec->valor }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-gray-400 py-6 text-center">Este producto aún no tiene especificaciones cargadas.</p>
                @endif
            </div>

            {{-- Contenido: DOCUMENTOS (oculto al inicio) --}}
            <div id="panel-documentos" class="panel-tab p-6 hidden">
                @if ($producto->documentos->count())
                    <div class="grid sm:grid-cols-2 gap-3">
                        @foreach ($producto->documentos as $doc)
                            <a href="{{ asset('storage/' . $doc->archivo) }}" target="_blank" rel="noopener"
                               class="flex items-center gap-3 bg-connera-bg rounded-lg px-4 py-3 hover:bg-gray-100 transition">
                                <span class="text-connera-blue text-xl">📄</span>
                                <span class="font-medium text-connera-text">{{ $doc->titulo }}</span>
                            </a>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-400 py-6 text-center">Este producto aún no tiene documentos descargables.</p>
                @endif
            </div>
        </div>

    </div>

    {{-- ===================== SCRIPT: cambio de pestañas ===================== --}}
    <script>
        // Al hacer clic en una pestaña, mostramos su panel y ocultamos el otro
        document.querySelectorAll('.boton-tab').forEach(function (boton) {
            boton.addEventListener('click', function () {
                const destino = this.dataset.tab;

                // 1) Resaltar el boton activo, apagar los demas
                document.querySelectorAll('.boton-tab').forEach(function (b) {
                    b.classList.remove('border-connera-blue', 'text-connera-blue');
                    b.classList.add('border-transparent', 'text-gray-500');
                });
                this.classList.add('border-connera-blue', 'text-connera-blue');
                this.classList.remove('border-transparent', 'text-gray-500');

                // 2) Mostrar el panel correspondiente, ocultar los demas
                document.querySelectorAll('.panel-tab').forEach(function (panel) {
                    panel.classList.add('hidden');
                });
                document.getElementById('panel-' + destino).classList.remove('hidden');
            });
        });
    </script>

    {{-- ===================== SCRIPT: zoom de la imagen ===================== --}}
    <script>
        document.querySelectorAll('.ver-imagen').forEach(function (img) {
            img.addEventListener('click', function () {
                Swal.fire({
                    imageUrl: this.dataset.imagen,
                    imageAlt: this.dataset.nombre,
                    width: 700,
                    showConfirmButton: true,
                    confirmButtonText: 'Cerrar',
                    confirmButtonColor: '#003B73'
                });
            });
        });
    </script>

</x-public-layout>