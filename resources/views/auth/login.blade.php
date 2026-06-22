{{-- 
  =====================================================================
  PANTALLA DE LOGIN DE CONNERA SHOP
  Usa el molde base <x-app-layout> y muestra el formulario de acceso
  con los colores corporativos (azul #003B73 y amarillo #FFD200).
  =====================================================================
--}}
<x-app-layout>

    {{-- Contenedor que centra la tarjeta de login en toda la pantalla --}}
    <div class="min-h-screen flex items-center justify-center px-4">

        {{-- Tarjeta blanca del formulario --}}
        <div class="w-full max-w-md bg-white rounded-2xl shadow-lg overflow-hidden">

            {{-- Encabezado azul corporativo con el nombre de la marca --}}
            <div class="bg-connera-blue py-8 px-6 text-center">
                <h1 class="text-2xl font-bold text-white">Connera Shop</h1>
                <p class="text-sm text-white/70 mt-1">Panel de administración</p>
            </div>

            {{-- Cuerpo del formulario --}}
            <div class="p-8">

                {{-- Si el login falla, aquí se muestra el mensaje de error --}}
                @if ($errors->any())
                    <div class="mb-4 rounded-lg bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700">
                        Correo o contraseña incorrectos. Inténtalo de nuevo.
                    </div>
                @endif

                {{-- El formulario envía los datos a la ruta 'login' por POST --}}
                  <form method="POST" action="{{ route('login.store') }}" class="space-y-5">

                    {{-- Campo de seguridad obligatorio de Laravel (anti-fraude) --}}
                    @csrf

                    {{-- Campo: Correo --}}
                    <div>
                        <label for="email" class="block text-sm font-medium text-connera-text mb-1">
                            Correo electrónico
                        </label>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-connera-blue focus:ring-2 focus:ring-connera-blue/30 outline-none transition"
                            placeholder="tucorreo@connerashop.com"
                        >
                    </div>

                    {{-- Campo: Contraseña --}}
                    <div>
                        <label for="password" class="block text-sm font-medium text-connera-text mb-1">
                            Contraseña
                        </label>
                        <input
                            id="password"
                            name="password"
                            type="password"
                            required
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-connera-blue focus:ring-2 focus:ring-connera-blue/30 outline-none transition"
                            placeholder="••••••••"
                        >
                    </div>

                    {{-- Casilla "Recordarme" --}}
                    <div class="flex items-center">
                        <input id="remember" name="remember" type="checkbox"
                               class="h-4 w-4 rounded border-gray-300 text-connera-blue focus:ring-connera-blue">
                        <label for="remember" class="ml-2 text-sm text-gray-600">Recordar mi sesión</label>
                    </div>

                    {{-- Botón amarillo corporativo para entrar --}}
                    <button type="submit"
                            class="w-full bg-connera-yellow text-connera-blue font-bold py-3 rounded-lg hover:brightness-95 transition">
                        Iniciar sesión
                    </button>

                </form>
            </div>
        </div>
    </div>

</x-app-layout>