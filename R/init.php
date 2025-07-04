<?php
    // Carga todas las rutas
    // Variables globales:
    // $log => Logger
    // $db_connection => Conexión a la base de datos
    require_once(__DIR__ . '/core/default_body_converters.php');

    // Crea un nuevo enrutador
    require_once(__DIR__ . '/internal/router.php');
    use Vendor\Route\Router;
    $router = new Router('api.php', $log);

    foreach(glob(__DIR__ . '/*_route.php') as $dir){
        require_once($dir);
    }
?>