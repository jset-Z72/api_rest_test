<?php
    // El logger y la conexión son proveidos por el init.php
    // las variables globales serían:
    // $log => registros de logs
    // $db_connection => conexión a la base de datos
    // $router => enrutador

    require_once('./C/init.php');
    use Assets\Controller\Detalles_zapatos_controller;

    // Creación del controlador
    $detalles_zapatos_controller = new Detalles_zapatos_controller($db_connection);
    
    // Ruta para Select all
    $router->attach_endpoint('GET', '/detalles_zapatos',
        [$detalles_zapatos_controller, 'all'],
        'Vendor\\Route\\__core__\\default_response_converter_json'
    );

    // Ruta para Select one
    $router->attach_endpoint('GET', '/detalles_zapatos/:Id',
        [$detalles_zapatos_controller, 'one'],
        'Vendor\\Route\\__core__\\default_response_converter_json'
    );

    // Ruta para Create one
    $router->attach_endpoint('POST', '/detalles_zapatos',
        [$detalles_zapatos_controller, 'create'],
        'Vendor\\Route\\__core__\\default_response_converter_json',
        'Vendor\\Route\\__core__\\default_request_converter_json'
    );
    
    // Ruta para actualizar
    $router->attach_endpoint('PUT', '/detalles_zapatos/:Id',
        [$detalles_zapatos_controller, 'update'],
        'Vendor\\Route\\__core__\\default_response_converter_json',
        'Vendor\\Route\\__core__\\default_request_converter_json'
    );

    // Ruta para eliminar un registro
    $router->attach_endpoint('DELETE', '/detalles_zapatos/:Id',
        [$detalles_zapatos_controller, 'delete'],
        'Vendor\\Route\\__core__\\default_response_converter_json',
    )
?>