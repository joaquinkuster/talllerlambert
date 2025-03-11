<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservar Turno</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #ADADAD;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }

        .reservation-container {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            margin-top: 10%;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-control {
            margin-bottom: 15px;
        }

        .btn-reserve {
            width: 100%;
            background-color: black;
            color: white;
        }
    </style>
    <style>
        body {
            background-color: #ADADAD;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }

        .service-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            margin-top: 5px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            flex: 1;
        }

        .form-row {
            margin-bottom: 15px;
        }

        footer {
            margin-top: auto;
            background-color: white;
            padding: 20px;
            text-align: center;
        }

        /* Estilos para la tabla */
        .table-container {
            max-height: 450px; /* Altura fija para el contenedor de la tabla */
            overflow-y: auto; /* Scroll vertical */
            border: 1px solid #dee2e6; /* Borde para el contenedor */
            border-radius: 8px; /* Bordes redondeados */
        }

        .table th,
        .table td {
            vertical-align: middle;
        }

        /* Estilos para los botones */
        .btn-custom {
            width: 100%;
            margin: 5px 0;
            font-size: 14px;
            padding: 10px;
        }
    </style>
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light py-3">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Logo</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto me-3">
                    <li class="nav-item me-3">
                        <a class="nav-link" href="#">Inicio</a>
                    </li>
                    <li class="nav-item me-3">
                        <a class="nav-link" href="#">Servicios</a>
                    </li>
                    <li class="nav-item me-3">
                        <a class="nav-link" href="#">Nosotros</a>
                    </li>
                    <li class="nav-item me-3">
                        <a class="nav-link" href="#">Galería</a>
                    </li>
                    <li class="nav-item me-3">
                        <a class="nav-link" href="#">Contacto</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png" alt="Profile" class="rounded-circle" width="30" height="30">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#">Perfil</a></li>
                            <li><a class="dropdown-item" href="#">Cerrar sesión</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <div class="reservation-container">
            <h2 class="text-center mb-4">Reservar turno</h2>
            <form action="#" method="post">
                <label for="servicio">Servicio a realizar:</label>
                <select class="form-control" id="servicio" name="servicio">
                    <option selected>Seleccione un servicio</option>
                </select>

                <label for="vehiculo">Vehículo:</label>
                <select class="form-control" id="vehiculo" name="vehiculo">
                    <option selected>Seleccione un vehículo</option>
                </select>

                <label for="fecha">Fecha:</label>
                <input type="date" class="form-control" id="fecha" name="fecha">

                <label for="hora">Horario:</label>
                <select class="form-control" id="hora" name="hora">
                    <option selected>Seleccione un horario</option>
                </select>

                <button type="submit" class="btn btn-reserve">Reservar</button>
            </form>
        </div>
    </div>

    <footer class="text-center py-3">
        <p>&copy; Diseño y Aplicaciones en la Web 2025 – Küster Joaquín, Martínez Lázaro Ezequiel</p>
        <p>Taller de Alineación y Balanceo "Lambert"</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
