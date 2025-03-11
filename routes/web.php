<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AutenticacionController;
use App\Http\Controllers\VehiculoController;

// Rutas relacionadas con AutenticacionController
Route::controller(AutenticacionController::class)->group(function () {
    Route::get('registro', 'registro')->name('registro');
    Route::post('registro', 'registrarCuenta')->name('registro.registrar');
});

Route::get('/vehiculo/registrar', [VehiculoController::class, 'registrarvehiculo'])->name('vehiculo.altavehiculo');
Route::post('/vehiculo/registrar', [VehiculoController::class, 'registrarvehiculo'])->name('vehiculo.altavehiculo');

Route::get('/vehiculo/mis-vehiculos', [VehiculoController::class, 'consultarvehiculo'])->name('vehiculo.consultarvehiculo');
Route::post('/vehiculo/mis-vehiculos', [VehiculoController::class, 'consultarvehiculo'])->name('vehiculo.consultarvehiculo');
