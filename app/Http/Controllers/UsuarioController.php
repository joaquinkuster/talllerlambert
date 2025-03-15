<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;

class UsuarioController extends Controller
{
    /**
     * Método para modificar el perfil del usuario.
     *
     * @param Request $req La solicitud HTTP.
     * @return RedirectResponse|View
     */
    public function modificar(Request $req)      
    {
        // Si la solicitud es de tipo GET, retornar la vista de perfil.
        if ($req->isMethod('get')) {
            return view('perfil');
        }

        // Validar los datos enviados en el formulario de modificación.
        $datos = $this->validarUsuario($req);

        // Si no se proporciona una nueva contraseña, eliminar el campo 'password' del array de datos.
        if (empty($req->password)) {
            unset($datos['password']);
        }

        // Actualizar la información del usuario autenticado con los datos validados.
        Auth::user()->update($datos);

        // Redirigir al perfil con un mensaje de éxito.
        return redirect()->route('modificar.perfil')->with('msj', 'Se modificó el perfil exitosamente.');
    }

    /**
     * Método para validar los datos del usuario.
     *
     * @param Request $req La solicitud HTTP.
     * @return array Los datos validados.
     */
    private function validarUsuario(Request $req)
    {
        // Validar los datos del formulario utilizando reglas definidas.
        return $req->validate([
            'nombre' => 'required|max:50|regex:' . Helper::REGEX_TEXTO,  // Validar que el nombre no exceda los 50 caracteres y tenga un formato válido (solo letras y un espacio).
            'apellido' => 'required|max:50|regex:' . Helper::REGEX_TEXTO,  // Lo mismo para el apellido.
            'dni' => 'required|size:8|unique:users,dni,' . Auth::user()->id . '|regex:' . Helper::REGEX_DNI,  // Validar el DNI (debe tener 8 caracteres y ser único, excepto para el usuario actual).
            'telefono' => 'nullable|max:12|regex:' . Helper::REGEX_TELEFONO,  // El teléfono es opcional, pero si se proporciona, debe cumplir con el formato y tamaño.
            'correo' => 'required|email|max:150|unique:users,correo,' . Auth::user()->id,  // Validar el correo (debe ser único, excepto para el usuario actual).
            'password' => 'nullable|confirmed|min:6|max:8|regex:' . Helper::REGEX_PASSWORD,  // Validar la contraseña si se proporciona.
        ], [
            // Mensajes personalizados de error para cada campo.
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
        ]);
    }
}