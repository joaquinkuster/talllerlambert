<?php

use App\Http\Controllers\UsuarioController;
use App\Http\Middleware\VerificarRolAdministrador;
use App\Http\Middleware\VerificarRolCliente;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AutenticacionController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\TurnoController;
use App\Http\Controllers\VehiculoController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\ResetPasswordController;

// Ruta para mostrar la lista de servicios (accesible desde la página principal)
Route::get('/', [ServicioController::class, 'index'])->name('servicios');

// Rutas accesibles solo para usuarios no autenticados (guest)
Route::middleware('guest')->group(function () {
    Route::controller(AutenticacionController::class)->group(function () {
        Route::get('registro', 'registrar')->name('registro');
        Route::post('registro', 'registrar')->name('registro');
        Route::get('login', 'acceder')->name('login');
        Route::post('login', 'acceder')->name('login');
    });
});

// Rutas accesibles solo para usuarios autenticados (auth)
Route::middleware('auth')->group(function () {
    // Ruta para cerrar sesión
    Route::get('logout', [AutenticacionController::class, 'logout'])->name('logout');

    // Rutas para modificar el perfil del usuario
    Route::controller(UsuarioController::class)->prefix('perfil')->group(function () {
        Route::get('', 'modificar')->name('modificar.perfil');
        Route::put('', 'modificar')->name('modificar.perfil');
    });

    // Rutas para manejar los turnos del usuario o usuarios
    Route::controller(TurnoController::class)->prefix('turnos')->group(function () {
        Route::get('', 'index')->name('turnos');
        Route::delete('cancelar/{id}', 'cancelar')->name('turnos.cancelar');
    });
});

// Rutas accesibles solo para usuarios autenticados y con rol de 'Cliente'
Route::middleware(['auth', VerificarRolCliente::class])->group(function () {
    // Rutas para gestionar los vehículos del cliente
    Route::controller(VehiculoController::class)->prefix('vehiculos')->group(function () {
        Route::get('', 'index')->name('vehiculos');
        Route::get('registrar', 'registrar')->name('vehiculos.registrar');
        Route::post('registrar', 'registrar')->name('vehiculos.registrar');
        Route::get('modificar/{id}', 'modificar')->name('vehiculos.modificar');
        Route::put('modificar/{id}', 'modificar')->name('vehiculos.modificar');
        Route::delete('eliminar/{id}', 'eliminar')->name('vehiculos.eliminar');
    });

    // Rutas para gestionar los turnos del cliente
    Route::controller(TurnoController::class)->prefix('turnos')->group(function () {
        Route::get('reservar', 'reservar')->name('turnos.reservar');
        Route::post('reservar', 'reservar')->name('turnos.reservar');
        Route::get('modificar/{id}', 'modificar')->name('turnos.modificar');
        Route::put('modificar/{id}', 'modificar')->name('turnos.modificar');
        Route::post('actualizarHorarios', 'actualizarHorarios')->name('turnos.actualizarHorarios');
    });
});

// Rutas accesibles solo para usuarios autenticados y con rol de 'Administrador' 
Route::middleware(['auth', VerificarRolAdministrador::class])->group(function () {
    // Rutas para gestionar los servicios (solo para administradores)
    Route::controller(ServicioController::class)->prefix('servicios')->group(function () {
        Route::get('registrar', 'registrar')->name('servicios.registrar');
        Route::post('registrar', 'registrar')->name('servicios.registrar');
        Route::get('modificar/{id}', 'modificar')->name('servicios.modificar');
        Route::put('modificar/{id}', 'modificar')->name('servicios.modificar');
        Route::delete('eliminar/{id}', 'eliminar')->name('servicios.eliminar');
    });

    // Ruta para finalizar un turno (solo para administradores)
    Route::put('finalizar/{id}', [TurnoController::class, 'finalizar'])->name('turnos.finalizar');
});

// Ruta GET para mostrar el formulario de solicitud de restablecimiento de correo en el perfil
Route::get('/perfil/solicitar-restablecer-correo', [UsuarioController::class, 'solicitarRestablecerCorreo'])
    ->name('perfil.solicitarRestablecerCorreo');

// Ruta POST para procesar la solicitud de restablecimiento de correo en el perfil
Route::post('/perfil/solicitar-restablecer-correo', [PerfilController::class, 'solicitarRestablecerCorreo'])
    ->name('perfil.solicitarRestablecerCorreo');

// Ruta GET para mostrar el formulario de restablecimiento de contraseña usando el token
Route::get('restablecer-contraseña/{token}', [ResetPasswordController::class, 'showResetForm'])
    ->name('password.reset');

// Ruta POST para actualizar la contraseña una vez validado el token
Route::post('restablecer-contraseña', [ResetPasswordController::class, 'reset'])
    ->name('password.update');

// Ruta GET para mostrar los servicios en la página de servicios
Route::get('/servicios', [ServicioController::class, 'index'])
    ->name('servicios.index');



