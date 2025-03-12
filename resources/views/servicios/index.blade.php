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
        <div class="table-responsive tabla-container">
            <table class="table table-bordered table-striped table-hover text-center rounded shadow-sm">
                <thead class="table-light">
                    <tr>
                        <th class="text-center">Nombre</th>
                        <th class="text-center">Descripción</th>
                        <th class="text-center">Costo (en ARS)</th>
                        <th class="text-center">Duración (min)</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($servicios->count() > 0)
                        @foreach ($servicios as $servicio)
                            <tr>
                                <td class="align-middle">{{ $servicio->nombre }}</td>
                                <td class="align-middle">{{ $servicio->descripcion }}</td>
                                <td class="align-middle">${{ $servicio->costo }}</td>
                                <td class="align-middle">{{ $servicio->duracion }}</td>
                            </tr>
                            <tr>
                                <td class="align-middle">{{ $rs->title }}</td>
                                <td class="align-middle">{{ $rs->price }}</td>
                                <td class="align-middle">{{ $rs->product_code }}</td>
                                <td class="align-middle">{{ $rs->description }}</td>
                                <td class="align-middle">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <a href="{{ route('products.show', $rs->id) }}" type="button"
                                            class="btn btn-secondary">Detail</a>
                                        <a href="{{ route('products.edit', $rs->id) }}" type="button"
                                            class="btn btn-warning">Edit</a>
                                        <form action="{{ route('products.destroy', $rs->id) }}" method="POST"
                                            type="button" class="btn btn-danger p-0" onsubmit="return confirm('Delete?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger m-0">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td class="text-center" colspan="5">Product not found</td>
                        </tr>
                    @endif
                    <!-- Más filas aquí -->
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-end mt-3">
            <a class="btn btn-dark px-5" href="{{ route('servicios.registrar') }}">Registrar servicio</a>
        </div>
    </div>
@endsection
