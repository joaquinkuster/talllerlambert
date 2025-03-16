@extends('layouts.app')

@section('titulo', 'Sevicios')

@section('contenido')
<div class="index-container bg-white rounded shadow p-5">

    @if (session('msj'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('msj') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('status'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle"></i> {{ session('status') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <h2 class="text-center mb-4">Servicios</h2>

    <!-- Filtros -->
    <div class="row mb-4 align-items-center gx-3 gy-3">
        <div class="col-auto">
            <strong>Filtrar por:</strong>
        </div>
        <div class="col-md col-12">
            <input type="text" class="form-control" placeholder="Nombre...">
        </div>
        <div class="col-md col-12">
            <input type="text" class="form-control" placeholder="Descripción...">
        </div>
        <div class="col-md col-12">
            <input type="text" class="form-control" placeholder="Costo...">
        </div>
        <div class="col-md col-12">
            <input type="text" class="form-control" placeholder="Duración...">
        </div>
    </div>

    <!-- Contenedor de la tabla con scroll -->
    @if ($servicios->count() > 0)
    <div class="table-responsive tabla-container">
        <table class="table table-bordered table-striped table-hover text-center rounded shadow-sm">
            <thead class="table-light">
                <tr>
                    <th class="text-center">Nombre</th>
                    <th class="text-center">Descripción</th>
                    <th class="text-center">Costo (en ARS)</th>
                    <th class="text-center">Duración (min)</th>
                    @if (auth()->user()->rol == 'Administrador')
                    <th class="text-center">Acciones</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($servicios as $servicio)
                <tr>
                    <td class="align-middle">{{ $servicio->nombre }}</td>
                    <td class="align-middle">{{ $servicio->descripcion }}</td>
                    <td class="align-middle">${{ $servicio->costo }}</td>
                    <td class="align-middle">{{ $servicio->duracion }}</td>
                    @if (auth()->user()->rol == 'Administrador')
                    <td class="align-middle">
                        <a href="{{ route('servicios.modificar', $servicio->id) }}"
                            class="btn btn-warning btn-sm">Modificar</a>
                        <form action="{{ route('servicios.eliminar', $servicio->id) }}" method="POST"
                            class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="btn btn-danger btn-sm btnConfirmar">Eliminar</button>
                        </form>
                    </td>
                    @endif
                </tr>
                @endforeach
                <!-- Más filas aquí -->
            </tbody>
        </table>
    </div>
    @else
    <div class="alert alert-info mt-5 text-center" role="alert">
        <p class="text-muted fs-5">No hay servicios registrados actualmente.</p>
    </div>
    @endif

    @if (auth()->user()->rol == 'Administrador')
    <div class="d-flex justify-content-end mt-3">
        <a class="btn btn-dark px-5" href="{{ route('servicios.registrar') }}">Registrar servicio</a>
    </div>
    @endif
</div>
@endsection