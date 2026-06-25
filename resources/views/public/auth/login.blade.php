{{-- LOGIN DE CLIENTE --}}
<x-public-layout>

    <div class="max-w-md mx-auto px-4 py-16">

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8">

            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-connera-text">Iniciar sesión</h1>
                <p class="text-gray-500 mt-2">Accede a tu cuenta de Connera Shop.</p>
            </div>

            @if ($errors->any())
                <div class="mb-6 rounded-lg bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700">
                    Correo o contraseña incorrectos. Inténtalo de nuevo.
                </div>
            @endif

            <form method="POST" action="{{ route('cliente.login.store') }}" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-connera-text mb-1">Correo electrónico</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                           class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-connera-blue focus:ring-2 focus:ring-connera-blue/30 outline-none transition">
                </div>

                <div>
                    <label class="block text-sm font-medium text-connera-text mb-1">Contraseña</label>
                    <input type="password" name="password" required
                           class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-connera-blue focus:ring-2 focus:ring-connera-blue/30 outline-none transition">
                </div>

                <div class="flex items-center">
                    <input id="remember" name="remember" type="checkbox"
                           class="h-4 w-4 rounded border-gray-300 text-connera-blue focus:ring-connera-blue">
                    <label for="remember" class="ml-2 text-sm text-gray-600">Recordar mi sesión</label>
                </div>

                <button type="submit"
                        class="w-full bg-connera-yellow text-connera-blue font-bold py-3 rounded-lg hover:brightness-95 transition">
                    Entrar
                </button>
            </form>

            <p class="text-center text-sm text-gray-500 mt-6">
                ¿No tienes cuenta?
                <a href="{{ route('cliente.registro') }}" class="text-connera-blue font-medium hover:underline">Regístrate</a>
            </p>
        </div>
    </div>

</x-public-layout>