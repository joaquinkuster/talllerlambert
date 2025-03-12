@extends('layouts.app')

@section('titulo', 'Sevicios')

@section('contenido')
    <div class="registro-container bg-white rounded shadow p-5 mx-auto">
        <h2 class="text-center mb-4">Dar de alta servicio</h2>
        <form action="{{ route('servicios.registrar') }}" method="post">
            @csrf
            <!-- Fila 1: Nombre del Servicio -->
            <div class="row mb-3">
                <div class="col-12">
                    <label for="nombre" class="form-label">Nombre:</label>
                    <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre"
                        name="nombre" placeholder="Nombre" value="{{ old('nombre') }}">
                    @error('nombre')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <!-- Fila 2: Duración y Costo -->
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
