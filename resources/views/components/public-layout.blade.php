{{-- 
  =====================================================================
  MOLDE DEL SITIO PÚBLICO  ->  <x-public-layout>
  =====================================================================
--}}
<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Connera Shop · Energía Renovable' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="h-full bg-white text-connera-text antialiased flex flex-col min-h-screen">

    {{-- ===================== BARRA SUPERIOR (NAVBAR) ===================== --}}
    <header class="bg-white shadow-sm sticky top-0 z-40">

        {{-- Franja azul: fecha + tipo de cambio + contacto --}}
        <div class="bg-connera-blue text-white text-xs">
            <div class="max-w-7xl mx-auto px-4 py-2 flex justify-between items-center">
                <span>
                    <span id="cinta-fecha"></span>
                    <span class="font-semibold ml-1">TC USD/MXN: <span id="cinta-dolar">...</span></span>
                </span>
                <span class="hidden sm:block">Tel: (000) 000 0000 · ventas@connerashop.com</span>
            </div>
        </div>

        {{-- Navbar principal --}}
        <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between gap-4">

            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <span class="text-2xl font-bold text-connera-blue">Connera</span>
                <span class="text-2xl font-bold text-connera-yellow">Shop</span>
            </a>

            <nav class="hidden md:flex items-center gap-6 text-sm font-medium text-connera-text">
                <a href="{{ route('home') }}" class="hover:text-connera-blue transition">Inicio</a>
                <a href="{{ route('catalogo') }}" class="hover:text-connera-blue transition">Productos</a>
                <a href="#" class="hover:text-connera-blue transition">Marcas</a>
                <a href="#" class="hover:text-connera-blue transition">Contacto</a>
            </nav>

            {{-- Acceso clientes: si ya inicio sesion, muestra su nombre; si no, los botones --}}
            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ route('cliente.panel') }}" class="text-sm font-medium text-connera-blue hover:underline">
                        Mi cuenta
                    </a>
                    <form method="POST" action="{{ route('cliente.logout') }}">
                        @csrf
                        <button type="submit" class="bg-connera-yellow text-connera-blue text-sm font-bold px-4 py-2 rounded-lg hover:brightness-95 transition">
                            Salir
                        </button>
                    </form>
                @else
                    <a href="{{ route('cliente.login') }}" class="text-sm font-medium text-connera-blue hover:underline">Iniciar sesión</a>
                    <a href="{{ route('cliente.registro') }}" class="bg-connera-yellow text-connera-blue text-sm font-bold px-4 py-2 rounded-lg hover:brightness-95 transition">
                        Cotizar
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <main class="flex-1">
        {{ $slot }}
    </main>

    {{-- ===================== PIE DE PÁGINA ===================== --}}
    <footer class="bg-connera-blue text-white mt-12">
        <div class="max-w-7xl mx-auto px-4 py-10 grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <h3 class="text-lg font-bold mb-2">Connera Shop</h3>
                <p class="text-sm text-white/70">Tu proveedor de soluciones en energía renovable. Paneles, inversores y más.</p>
            </div>
            <div>
                <h4 class="font-semibold mb-2">Enlaces</h4>
                <ul class="space-y-1 text-sm text-white/70">
                    <li><a href="{{ route('home') }}" class="hover:text-white">Inicio</a></li>
                    <li><a href="{{ route('catalogo') }}" class="hover:text-white">Productos</a></li>
                    <li><a href="#" class="hover:text-white">Marcas</a></li>
                    <li><a href="#" class="hover:text-white">Contacto</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-semibold mb-2">Contacto</h4>
                <ul class="space-y-1 text-sm text-white/70">
                    <li>Tel: (000) 000 0000</li>
                    <li>ventas@connerashop.com</li>
                    <li>Tabasco, México</li>
                </ul>
            </div>
        </div>

        <div class="border-t border-white/10">
            <div class="max-w-7xl mx-auto px-4 py-4 flex flex-col sm:flex-row justify-between items-center gap-2 text-xs text-white/50">
                <span>© {{ date('Y') }} Connera Shop. Todos los derechos reservados.</span>
                <span>
                    Desarrollado por
                    <a href="https://prowebsoluciones.org/" target="_blank" rel="noopener" class="text-connera-yellow hover:underline">ProWeb Soluciones</a>
                </span>
            </div>
        </div>
    </footer>

    {{-- ===================== CINTA: FECHA + DÓLAR ===================== --}}
    <script>
        function ponerFecha() {
            const ahora = new Date();
            const dias  = ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'];
            const meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
                           'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
            document.getElementById('cinta-fecha').textContent =
                dias[ahora.getDay()] + ', ' + ahora.getDate() + ' ' + meses[ahora.getMonth()] + ' ' + ahora.getFullYear();
        }
        function ponerDolar() {
            fetch('https://open.er-api.com/v6/latest/USD')
                .then(r => r.json())
                .then(d => {
                    document.getElementById('cinta-dolar').textContent =
                        (d && d.rates && d.rates.MXN) ? d.rates.MXN.toFixed(2) : 'N/D';
                })
                .catch(() => { document.getElementById('cinta-dolar').textContent = 'N/D'; });
        }
        ponerFecha();
        ponerDolar();
    </script>

    @if (session('exito'))
        <script>
            Swal.fire({ icon: 'success', title: '¡Listo!', text: @json(session('exito')), confirmButtonColor: '#003B73' });
        </script>
    @endif

</body>
</html>