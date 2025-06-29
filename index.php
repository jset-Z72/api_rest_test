<?php
    // Variables globales
    $env = parse_ini_file('./env.ini', true);

    require_once('M/init.php');
    /* Obtiene todo del modelo
     * adquiere los archivos de modelo correspondientes,
     * adquiere las funciones core/utils 
     * adquiere el constructor de conección
    */
    
    // echo '<pre>'; print_r($env); echo '</pre>';
    /*echo '<pre>'; print_r($Detalles_zapatos_model->Select(
        function ($value) { return $value['Id'] == 12; }
    )); echo '</pre>';*/
?>