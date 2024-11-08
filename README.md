# first-project-cake
Este proyecto es parte de mi estudio para realizar una prueba técnica con el framework de PHP
llamado Cake. También hacemos uso de Materialize CSS para la parte visual y Datatable Js.

La siguiente documentación es obtenida desde el sitio oficial de [CakePHP](https://book.cakephp.org/4/en/index.html) para la **version 4.**

Requerimientos:

- HTTP Server.  Por ejemplo: **Apache**.
- Version **PHP 7.4** hasta  **8.2**.

CakePHP DB soportadas:

- MySQL (5.6 or higher)
- MariaDB (5.6 or higher)
- PostgreSQL (9.4 or higher)
- Microsoft SQL Server (2012 or higher)
- SQLite 3

Partiendo de que tenemos todo instalado (Composer, PHP, Mysql, etc) y siendo que vamos a descargar este 
repositorio, vamos a ejecutar el siguiente comando para hacer la instalación de los paquetes.

  ```
      Composer install
  ```

Luego, levantaremos nuestro servidor local ejecutando lo siguiente

  ```
      bin/cake server
  ```
Tu aplicación estará disponible en http://host:port

# DB MySQL

El script que contiene la creación tanto de la DB como de las tablas (roles y usuarios) se encuentra en la carpeta **DB** ubicada en la raíz 
del proyecto.

Nota: Si requieres de alguna configuración extra, puedes hacerla desde config/app_local.php dentro de 
Datasource y dentro de app.php viene la configuración de la DB a usar (config de driver, timezone, etc) de igual manera en Datasource.

# Probar proyecto
Después de haber cargado nuestra DB ejecuta el comando para levantar el servidor y podremos probar nuestro CRUD.

Nota: Para ver nuestro Admin Dashboard, coloca la siguiente url con el host y puerto que te generó

  ```
      http://localhost:8765/roles
  ```




