<?php
    // Prueba de las rutas

    // Variables globales
    $env = parse_ini_file('env.ini', true);

    // Importación de dependencias
    require_once('core/logger.php');
    require_once('R/internal/router.php');
    require_once('R/core/default_body_converters.php');

    use Vendor\Logger;
    use vendor\Route\__base__\Router;
    use function Vendor\Route\__core__\default_response_converter_json;

    // Creación del logger
    $log = new Logger($env['LOG']);
    $log->app('info', 'Corriendo app desde '.$_SERVER['SCRIPT_NAME']);
    // echo "Logger funcionando correctamente<br>";

    // Creando una ruta de prueba
    $router = new Router('probe.php', $log);
    // echo "Creación exitosa del enrutador<br>";

    // Creando un controlador de prueba
    function test_controller($req, &$res) {
        if(isset($req['name'])){
            $res['body']['text'] = "Hola ".$req['name']."! ¿cómo estas?";
        }
        $res['body'] = array('text' => "Esto es un mensaje de prueba. Envía tu nombre en la ruta para saludarte!");
    }

    // enrutando el controlador
    $router->attach_endpoint('GET', '/test/:value/:var', 'test_controller',
        "Vendor\\Route\\__core__\\default_response_converter_json"
    );
    // echo "Enrutación exitosa para el endpoint /test<br>";

    // Generación de respuesta
    $router->handle_request();
?>