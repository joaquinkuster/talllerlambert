@extends('layouts.app')

@section('titulo', 'Modificar perfil')

@section('contenido')
    <div class="registro-container bg-white rounded shadow p-5 mx-auto">
        @if (session('msj'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('msj') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <h2 class="text-center mb-4">Modificar perfil</h2>
        <form action="{{ route('modificar.perfil') }}" method="post">
            @csrf
            @method('PUT')

            <div class="row mb-3">
                <div class="col">
                    <label for="nombre" class="form-label">Nombre:</label>
                    <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre"
                        name="nombre" placeholder="Nombre" value="{{ auth()->user()->nombre }}">
                    @error('nombre')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col">
                    <label for="apellido" class="form-label">Apellido:</label>
                    <input type="text" class="form-control @error('apellido') is-invalid @enderror" id="apellido"
                        name="apellido" placeholder="Apellido" value="{{ auth()->user()->apellido }}">
                    @error('apellido')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label for="dni" class="form-label">DNI:</label>
                    <input type="text" class="form-control @error('dni') is-invalid @enderror" id="dni"
                        name="dni" placeholder="DNI" value="{{ auth()->user()->dni }}">
                    @error('dni')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col">
                    <label for="telefono" class="form-label">Teléfono (Opcional):</label>
                    <div class="input-group @error('telefono') is-invalid @enderror">
                        <span class="input-group-text">+54</span>
                        <input type="tel" class="form-control @error('telefono') is-invalid @enderror" id="telefono"
                            name="telefono" placeholder="Número de teléfono" value="{{ auth()->user()->telefono }}">
                    </div>
                    @error('telefono')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="mb-3">
                <label for="correo" class="form-label">Correo:</label>
                <input type="email" class="form-control @error('correo') is-invalid @enderror" id="correo"
                    name="correo" placeholder="Correo" value="{{ auth()->user()->correo }}">
                @error('correo')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <button type="submit" class="btn btn-dark w-100">Modificar</button>
        </form>

        <!-- Formulario para enviar el correo de restablecimiento -->
        <h3 class="text-center mt-5">Restablecer Contraseña</h3>
        <form action="{{ route('perfil.solicitarRestablecerCorreo') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="correo" class="form-label">Correo Electrónico</label>
                <input type="email" name="correo" id="correo" class="form-control @error('correo') is-invalid @enderror" required>
                @error('correo')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-dark w-100">Enviar correo de restablecimiento</button>
        </form>
    </div>
@endsection
