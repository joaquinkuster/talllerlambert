<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;

class VehiculoController extends Controller
{
    /**
     * Muestra todos los vehículos del usuario autenticado.
     *
     * @return View
     */
    public function index()
    {
        // Obtiene todos los vehículos asociados al usuario autenticado
        $vehiculos = Auth::user()->vehiculos;

        // Retorna la vista 'vehiculos.index' con la lista de vehículos
        return view('vehiculos.index', compact('vehiculos'));
    }

    /**
     * Registra un nuevo vehículo para el usuario autenticado.
     *
     * @param Request $req La solicitud HTTP.
     * @return RedirectResponse|View
     */
    public function registrar(Request $req)
    {
        // Si la solicitud es GET, retornar la vista de registro
        if ($req->isMethod('get')) {
            return view('vehiculos.registrar');
        }

        // Validar los datos del vehículo utilizando el método privado
        $datos = $this->validarVehiculo($req);

        // Crear un nuevo vehículo asociado al usuario autenticado
        Auth::user()->vehiculos()->create($datos);

        // Redirige al índice de vehículos con un mensaje de éxito
        return redirect()->route('vehiculos')->with('msj', 'Se creó el vehículo exitosamente.');
    }

    /**
     * Modifica los datos de un vehículo existente.
     *
     * @param Request $req La solicitud HTTP.
     * @param string $id El ID del vehículo a modificar.
     * @return RedirectResponse|View
     */
    public function modificar(Request $req, string $id)
    {
        // Buscar el vehículo con el ID proporcionado
        $vehiculo = Auth::user()->vehiculos()->findOrFail($id);

        // Si la solicitud es GET, retornar la vista de modificación con los datos del vehículo
        if ($req->isMethod('get')) {
            return view('vehiculos.modificar', compact('vehiculo'));
        }

        // Validar los datos del vehículo utilizando el método privado
        $datos = $this->validarVehiculo($req);

        // Actualizar el vehículo con los datos validados
        $vehiculo->update($datos);

        // Redirigir al índice de vehículos con un mensaje de éxito
        return redirect()->route('vehiculos')->with('msj', 'Se modificó el vehículo exitosamente.');
    }

    /**
     * Elimina un vehículo del usuario autenticado.
     *
     * @param string $id El ID del vehículo a eliminar.
     * @return RedirectResponse
     */
    public function eliminar(string $id)
    {
        // Buscar el vehículo con el ID proporcionado
        $vehiculo = Auth::user()->vehiculos()->findOrFail($id);

        // Verificar que no esté relacionado con otros registros
        if ($vehiculo->turnos()->count() > 0) {
            return redirect()->route('vehiculos')->with('error', 'No se puede eliminar el vehículo porque está relacionado con otros turnos.');
        }

        // Eliminar el vehículo
        $vehiculo->delete();

        // Redirigir al índice de vehículos con un mensaje de éxito
        return redirect()->route('vehiculos')->with('msj', 'Se eliminó el vehículo exitosamente.');
    }

    /**
     * Valida los datos del vehículo recibidos en la solicitud.
     *
     * @param Request $req La solicitud HTTP.
     * @return array Los datos validados.
     */
    private function validarVehiculo(Request $req)
    {
        // Validación de los campos del vehículo con reglas específicas
        return $req->validate([
            'marca' => 'required|string|max:50|regex:' . Helper::REGEX_TEXTO,
            'modelo' => 'required|string|max:50',
            'patente' => ['required', 'string', 'min:6', 'max:7', 'unique:vehiculos,patente', 'regex:' . Helper::REGEX_PATENTE],
            'anio' => 'required|integer|min:1900|max:' . date('Y'),
            'tipo' => 'required|in:Auto,Moto',
        ], [
            // Mensajes personalizados para las reglas de validación
            'marca.required' => 'La marca del vehículo es obligatoria.',
            'marca.string' => 'La marca debe ser una cadena de texto.',
            'marca.max' => 'La marca no puede tener más de 50 caracteres.',
            'marca.regex' => 'La marca solo puede contener letras y un solo espacio entre palabras.',

            'modelo.required' => 'El modelo del vehículo es obligatorio.',
            'modelo.string' => 'El modelo debe ser una cadena de texto.',
            'modelo.max' => 'El modelo no puede tener más de 50 caracteres.',

            'patente.required' => 'La patente del vehículo es obligatoria.',
            'patente.string' => 'La patente debe ser una cadena de texto.',
            'patente.min' => 'La patente debe tener al menos 6 caracteres.',
            'patente.max' => 'La patente no puede tener más de 7 caracteres.',
            'patente.unique' => 'La patente ingresada ya está registrada.',
            'patente.regex' => 'La patente ingresada no es válida. Debe ser AAA123 o AA123AA.',

            'anio.required' => 'El año del vehículo es obligatorio.',
            'anio.integer' => 'El año debe ser un número entero.',
            'anio.min' => 'El año debe ser mayor o igual a 1900.',
            'anio.max' => 'El año no puede ser mayor al año actual.',

            'tipo.required' => 'El tipo de vehículo es obligatorio.',
            'tipo.in' => 'El tipo debe ser "Auto" o "Moto".',
        ]);
    }
}
