<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use Illuminate\Http\Request;

class ServicioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(){
        // Ordenar en orden descendente (el más reciente primero)
        $servicios = Servicio::orderBy('created_at', 'DESC')->get();
  
        // Crear un array y retornar la vista
        return view('products.index', compact('servicios'));
    }

    public function registrar(Request $req){
        // Si la solicitud es get, retornar vista
        if ($req->isMethod('get')) {
            return view('servicios.registrar');
        }

        // Validar los datos
        $req->validate([
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
            
            'descripcion.required' => 'La descripción del servicio es obligatorio.',
            'descripcion.string' => 'La descripción debe ser un texto válido.',
            'descripcion.max' => 'La descripción no puede tener más de 500 caracteres.',
        ]);

        // Crear el servicio con los datos validados
        Servicio::create([
            'nombre' => $req->nombre,
            'duracion' => $req->duracion,
            'costo' => $req->costo,
            'descripcion' => $req->descripcion,
        ]);

        // Redirigir al index con un mensaje de éxito
        return redirect()->route('servicios')->with('msj', 'Se creó el servicio exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
