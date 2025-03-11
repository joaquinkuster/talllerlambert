<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TurnoController extends Controller
{
    public function registrarturno(Request $request)
    {
        if ($request->isMethod('post')) {
            // Lógica para guardar el vehículo en la base de datos
            // Por ejemplo:
            // Vehiculo::create($request->all());
            return redirect()->route('turno.altaturno')->with('success', 'Turno registrado correctamente');
        }
        
        return view('turno.altaturno');
    }

    public function consultarturno(Request $request)
    {
        if ($request->isMethod('post')) {
            // Lógica para guardar el vehículo en la base de datos
            // Por ejemplo:
            // Vehiculo::create($request->all());
            return redirect()->route('turno.consultarturno')->with('success', 'Consultar turno');
        }
        
        return view('turno.consultarturno');
    }
}