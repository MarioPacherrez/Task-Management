<p align="center"><strong> API - Task Management (Laravel 10)</strong></p>


### REQUISITOS

Antes de comenzar, asegúrate de tener instalados los siguientes programas:

- [PHP](https://www.php.net/) (recomendado: versión 8.2 o superior)
- [Composer](https://getcomposer.org/) (para la gestión de dependencias)
- [Node.js](https://nodejs.org/) (para la gestión de dependencias de frontend si es necesario)
- [Xampp](https://www.apachefriends.org/es/index.html) (opcional: versión 8.2.x o superior, para la administración de los datos (si se usa MySQL) y también te brinda la instalación de la última versión de PHP para Laravel 10)

### PASOS PARA LA INSTALACIÓN Y EJECUCIÓN DEL PROYECTO

1.- Clonar el repositorio que es público: https://github.com/MarioPacherrez/Task-Management.git

2.- Instalar dependencias, para ello ejecutar los comandos: npm install y composer install.

3.- Configurar el archivo .env, copia el archivo .env.example y renómbralo a .env
Luego, abre el archivo .env y configura los parámetros de la base de datos según tu entorno. Asegúrate de tener configurado el DB_CONNECTION, DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME y DB_PASSWORD correctamente.

4.- Generar la clave de la aplicación, Laravel necesita una clave única para la aplicación. Genera esta clave ejecutando: php artisan key:generate

5.- Ejecutar las migraciones con el siguiente comando: php artisan migrate

6.- Iniciar el servidor de desarrollo con el siguiente comando: php artisan serve
El servidor se ejecutará en http://127.0.0.1:8000 de forma predeterminada.

7.- Como en este caso el proyecto tiene pruebas configuradas puedes ejecutar las pruebas con PHPUnit para verificar que todo funcione correctamente con el siguiente comando: php artisan test

8.- API Endpoints, el proyecto tiene las rutas API para el uso y ejecución de las funcionalidades en al archivo routes/api.php, para ello necesitas registrarte ya que se generará un token con el cual puedes hacer uso de las otras API para lo correspondiente al uso de las funcionalidades para Task.

9.- Para probar la autenticación y visualizar las tareas:
- Realiza una solicitud POST a /api/login con las credenciales del usuario ya registrado.
- Usa el token de autenticación para hacer solicitudes autenticadas a otros endpoints, como /api/tasks.

10.- Nota: para este proyecto se hizo uso del Xampp en la versión xampp-windows-x64-8.2.12-0-VS16-installer ya que instalaba el servidor de BD y la versión de PHP necesaria para Laravel 10 que luego se iniciaban estos servicios junto con el proyecto ya levantado.