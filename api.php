<?php

    // Generación de variables de entorno
    $env = parse_ini_file('./env.ini', true);

    // Importación y creación del logger
    require_once('./core/logger.php');
    $log = new Vendor\Logger($env['LOG']);

    // Carga los factories de los modelos, y la conexión a la base de datos
    require_once('./M/init.php');
    use Vendor\Model\Connection;
    try {
        $db_connection = new Connection($log, $env['DSN']);
    } catch (Exception $e) {
        $log->app('error', $e->getMessage());
        exit(1);
    }

    // Importación de las rutas
    // En en R/init.php se crea el enrutador
    // y se enruta los controladores
    try {
        $router = null;
        require_once('./R/init.php');
    } catch (Exception $e) {
        $log->app('error', $e->getMessage());
        exit(1);
    }

    // Procesa la petición HTTP
    $log->app('info', 'Corriendo app desde '.$_SERVER['SCRIPT_NAME']);
    $router->handle_request();

?>