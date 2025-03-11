<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar Servicios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
        <div class="service-container">
            <h2 class="text-center mb-4">Servicios</h2>

            <!-- Filtros -->
            <div class="row mb-3 align-items-center">
                <div class="col-auto">
                    <strong>Filtrar por:</strong>
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control" placeholder="Nombre...">
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control" placeholder="Descripción...">
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control" placeholder="Costo...">
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control" placeholder="Duración...">
                </div>
                <!-- <div class="col-md-2">
                    <button class="btn btn-dark">Buscar</button>
                </div> -->
            </div>

            <!-- Contenedor de la tabla con scroll -->
            <div class="table-container">
                <table class="table table-bordered text-center">
                    <thead class="table-light">
                        <tr>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Costo</th>
                            <th>Duración (min)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Ejemplo de datos -->
                        <tr>
                            <td>Alineación de ojos</td>
                            <td>Servicio para corregir la alineación de los ojos del vehículo. Mejora la estabilidad y el desgaste de los neumáticos.</td>
                            <td>$515,500</td>
                            <td>60</td>
                        </tr>
                        <tr>
                            <td>Balanceo de ruedas</td>
                            <td>Ajuste de las ruedas para evitar vibraciones y distribución de peso uniforme.</td>
                            <td>$512,005</td>
                            <td>45</td>
                        </tr>
                        <tr>
                            <td>Cambio de aceite</td>
                            <td>Servicio para cambiar el aceite del motor y mantener el vehículo en óptimas condiciones.</td>
                            <td>$300,000</td>
                            <td>30</td>
                        </tr>
                        <tr>
                            <td>Revisión de frenos</td>
                            <td>Revisión y ajuste del sistema de frenos para garantizar la seguridad del vehículo.</td>
                            <td>$400,000</td>
                            <td>50</td>
                        </tr>
                        <tr>
                            <td>Rotación de neumáticos</td>
                            <td>Rotación de neumáticos para un desgaste uniforme y mayor durabilidad.</td>
                            <td>$200,000</td>
                            <td>40</td>
                        </tr>
                        <tr>
                            <td>Limpieza de inyectores</td>
                            <td>Limpieza de los inyectores de combustible para mejorar el rendimiento del motor.</td>
                            <td>$250,000</td>
                            <td>35</td>
                        </tr>
                        <tr>
                            <td>Revisión de suspensión</td>
                            <td>Revisión y ajuste del sistema de suspensión para una conducción suave.</td>
                            <td>$350,000</td>
                            <td>55</td>
                        </tr>
                        <tr>
                            <td>Cambio de bujías</td>
                            <td>Cambio de bujías para mejorar la eficiencia del motor.</td>
                            <td>$150,000</td>
                            <td>25</td>
                        </tr>
                        <tr>
                            <td>Revisión de batería</td>
                            <td>Revisión y mantenimiento de la batería del vehículo.</td>
                            <td>$100,000</td>
                            <td>20</td>
                        </tr>
                        <tr>
                            <td>Limpieza de aire acondicionado</td>
                            <td>Limpieza y mantenimiento del sistema de aire acondicionado.</td>
                            <td>$180,000</td>
                            <td>30</td>
                        </tr>
                        <tr>
                            <td>Revisión de luces</td>
                            <td>Revisión y ajuste de las luces del vehículo.</td>
                            <td>$120,000</td>
                            <td>15</td>
                        </tr>
                        <tr>
                            <td>Cambio de filtros</td>
                            <td>Cambio de filtros de aire, aceite y combustible.</td>
                            <td>$220,000</td>
                            <td>40</td>
                        </tr>
                        <tr>
                            <td>Revisión de transmisión</td>
                            <td>Revisión y mantenimiento del sistema de transmisión.</td>
                            <td>$450,000</td>
                            <td>60</td>
                        </tr>
                        <tr>
                            <td>Limpieza de tapicería</td>
                            <td>Limpieza profunda de la tapicería del vehículo.</td>
                            <td>$280,000</td>
                            <td>50</td>
                        </tr>
                        <tr>
                            <td>Revisión de escape</td>
                            <td>Revisión y mantenimiento del sistema de escape.</td>
                            <td>$320,000</td>
                            <td>45</td>
                        </tr>
                        <!-- Agrega más filas según sea necesario -->
                    </tbody>
                </table>
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