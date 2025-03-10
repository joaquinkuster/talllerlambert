<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AutenticacionController extends Controller
{
    public function registro(){
        return view('autenticacion/registro');
    }
    public function registrarCuenta(Request $req)
    {
        // Validar los datos
        $req->validate([
            'nombre' => 'required|string|max:50|regex:/^[a-zA-ZÁáÉéÍíÓóÚúÜü]+( [a-zA-ZÁáÉéÍíÓóÚúÜü]+)*$/',
            'apellido' => 'required|string|max:50|regex:/^[a-zA-ZÁáÉéÍíÓóÚúÜü]+( [a-zA-ZÁáÉéÍíÓóÚúÜü]+)*$/',
            'dni' => 'required|string|size:8|unique:users,dni|regex:/^(?:[M|F]\d{1,7}|\d{1,8})$/',
            'telefono' => 'nullable|string|max:15|regex:/^\d{2,4}\d{4,6}$/',
            'correo' => 'required|email|max:150|unique:users,correo',
            'password' => 'required|confirmed|min:8',
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'apellido.required' => 'El apellido es obligatorio.',
            'nombre.regex' => 'El nombre es inválido.',
            'dni.required' => 'El DNI es obligatorio.',
            'dni.size' => 'El DNI debe tener 8 caracteres.',
            'dni.unique' => 'El DNI ya está registrado.',
            'correo.required' => 'El correo es obligatorio.',
            'correo.unique' => 'El correo ya está registrado.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
        ]);
    
        // Crear el usuario
        User::create([
            'nombre' => $req->nombre,
            'apellido' => $req->apellido,
            'dni' => $req->dni,
            'telefono' => $req->telefono,
            'correo' => $req->correo,
            'password' => Hash::make($req->password),
        ]);
    
        // Redirigir al login con un mensaje de éxito
        //return redirect()->route('login')->with('success', 'Cuenta creada exitosamente.');
    }
}
