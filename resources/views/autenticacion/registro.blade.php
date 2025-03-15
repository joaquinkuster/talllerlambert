@extends('layouts.app')

@section('titulo', 'Registro de cuenta')

@section('contenido')
    <div class="registro-container bg-white rounded shadow p-5 mx-auto">
        <h2 class="text-center mb-4">Registrar cuenta</h2>
        <form action="{{ route('registro') }}" method="post">
            @csrf

            <div class="row mb-3">
                <div class="col">
                    <label for="nombre" class="form-label">Nombre:</label>
                    <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre"
                        name="nombre" placeholder="Nombre" value="{{ old('nombre') }}">
                    @error('nombre')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col">
                    <label for="apellido" class="form-label">Apellido:</label>
                    <input type="text" class="form-control @error('apellido') is-invalid @enderror" id="apellido"
                        name="apellido" placeholder="Apellido" value="{{ old('apellido') }}">
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
                        name="dni" placeholder="DNI" value="{{ old('dni') }}">
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
                            name="telefono" placeholder="Número de teléfono" value="{{ old('telefono') }}">
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
                    name="correo" placeholder="Correo" value="{{ old('correo') }}">
                @error('correo')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="contrasena" class="form-label">Contraseña:</label>
                <div class="input-group @error('password') is-invalid @enderror">
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                        name="password" placeholder="Contraseña">
                    <span class="input-group-text">
                        <i class="fas fa-eye-slash" id="togglePassword"></i>
                    </span>
                </div>
                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Repetir Contraseña:</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                        placeholder="Repetir Contraseña">
                    <span class="input-group-text">
                        <i class="fas fa-eye-slash" id="togglePasswordConfirm"></i>
                    </span>
                </div>
            </div>
            <div class="mb-3">
                <div class="form-check @error('terminos') is-invalid @enderror">
                    <input type="checkbox" class="form-check-input" id="terminos" name="terminos"
                        {{ old('terminos') ? 'checked' : '' }}>
                    <label class="form-check-label" for="terminos">Acepto los términos y condiciones del sitio</label>
                </div>
                @error('terminos')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <button type="submit" class="btn btn-dark w-100">Registrar</button>
        </form>
    </div>
@endsection
