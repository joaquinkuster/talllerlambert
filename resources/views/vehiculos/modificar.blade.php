@extends('layouts.app')

@section('titulo', 'Modificar vehículo')

@section('contenido')
    <div class="registro-container bg-white rounded shadow p-5 mx-auto">
        <h2 class="text-center mb-4">Modificar vehículo</h2>
        <form action="{{ route('vehiculos.modificar', $vehiculo->id) }}" method="post">
            @csrf
            @method('PUT')
            <div class="row mb-3">
                <div class="col">
                    <label for="marca" class="form-label">Marca:</label>
                    <input type="text" class="form-control @error('marca') is-invalid @enderror" id="marca"
                        name="marca" placeholder="Marca" value="{{ $vehiculo->marca }}">
                    @error('marca')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col">
                    <label for="modelo" class="form-label">Modelo:</label>
                    <input type="text" class="form-control @error('modelo') is-invalid @enderror" id="modelo"
                        name="modelo" placeholder="Modelo" value="{{ $vehiculo->modelo }}">
                    @error('modelo')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label for="anio" class="form-label">Año:</label>
                    <select id="anio" name="anio" class="form-select @error('anio') is-invalid @enderror">
                        <option value="">Seleccione un año</option>
                        @for ($i = 1900; $i <= date('Y'); $i++)
                            <option value="{{ $i }}" {{ $vehiculo->anio == $i ? 'selected' : '' }}>
                                {{ $i }}
                            </option>
                        @endfor
                    </select>
                    @error('anio')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col">
                    <label for="patente" class="form-label">Patente:</label>
                    <input type="text" class="form-control @error('patente') is-invalid @enderror" id="patente"
                        name="patente" placeholder="Patente" value="{{ $vehiculo->patente }}">
                    @error('patente')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <!-- Fila 3: Descripción -->
            <div class="row mb-3">
                <div class="col">
                    <label for="tipo" class="form-label">Tipo:</label>
                    <select id="tipo" name="tipo" class="form-select @error('tipo') is-invalid @enderror">
                        <option value="">Seleccione un tipo</option>
                        <option value="Auto" {{ $vehiculo->tipo == 'Auto' ? 'selected' : '' }}>Auto</option>
                        <option value="Moto" {{ $vehiculo->tipo == 'Moto' ? 'selected' : '' }}>Moto</option>
                    </select>
                    @error('tipo')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <!-- Botón de Registrar -->
            <button type="submit" class="btn btn-dark w-100">Modificar</button>
        </form>
    </div>
@endsection
