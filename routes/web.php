<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleController;



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
    Route::get('/inicio', function () {
        return view('inicio');
        })->name('inicio');
});
require __DIR__.'/auth.php';
