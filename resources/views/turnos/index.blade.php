@extends('layouts.app')

@section('titulo', 'Turnos')

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

        <h2 class="text-center mb-4">Turnos</h2>

        <!-- Filtros -->
        <div class="row mb-4 align-items-center gx-3 gy-3">
            <div class="col-auto">
                <strong>Filtrar por:</strong>
            </div>
            @if (auth()->user()->rol == 'Administrador')
                <div class="col-md col-12">
                    <input type="text" class="form-control" placeholder="Nombre del cliente...">
                </div>
            @endif
            <div class="col-md col-12">
                <select class="form-select">
                    <option value="">Seleccione un servicio</option>
                    @foreach ($servicios as $servicio)
                        <option value="{{ $servicio->id }}">{{ Str::limit($servicio, 15) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md col-12">
                <select class="form-select">
                    <option value="">Seleccione un vehículo</option>
                    @foreach ($vehiculos as $vehiculo)
                        <option value="{{ $vehiculo->id }}">{{ Str::limit($vehiculo, 15) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md col-12">
                <input type="date" class="form-control" id="fecha" name="fecha" placeholder="Fecha...">
            </div>
            <div class="col-md col-12">
                <input type="time" id="hora" name="hora" class="form-control" placeholder="Hora...">
            </div>
            <div class="col-md col-12">
                <select class="form-select">
                    <option>Seleccione un estado</option>
                    <option>Pendiente</option>
                    <option>Finalizado</option>
                    <option>Cancelado</option>
                </select>
            </div>
        </div>

        <!-- Contenedor de la tabla con scroll -->
        @if ($turnos->count() > 0)
            <div class="table-responsive tabla-container">
                <table class="table table-bordered table-striped table-hover text-center rounded shadow-sm">
                    <thead class="table-light">
                        <tr>
                            @if (auth()->user()->rol == 'Administrador')
                                <th class="text-center">Cliente</th>
                            @endif
                            <th class="text-center">Servicios</th>
                            <th class="text-center">Vehículo</th>
                            <th class="text-center">Fecha y Hora</th>
                            <th class="text-center">Estado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($turnos as $turno)
                            <tr>
                                @if (auth()->user()->rol == 'Administrador')
                                    <td class="align-middle">{{ $turno->user }}</td>
                                @endif
                                <td class="align-middle">
                                    <ul>
                                        @foreach ($turno->servicios as $servicio)
                                            <li>{{ $servicio }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td class="align-middle">{{ $turno->vehiculo }}</td>
                                <td class="align-middle">{{ $turno->fechaHora->format('Y-m-d H:i') }}</td>
                                <td class="align-middle">{{ $turno->estado }}</td>
                                <td class="align-middle">
                                    @if ($turno->estado == 'Pendiente')
                                        @if (auth()->user()->rol == 'Cliente')
                                            <a href="{{ route('turnos.modificar', $turno->id) }}"
                                                class="btn btn-warning btn-sm">Modificar</a>
                                        @endif
                                        <form action="{{ route('turnos.cancelar', $turno->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="btn btn-danger btn-sm btnConfirmar">Cancelar</button>
                                        </form>
                                        @if (auth()->user()->rol == 'Administrador')
                                            <form action="{{ route('turnos.finalizar', $turno->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit"
                                                    class="btn btn-primary btn-sm btnConfirmar">Finalizar</button>
                                            </form>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        <!-- Más filas aquí -->
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-info mt-5 text-center" role="alert">
                <p class="text-muted fs-5">No tienes turnos registrados actualmente.</p>
            </div>
        @endif

        @if (auth()->user()->rol == 'Cliente')
            <div class="d-flex justify-content-end mt-3">
                <a class="btn btn-dark px-5" href="{{ route('turnos.reservar') }}">Reservar turno</a>
            </div>
        @endif
    </div>
@endsection
