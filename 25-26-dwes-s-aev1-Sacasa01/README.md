[![Review Assignment Due Date](https://classroom.github.com/assets/deadline-readme-button-22041afd0340ce965d47ae6ef1cefeee28c7c493a6346c4f15d667ab976d596c.svg)](https://classroom.github.com/a/xmnGiP5S)
# Cómo configurar el proyecto para la AEV2

Para ejecutar el entorno Docker del proyecto sigue estos pasos:

1. Inicia el contenedor ejecutando el archivo `docker-compose.yml` con click derecha en Run.

2. Crea una nueva conexión a la base de datos (mariaDB) usando el puerto `3320`. Importa la base de datos que hay en
   .BBDD_archive

3. Para acceder al contenedor, ejecuta en la terminal del proyecto:
   ```zsh
   docker exec -it servidor_php_aev2 /bin/bash
   ```

4. Dentro del contenedor, navega a la carpeta `public` y ejecuta:
   ```zsh
   php -S 0.0.0.0:8020
   ```

Esto iniciará el servidor PHP en el puerto `8020`.

5. Abre tu navegador y accede a `http://localhost:8020` para ver la aplicación en funcionamiento.

6. Revisa tener PHP 8.3 puesto en PHPStorm.

7. Activar el Debug, recuerda guardar la ruta correcta en:
   Settings -> PHP -> Servers -> Add
    ```zsh
    Host: 0.0.0.0 Port: 8020 Debugger: Xdebug
    ```
   Configurar el path mapping:
    ```zsh
    Directory: [tu carpeta] Absolute path on the server: /www/html
    ```

8. En el [README](./AEV2/README.md) de dentro de AEV2 encontrarás las instrucciones para realizar la AEV2.
