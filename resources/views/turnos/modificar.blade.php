@extends('layouts.app')

@section('titulo', 'Modificar turno')

@push('estilos')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
@endpush

@section('contenido')
    <div class="registro-container bg-white rounded shadow p-5 mx-auto">
        <h2 class="text-center mb-4">Modificar turno</h2>
        <form action="{{ route('turnos.modificar', $turno->id) }}" method="post">
            @csrf
            @method('PUT')
            <div class="row mb-3">
                <div class="col-12">
                    <label for="servicio" class="form-label">Servicios:</label>
                    <input type="hidden" id="data-horarios" data-url="{{ route('turnos.actualizarHorarios') }}"
                        data-token="{{ csrf_token() }}" data-id-turno="{{ $turno->id }}">
                    <select name="servicios[]" id="selectMultiple"
                        class="form-select @error('servicios') is-invalid @enderror" multiple>
                        @foreach ($servicios as $servicio)
                            <option value="{{ $servicio->id }}"
                                {{ $turno->servicios->contains('id', $servicio->id) ? 'selected' : '' }}>{{ $servicio }}
                            </option>
                        @endforeach
                    </select>
                    @error('servicios')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12">
                    <label for="vehiculo_id" class="form-label">Vehículo:</label>
                    <select name="vehiculo_id" id="vehiculo"
                        class="form-select @error('vehiculo_id') is-invalid @enderror">
                        <option value="">Seleccione un vehículo</option>
                        @foreach ($vehiculos as $vehiculo)
                            <option value="{{ $vehiculo->id }}"
                                {{ $turno->vehiculo->id == $vehiculo->id ? 'selected' : '' }}>
                                {{ $vehiculo }}
                            </option>
                        @endforeach
                    </select>
                    @error('vehiculo_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12">
                    <label for="fechaHora" class="form-label">Fecha y hora:</label>
                    <select id="fechaHora" name="fechaHora" class="form-select @error('fechaHora') is-invalid @enderror">
                        @php
                            $horariosDisponibles = old('horariosDisponibles', $horariosDisponibles ?? []);
                            echo json_encode($horariosDisponibles);
                        @endphp
                        @if (count($horariosDisponibles) > 0)
                            <option value="">Seleccione una fecha y hora</option>
                            @foreach ($horariosDisponibles as $horario)
                                <option value="{{ $horario }}" {{ $turno->fechaHora->format('Y-m-d H:i') == $horario ? 'selected' : '' }}>
                                    {{ $horario }}</option>
                            @endforeach
                        @else
                            <option value="">No hay horarios disponibles para mostrar.</option>
                        @endif
                    </select>
                    @error('fechaHora')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <button type="submit" class="btn btn-dark w-100">Modificar</button>
        </form>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endpush
