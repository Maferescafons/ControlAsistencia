Aplicación para llevar el control de asistencia de un listado de empleados, cada persona ingresará al sistema a través de su código de empleado y marcará la entrada, inicio almuerzo, regreso almuerzo y salida.


Para levanar la aplicacion se necesita copiar el contenido del env.example y reemplazar 

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=laravel ->Nombre de la base
DB_USERNAME=root  -> usuario DB
DB_PASSWORD=root  -> contraseña DB


ejecutar los siguientes codigos dentro de una terminal:

npm install
run watch
php artisan serve

El script de la base es el archivo users(1).sql 
