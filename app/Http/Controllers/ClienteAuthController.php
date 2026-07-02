<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Cotizacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * Controlador de acceso para CLIENTES (sitio publico).
 * Maneja registro, login, logout y el panel del cliente.
 */
class ClienteAuthController extends Controller
{
    /* ===================== REGISTRO ===================== */

    // Mostrar el formulario de registro
    public function mostrarRegistro()
    {
        return view('public.auth.registro');
    }

    // Guardar el nuevo cliente
    public function registrar(Request $request)
    {
        // 1) Validar los datos que llegan del formulario
        $datos = $request->validate([
            'name'             => ['required', 'string', 'max:255'],
            'apellido'         => ['nullable', 'string', 'max:255'],
            'email'            => ['required', 'email', 'max:255', 'unique:users,email'],
            'telefono'         => ['nullable', 'string', 'max:30'],
            'empresa'          => ['nullable', 'string', 'max:255'],
            'ciudad'           => ['nullable', 'string', 'max:255'],
            'estado_direccion' => ['nullable', 'string', 'max:255'],
            'password'         => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'email.unique'       => 'Ese correo ya está registrado.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'password.min'       => 'La contraseña debe tener al menos 6 caracteres.',
        ]);

        // 2) Crear el usuario con rol de cliente
        $cliente = User::create([
            'name'             => $datos['name'],
            'apellido'         => $datos['apellido'] ?? null,
            'email'            => $datos['email'],
            'telefono'         => $datos['telefono'] ?? null,
            'empresa'          => $datos['empresa'] ?? null,
            'ciudad'           => $datos['ciudad'] ?? null,
            'estado_direccion' => $datos['estado_direccion'] ?? null,
            'password'         => Hash::make($datos['password']),
            'role'             => 'client',
            'estatus'          => 'activo',
        ]);

        // 3) Iniciar sesion automaticamente y llevarlo a su panel
        Auth::login($cliente);

        return redirect()->route('cliente.panel')
                         ->with('exito', '¡Bienvenido a Connera Shop! Tu cuenta fue creada.');
    }

    /* ===================== LOGIN ===================== */

    // Mostrar el formulario de login del cliente
    public function mostrarLogin()
    {
        return view('public.auth.login');
    }

    // Procesar el login del cliente
    public function login(Request $request)
    {
        $datos = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Intentar iniciar sesion SOLO si es un cliente
        if (Auth::attempt([...$datos, 'role' => 'client'], $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->route('cliente.panel');
        }

        // Si fallo, regresar con error
        return back()->withErrors([
            'email' => 'Correo o contraseña incorrectos.',
        ])->onlyInput('email');
    }

    /* ===================== LOGOUT ===================== */

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }

    /* ===================== PANEL DEL CLIENTE ===================== */

    public function panel()
    {
        // Traemos las cotizaciones del cliente logueado (las mas recientes primero)
        // Cargamos tambien sus items (productos) para mostrarlos
        $cotizaciones = Cotizacion::where('user_id', Auth::id())
                            ->with('items')
                            ->latest()
                            ->get();

        return view('public.cliente.panel', compact('cotizaciones'));
    }
}