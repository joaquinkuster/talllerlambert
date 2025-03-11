<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dar de Alta Vehículo</title>
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
            /* Empuja el footer hacia abajo */
            background-color: white;
            padding: 20px;
            text-align: center;
        }
    </style>
    <style>
        /* Estilos para que el contenedor de la tabla llegue hasta el footer */
        .table-container {
            max-height: 60vh;
            /* Ajusta la altura de la tabla */
            overflow-y: auto;
            /* Habilita el scroll vertical cuando sea necesario */
        }

        .card {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            height: 75vh;
            /* Ocupa casi toda la pantalla */
            display: flex;
            flex-direction: column;
        }

        /* Contenedor de botones en Acciones */
        .actions-container {
            display: flex;
            justify-content: center;
            gap: 10px;
            /* Espaciado entre botones */
        }

        /* Botones ocupando todo el ancho disponible */
        .actions-container button {
            flex: 1;
            /* Hace que los botones se expandan */
            min-width: 100px;
            /* Tamaño mínimo */
        }

        .table-responsive {
            flex-grow: 1;
            /* Hace que la tabla crezca hasta ocupar el espacio disponible */
        }

        .table th,
        .table td {
            vertical-align: middle;
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

    <div class="container my-4">
        <div class="card">
            <h2 class="text-center mb-4">Mis vehículos</h2>

            <!-- Filtros -->
            <div class="row mb-3 align-items-center">
                <div class="col-auto">
                    <strong>Filtrar por:</strong>
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control" placeholder="Marca...">
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control" placeholder="Modelo...">
                </div>
                <div class="col-md-2">
                    <select class="form-select">
                        <option>Año</option>
                        <option>2024</option>
                        <option>2023</option>
                        <option>2022</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control" placeholder="Patente...">
                </div>
                <div class="col-md-2">
                    <select class="form-select">
                        <option>Tipo</option>
                        <option>Auto</option>
                        <option>Moto</option>
                    </select>
                </div>
            </div>


            <!-- Contenedor de la tabla con scroll -->
            <div class="table-responsive table-container">
                <table class="table table-bordered text-center">
                    <thead class="table-light">
                        <tr>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>Año</th>
                            <th>Patente</th>
                            <th>Tipo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for ($i = 0; $i < 15; $i++) {{-- Datos de prueba para ver el scroll --}}
                            <tr>
                            <td>Toyota</td>
                            <td>Corolla</td>
                            <td>2020</td>
                            <td>ABC 123</td>
                            <td>Auto</td>
                            <td>
                                <div class="actions-container">
                                    <button class="btn btn-sm btn-dark">Modificar</button>
                                    <button class="btn btn-sm btn-dark">Eliminar</button>
                                </div>
                            </td>
                            </tr>
                            @endfor
                    </tbody>
                </table>
            </div>

            <!-- Botón para registrar nuevo vehículo -->
            <div class="text-end mt-3">
                <button class="btn btn-dark w-25">Registrar vehículo</button>
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