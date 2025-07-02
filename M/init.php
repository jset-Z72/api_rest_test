<?php function initModels(&$logger, &$env_dsn)
{
    // $env presente en root/index.php
    require_once('internal/connection.php');

    // Generando conexión a la base de datos
    $db_connection = new Connection($env_dsn, $logger);

    // Carga los modelos
    foreach(glob(__DIR__ . '/*_model.php') as $dir) {
        require_once($dir);
    }
}
?>