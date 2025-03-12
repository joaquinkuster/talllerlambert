@extends('layouts.app')

@section('titulo', 'Inicio de sesión')

@section('contenido')
    <div class="login-container bg-white rounded shadow p-5 d-flex">
        <div class="d-flex justify-content-around align-items-center w-100">
            <div class="formulario-izquierda w-50 px-5 d-flex flex-column">
                <h2 class="text-center mb-4">Bienvenido</h2>
                <h2 class="text-center mb-4">Iniciar sesión</h2>
                <form action="{{ route('login.acceder') }}" method="post" class="w-100">
                    @csrf
                    @error('login')
                        <div class="alert alert-danger" role="alert">
                            {{ $message }}
                        </div>
                    @enderror
                    @if (session('msj'))
                        <div class="alert alert-success alert-dismissible fade show">
                            {{ session('msj') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="mb-3">
                        <label for="dni" class="form-label">DNI:</label>
                        <input type="text" class="form-control @error('dni') is-invalid @enderror" id="dni"
                            name="dni" placeholder="DNI" value="{{ old('dni') }}">
                        @error('dni')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="contrasena" class="form-label">Contraseña:</label>
                        <div class="input-group @error('password') is-invalid @enderror">
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                id="password" name="password" placeholder="Contraseña">
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
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="recordar" name="recordar"
                                {{ old('recordar') ? 'checked' : '' }}>
                            <label class="form-check-label" for="recordar">Recordarme</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <a href="{{ route('registro') }}"
                            class="link-offset-2 link-underline link-underline-opacity-0 link-secondary fw-bold">¿No
                            estás registrado? Registrarse</a>
                    </div>
                    <button type="submit" class="btn btn-dark w-100 mt-5">Acceder</button>
                </form>
            </div>
            <div class="logo-derecha d-flex w-50 h-100">
                <img src="https://img.freepik.com/premium-vector/default-image-icon-vector-missing-picture-page-website-design-mobile-app-no-photo-available_87543-11093.jpg"
                    alt="" class="w-100 rounded">
            </div>
        </div>
    </div>
@endsection
