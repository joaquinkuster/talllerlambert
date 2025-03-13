<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use Illuminate\Http\Request;

class ServicioController extends Controller
{
    public function index()
    {
        // Ordenar en orden descendente (el más reciente primero)
        $servicios = Servicio::orderBy('created_at', 'DESC')->get();

        // Crear un array y retornar la vista
        return view('servicios.index', compact('servicios'));
    }

    public function registrar(Request $req)
    {
        // Si la solicitud es get, retornar vista
        if ($req->isMethod('get')) {
            return view('servicios.registrar');
        }

        // Validar los datos
        $datos = $this->validarServicio($req);

        // Crear el servicio con los datos validados
        Servicio::create($datos);

        // Redirigir al index con un mensaje de éxito
        return redirect()->route('servicios')->with('msj', 'Se creó el servicio exitosamente.');
    }

    public function modificar(Request $req, string $id)
    {
        // Buscar el servicio por el id proporcionado
        $servicio = Servicio::findOrFail($id);

        // Si la solicitud es get, retornar vista
        if ($req->isMethod('get')) {
            return view('servicios.modificar', compact('servicio'));
        }

        // Validar los datos
        $datos = $this->validarServicio($req);

        // Actualizar el servicio con los datos validados
        $servicio->update($datos);

        // Redirigir al index con un mensaje de éxito
        return redirect()->route('servicios')->with('msj', 'Se modificó el servicio exitosamente.');
    }

    public function eliminar(string $id)
    {
        // Buscar el servicio por el id proporcionado
        $servicio = Servicio::findOrFail($id);

        // Actualizar el servicio con los datos validados
        $servicio->delete();

        // Redirigir al index con un mensaje de éxito
        return redirect()->route('servicios')->with('msj', 'Se eliminó el servicio exitosamente.');
    }

    private function validarServicio(Request $req)
    {
        return $req->validate([
            'nombre' => 'required|string|max:50',
            'duracion' => 'required|integer|min:1|max:9999',
            'costo' => 'required|numeric|min:0|max:9999999.99',
            'descripcion' => 'required|string|max:500',
        ], [
            'nombre.required' => 'El nombre del servicio es obligatorio.',
            'nombre.string' => 'El nombre debe ser un texto válido.',
            'nombre.regex' => 'El nombre solo puede contener letras y un solo espacio entre palabras.',

            'duracion.required' => 'La duración del servicio es obligatoria.',
            'duracion.integer' => 'La duración debe ser un número entero.',
            'duracion.min' => 'La duración debe ser al menos 1 minuto.',
            'duracion.max' => 'La duración no puede ser mayor a 9999 minutos.',

            'costo.required' => 'El costo del servicio es obligatorio.',
            'costo.numeric' => 'El costo debe ser un número válido.',
            'costo.min' => 'El costo no puede ser negativo.',
            'costo.max' => 'El costo no puede superar los 9,999,999.99.',

            'descripcion.required' => 'La descripción del servicio es obligatoria.',
            'descripcion.string' => 'La descripción debe ser un texto válido.',
            'descripcion.max' => 'La descripción no puede tener más de 500 caracteres.',
        ]);
    }
}
