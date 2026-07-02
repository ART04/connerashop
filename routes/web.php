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
   SITIO PÚBLICO (lo que ven los clientes, sin necesidad de login)
------------------------------------------------------------------------- */
use App\Http\Controllers\HomeController;

// Pagina de inicio publica
Route::get('/', [HomeController::class, 'index'])->name('home');
// Ficha publica de un producto (se identifica por su slug amigable)
Route::get('/producto/{slug}', [HomeController::class, 'producto'])->name('producto.show');
// Catalogo publico: todos los productos con filtros
Route::get('/catalogo', [HomeController::class, 'catalogo'])->name('catalogo');

/* -------------------------------------------------------------------------
   ACCESO DE CLIENTES (registro, login, panel)
------------------------------------------------------------------------- */
use App\Http\Controllers\ClienteAuthController;

// Registro
Route::get('/registro', [ClienteAuthController::class, 'mostrarRegistro'])->name('cliente.registro');
Route::post('/registro', [ClienteAuthController::class, 'registrar'])->name('cliente.registro.store');

// Login de cliente
Route::get('/cliente/login', [ClienteAuthController::class, 'mostrarLogin'])->name('cliente.login');
Route::post('/cliente/login', [ClienteAuthController::class, 'login'])->name('cliente.login.store');

// Logout de cliente
Route::post('/cliente/logout', [ClienteAuthController::class, 'logout'])->name('cliente.logout');

// Panel del cliente (protegido: requiere sesion)
Route::get('/cliente', [ClienteAuthController::class, 'panel'])
     ->middleware('auth')->name('cliente.panel');
/* -------------------------------------------------------------------------
   COTIZACIONES (lado cliente)
------------------------------------------------------------------------- */
use App\Http\Controllers\CotizacionController;

// Formulario para cotizar un producto
Route::get('/cotizar/{slug}', [CotizacionController::class, 'crear'])->name('cotizacion.crear');
Route::post('/cotizar/{slug}', [CotizacionController::class, 'guardar'])->name('cotizacion.guardar');

// Pagina de agradecimiento
Route::get('/cotizacion/gracias/{folio}', [CotizacionController::class, 'gracias'])->name('cotizacion.gracias');

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

/* -------------------------------------------------------------------------
   MODULO DE MARCAS (protegido)
------------------------------------------------------------------------- */
use App\Http\Controllers\Admin\MarcaController;

Route::resource('marcas', MarcaController::class)
     ->middleware('auth');

/* -------------------------------------------------------------------------
   MODULO DE COTIZACIONES - ADMIN (protegido)
------------------------------------------------------------------------- */
use App\Http\Controllers\Admin\CotizacionAdminController;

Route::middleware('auth')->group(function () {
    // Lista de cotizaciones recibidas
    Route::get('/admin/cotizaciones', [CotizacionAdminController::class, 'index'])
         ->name('admin.cotizaciones.index');

    // Ver detalle de una cotizacion
    Route::get('/admin/cotizaciones/{cotizacion}', [CotizacionAdminController::class, 'show'])
         ->name('admin.cotizaciones.show');

    // Cambiar el estado de una cotizacion
    Route::put('/admin/cotizaciones/{cotizacion}/estado', [CotizacionAdminController::class, 'actualizarEstado'])
         ->name('admin.cotizaciones.estado');

    // Borrar una cotizacion
    Route::delete('/admin/cotizaciones/{cotizacion}', [CotizacionAdminController::class, 'destroy'])
         ->name('admin.cotizaciones.destroy');
});