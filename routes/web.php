<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\LigaController;
use App\Http\Controllers\MiLigaController;
use App\Http\Controllers\JugadorController;
use App\Http\Controllers\TopGlobalController;
use App\Http\Controllers\LocaleController;
use Illuminate\Http\Request;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminUserController;


Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('inicio');
    }
    return view('index');
})->name('index');


Route::prefix('admin')->group(function () {
    Route::get('/', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
});

// Rutas de administración de ligas y usuarios en ligas
Route::prefix('admin')->name('admin.')->middleware('auth:admin')->group(function () {
    Route::post('/ligas/{liga}/usuarios', [AdminDashboardController::class, 'addUserToLiga'])->name('ligas.usuarios.add');
    Route::delete('/ligas/{liga}/usuarios/{equipo}', [AdminDashboardController::class, 'removeUserFromLiga'])->name('ligas.usuarios.remove');
    Route::post('/ligas/{liga}/usuarios/agregar', [AdminDashboardController::class, 'agregarUsuarioALiga'])->name('ligas.usuarios.agregar');
    Route::post('/ligas/{liga}/usuarios/quitar', [AdminDashboardController::class, 'quitarUsuarioDeLiga'])->name('ligas.usuarios.quitar');
});

Route::middleware('auth:admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Ligas
    Route::get('/ligas/crear', [AdminDashboardController::class, 'createLiga'])->name('ligas.create');
    Route::post('/ligas', [AdminDashboardController::class, 'storeLiga'])->name('ligas.store');
    Route::get('/ligas/{liga}', [AdminDashboardController::class, 'showLiga'])->name('ligas.show');
    Route::get('/ligas/{liga}/editar', [AdminDashboardController::class, 'editLiga'])->name('ligas.edit');
    Route::put('/ligas/{liga}', [AdminDashboardController::class, 'updateLiga'])->name('ligas.update');
    Route::delete('/ligas/{liga}', [AdminDashboardController::class, 'destroyLiga'])->name('ligas.destroy');

    // Usuarios
    Route::get('/usuarios', [AdminUserController::class, 'index'])->name('usuarios.index');
    Route::get('/usuarios/crear', [AdminUserController::class, 'create'])->name('usuarios.create');
    Route::post('/usuarios', [AdminUserController::class, 'store'])->name('usuarios.store');
});


Route::get('/login/google', [GoogleController::class, 'redirectToGoogle'])
    ->name('login.google');
Route::get('/login/google/callback', [GoogleController::class, 'handleGoogleCallback']);

Route::view('/privacy', 'privacy-policy')->name('privacy');
Route::view('/terms', 'terms-conditions')->name('terms');
Route::view('/cookies', 'cookies-policy')->name('cookies');

Route::get('/contacto', [ContactController::class, 'showForm'])->name('contact');
Route::post('/contacto', [ContactController::class, 'submit'])->name('contact.submit');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    // Ruta de inicio, que muestra las ligas
    Route::get('/inicio', [LigaController::class, 'index'])->name('inicio');
    
    // Ruta para almacenar una liga (la que maneja el formulario POST)
    Route::post('/ligas', [LigaController::class, 'store'])->name('ligas.store');

    Route::delete('/ligas/{liga}/salir', [LigaController::class, 'salir'])
        ->name('ligas.salir');

    Route::post('/ligas/unirse', [LigaController::class, 'unirse']);
    Route::get('/ligas/buscar', [LigaController::class, 'buscarLigas'])->name('ligas.buscar');

});

Route::prefix('liga/{liga}')->middleware(['auth'])->group(function() {
    // Rutas de visualización
    Route::get('mi-liga', [MiLigaController::class, 'index'])->name('mi-liga');
    Route::get('actividad', [MiLigaController::class, 'actividad'])->name('actividad');
    Route::get('mi-equipo', [MiLigaController::class, 'miEquipo'])->name('mi-equipo');
    Route::get('mercado', [MiLigaController::class, 'mercado'])->name('mercado');
    Route::get('clasificacion', [MiLigaController::class, 'clasificacion'])->name('clasificacion');
    
    Route::get('editar', [MiLigaController::class, 'editar'])->name('editar-liga');
    Route::get('chat', [MiLigaController::class, 'mostrarChat'])->name('chat');
    Route::get('chat/participantes', [MiLigaController::class, 'participantes'])->name('chat.participantes');

    // Rutas de equipo (jugadores)
    Route::prefix('equipo/{equipo}')->group(function() {
        Route::post('jugador/{jugador}/asignar', [MiLigaController::class, 'asignarJugador'])
            ->name('equipo.asignar-jugador');
        Route::post('jugador/{jugador}/vender', [MiLigaController::class, 'venderJugador'])
            ->name('equipo.vender-jugador');
        Route::get('jugador/{jugador}/puntos', [MiLigaController::class, 'obtenerPuntosJugador'])
            ->name('equipo.obtener-puntos');
    });

    // Rutas de mercado
    Route::prefix('mercado')->group(function() {
        Route::post('pujar', [MiLigaController::class, 'pujar'])->name('mercado.pujar');
        Route::post('procesar', [MiLigaController::class, 'procesarPujas'])->name('mercado.procesar');
        Route::delete('eliminar-puja', [MiLigaController::class, 'eliminarPuja'])->name('mercado.eliminar-puja');
    });

    // Rutas de chat
    Route::prefix('chat')->group(function() {
        Route::post('enviar', [MiLigaController::class, 'enviarChat'])->name('chat.enviar');
        Route::delete('borrar', [MiLigaController::class, 'borrarChat'])->name('chat.borrar');
    });

    // Rutas de gestión de liga
    Route::put('', [MiLigaController::class, 'actualizarLiga'])->name('actualizar-liga');    
    Route::delete('', [MiLigaController::class, 'destroy'])->name('eliminar-liga');
});


Route::get('/jugadores', [JugadorController::class, 'index'])->name('jugadores');
Route::get('/top-global', [TopGlobalController::class, 'index'])->name('top-global');

// Ruta para cambiar el idioma
Route::get('locale/{lang}', [LocaleController::class, 'setLocale'])->name('locale');





require __DIR__.'/auth.php';
