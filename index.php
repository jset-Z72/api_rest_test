<?php
    $env = parse_ini_file('./env.ini', true);
    require_once('./M/core/connection.php');
    require_once('./M/detalles_zapatos.php');

    //phpinfo();
    // echo '<pre>'; print_r($env); echo '</pre>';
    $db_connection = new Connection($env['DSN']);
    $detalles_zapatos_model = new Detalles_zapatos_model($db_connection);
    echo '<pre>'; print_r($detalles_zapatos_model->Select(null)); echo '</pre>';
?>