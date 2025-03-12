<!DOCTYPE html>
<html lang="es">

@include('layouts.head')

<body>

    @include('layouts.navbar')

    <div class="container my-5">
        @yield('contenido')
    </div>

    @include('layouts.footer')

    @include('layouts.scripts')

</body>

</html>
