@extends('layouts.app')

@section('titulo', 'Modificar Contraseña')

@section('contenido')
<div class="perfil-container bg-white rounded shadow p-5 mx-auto">
    <h2 class="text-center mb-4">Modificar Contraseña</h2>

    @if (session('msj'))
    <div class="alert alert-success">
        {{ session('msj') }}
    </div>
    @endif

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Formulario para enviar el correo de restablecimiento -->
    <form action="{{ route('perfil.solicitarRestablecerCorreo') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="correo" class="form-label">Correo Electrónico</label>
            <input type="correo" name="correo" id="correo" class="form-control @error('correo') is-invalid @enderror" required>
            @error('correo')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-dark w-100">Enviar correo de restablecimiento</button>
    </form>

</div>
@endsection
