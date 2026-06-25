{{-- CATÁLOGO PÚBLICO: todos los productos con filtros --}}
<x-public-layout>

    <div class="max-w-7xl mx-auto px-4 py-10">

        {{-- Titulo --}}
        <div class="flex items-center gap-3 mb-8">
            <span class="w-1.5 h-8 bg-connera-yellow rounded-full"></span>
            <h1 class="text-3xl font-bold text-connera-text">Nuestros productos</h1>
        </div>

        {{-- ===================== FILTROS ===================== --}}
        {{-- Un formulario simple que manda los filtros por la URL (metodo GET) --}}
        <form method="GET" action="{{ route('catalogo') }}"
              class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 mb-8 grid sm:grid-cols-3 gap-4">

            {{-- Buscar por nombre o marca --}}
            <div>
                <label class="block text-sm font-medium text-connera-text mb-1">Buscar</label>
                <input type="text" name="buscar" value="{{ request('buscar') }}"
                       placeholder="Nombre o marca..."
                       class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-connera-blue focus:ring-2 focus:ring-connera-blue/30 outline-none transition">
            </div>

            {{-- Filtrar por categoria --}}
            <div>
                <label class="block text-sm font-medium text-connera-text mb-1">Categoría</label>
                <select name="categoria"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-connera-blue focus:ring-2 focus:ring-connera-blue/30 outline-none transition">
                    <option value="">Todas las categorías</option>
                    @foreach ($categorias as $categoria)
                        <option value="{{ $categoria->id }}" {{ request('categoria') == $categoria->id ? 'selected' : '' }}>
                            {{ $categoria->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Botones --}}
            <div class="flex items-end gap-2">
                <button type="submit"
                        class="bg-connera-yellow text-connera-blue font-bold px-6 py-2.5 rounded-lg hover:brightness-95 transition">
                    Filtrar
                </button>
                <a href="{{ route('catalogo') }}"
                   class="text-gray-500 font-medium px-3 py-2.5 hover:underline">Limpiar</a>
            </div>
        </form>

        {{-- ===================== RESULTADOS ===================== --}}
        @if ($productos->count())

            {{-- Contador de resultados --}}
            <p class="text-sm text-gray-500 mb-4">{{ $productos->total() }} producto(s) encontrado(s)</p>

            {{-- Cuadricula de tarjetas --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($productos as $producto)
                    <div class="bg-white rounded-2xl shadow hover:shadow-lg transition overflow-hidden border border-gray-100">
                        <a href="{{ route('producto.show', $producto->slug) }}" class="block aspect-square bg-gray-50 flex items-center justify-center p-4">
                            @if ($producto->imagen)
                                <img src="{{ asset('storage/' . $producto->imagen) }}" alt="{{ $producto->nombre }}"
                                     class="max-h-full max-w-full object-contain">
                            @else
                                <div class="text-gray-300 text-sm">Sin imagen</div>
                            @endif
                        </a>
                        <div class="p-4">
                            @if ($producto->categoria)
                                <span class="text-xs text-connera-blue font-medium">{{ $producto->categoria->nombre }}</span>
                            @endif
                            <h3 class="font-semibold text-connera-text mt-1 line-clamp-2">{{ $producto->nombre }}</h3>
                            @if ($producto->precio > 0)
                                <p class="text-lg font-bold text-connera-blue mt-2">${{ number_format($producto->precio, 2) }}</p>
                            @endif
                            <a href="{{ route('producto.show', $producto->slug) }}" class="block text-center bg-connera-yellow text-connera-blue font-bold py-2 rounded-lg mt-3 hover:brightness-95 transition">
                                Ver detalles
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Paginacion --}}
            <div class="mt-10">
                {{ $productos->links() }}
            </div>

        @else
            {{-- Sin resultados --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm py-16 text-center">
                <p class="text-gray-400 text-lg">No se encontraron productos con esos filtros.</p>
                <a href="{{ route('catalogo') }}" class="inline-block mt-4 text-connera-blue font-medium hover:underline">Ver todos los productos</a>
            </div>
        @endif

    </div>

</x-public-layout>