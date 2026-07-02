{{-- PÁGINA DE AGRADECIMIENTO TRAS ENVIAR LA COTIZACIÓN --}}
<x-public-layout>

    <div class="max-w-2xl mx-auto px-4 py-16 text-center">

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-10">

            {{-- Icono de exito --}}
            <div class="text-6xl mb-4">✅</div>

            <h1 class="text-3xl font-bold text-connera-text mb-3">¡Solicitud enviada!</h1>
            <p class="text-gray-600 mb-6">
                Gracias por tu interés. Hemos recibido tu solicitud de cotización
                y te contactaremos pronto.
            </p>

            {{-- Folio de la cotizacion --}}
            <div class="bg-connera-bg rounded-xl py-4 px-6 inline-block mb-8">
                <span class="text-sm text-gray-500 block">Tu número de folio:</span>
                <span class="text-2xl font-bold text-connera-blue">{{ $cotizacion->folio }}</span>
            </div>

            <p class="text-sm text-gray-500 mb-8">
                Guarda este folio para dar seguimiento a tu cotización.
            </p>

            {{-- Botones de accion --}}
            <div class="flex flex-wrap justify-center gap-3">
                <a href="{{ route('catalogo') }}"
                   class="bg-connera-yellow text-connera-blue font-bold px-6 py-3 rounded-lg hover:brightness-95 transition">
                    Seguir explorando
                </a>
                @auth
                    <a href="{{ route('cliente.panel') }}"
                       class="border border-gray-300 text-connera-text font-medium px-6 py-3 rounded-lg hover:bg-gray-50 transition">
                        Ir a mi cuenta
                    </a>
                @endauth
            </div>
        </div>
    </div>

</x-public-layout>