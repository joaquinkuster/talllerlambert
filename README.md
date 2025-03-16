# Sistema de Gestión de Taller de Alineación y Balanceo

Este proyecto es un sistema de gestión diseñado para el **Taller de Alineación y Balanceo "Lambert"**, ubicado en Puerto Iguazú. El sistema tiene como objetivo optimizar la organización del taller, mejorar la experiencia del cliente y facilitar la gestión de turnos, servicios y vehículos.

---

## Escenario

El taller actualmente no cuenta con un sistema de gestión, lo que genera desorganización en su operativa. Los mecánicos trabajan en dos turnos (de 8:00 a 12:00 y de 14:00 a 18:00), atendiendo autos convencionales (4 ruedas, 2 ejes) y motos (2 ruedas, 1 eje). Los servicios principales son:

- **Alineación de ejes**: Corrige la inclinación y dirección del vehículo, evitando el desgaste irregular de los neumáticos. Tiempo estimado: 40 minutos.
- **Balanceo de ruedas**: Distribuye el peso de manera uniforme mediante la adición de plomo, reduciendo vibraciones al conducir. Tiempo estimado: 30 minutos.

El sistema busca resolver problemas como:
- Falta de historial de clientes y vehículos.
- Ausencia de turnos programados, lo que genera largas esperas.
- Registros manuales y dispersos, propensos a errores.
- Falta de control sobre los tiempos de los servicios.

---

## Integrantes del Proyecto

- **Desarrolladores**:
  - *Joaquín Kuster* (joaquinkuster3000@gmail.com)
  - *Martínez Lázaro Ezequiel* (lazamartinez1999@gmail.com) 

- **Cliente**:
  - Taller de Alineación y Balanceo “Lambert”

---

## Tecnologías Utilizadas

### Backend
- **Laravel**: Framework PHP utilizado para el desarrollo del backend. Proporciona una estructura robusta y escalable para la aplicación.
- **Blade**: Motor de plantillas de Laravel que se ejecuta en el **lado del servidor**. Permite crear vistas dinámicas y reutilizables.

### Base de Datos
- **MySQL**: Base de datos relacional utilizada para almacenar la información del sistema (clientes, vehículos, servicios, turnos, etc.).

### Frontend
- **Bootstrap**: Framework CSS utilizado para diseñar interfaces responsivas y modernas.
- **HTML5 y CSS3**: Para la estructura y estilos de las páginas web.
- **JavaScript**: Para la interactividad del lado del cliente.

---

## Requisitos del Sistema

### Requisitos Funcionales

#### Iteración 1:
1. **CU-01: Registrar cuenta**: Permite a los clientes registrarse en el sistema.
2. **CU-02: Modificar perfil**: Permite a los clientes actualizar sus datos personales.
3. **CU-03: Iniciar sesión**: Permite a los usuarios acceder al sistema.
4. **CU-04: Cerrar sesión**: Permite a los usuarios cerrar sesión de manera segura.
5. **CU-05: Dar de alta vehículo**: Permite a los clientes registrar sus vehículos.
6. **CU-06: Modificar vehículo**: Permite a los clientes actualizar la información de sus vehículos.
7. **CU-07: Dar de baja vehículo**: Permite a los clientes eliminar vehículos registrados.
8. **CU-08: Consultar vehículo**: Permite a los clientes ver la información de sus vehículos.
9. **CU-09: Consultar servicio**: Permite a los clientes ver los servicios disponibles.

#### Iteración 2:
1. **CU-10: Dar de alta servicio**: Permite al administrador agregar nuevos servicios.
2. **CU-11: Modificar servicio**: Permite al administrador editar los servicios existentes.
3. **CU-12: Eliminar servicio**: Permite al administrador eliminar servicios.
4. **CU-13: Reservar turno**: Permite a los clientes reservar turnos para los servicios.
5. **CU-14: Cancelar turno**: Permite a los clientes o administradores cancelar turnos.
6. **CU-15: Modificar turno**: Permite a los clientes modificar turnos reservados.
7. **CU-16: Consultar turno**: Permite a los clientes y administradores ver los turnos programados.

### Requisitos No Funcionales
1. **Responsividad**: El sistema debe ser compatible con dispositivos móviles, tablets y computadoras.
2. **Cifrado de contraseñas**: Las contraseñas deben almacenarse de manera segura.
3. **Límite de espera de 4 min**: El sistema rechazará solicitudes que no reciban respuesta en 4 minutos.
4. **Respaldo en la nube**: La información debe almacenarse en la nube para evitar pérdidas de datos.

---

## Instrucciones para Ejecutar el Proyecto

### Requisitos Previos
- **PHP** (versión 8.0 o superior).
- **Composer** (gestor de dependencias de PHP).
- **MySQL** (base de datos).
- **Node.js** (opcional, para compilar assets).

### Pasos para Configurar el Proyecto

1. **Clonar el Repositorio**:
   ```bash
   git clone https://github.com/joaquinkuster/talllerlambert.git 
   cd tallerlambert
   ```

2. **Instalar Dependencias**:
   ```bash
   composer install
   npm install
   ```

3. **Configurar el Archivo .env**:
   - Copiar el archivo `.env.example` y renombrarlo a `.env`.
   - Configurar las credenciales de la base de datos:
     ```env
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=tallerlamber
     DB_USERNAME=root
     DB_PASSWORD=tu_contraseña
     ```

4. **Ejecutar Migraciones y Seeders**:
   - Crear la base de datos `tallerlamber` en MySQL.
   - Ejecutar las migraciones y el seeder para crear el administrador:
     ```bash
     php artisan migrate --seed
     ```

5. **Ejecutar el Servidor**:
   ```bash
   php artisan serve
   ```

6. **Acceder al Sistema**:
   - Abrir el navegador y visitar [http://localhost:8000](http://localhost:8000).
   - Iniciar sesión con las credenciales del administrador:
     - **DNI**: `12345678`
     - **Contraseña**: `12345a`
