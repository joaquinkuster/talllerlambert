<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VehiculoController extends Controller
{
    public function registrarvehiculo(Request $request)
    {
        if ($request->isMethod('post')) {
            // Lógica para guardar el vehículo en la base de datos
            // Por ejemplo:
            // Vehiculo::create($request->all());
            return redirect()->route('vehiculo.altavehiculo')->with('success', 'Vehículo registrado correctamente');
        }
        
        return view('vehiculo.altavehiculo');
    }

    public function consultarvehiculo(Request $request)
    {
        if ($request->isMethod('post')) {
            // Lógica para guardar el vehículo en la base de datos
            // Por ejemplo:
            // Vehiculo::create($request->all());
            return redirect()->route('vehiculo.consultarvehiculo')->with('success', 'Vehículo registrado correctamente');
        }
        
        return view('vehiculo.consultarvehiculo');
    }
}