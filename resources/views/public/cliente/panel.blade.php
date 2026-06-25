{{-- PANEL DEL CLIENTE (su zona privada) --}}
<x-public-layout>

    <div class="max-w-5xl mx-auto px-4 py-12">

        {{-- Bienvenida --}}
        <div class="bg-gradient-to-r from-connera-blue to-blue-800 text-white rounded-2xl p-8 mb-8">
            <h1 class="text-2xl font-bold">Hola, {{ Auth::user()->name }} 👋</h1>
            <p class="text-white/80 mt-1">Bienvenido a tu cuenta de Connera Shop.</p>
        </div>

        {{-- Tarjetas de accesos --}}
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">

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

            {{-- Mis cotizaciones (proximamente) --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h3 class="font-bold text-connera-text mb-3">Mis cotizaciones</h3>
                <p class="text-sm text-gray-400">Aquí verás tus cotizaciones. (Próximamente)</p>
            </div>

            {{-- Explorar productos --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h3 class="font-bold text-connera-text mb-3">Explorar catálogo</h3>
                <p class="text-sm text-gray-600 mb-4">Descubre nuestros productos solares.</p>
                <a href="{{ route('catalogo') }}" class="text-connera-blue font-medium hover:underline">Ver productos →</a>
            </div>
        </div>

        {{-- Cerrar sesion --}}
        <div class="mt-8">
            <form method="POST" action="{{ route('cliente.logout') }}">
                @csrf
                <button type="submit" class="text-red-600 font-medium hover:underline">Cerrar sesión</button>
            </form>
        </div>
    </div>

</x-public-layout>