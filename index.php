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
        'Cod_zapato' => 'nk' . random_int(111,999),
        'Cod_color' => 'mr',
        'Descripcion' => 'zapato pecuecoso',
        'Cod_categoria' => 'dm',
        'Cod_clasificacion' => 'cs',
        'Talla' => 56
    ]);*/
    /*$Detalles_zapatos_model->Update([
        'Id' => 1,
        'Cod_zapato' => 'fino',
        'Cod_color' => 'rjj',
        'Descripcion' => 'zapato',
        'Cod_categoria' => 'cb',
        'Cod_clasificacion' => 'dp',
        'Talla' => random_int(10,300)
    ]);*/
    // $Detalles_zapatos_model->Delete([ 'Id' => 1 ]);
    // echo '<pre>'; print_r($env); echo '</pre>';
    echo '<pre>';
    echo print_r($Detalles_zapatos_model->Select(/*function($v) { return $v['Cod_color']=='mr'; }*/));
    echo '</pre>';
?>