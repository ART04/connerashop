{{-- PANEL DEL CLIENTE (su zona privada) --}}
<x-public-layout>

    <div class="max-w-5xl mx-auto px-4 py-12">

        {{-- Bienvenida --}}
        <div class="bg-gradient-to-r from-connera-blue to-blue-800 text-white rounded-2xl p-8 mb-8">
            <h1 class="text-2xl font-bold">Hola, {{ Auth::user()->name }} 👋</h1>
            <p class="text-white/80 mt-1">Bienvenido a tu cuenta de Connera Shop.</p>
        </div>

        {{-- Tarjetas de accesos --}}
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">

            {{-- Mis datos --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h3 class="font-bold text-connera-text mb-3">Mis datos</h3>
                <ul class="text-sm text-gray-600 space-y-1">
                    <li><span class="font-medium">Nombre:</span> {{ Auth::user()->name }} {{ Auth::user()->apellido }}</li>
                    <li><span class="font-medium">Correo:</span> {{ Auth::user()->email }}</li>
                    @if (Auth::user()->telefono)
                        <li><span class="font-medium">Teléfono:</span> {{ Auth::user()->telefono }}</li>
                    @endif
                    @if (Auth::user()->empresa)
                        <li><span class="font-medium">Empresa:</span> {{ Auth::user()->empresa }}</li>
                    @endif
                </ul>
            </div>

            {{-- Total de cotizaciones --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h3 class="font-bold text-connera-text mb-3">Mis cotizaciones</h3>
                <p class="text-4xl font-bold text-connera-blue">{{ $cotizaciones->count() }}</p>
                <p class="text-sm text-gray-400">solicitudes realizadas</p>
            </div>

            {{-- Explorar productos --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h3 class="font-bold text-connera-text mb-3">Explorar catálogo</h3>
                <p class="text-sm text-gray-600 mb-4">Descubre nuestros productos solares.</p>
                <a href="{{ route('catalogo') }}" class="text-connera-blue font-medium hover:underline">Ver productos →</a>
            </div>
        </div>

        {{-- ===================== HISTORIAL DE COTIZACIONES ===================== --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-8">
            <h3 class="font-bold text-connera-text border-b pb-3 mb-4">Historial de cotizaciones</h3>

            @if ($cotizaciones->count())
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-sm text-gray-500 border-b">
                                <th class="py-2 pr-4 font-semibold">Folio</th>
                                <th class="py-2 pr-4 font-semibold">Producto(s)</th>
                                <th class="py-2 pr-4 font-semibold">Estado</th>
                                <th class="py-2 font-semibold">Fecha</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($cotizaciones as $cotizacion)
                                <tr>
                                    {{-- Folio --}}
                                    <td class="py-3 pr-4 font-medium text-connera-blue">{{ $cotizacion->folio }}</td>

                                    {{-- Productos solicitados --}}
                                    <td class="py-3 pr-4 text-sm text-gray-600">
                                        @foreach ($cotizacion->items as $item)
                                            <span class="block">{{ $item->cantidad }} × {{ $item->producto_nombre }}</span>
                                        @endforeach
                                    </td>

                                    {{-- Estado con color --}}
                                    <td class="py-3 pr-4">
                                        @php
                                            $colores = [
                                                'nueva'      => 'bg-blue-100 text-blue-700',
                                                'en_proceso' => 'bg-yellow-100 text-yellow-700',
                                                'enviada'    => 'bg-purple-100 text-purple-700',
                                                'aprobada'   => 'bg-green-100 text-green-700',
                                                'rechazada'  => 'bg-red-100 text-red-700',
                                                'cancelada'  => 'bg-gray-100 text-gray-500',
                                            ];
                                            $clase = $colores[$cotizacion->estado] ?? 'bg-gray-100 text-gray-500';
                                        @endphp
                                        <span class="inline-block {{ $clase }} text-xs font-medium px-2.5 py-1 rounded-full">
                                            {{ ucfirst(str_replace('_', ' ', $cotizacion->estado)) }}
                                        </span>
                                    </td>

                                    {{-- Fecha --}}
                                    <td class="py-3 text-sm text-gray-500">{{ $cotizacion->created_at->format('d/m/Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                {{-- Si no tiene cotizaciones aun --}}
                <div class="text-center py-10">
                    <p class="text-gray-400 mb-4">Aún no has solicitado ninguna cotización.</p>
                    <a href="{{ route('catalogo') }}"
                       class="inline-block bg-connera-yellow text-connera-blue font-bold px-6 py-3 rounded-lg hover:brightness-95 transition">
                        Explorar productos
                    </a>
                </div>
            @endif
        </div>

        {{-- Cerrar sesion --}}
        <div>
            <form method="POST" action="{{ route('cliente.logout') }}">
                @csrf
                <button type="submit" class="text-red-600 font-medium hover:underline">Cerrar sesión</button>
            </form>
        </div>
    </div>

</x-public-layout>