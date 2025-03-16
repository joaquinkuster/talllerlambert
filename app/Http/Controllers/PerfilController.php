<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ResetPasswordToken;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordMail;

class PerfilController extends Controller
{
    public function solicitarRestablecerCorreo(Request $request)
    {
        // Validar el correo
        $request->validate([
            'correo' => 'required|email|exists:users,correo',
        ]);

        // Buscar al usuario por su correo
        $user = User::where('correo', $request->correo)->first();

        // Verificar si el usuario existe
        if (!$user) {
            return back()->withErrors(['correo' => 'El correo no está registrado en nuestro sistema.']);
        }

        // Generar un token único
        $token = Str::random(60);

        // Guardar el token en la base de datos
        ResetPasswordToken::create([
            'user_id' => $user->id,
            'token' => $token,
            'expires_at' => now()->addMinutes(60), // El token expirará en 60 minutos
        ]);

        // Enviar el correo con el token
        try {
            Mail::to($user->correo)->send(new ResetPasswordMail($token));
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Hubo un problema al enviar el correo: ' . $e->getMessage()]);
        }

        return back()->with('msj', 'Te hemos enviado un enlace para restablecer tu contraseña.');
    }
    public function mostrarFormulario($token)
    {
        // Buscar el token de restablecimiento en la base de datos
        $resetToken = ResetPasswordToken::where('token', $token)->first();

        // Verificar si el token existe y no ha expirado
        if (!$resetToken || $resetToken->expires_at < now()) {
            return redirect()->route('login')->withErrors('El enlace de restablecimiento ha expirado o es inválido.');
        }

        return view('auth.restablecer-contraseña', compact('token'));
    }

    public function restablecerContraseña(Request $request, $token)
    {
        // Validar la nueva contraseña
        $request->validate([
            'password' => 'required|confirmed|min:8', // Asegúrate de que las contraseñas coincidan y tengan al menos 8 caracteres
        ]);

        // Buscar el token de restablecimiento en la base de datos
        $resetToken = ResetPasswordToken::where('token', $token)->first();

        // Verificar si el token existe y no ha expirado
        if (!$resetToken || $resetToken->expires_at < now()) {
            return redirect()->route('login')->withErrors('El enlace de restablecimiento ha expirado o es inválido.');
        }

        // Buscar el usuario asociado con el token
        $user = User::find($resetToken->user_id);

        // Actualizar la contraseña del usuario
        $user->password = bcrypt($request->password);
        $user->save();

        // Eliminar el token de la base de datos
        $resetToken->delete();

        return redirect()->route('login')->with('msj', 'Tu contraseña ha sido restablecida exitosamente.');
    }
    
}
