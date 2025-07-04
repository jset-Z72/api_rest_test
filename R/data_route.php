<?php
    // El logger y la conexión son proveidos por el init.php
    // las variables globales serían:
    // $log => registros de logs
    // $db_connection => conexión a la base de datos
    // $router => enrutador

    require_once('./C/init.php');
    use Assets\Controller\Data_controller;

    // Creación del controlador
    $data_controller = new Data_controller($db_connection);
    
    // Ruta para Select all
    $router->attach_endpoint('GET', '/data',
        [$data_controller, 'all'],
        'Vendor\\Route\\__core__\\default_response_converter_json'
    );

    // Ruta para Select one
    $router->attach_endpoint('GET', '/data/:ci',
        [$data_controller, 'one'],
        'Vendor\\Route\\__core__\\default_response_converter_json'
    );

    // Ruta para Create one
    $router->attach_endpoint('POST', '/data',
        [$data_controller, 'create'],
        'Vendor\\Route\\__core__\\default_response_converter_json',
        'Vendor\\Route\\__core__\\default_request_converter_json'
    );
    
    // Ruta para actualizar
    $router->attach_endpoint('PUT', '/data/:ci',
        [$data_controller, 'update'],
        'Vendor\\Route\\__core__\\default_response_converter_json',
        'Vendor\\Route\\__core__\\default_request_converter_json'
    );

    // Ruta para eliminar un registro
    $router->attach_endpoint('DELETE', '/data/:ci',
        [$data_controller, 'delete'],
        'Vendor\\Route\\__core__\\default_response_converter_json',
    )
?>