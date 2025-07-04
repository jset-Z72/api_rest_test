<?php
    // $env_dsn que contiene el dsn para la conexión
    // $logger que tiene la dirección para gestión de logs
    // $import_models que contiene los modelos a importar

    // Carga la clase de conección
    require_once(__DIR__ . '/internal/model/connection.php');
    // Carga los modelos
    foreach(glob(__DIR__ . '/*_model.php') as $dir){
        require_once($dir);
    }
?>