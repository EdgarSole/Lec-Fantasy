<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\LigaController;



Route::get('/', function () {
    return view('index');
})->name('index');


Route::get('/login/google', [GoogleController::class, 'redirectToGoogle'])
    ->name('login.google');
Route::get('/login/google/callback', [GoogleController::class, 'handleGoogleCallback']);



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




require __DIR__.'/auth.php';
