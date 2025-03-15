<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Hash; 
use App\Models\User; 
use Illuminate\Support\Facades\Auth; 
use Illuminate\Validation\ValidationException; 
use App\Helpers\Helper; 
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;

class AutenticacionController extends Controller
{

    /**
     * Método para registrar un nuevo usuario.
     *
     * @param Request $req La solicitud HTTP que contiene los datos del usuario.
     * @return RedirectResponse|View
     */
    public function registrar(Request $req)
    {
        // Si la solicitud es GET, mostrar la vista de registro
        if ($req->isMethod('get')) {
            return view('autenticacion/registro');
        }

        // Validar los datos del formulario de registro utilizando la función validarUsuario()
        $datos = $this->validarUsuario($req);

        // Encriptar la contraseña antes de guardar
        $datos['password'] = Hash::make($req->password);

        // Crear un nuevo usuario con los datos validados
        User::create($datos);

        // Redirigir a la página de login con un mensaje de éxito
        return redirect()->route('login')->with('msj', 'Se creó la cuenta exitosamente.');
    }

    /**
     * Método para autenticar al usuario en el sistema.
     *
     * @param Request $req La solicitud HTTP que contiene el DNI y la contraseña del usuario.
     * @return RedirectResponse|View
     */
    public function acceder(Request $req)
    {
        // Si la solicitud es GET, mostrar la vista de login
        if ($req->isMethod('get')) {
            return view('autenticacion/login');
        }

        // Validar los datos de la solicitud (DNI y contraseña)
        $req->validate([
            'dni' => 'required|regex:' . Helper::REGEX_DNI, // Validación para el DNI
            'password' => 'required', // La contraseña es obligatoria
        ], [
            'dni.required' => 'El DNI es obligatorio.',
            'dni.regex' => 'El DNI debe tener 8 dígitos o empezar con M/F seguido de 7 dígitos.',
            'password.required' => 'La contraseña es obligatoria.',
        ]);

        // Intentar autenticar al usuario con los datos proporcionados (DNI y contraseña)
        if (!Auth::attempt($req->only('dni', 'password'), $req->boolean('recordar'))) {
            // Si la autenticación falla, lanzar una excepción de validación
            throw ValidationException::withMessages([
                'login' => trans('auth.failed') // Mensaje de error si la autenticación falla
            ]);
        }

        // Regenerar la sesión para mayor seguridad
        $req->session()->regenerate();

        // Redirigir al usuario al index de servicios con un mensaje de éxito
        return redirect()->route('servicios')->with('msj', 'Se inició sesión exitosamente.');
    }

    /**
     * Método para cerrar la sesión del usuario.
     *
     * @param Request $request La solicitud HTTP para cerrar sesión.
     * @return RedirectResponse
     */
    public function logout(Request $request)
    {
        // Cerrar la sesión del usuario autenticado utilizando el guard web
        Auth::guard('web')->logout();

        // Invalidar la sesión actual para mayor seguridad
        $request->session()->invalidate();

        // Redirigir al usuario a la página de login con un mensaje de éxito
        return redirect()->route('login')->with('msj', 'Se cerró la sesión exitosamente.');
    }

    /**
     * Método para validar los datos del formulario de registro de un nuevo usuario.
     *
     * @param Request $req La solicitud HTTP que contiene los datos del formulario.
     * @return array Los datos validados del usuario.
     */
    private function validarUsuario(Request $req)
    {
        // Validar los datos del formulario utilizando reglas definidas
        return $req->validate([
            'nombre' => 'required|max:50|regex:' . Helper::REGEX_TEXTO, // Nombre: obligatorio, máximo 50 caracteres, solo texto
            'apellido' => 'required|max:50|regex:' . Helper::REGEX_TEXTO, // Apellido: obligatorio, máximo 50 caracteres, solo texto
            'dni' => 'required|size:8|unique:users,dni|regex:' . Helper::REGEX_DNI, // DNI: obligatorio, tamaño 8, único, regex personalizado
            'telefono' => 'nullable|max:12|regex:' . Helper::REGEX_TELEFONO, // Teléfono: opcional, máximo 12 caracteres, regex personalizado
            'correo' => 'required|email|max:150|unique:users,correo', // Correo: obligatorio, formato email, único
            'password' => ['required', 'confirmed', 'min:6', 'max:8', 'regex:' . Helper::REGEX_PASSWORD], // Contraseña: obligatoria, confirmada, entre 6 y 8 caracteres, regex personalizado
            'terminos' => 'accepted', // Términos: debe ser aceptado
        ], [
            // Mensajes personalizados de validación para cada campo
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
    }
}
