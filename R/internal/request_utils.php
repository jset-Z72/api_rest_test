<?php
namespace Vendor\Route\__base__ {

    use \Exception;

    function get_request_data(&$log, ?callable $body_request_converter = null) {
        // Genera el formato y data del request que será
        // pasado al controlador
        try {
            $request = [
                'body' => null,
                'params' => null,
                'endpoint_params' => null,
            ];

            // Obtiene el cuerpo de la solicitud
            $body = file_get_contents('php://input');
            if(isset($body_request_converter)) {
                $body_request_converter($body);
            }

            // Obtiene los argumentos o parámetros pasados en la uri
            $args = !empty($_GET) ? $_GET : array();

            $request['body'] = $body;
            $request['params'] = $args;
            return $request;

        } catch (Exception $e) {
            $log->route('error', $e->getMessage());
        }
    }

    function send_response(&$log, $response, ?callable $body_response_converter) {
        // Envía la respuesta http dado el response
        // el callable $body_converter es para convertir el body de la respuesta
        // a algún formato arbitrario, y también establece el Content-type de la
        // cabezera http

        try {
            ['content_type' => $content_type, 'body' => $body] = $body_response_converter($response['body']);
            http_response_code($response['status']);
            header("Content-Type: $content_type");
            echo $body;
            $log->route('info', 'HTTP response was sent from '.$response['origin']);
        } catch (Exception $e) {
            $log->route('error', $e->getMessage());
        }
    }
}
?>