<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VehiculoController extends Controller
{
    public function index()
    {
        $vehiculos = Auth::user()->vehiculos; // Obtiene todos los vehículos del usuario autenticado

        // Crear un array y retornar la vista
        return view('vehiculos.index', compact('vehiculos'));
    }

    public function registrar(Request $req)
    {
        // Si la solicitud es get, retornar vista
        if ($req->isMethod('get')) {
            return view('vehiculos.registrar');
        }

        // Validar los datos
        $datos = $this->validarVehiculo($req);

        // Crear el vehículo asociado al usuario autenticado
        Auth::user()->vehiculos()->create($datos);

        // Redirigir al index con un mensaje de éxito
        return redirect()->route('vehiculos')->with('msj', 'Se creó el vehículo exitosamente.');
    }

    public function modificar(Request $req, string $id)
    {
        // Buscar el vehículo por el id proporcionado
        $vehiculo = Auth::user()->vehiculos()->findOrFail($id);

        // Si la solicitud es get, retornar vista
        if ($req->isMethod('get')) {
            return view('vehiculos.modificar', compact('vehiculo'));
        }

        // Validar los datos
        $datos = $this->validarVehiculo($req);

        // Actualizar el vehículo con los datos validados
        $vehiculo->update($datos);

        // Redirigir al index con un mensaje de éxito
        return redirect()->route('vehiculos')->with('msj', 'Se modificó el vehículo exitosamente.');
    }

    public function eliminar(string $id)
    {
        // Buscar el vehículo por el id proporcionado
        $vehiculo = Auth::user()->vehiculos()->findOrFail($id);

        // Actualizar el vehículo con los datos validados
        $vehiculo->delete();

        // Redirigir al index con un mensaje de éxito
        return redirect()->route('vehiculos')->with('msj', 'Se eliminó el vehículo exitosamente.');
    }

    private function validarVehiculo(Request $req)
    {
        return $req->validate([
            'marca' => 'required|string|max:50|regex:' . Helper::REGEX_TEXTO,
            'modelo' => 'required|string|max:50',
            'patente' => ['required', 'string', 'min:6', 'max:7', 'unique:vehiculos,patente', 'regex:' . Helper::REGEX_PATENTE],
            'anio' => 'required|integer|min:1900|max:' . date('Y'),
            'tipo' => 'required|in:Auto,Moto',
        ], [
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
