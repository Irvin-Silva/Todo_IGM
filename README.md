# Aplicación de Notas "ToDo"

## Objetivo

Desarrollar una aplicación de notas "ToDo" mediante Laravel y Vue.js, siguiendo buenas prácticas de desarrollo.

## Condiciones

- Usar como mínimo Laravel 8.
- Usar como mínimo Vue 2.7.
- Motor de base de datos: MySQL 8 o PostgreSQL 12.

## Requerimientos

- El frontend y el backend deben estar en el mismo proyecto.

### Backend

- Lógica del módulo de notas reutilizable.
- API REST con autenticación mediante personal tokens o JWT (se recomienda Laravel Fortify o Passport).
- Creación, edición, listado y eliminación de notas mediante API y consola (comandos de Artisan).
- El listado de notas debe poder ordenarse por fecha de creación o fecha de vencimiento.
- Migraciones de la base de datos (no archivos SQL).
- Validación de datos.

### Frontend

- Rutas con Vue Router y gestión de estado con Vuex.
- Pantalla de inicio de sesión y registro.
- Pantalla principal de notas.
- Formulario de creación y edición de notas.
- Validación de datos.
- Peticiones AJAX con Axios o Fetch.

### Notas

Cada nota debe contener:

#### Requerido

- Título
- Descripción
- Fecha de creación
- Usuario
- Etiquetas (como categorías o grupos de notas)

#### Opcional al crear la nota

- Fecha de vencimiento
- Imagen

#### Usuario

Cada usuario debe contener:

- Nombre
- Email
- Contraseña

## Setup

Asegúrate de tener PHP 8 y MySQL instalados en tu máquina.

1. Copia `.env.example` a `.env` y cambia la información de la base de datos por la tuya.
2. Abre tu terminal/cmd y ejecuta `composer install` para instalar todos los paquetes relacionados con PHP, luego ejecuta `npm install` para los paquetes relacionados con JavaScript.
3. Ejecuta `php artisan migrate` (esto creará las tablas requeridas por la aplicación en tu base de datos) y `php artisan db:seed` (esto insertará datos de ejemplo en las tablas creadas).
4. Luego, ejecuta `npm run dev` (esto compila y construye nuestro JavaScript).
5. Abre otra terminal/cmd y ejecuta `php artisan serve` (esto inicia el servidor de Laravel para ejecutar la aplicación).
6. Finalmente, dirígete a tu navegador e ingresa la dirección de tu servidor Laravel o escribe: `http://localhost:8000`.


## Licencia

Este proyecto está bajo la Licencia MIT. Consulta el archivo `LICENSE` para más detalles.
