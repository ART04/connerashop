{{-- 
  =====================================================================
  PANEL (DASHBOARD) DE CONNERA SHOP
  Usa el molde del admin <x-admin-layout> (menú lateral + barra superior).
  Aquí solo va el contenido central de la pantalla de inicio.
  =====================================================================
--}}
<x-admin-layout header="Inicio">

    <div class="bg-white rounded-2xl shadow p-8">
        <h2 class="text-2xl font-bold text-connera-text mb-2">¡Bienvenido a tu panel! 🎉</h2>
        <p class="text-gray-600">
            Has iniciado sesión como administrador. Desde el menú de la izquierda
            gestionarás tu catálogo, cotizaciones y clientes.
        </p>

        <div class="mt-6 inline-block bg-connera-bg border border-connera-blue/20 rounded-lg px-4 py-3">
            <p class="text-sm text-connera-blue font-medium">✅ Panel listo con tu menú lateral.</p>
        </div>
    </div>

</x-admin-layout>