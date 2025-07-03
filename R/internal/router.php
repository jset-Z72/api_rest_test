<?php
namespace Vendor\Route\__base__ {
    require_once(__DIR__ . "/../core/endpoint_utils.php");
    require_once(__DIR__ . "/request_utils.php");

    use \Exception;
    use function Vendor\Route\__core__\get_client_endpoint;
    use function Vendor\Route\__core__\get_endpoint_pattern;

    class Router {

        public function __construct($file_path, &$log) {
            $this->file_path = $file_path;
            $this->logger = $log;
        }

        private $logger;
        private $file_path;
        private $attached_endpoints = array();
        /* $attached_endpoints = [
         *     $method => [
         *         [
         *             'endpoint_pattern' => RegExp $,
         *             'controller' => callable $,
         *             'body_request_converter' => callable $,
         *             'body_response_coverter' => callable $
         *         ],
         *         ...
         *     ],
         *     ...
         * ]
         */

        public function attach_endpoint(
            $method,
            $endpoint, 
            callable $controller,
            callable $body_response_converter,
            ?callable $body_request_converter = null,
        ) {
            // Enruta un nuevo endpoint al controlador del parámetro,
            // para que pueda ser escuchado al ejecutar el handle_request
            $log = $this->logger;
            
            // Comprueba que el $method sea un método http válido

            $method = strtoupper($method);
            try {
                if(in_array($method, [
                    'GET',
                    'POST',
                    'PUT',
                    'DELETE',
                    'PATCH',
                    'HEAD',
                    'OPTIONS',
                    'CONNECT', // Usado para tunelización HTTP
                    'TRACE',    // Usado para debugging de proxies
                ], true)
                ) {
                    $endpoint_pattern = get_endpoint_pattern($endpoint);
                    $endpoint_data = [
                        'endpoint_pattern' => $endpoint_pattern,
                        'controller' => $controller,
                        'body_request_converter' => $body_request_converter,
                        'body_response_converter' => $body_response_converter,
                    ];
                    if(!isset($this->attached_endpoints[$method])){
                        $this->attached_endpoints[$method] = array();
                    }
                    $this->attached_endpoints[$method][] = $endpoint_data;
                    $log->route('info',
                        "New endpoint created: method => $method endpoint => $endpoint"
                    );
                } else {
                    throw new Exception("Invalid HTTP method: $method in endpoint: $endpoint");
                }
            } catch (Exception $e) {
                $log->route('error', $e->getMessage());
            }
        }

        public function handle_request() {
            // Procesa la petición http llegada
            $log = &$this->logger;
            $response = [
                'origin' => 'Router: handle_request',
                'status' => 200,
                'body' => 'Default message returned',
            ];
            try {
                // Obtiene el request, el endpoint y el method
                $method = $_SERVER['REQUEST_METHOD'];
                $client_endpoint = get_client_endpoint($_SERVER['REQUEST_URI'], $this->file_path);
                if($client_endpoint === '')
                    $client_endpoint = '/';

                // envía el request al primer controlador que coincida
                // con el $client_endpoint enviado, sin ningún endpoint_pattern 
                // coincide, se lanza una excepción. Se recomienda cuidado al
                // crear los endpoint patterns, ya que se podrían causar conflictos entre
                // ellos si son muy parecidos.
                if(isset($this->attached_endpoints[$method])){
                    foreach($this->attached_endpoints[$method] as $endpoint_data){

                        if(preg_match($endpoint_data['endpoint_pattern'], $client_endpoint, $uri_params)){
                            // Genera la petición del cliente
                            $request = get_request_data($log, $endpoint_data['body_request_converter']);
                            $request['endpoint_params'] = $uri_params;

                            // Ejecuta el controlador
                            $endpoint_data['controller']($request, $response);

                            // Envía la respuesta
                            send_response($log, $response, $endpoint_data['body_response_converter']);
                            return;
                        }
                    }
                    // Si el código llega a esta parte, significa que ninguna ruta estuvo asociada,
                    // y por ende el usuario realizó mal la petición, o no hay rutas disponibles
                }

                $response['status'] = 404;
                $response['body'] = "404\nNinguna respuesta para la petición $method ".$_SERVER['REQUEST_URI'];

                send_response($log, $response,
                    function ($body) {
                        return [
                            'content_type' => 'text/plain',
                            'body' => $body,
                        ];
                    }
                );
            } catch (Exception $e) {
                $log->route('error', $e->getMessage());
                $response['status'] = 500;
                $response['body'] = "<h1>500</h1><p>Ha ocurrido un error en el servidor! Contacte con su administrador.</p>";

                send_response($log, $response,
                    function ($body){
                        return [
                            'content_type' => 'text/html',
                            'body' => $body,
                        ];
                    }
                );
            }
        }
    }
}
?>