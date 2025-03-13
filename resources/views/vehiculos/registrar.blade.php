@extends('layouts.app')

@section('titulo', 'Registrar vehículo')

@section('contenido')
    <div class="registro-container bg-white rounded shadow p-5 mx-auto">
        <h2 class="text-center mb-4">Dar de alta vehículo</h2>
        <form action="{{ route('vehiculos.registrar') }}" method="post">
            @csrf
            <div class="row mb-3">
                <div class="col">
                    <label for="marca" class="form-label">Marca:</label>
                    <input type="text" class="form-control @error('marca') is-invalid @enderror" id="marca"
                        name="marca" placeholder="Marca" value="{{ old('marca') }}">
                    @error('marca')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col">
                    <label for="modelo" class="form-label">Modelo:</label>
                    <input type="text" class="form-control @error('modelo') is-invalid @enderror" id="modelo"
                        name="modelo" placeholder="Modelo" value="{{ old('modelo') }}">
                    @error('modelo')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label for="duracion" class="form-label">Duración
                        (minutos):</label>
                    <input type="number" step="0" min="1"
                        class="form-control @error('duracion') is-invalid @enderror" id="duracion" name="duracion"
                        placeholder="Duración" value="{{ old('duracion') }}">
                    @error('duracion')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col">
                    <label for="costo" class="form-label">Costo:</label>
                    <input type="number" step="0.01" min="0"
                        class="form-control @error('costo') is-invalid @enderror" id="costo" name="costo"
                        placeholder="Costo" value="{{ old('costo') }}">
                    @error('costo')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <!-- Fila 3: Descripción -->
            <div class="row mb-3">
                <div class="col">
                    <label for="descripcion" class="form-label">Descripción:</label>
                    <textarea class="form-control @error('descripcion') is-invalid @enderror" id="descripcion" name="descripcion"
                        rows="3" placeholder="Descripción">{{ old('descripcion') }}</textarea>
                    @error('descripcion')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <!-- Botón de Registrar -->
            <button type="submit" class="btn btn-dark w-100">Registrar</button>
        </form>
    </div>
@endsection
