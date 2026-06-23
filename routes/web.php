<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| RUTAS WEB DE CONNERA SHOP
|--------------------------------------------------------------------------
| Aquí se definen las direcciones (URLs) de la plataforma y qué hace
| cada una. Por ahora: la página de inicio, el login y el panel del admin.
*/

/* -------------------------------------------------------------------------
   PÁGINA DE INICIO
   Por ahora redirige al login. Más adelante será el catálogo público.
------------------------------------------------------------------------- */
Route::get('/', function () {
    return redirect()->route('login');
});

/* -------------------------------------------------------------------------
   MOSTRAR EL FORMULARIO DE LOGIN
   Dirección:  /login   (cuando se visita, muestra la pantalla de acceso)
   El nombre 'login' es el que usa el formulario en action="{{ route('login') }}".
------------------------------------------------------------------------- */
Route::get('/login', function () {
    return view('auth.login'); // muestra resources/views/auth/login.blade.php
})->name('login');

/* -------------------------------------------------------------------------
   PROCESAR EL LOGIN (cuando se da clic en "Iniciar sesión")
   Verifica el correo y la contraseña contra la base de datos.
------------------------------------------------------------------------- */
Route::post('/login', function (Request $request) {

    // 1) Validar que vengan los campos obligatorios
    $datos = $request->validate([
        'email'    => ['required', 'email'],
        'password' => ['required'],
    ]);

    // 2) Intentar iniciar sesión. Auth::attempt compara la contraseña
    //    de forma segura (encriptada) automáticamente.
    //    El segundo parámetro respeta la casilla "Recordar mi sesión".
    if (Auth::attempt($datos, $request->boolean('remember'))) {

        // 3) Regenerar la sesión por seguridad (evita robo de sesión)
        $request->session()->regenerate();

        // 4) Entró bien -> mandarlo al panel de administración
        return redirect()->route('dashboard');
    }

    // 5) Si falló, regresar al login mostrando el error
    return back()->withErrors([
        'email' => 'Las credenciales no coinciden.',
    ])->onlyInput('email');

})->name('login.store');

/* -------------------------------------------------------------------------
   CERRAR SESIÓN
------------------------------------------------------------------------- */
Route::post('/logout', function (Request $request) {
    Auth::logout();                          // cierra la sesión del usuario
    $request->session()->invalidate();       // borra los datos de sesión
    $request->session()->regenerateToken();  // renueva el token de seguridad
    return redirect()->route('login');       // de vuelta al login
})->name('logout');

/* -------------------------------------------------------------------------
   PANEL DE ADMINISTRACIÓN (protegido)
   El middleware 'auth' impide entrar aquí si NO has iniciado sesión.
   Si un visitante sin sesión intenta entrar, Laravel lo manda al login.
------------------------------------------------------------------------- */
Route::get('/dashboard', function () {
    return view('admin.dashboard'); // lo creamos en el siguiente paso
})->middleware('auth')->name('dashboard');

/* -------------------------------------------------------------------------
   MÓDULO DE CATEGORÍAS (protegido: solo con sesión iniciada)
   Esta sola línea crea TODAS las direcciones del módulo:
   listar, crear, guardar, editar, actualizar y borrar.
------------------------------------------------------------------------- */
use App\Http\Controllers\Admin\CategoriaController;

Route::resource('categorias', CategoriaController::class)
     ->middleware('auth');
     /* -------------------------------------------------------------------------
       MODULO DE PRODUCTOS (protegido)
------------------------------------------------------------------------- */
use App\Http\Controllers\Admin\ProductoController;

Route::resource('productos', ProductoController::class)
     ->middleware('auth');