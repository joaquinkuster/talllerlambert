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
            overflow: hidden;
            margin: 0;
        }

        .vehicle-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            margin-top: 10%;
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

        /* Estilos para que el contenedor de la tabla llegue hasta el footer */
        .table-container {
            max-height: 60vh;
            overflow-y: auto;
        }

        .card {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            height: 75vh;
            display: flex;
            flex-direction: column;
        }

        /* Contenedor de botones en Acciones */
        .actions-container {
            display: flex;
            flex-direction: row; /* Cambiamos a horizontal */
            gap: 5px; /* Espaciado entre botones */
            width: 190px; /* Ancho fijo para la columna */
        }

        /* Botones ocupando todo el ancho disponible */
        .actions-container button {
            flex: 1; /* Los botones ocupan el espacio disponible */
            margin: 2px 0;
            font-size: 12px; /* Tamaño de fuente más pequeño */
            padding: 5px; /* Padding reducido */
        }

        .table-responsive {
            flex-grow: 1;
        }

        .table th,
        .table td {
            vertical-align: middle;
        }

        /* Ajustar el ancho de la columna "Acciones" */
        .table th:nth-child(6),
        .table td:nth-child(6) {
            width: 150px; /* Ancho fijo para la columna "Acciones" */
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

    <div class="container">
        <div class="card">
            <h2 class="text-center mb-4">Turnos</h2>
            <div class="row mb-3">
                <div class="col-md-2"><strong>Filtrar por:</strong></div>
                <div class="col-md-2"><select class="form-select"><option>Servicio</option></select></div>
                <div class="col-md-2"><select class="form-select"><option>Vehículo</option></select></div>
                <div class="col-md-2"><select class="form-select"><option>Fecha</option></select></div>
                <div class="col-md-2"><select class="form-select"><option>Hora</option></select></div>
                <div class="col-md-2"><select class="form-select"><option>Estado</option></select></div>
            </div>
            <div class="table-responsive table-container">
                <table class="table table-bordered text-center">
                    <thead class="table-light">
                        <tr>
                            <th>Servicio solicitado</th>
                            <th>Vehículo</th>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Alineación de ejes</td>
                            <td>Toyota Corolla 2020</td>
                            <td>20/05/2025</td>
                            <td>17:30</td>
                            <td>Pendiente</td>
                            <td>
                                <div class="actions-container">
                                    <button class="btn btn-dark btn-sm">Modificar</button>
                                    <button class="btn btn-dark btn-sm">Cancelar</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Balanceo de ruedas</td>
                            <td>Toyota Corolla 2020</td>
                            <td>21/05/2025</td>
                            <td>09:00</td>
                            <td>Cancelado</td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="text-end mt-3">
                <button class="btn btn-dark">Reservar turno</button>
            </div>
        </div>
    </div>

    <footer>
        <p>© Diseño y Aplicaciones en la Web 2025 – Küster Joaquín, Martínez Lázaro Ezequiel</p>
        <p>Taller de Alineación y Balanceo "Lambert"</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
