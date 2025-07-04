<?php
    // El logger y la conexión son proveidos por el init.php
    // las variables globales serían:
    // $log => registros de logs
    // $db_connection => conexión a la base de datos
    // $router => enrutador

    require_once('./C/init.php');
    use Assets\Controller\Colores_controller;

    // Creación del controlador
    $colores_controller = new Colores_controller($db_connection);
    
    // Ruta para Select all
    $router->attach_endpoint('GET', '/colores',
        [$colores_controller, 'all'],
        'Vendor\\Route\\__core__\\default_response_converter_json'
    );

    // Ruta para Select one
    $router->attach_endpoint('GET', '/colores/:Id',
        [$colores_controller, 'one'],
        'Vendor\\Route\\__core__\\default_response_converter_json'
    );

    // Ruta para Create one
    $router->attach_endpoint('POST', '/colores',
        [$colores_controller, 'create'],
        'Vendor\\Route\\__core__\\default_response_converter_json',
        'Vendor\\Route\\__core__\\default_request_converter_json'
    );
    
    // Ruta para actualizar
    $router->attach_endpoint('PUT', '/colores/:Id',
        [$colores_controller, 'update'],
        'Vendor\\Route\\__core__\\default_response_converter_json',
        'Vendor\\Route\\__core__\\default_request_converter_json'
    );

    // Ruta para eliminar un registro
    $router->attach_endpoint('DELETE', '/colores/:Id',
        [$colores_controller, 'delete'],
        'Vendor\\Route\\__core__\\default_response_converter_json',
    )
?>