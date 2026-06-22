{{-- 
  =====================================================================
  DASHBOARD (PANEL) DE CONNERA SHOP
  Pantalla principal del administrador, visible solo tras iniciar sesión.
  Por ahora muestra un saludo; luego tendrá estadísticas y accesos.
  =====================================================================
--}}
<x-app-layout>

    {{-- Barra superior azul corporativa --}}
    <header class="bg-connera-blue text-white shadow">
        <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">

            {{-- Nombre de la marca --}}
            <h1 class="text-xl font-bold">Connera Shop</h1>

            {{-- Saludo + botón de cerrar sesión --}}
            <div class="flex items-center gap-4">
                {{-- Auth::user() es el usuario que inició sesión --}}
                <span class="text-sm text-white/80">Hola, {{ Auth::user()->name }}</span>

                {{-- Formulario para cerrar sesión (envía a la ruta 'logout') --}}
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

    {{-- Contenido principal del panel --}}
    <main class="max-w-6xl mx-auto px-6 py-10">

        {{-- Tarjeta de bienvenida --}}
        <div class="bg-white rounded-2xl shadow p-8">
            <h2 class="text-2xl font-bold text-connera-text mb-2">
                ¡Bienvenido a tu panel! 🎉
            </h2>
            <p class="text-gray-600">
                Has iniciado sesión correctamente como administrador.
                Desde aquí gestionarás tu catálogo, cotizaciones y clientes.
            </p>

            {{-- Pequeño aviso de que todo funciona --}}
            <div class="mt-6 inline-block bg-connera-bg border border-connera-blue/20 rounded-lg px-4 py-3">
                <p class="text-sm text-connera-blue font-medium">
                    ✅ Sistema de acceso funcionando con tus colores corporativos.
                </p>
            </div>
        </div>
    </main>

</x-app-layout>