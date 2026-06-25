{{-- HOME PÚBLICA DE CONNERA SHOP --}}
<x-public-layout>

    {{-- ===================== BANNER PRINCIPAL ===================== --}}
    <section class="bg-gradient-to-r from-connera-blue to-blue-800 text-white">
        <div class="max-w-7xl mx-auto px-4 py-20 grid md:grid-cols-2 gap-8 items-center">
            <div>
                <h1 class="text-4xl md:text-5xl font-bold leading-tight mb-4">
                    Energía solar para <span class="text-connera-yellow">tu futuro</span>
                </h1>
                <p class="text-lg text-white/80 mb-6">
                    Paneles, inversores y soluciones de energía renovable de las mejores marcas.
                    Cotiza fácil y rápido.
                </p>
                <div class="flex gap-3">
                    <a href="#productos" class="bg-connera-yellow text-connera-blue font-bold px-6 py-3 rounded-lg hover:brightness-95 transition">
                        Ver productos
                    </a>
                    <a href="#" class="border border-white/40 text-white font-medium px-6 py-3 rounded-lg hover:bg-white/10 transition">
                        Solicitar cotización
                    </a>
                </div>
            </div>
            <div class="hidden md:flex justify-center">
                <div class="text-[12rem] leading-none">☀️</div>
            </div>
        </div>
    </section>

    {{-- ===================== PRODUCTOS DESTACADOS ===================== --}}
    <section id="productos" class="max-w-7xl mx-auto px-4 py-16">
        <div class="flex items-center gap-3 mb-8">
            <span class="w-1.5 h-8 bg-connera-yellow rounded-full"></span>
            <h2 class="text-2xl font-bold text-connera-text">Productos destacados</h2>
        </div>

        @if ($destacados->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($destacados as $producto)
                    {{-- TARJETA DE PRODUCTO --}}
                    <div class="bg-white rounded-2xl shadow hover:shadow-lg transition overflow-hidden border border-gray-100">
                        {{-- Foto (clic lleva a la ficha) --}}
                        <a href="{{ route('producto.show', $producto->slug) }}" class="block aspect-square bg-gray-50 flex items-center justify-center p-4">
                            @if ($producto->imagen)
                                <img src="{{ asset('storage/' . $producto->imagen) }}" alt="{{ $producto->nombre }}"
                                     class="max-h-full max-w-full object-contain">
                            @else
                                <div class="text-gray-300 text-sm">Sin imagen</div>
                            @endif
                        </a>
                        {{-- Info --}}
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
        @else
            <p class="text-gray-400 text-center py-10">Pronto agregaremos productos destacados.</p>
        @endif
    </section>

    {{-- ===================== CARRUSEL DE MARCAS ===================== --}}
    @if ($marcas->count())
        <section class="bg-connera-bg py-16">
            <div class="max-w-7xl mx-auto px-4">
                <div class="flex items-center gap-3 mb-8">
                    <span class="w-1.5 h-8 bg-connera-yellow rounded-full"></span>
                    <h2 class="text-2xl font-bold text-connera-text">Nuestras marcas</h2>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-6">
                    @foreach ($marcas as $marca)
                        <div class="bg-white rounded-xl p-6 flex items-center justify-center h-28 shadow-sm hover:shadow transition">
                            @if ($marca->logo)
                                <img src="{{ asset('storage/' . $marca->logo) }}" alt="{{ $marca->nombre }}"
                                     class="max-h-full max-w-full object-contain">
                            @else
                                <span class="text-gray-400 text-sm">{{ $marca->nombre }}</span>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

</x-public-layout>