@extends('layouts.app')

@section('titulo', 'Mis vehiculos')

@section('contenido')
    <div class="index-container bg-white rounded shadow p-5">

        @if (session('msj'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('msj') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <h2 class="text-center mb-4">Mis vehiculos</h2>

        <!-- Filtros -->
        <div class="row mb-4 align-items-center gx-3 gy-3">
            <div class="col-auto">
                <strong>Filtrar por:</strong>
            </div>
            <div class="col-md col-12">
                <input type="text" class="form-control" placeholder="Marca...">
            </div>
            <div class="col-md col-12">
                <input type="text" class="form-control" placeholder="Modelo...">
            </div>
            <div class="col-md col-12">
                <select class="form-select" placeholder="Año...">
                    <option>2024</option>
                    <option>2023</option>
                    <option>2022</option>
                </select>
            </div>
            <div class="col-md col-12">
                <input type="text" class="form-control" placeholder="Patente...">
            </div>
            <div class="col-md col-12">
                <select class="form-select">
                    <option>Tipo</option>
                    <option>Auto</option>
                    <option>Moto</option>
                </select>
            </div>
        </div>

        <!-- Contenedor de la tabla con scroll -->
        @if ($vehiculos->count() > 0)
            <div class="table-responsive tabla-container">
                <table class="table table-bordered table-striped table-hover text-center rounded shadow-sm">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center">Marca</th>
                            <th class="text-center">Modelo</th>
                            <th class="text-center">Año</th>
                            <th class="text-center">Patente</th>
                            <th class="text-center">Tipo</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($vehiculos as $vehiculo)
                            <tr>
                                <td class="align-middle">{{ $vehiculo->marca }}</td>
                                <td class="align-middle">{{ $vehiculo->modelo }}</td>
                                <td class="align-middle">{{ $vehiculo->anio }}</td>
                                <td class="align-middle">{{ $vehiculo->patente }}</td>
                                <td class="align-middle">{{ $vehiculo->tipo }}</td>
                                <td class="align-middle">
                                    <a href="{{ route('vehiculos.modificar', $vehiculo->id) }}"
                                        class="btn btn-warning btn-sm">Modificar</a>
                                    <form action="{{ route('vehiculos.eliminar', $vehiculo->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm btnConfirmar">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        <!-- Más filas aquí -->
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-info mt-5 text-center" role="alert">
                <p class="text-muted fs-5">No tienes vehiculos registrados actualmente.</p>
            </div>
        @endif

        <div class="d-flex justify-content-end mt-3">
            <a class="btn btn-dark px-5" href="{{ route('vehiculos.registrar') }}">Registrar vehículo</a>
        </div>
    </div>
@endsection
