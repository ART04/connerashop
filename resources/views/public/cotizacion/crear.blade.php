{{-- FORMULARIO DE COTIZACIÓN DE UN PRODUCTO --}}
<x-public-layout>

    <div class="max-w-3xl mx-auto px-4 py-12">

        {{-- Encabezado con el producto --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-6 flex items-center gap-4">
            @if ($producto->imagen)
                <img src="{{ asset('storage/' . $producto->imagen) }}" alt="{{ $producto->nombre }}"
                     class="w-20 h-20 object-contain rounded-lg border border-gray-200">
            @endif
            <div>
                <span class="text-xs text-gray-500">Solicitar cotización de:</span>
                <h1 class="text-xl font-bold text-connera-text">{{ $producto->nombre }}</h1>
            </div>
        </div>

        @if ($errors->any())
            <div class="mb-6 rounded-lg bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('cotizacion.guardar', $producto->slug) }}"
              enctype="multipart/form-data"
              class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8 space-y-5">
            @csrf

            <h2 class="text-lg font-bold text-connera-text border-b pb-2">Tus datos</h2>

            {{-- Nombre y Email (se rellenan solos si esta logueado) --}}
            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-connera-text mb-1">Nombre *</label>
                    <input type="text" name="nombre" required
                           value="{{ old('nombre', Auth::user()->name ?? '') }}"
                           class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-connera-blue focus:ring-2 focus:ring-connera-blue/30 outline-none transition">
                </div>
                <div>
                    <label class="block text-sm font-medium text-connera-text mb-1">Correo electrónico *</label>
                    <input type="email" name="email" required
                           value="{{ old('email', Auth::user()->email ?? '') }}"
                           class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-connera-blue focus:ring-2 focus:ring-connera-blue/30 outline-none transition">
                </div>
            </div>

            {{-- Telefono y Empresa --}}
            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-connera-text mb-1">Teléfono</label>
                    <input type="text" name="telefono"
                           value="{{ old('telefono', Auth::user()->telefono ?? '') }}"
                           class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-connera-blue focus:ring-2 focus:ring-connera-blue/30 outline-none transition">
                </div>
                <div>
                    <label class="block text-sm font-medium text-connera-text mb-1">Empresa</label>
                    <input type="text" name="empresa"
                           value="{{ old('empresa', Auth::user()->empresa ?? '') }}"
                           class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-connera-blue focus:ring-2 focus:ring-connera-blue/30 outline-none transition">
                </div>
            </div>

            <h2 class="text-lg font-bold text-connera-text border-b pb-2 pt-2">Tu solicitud</h2>

            {{-- Cantidad --}}
            <div>
                <label class="block text-sm font-medium text-connera-text mb-1">Cantidad *</label>
                <input type="number" name="cantidad" value="{{ old('cantidad', 1) }}" min="1" required
                       class="w-32 rounded-lg border border-gray-300 px-4 py-2.5 focus:border-connera-blue focus:ring-2 focus:ring-connera-blue/30 outline-none transition">
            </div>

            {{-- Comentarios --}}
            <div>
                <label class="block text-sm font-medium text-connera-text mb-1">Comentarios</label>
                <textarea name="comentarios" rows="3"
                          placeholder="Cuéntanos más sobre lo que necesitas..."
                          class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-connera-blue focus:ring-2 focus:ring-connera-blue/30 outline-none transition">{{ old('comentarios') }}</textarea>
            </div>

            {{-- Recibo CFE --}}
            <div>
                <label class="block text-sm font-medium text-connera-text mb-1">Recibo CFE (opcional)</label>
                <input type="file" name="recibo_cfe" accept=".pdf,image/*"
                       class="w-full rounded-lg border border-gray-300 px-4 py-2.5 file:mr-3 file:py-1.5 file:px-4 file:rounded-lg file:border-0 file:bg-connera-blue file:text-white file:font-medium hover:file:brightness-110">
                <span class="text-xs text-gray-400">Ayúdanos a cotizar mejor. PDF o imagen, máx 5 MB.</span>
            </div>

            {{-- Botones --}}
            <div class="flex items-center gap-3 pt-2">
                <button type="submit"
                        class="bg-connera-yellow text-connera-blue font-bold px-6 py-3 rounded-lg hover:brightness-95 transition">
                    Enviar solicitud
                </button>
                <a href="{{ route('producto.show', $producto->slug) }}" class="text-gray-500 font-medium hover:underline">Cancelar</a>
            </div>
        </form>
    </div>

</x-public-layout>