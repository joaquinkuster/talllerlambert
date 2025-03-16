<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\ResetPasswordToken;
use App\Models\User;
use Carbon\Carbon;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    public function enviarCorreo(Request $req)
    {
        $req->validate([
            'correo' => 'required|correo|exists:users,correo',
        ], [
            'correo.exists' => 'No encontramos un usuario con este correo.',
        ]);

        $user = User::where('correo', $req->correo)->first();
        $token = Str::random(60);
        $expires_at = Carbon::now()->addMinutes(30); // Token válido por 30 minutos

        // Crear o actualizar el token en la base de datos con el user_id
        ResetPasswordToken::updateOrCreate(
            ['user_id' => $user->id],
            ['token' => $token, 'expires_at' => $expires_at]
        );

        // Enviar el correo con el token
        Mail::to($user->correo)->send(new ResetPasswordMail($token));

        return back()->with('msj', 'Se ha enviado un correo con instrucciones para restablecer tu contraseña.');
    }

    public function reset(Request $request)
    {
        // Validar las contraseñas y el token
        $request->validate([
            'token' => 'required',
            'password' => 'required|confirmed|min:8',
        ]);

        // Buscar el token en la base de datos y verificar que no haya expirado
        $resetToken = ResetPasswordToken::where('token', $request->token)
            ->where('expires_at', '>', now())
            ->firstOrFail(); // Lanza un error 404 si no se encuentra el token o ha expirado

        // Buscar al usuario asociado al token
        $user = User::findOrFail($resetToken->user_id);

        // Actualizar la contraseña
        $user->password = Hash::make($request->password);
        $user->save();

        // Eliminar el token (ya no es necesario)
        $resetToken->delete();

        return redirect()->route('servicios.index')->with('status', 'Contraseña actualizada exitosamente.');
    }

    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.restablecer-contraseña')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }
}
