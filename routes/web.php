<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AutenticacionController;

Route::get('/', function () {
    return view('welcome');
});

Route::controller(AutenticacionController::class)->group(function () {
    Route::get('registro', 'registro')->name('registro');
    Route::post('registro', 'registrarCuenta')->name('registro.registrar');
});
