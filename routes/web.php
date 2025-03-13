<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AutenticacionController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\TurnoController;
use App\Http\Controllers\VehiculoController;

Route::get('/', [ServicioController::class, 'index'])->name('servicios');

// Rutas relacionadas con AutenticacionController
Route::middleware('guest')->group(function () {
    Route::controller(AutenticacionController::class)->group(function () {
        Route::get('registro', 'registro')->name('registro');
        Route::post('registro', 'registrar')->name('registro.registrar');
        Route::get('login', 'login')->name('login');
        Route::post('login', 'acceder')->name('login.acceder');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('logout', [AutenticacionController::class, 'logout'])->name('logout');

    Route::controller(ServicioController::class)->prefix('servicios')->group(function () {
        Route::get('registrar', 'registrar')->name('servicios.registrar');
        Route::post('registrar', 'registrar')->name('servicios.registrar');
        Route::get('modificar/{id}', 'modificar')->name('servicios.modificar');
        Route::put('modificar/{id}', 'modificar')->name('servicios.modificar');
        Route::delete('eliminar/{id}', 'eliminar')->name('servicios.eliminar');
    });

    Route::controller(VehiculoController::class)->prefix('vehiculos')->group(function () {
        Route::get('', 'index')->name('vehiculos');
        Route::get('registrar', 'registrar')->name('vehiculos.registrar');
        Route::post('registrar', 'registrar')->name('vehiculos.registrar');
        Route::get('modificar/{id}', 'modificar')->name('vehiculos.modificar');
        Route::put('modificar/{id}', 'modificar')->name('vehiculos.modificar');
        Route::delete('eliminar/{id}', 'eliminar')->name('vehiculos.eliminar');
    });
});

Route::get('/turno/registrar', [TurnoController::class, 'registrarturno'])->name('turno.altaturno');
Route::post('/turno/registrar', [TurnoController::class, 'registrarturno'])->name('turno.altaturno');

Route::get('/turno/mis-turnos', [TurnoController::class, 'consultarturno'])->name('turno.altaturno');
Route::post('/turno/mis-turnos', [TurnoController::class, 'consultarturno'])->name('turno.altaturno');
