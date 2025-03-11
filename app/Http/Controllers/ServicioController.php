<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ServicioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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

    public function registrarservicio(Request $request)
    {
        if ($request->isMethod('post')) {
            // Lógica para guardar el vehículo en la base de datos
            // Por ejemplo:
            // Vehiculo::create($request->all());
            return redirect()->route('servicio.altaservicio')->with('success', 'Servicio registrado correctamente');
        }
        
        return view('servicio.altaservicio');
    }

    public function consultarservicio(Request $request)
    {
        if ($request->isMethod('post')) {
            // Lógica para guardar el vehículo en la base de datos
            // Por ejemplo:
            // Vehiculo::create($request->all());
            return redirect()->route('servicio.consultarservicio')->with('success', 'Consultar servicio correctamente');
        }
        
        return view('servicio.consultarservicio');
    }
}
