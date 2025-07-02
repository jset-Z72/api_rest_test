<?php
    // $env_dsn que contiene el dsn para la conexión
    // $logger que tiene la dirección para gestión de logs
    // $import_models que contiene los modelos a importar

    require_once('internal/model/connection.php');
    use Vendor\Model\__base__\Connection;

    // Generando conexión a la base de datos
    $db_connection = new Connection($env_dsn, $logger);

    // Carga los modelos
    foreach($mport_models as $model_name){
        require_once(__DIR__ . '/' . strtolower($model_name) . '.php');
    }
?>