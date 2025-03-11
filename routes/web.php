<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AutenticacionController;
use App\Http\Controllers\VehiculoController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\TurnoController;

// Rutas relacionadas con AutenticacionController
Route::controller(AutenticacionController::class)->group(function () {
    Route::get('registro', 'registro')->name('registro');
    Route::post('registro', 'registrarCuenta')->name('registro.registrar');
});

Route::get('/vehiculo/registrar', [VehiculoController::class, 'registrarvehiculo'])->name('vehiculo.altavehiculo');
Route::post('/vehiculo/registrar', [VehiculoController::class, 'registrarvehiculo'])->name('vehiculo.altavehiculo');

Route::get('/vehiculo/mis-vehiculos', [VehiculoController::class, 'consultarvehiculo'])->name('vehiculo.consultarvehiculo');
Route::post('/vehiculo/mis-vehiculos', [VehiculoController::class, 'consultarvehiculo'])->name('vehiculo.consultarvehiculo');

Route::get('/servicio/registrar', [ServicioController::class, 'registrarservicio'])->name('servicio.altaservicio');
Route::post('/servicio/registrar', [ServicioController::class, 'registrarservicio'])->name('servicio.altaservicio');

Route::get('/servicio/mis-servicios', [ServicioController::class, 'consultarservicio'])->name('servicio.consultarservicio');
Route::post('/servicio/mis-servicios', [ServicioController::class, 'consultarservicio'])->name('servicio.consultarservicio');

Route::get('/turno/registrar', [TurnoController::class, 'registrarturno'])->name('turno.altaturno');
Route::post('/turno/registrar', [TurnoController::class, 'registrarturno'])->name('turno.altaturno');

Route::get('/turno/mis-turnos', [TurnoController::class, 'consultarturno'])->name('turno.altaturno');
Route::post('/turno/mis-turnos', [TurnoController::class, 'consultarturno'])->name('turno.altaturno');