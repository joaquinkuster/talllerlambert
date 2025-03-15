<?php

namespace App\Http\Controllers;

use App\Models\Servicio; 
use Illuminate\Http\Request; 
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;

class ServicioController extends Controller
{
    /**
     * Método para mostrar todos los servicios registrados.
     *
     * @return View
     */
    public function index()
    {
        // Ordenar los servicios por fecha de creación en orden descendente (el más reciente primero)
        $servicios = Servicio::orderBy('created_at', 'DESC')->get();

        // Retornar la vista 'servicios.index' con la lista de servicios
        return view('servicios.index', compact('servicios'));
    }

    /**
     * Método para registrar un nuevo servicio.
     *
     * @param Request $req La solicitud HTTP que contiene los datos del servicio.
     * @return RedirectResponse|View
     */
    public function registrar(Request $req)
    {
        // Si la solicitud es GET, mostrar el formulario de registro
        if ($req->isMethod('get')) {
            return view('servicios.registrar');
        }

        // Validar los datos del formulario de registro utilizando la función validarServicio()
        $datos = $this->validarServicio($req);

        // Crear un nuevo servicio con los datos validados
        Servicio::create($datos);

        // Redirigir al index de servicios con un mensaje de éxito
        return redirect()->route('servicios')->with('msj', 'Se creó el servicio exitosamente.');
    }

    /**
     * Método para modificar un servicio existente.
     *
     * @param Request $req La solicitud HTTP que contiene los nuevos datos del servicio.
     * @param string $id El ID del servicio a modificar.
     * @return RedirectResponse|View
     */
    public function modificar(Request $req, string $id)
    {
        // Buscar el servicio por el ID proporcionado
        $servicio = Servicio::findOrFail($id);

        // Si la solicitud es GET, mostrar el formulario de modificación con los datos actuales del servicio
        if ($req->isMethod('get')) {
            return view('servicios.modificar', compact('servicio'));
        }

        // Validar los nuevos datos del servicio
        $datos = $this->validarServicio($req);

        // Actualizar el servicio con los nuevos datos validados
        $servicio->update($datos);

        // Redirigir al index de servicios con un mensaje de éxito
        return redirect()->route('servicios')->with('msj', 'Se modificó el servicio exitosamente.');
    }

    /**
     * Método para eliminar un servicio.
     *
     * @param string $id El ID del servicio a eliminar.
     * @return RedirectResponse
     */
    public function eliminar(string $id)
    {
        // Buscar el servicio por el ID proporcionado
        $servicio = Servicio::findOrFail($id);

        // Verificar que no esté relacionado con otros registros
        if ($servicio->turnos()->count() > 0) {
            return redirect()->route('servicios')->with('error', 'No se puede eliminar el servicio porque está relacionado con otros turnos.');
        }

        // Eliminar el servicio
        $servicio->delete();

        // Redirigir al index de servicios con un mensaje de éxito
        return redirect()->route('servicios')->with('msj', 'Se eliminó el servicio exitosamente.');
    }

    /**
     * Método para validar los datos de un servicio.
     *
     * @param Request $req La solicitud HTTP que contiene los datos del servicio.
     * @return array Los datos validados del servicio.
     */
    private function validarServicio(Request $req)
    {
        // Validación de los datos utilizando reglas definidas
        return $req->validate([
            'nombre' => 'required|string|max:50', // Nombre obligatorio, texto, máximo 50 caracteres
            'duracion' => 'required|integer|min:1|max:60', // Duración obligatoria, entero, entre 1 y 60 minutos
            'costo' => 'required|numeric|min:0|max:1000000.00', // Costo obligatorio, numérico, entre 0 y 1000000.00
            'descripcion' => 'required|string|max:500', // Descripción obligatoria, texto, máximo 500 caracteres
        ], [
            // Mensajes personalizados de validación para cada campo
            'nombre.required' => 'El nombre del servicio es obligatorio.',
            'nombre.string' => 'El nombre debe ser un texto válido.',
            'nombre.max' => 'El nombre no puede superar los 50 caracteres.',

            'duracion.required' => 'La duración del servicio es obligatoria.',
            'duracion.integer' => 'La duración debe ser un número entero.',
            'duracion.min' => 'La duración debe ser al menos 1 minuto.',
            'duracion.max' => 'La duración no puede ser mayor a 60 minutos.',

            'costo.required' => 'El costo del servicio es obligatorio.',
            'costo.numeric' => 'El costo debe ser un número válido.',
            'costo.min' => 'El costo no puede ser negativo.',
            'costo.max' => 'El costo no puede superar el millón ($1,000,000.00).',

            'descripcion.required' => 'La descripción del servicio es obligatoria.',
            'descripcion.string' => 'La descripción debe ser un texto válido.',
            'descripcion.max' => 'La descripción no puede tener más de 500 caracteres.',
        ]);
    }
}
