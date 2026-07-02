{{-- 
  =====================================================================
  MOLDE DEL PANEL DE ADMINISTRACIÓN  ->  <x-admin-layout>
  Menú lateral + barra superior + footer + SweetAlert2 + DataTables.
  =====================================================================
--}}
<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Panel · Connera Shop' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- SweetAlert2: alertas bonitas (CDN) --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- jQuery: requerido por DataTables (debe ir ANTES que DataTables) --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    {{-- DataTables: buscador, orden y paginacion para las tablas (CDN) --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.8/css/dataTables.dataTables.css">
    <script src="https://cdn.datatables.net/2.3.8/js/dataTables.js"></script>
</head>

<body class="h-full bg-connera-bg text-connera-text antialiased">

    <div class="min-h-screen flex">

        {{-- ===================== MENÚ LATERAL ===================== --}}
        <aside class="w-64 bg-connera-blue text-white flex flex-col shrink-0">

            <div class="px-6 py-5 border-b border-white/10">
                <span class="text-lg font-bold">Connera Shop</span>
                <span class="block text-xs text-white/50">Administración</span>
            </div>

            <nav class="flex-1 px-3 py-4 space-y-1">

                {{-- INICIO --}}
                <a href="{{ route('dashboard') }}"
                   class="block px-4 py-2.5 rounded-lg transition
                          {{ request()->routeIs('dashboard') ? 'bg-white/10 font-medium text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                    Inicio
                </a>

                {{-- CATEGORÍAS --}}
                <a href="{{ route('categorias.index') }}"
                   class="block px-4 py-2.5 rounded-lg transition
                          {{ request()->routeIs('categorias.*') ? 'bg-white/10 font-medium text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                    Categorías
                </a>

                {{-- PRODUCTOS --}}
                <a href="{{ route('productos.index') }}"
                   class="block px-4 py-2.5 rounded-lg transition
                          {{ request()->routeIs('productos.*') ? 'bg-white/10 font-medium text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                    Productos
                </a>

                {{-- MARCAS --}}
                <a href="{{ route('marcas.index') }}"
                   class="block px-4 py-2.5 rounded-lg transition
                          {{ request()->routeIs('marcas.*') ? 'bg-white/10 font-medium text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                    Marcas
                </a>

                {{-- COTIZACIONES (ya conectado) --}}
                {{-- Aqui llegan las solicitudes de cotizacion de los clientes --}}
                <a href="{{ route('admin.cotizaciones.index') }}"
                   class="block px-4 py-2.5 rounded-lg transition
                          {{ request()->routeIs('admin.cotizaciones.*') ? 'bg-white/10 font-medium text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                    Cotizaciones
                </a>

                {{-- Próximo módulo --}}
                <a href="#" class="block px-4 py-2.5 rounded-lg text-white/70 hover:bg-white/10 hover:text-white transition">Recursos</a>
            </nav>

            <div class="px-6 py-4 border-t border-white/10 text-xs text-white/40">
                Versión 1.0
            </div>
        </aside>

        {{-- ===================== ÁREA DE CONTENIDO ===================== --}}
        <div class="flex-1 flex flex-col min-w-0">

            <header class="bg-white border-b border-gray-200">
                <div class="px-6 py-3 flex items-center justify-between">
                    <h1 class="text-lg font-semibold text-connera-text">{{ $header ?? 'Panel' }}</h1>
                    <div class="flex items-center gap-4">
                        <span class="text-sm text-gray-500">Hola, {{ Auth::user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="bg-connera-yellow text-connera-blue text-sm font-bold px-4 py-2 rounded-lg hover:brightness-95 transition">
                                Cerrar sesión
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <main class="flex-1 p-6">
                {{ $slot }}
            </main>

            {{-- ===================== FOOTER ===================== --}}
            <footer class="bg-white border-t border-gray-200 px-6 py-4">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-2 text-sm text-gray-600">
                    <div>
                        Sistema Connera Shop <span class="font-semibold text-connera-blue">v0.1</span>
                    </div>
                    <div>
                        Sistema desarrollado por
                        <a href="https://prowebsoluciones.org/" target="_blank" rel="noopener"
                           class="font-semibold text-connera-blue hover:underline">
                            ProWeb Soluciones
                        </a>
                    </div>
                    <div id="reloj-sistema" class="font-mono text-connera-blue font-medium"></div>
                </div>
            </footer>

        </div>
    </div>

    {{-- ===================== RELOJ EN VIVO ===================== --}}
    <script>
        function actualizarReloj() {
            const ahora = new Date();
            const opciones = {
                day: '2-digit', month: '2-digit', year: 'numeric',
                hour: '2-digit', minute: '2-digit', second: '2-digit',
                hour12: false
            };
            document.getElementById('reloj-sistema').textContent = ahora.toLocaleString('es-MX', opciones);
        }
        actualizarReloj();
        setInterval(actualizarReloj, 1000);
    </script>

    {{-- ===================== ALERTAS SWEETALERT2 ===================== --}}
    @if (session('exito'))
        <script>
            Swal.fire({
                icon: 'success',
                title: '¡Listo!',
                text: @json(session('exito')),
                confirmButtonColor: '#003B73',
                timer: 2500,
                timerProgressBar: true
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Ups...',
                text: @json(session('error')),
                confirmButtonColor: '#003B73'
            });
        </script>
    @endif

</body>
</html>