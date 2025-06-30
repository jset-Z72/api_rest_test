<?php
    // Variables globales
    $env = parse_ini_file('./env.ini', true);

    // Cargar el logger
    //require_once('core/logger.php');
    //$log = new Logger($env['LOG']);

    require_once('M/init.php');
    /* Obtiene todo del modelo
     * adquiere los archivos de modelo correspondientes,
     * adquiere las funciones core/utils 
     * adquiere el constructor de conección
    */
    
    /*$Detalles_zapatos_model->Create([
        'Cod_zapato' => 'nk001',
        'Cod_color' => 'mr',
        'Descripcion' => 'zapato',
        'Cod_categoria' => 'dm',
        'Cod_clasificacion' => 'cs',
        'Talla' => 121
    ]);*/
    // echo '<pre>'; print_r($env); echo '</pre>';
    echo '<pre>';
    echo print_r($Detalles_zapatos_model->Select());
    echo '</pre>';
?>