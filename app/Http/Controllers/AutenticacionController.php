<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Helpers\Helper;

class AutenticacionController extends Controller
{
    public function registro()
    {
        return view('autenticacion/registro');
    }

    public function registrar(Request $req)
    {
        // Validar los datos
        $req->validate([
            'nombre' => 'required|max:50|regex:' . Helper::REGEX_TEXTO,
            'apellido' => 'required|max:50|regex:' . Helper::REGEX_TEXTO,
            'dni' => 'required|size:8|unique:users,dni|regex:' . Helper::REGEX_DNI,
            'telefono' => 'nullable|max:12|regex:' . Helper::REGEX_TELEFONO,
            'correo' => 'required|email|max:150|unique:users,correo',
            'password' => 'required|confirmed|min:6|max:8|regex:' . Helper::REGEX_PASSWORD,
            'terminos' => 'accepted',
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.max' => 'El nombre no puede superar los 50 caracteres.',
            'nombre.regex' => 'El nombre solo puede contener letras y un solo espacio entre palabras.',

            'apellido.required' => 'El apellido es obligatorio.',
            'apellido.max' => 'El apellido no puede superar los 50 caracteres.',
            'apellido.regex' => 'El apellido solo puede contener letras y un solo espacio entre palabras.',

            'dni.required' => 'El DNI es obligatorio.',
            'dni.size' => 'El DNI debe tener exactamente 8 caracteres.',
            'dni.unique' => 'El DNI ya está registrado.',
            'dni.regex' => 'El DNI debe tener 8 dígitos o empezar con M/F seguido de 7 dígitos.',

            'telefono.max' => 'El teléfono no puede superar los 12 caracteres.',
            'telefono.regex' => 'El teléfono debe tener entre 8 y 12 dígitos.',

            'correo.required' => 'El correo es obligatorio.',
            'correo.email' => 'El correo debe tener un formato válido.',
            'correo.max' => 'El correo no puede superar los 150 caracteres.',
            'correo.unique' => 'El correo ya está registrado.',

            'password.required' => 'La contraseña es obligatoria.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres.',
            'password.max' => 'La contraseña no puede superar los 8 caracteres.',
            'password.regex' => 'La contraseña debe incluir al menos 5 números y 1 letra.',

            'terminos.accepted' => 'Debes aceptar los términos y condiciones.'
        ]);

        // Crear el usuario con los datos validados
        User::create([
            'nombre' => $req->nombre,
            'apellido' => $req->apellido,
            'dni' => $req->dni,
            'telefono' => $req->telefono,
            'correo' => $req->correo,
            'password' => Hash::make($req->password),
        ]);

        // Redirigir al login con un mensaje de éxito
        return redirect()->route('login')->with('msj', 'Se creó la cuenta exitosamente.');
    }

    public function login()
    {
        return view('autenticacion/login');
    }

    public function acceder(Request $req)
    {
        // Validar los datos
        $req->validate([
            'dni' => 'required|regex:' . Helper::REGEX_DNI,
            'password' => 'required',
        ], [
            'dni.required' => 'El DNI es obligatorio.',
            'dni.regex' => 'El DNI debe tener 8 dígitos o empezar con M/F seguido de 7 dígitos.',
            'password.required' => 'La contraseña es obligatoria.',
        ]);

        // Intentar autenticar
        if (!Auth::attempt($req->only('dni', 'password'), $req->boolean('recordar'))) {
            throw ValidationException::withMessages([
                'login' => trans('auth.failed')
            ]);
        }

        // Regenerar la sesión para mayor seguridad
        $req->session()->regenerate();

        // Redirigir al index de servicios
        return redirect()->route('servicios')->with('msj', 'Se inició sesión exitosamente.');
    }

    public function logout(Request $request)
    {
        // Cerrar la sesión del usuario autenticado
        // Especificar el guard que maneja la autenticación y almacena la información del usuario, 
        // ya sea mediante sesiones (web) o tokens (API).
        Auth::guard('web')->logout();
  
        // Invalida la sesión actual para seguridad
        $request->session()->invalidate();
  
        // Redirigir al index de servicios
        return redirect()->route('login')->with('msj', 'Se cerró la sesión exitosamente.');
    }
}
