<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dar de Alta Servicio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #ADADAD;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            overflow: hidden;
            margin: 0;
        }

        .service-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            margin-top: 5%;
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
        <div class="service-container">
            <h2 class="text-center mb-4">Dar de alta Servicio</h2>
            <form action="#" method="post">
                @csrf

                <!-- Fila 1: Nombre del Servicio -->
                <div class="row form-row">
                    <div class="col-12">
                        <label for="nombre" class="form-label">Nombre del Servicio:</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="">
                    </div>
                </div>

                <!-- Fila 2: Duración y Costo -->
                <div class="row form-row">
                    <div class="col-md-6">
                        <label for="duracion" class="form-label">Duración (minutos):</label>
                        <input type="number" class="form-control" id="duracion" name="duracion" placeholder="">
                    </div>
                    <div class="col-md-6">
                        <label for="costo" class="form-label">Costo:</label>
                        <input type="number" class="form-control" id="costo" name="costo" placeholder="">
                    </div>
                </div>

                <!-- Fila 3: Descripción -->
                <div class="row form-row">
                    <div class="col-12">
                        <label for="descripcion" class="form-label">Descripción:</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
                    </div>
                </div>

                <!-- Botón de Registrar -->
                <div class="row form-row">
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-dark btn-custom">Registrar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <footer>
        <p>© Diseño y Aplicaciones en la Web 2025 – Küster Joaquín, Martínez Lázaro Ezequiel</p>
        <p>Taller de Alineación y Balanceo "Lambert"</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>