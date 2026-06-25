{{-- REGISTRO DE CLIENTE --}}
<x-public-layout>

    <div class="max-w-2xl mx-auto px-4 py-12">

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8">

            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-connera-text">Crear cuenta</h1>
                <p class="text-gray-500 mt-2">Regístrate para cotizar y dar seguimiento a tus pedidos.</p>
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

            <form method="POST" action="{{ route('cliente.registro.store') }}" class="space-y-5">
                @csrf

                {{-- Nombre y Apellido --}}
                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-connera-text mb-1">Nombre *</label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                               class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-connera-blue focus:ring-2 focus:ring-connera-blue/30 outline-none transition">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-connera-text mb-1">Apellido</label>
                        <input type="text" name="apellido" value="{{ old('apellido') }}"
                               class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-connera-blue focus:ring-2 focus:ring-connera-blue/30 outline-none transition">
                    </div>
                </div>

                {{-- Correo y Telefono --}}
                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-connera-text mb-1">Correo electrónico *</label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                               class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-connera-blue focus:ring-2 focus:ring-connera-blue/30 outline-none transition">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-connera-text mb-1">Teléfono</label>
                        <input type="text" name="telefono" value="{{ old('telefono') }}"
                               class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-connera-blue focus:ring-2 focus:ring-connera-blue/30 outline-none transition">
                    </div>
                </div>

                {{-- Empresa --}}
                <div>
                    <label class="block text-sm font-medium text-connera-text mb-1">Empresa</label>
                    <input type="text" name="empresa" value="{{ old('empresa') }}"
                           class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-connera-blue focus:ring-2 focus:ring-connera-blue/30 outline-none transition">
                </div>

                {{-- Ciudad y Estado --}}
                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-connera-text mb-1">Ciudad</label>
                        <input type="text" name="ciudad" value="{{ old('ciudad') }}"
                               class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-connera-blue focus:ring-2 focus:ring-connera-blue/30 outline-none transition">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-connera-text mb-1">Estado</label>
                        <input type="text" name="estado_direccion" value="{{ old('estado_direccion') }}"
                               class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-connera-blue focus:ring-2 focus:ring-connera-blue/30 outline-none transition">
                    </div>
                </div>

                {{-- Contrasena y Confirmar --}}
                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-connera-text mb-1">Contraseña *</label>
                        <input type="password" name="password" required
                               class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-connera-blue focus:ring-2 focus:ring-connera-blue/30 outline-none transition">
                        <span class="text-xs text-gray-400">Mínimo 6 caracteres.</span>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-connera-text mb-1">Confirmar contraseña *</label>
                        <input type="password" name="password_confirmation" required
                               class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-connera-blue focus:ring-2 focus:ring-connera-blue/30 outline-none transition">
                    </div>
                </div>

                <button type="submit"
                        class="w-full bg-connera-yellow text-connera-blue font-bold py-3 rounded-lg hover:brightness-95 transition">
                    Crear mi cuenta
                </button>
            </form>

            <p class="text-center text-sm text-gray-500 mt-6">
                ¿Ya tienes cuenta?
                <a href="{{ route('cliente.login') }}" class="text-connera-blue font-medium hover:underline">Inicia sesión</a>
            </p>
        </div>
    </div>

</x-public-layout>