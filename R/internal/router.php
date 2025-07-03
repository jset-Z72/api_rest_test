<?php
namespace Vendor\Route\__base__ {
    require_once(__DIR__ . "/../core/endpoint_utils.php");

    use Vendor\Model\__core__;
    use Exception;

    use const Dom\NOT_FOUND_ERR;

    use function Vendor\Route\__core__\get_client_endpoint;

    class Router {

        public function __contruct($file_path, &$log) {
            // $path es el archivo principal de donde se trabajan las rutas; por defecto es el index.php
        }

        private $logger;
        private $file_path;
        private $attached_endpoints;
        /* $attached_endpoints = [
         *     $method => [
         *         [
         *             'endpoint_pattern' => $,
         *             'controller' => $,
         *             '' => ''
         *         ],
         *         ...
         *     ],
         *     ...
         * ]
         */

        public function attach_endpoint($method, $endpoint, $controller) {
            // Enruta un nuevo endpoint al controlador del parámetro,
            // para que pueda ser escuchado al ejecutar el handle_request
        }

        public function handle_request() {
            // Procesa la petición http llegada
            $log = &$this->logger;
            $response = [
                'content_type' => 'application/json',
                'status' => 500,
                'body' => [
                    'message' => 'Error en el servidor, contacte con su administrador',
                    'data' => array(),
                ],
            ];
            try {
                // Obtiene el request, el endpoint y el method
                $method = $_SERVER['REQUEST_METHOD'];
                $client_endpoint = get_client_endpoint($_SERVER['REQUEST_URI'], $this->file_path);

                // envía el request al primer controlador que coincida
                // con el $client_endpoint enviado, sin ningún endpoint_pattern 
                // coincide, se lanza una excepción. Se recomienda cuidado al
                // crear los endpoint patterns, ya que se podrían causar conflictos entre
                // ellos si son muy parecidos.
                if(isset($this->attached_endpoints[$method])){
                    foreach($this->attached_endpoints[$method] as $endpoint_data){
                        if(preg_match($endpoint_data['endpoint_pattern'], $client_endpoint)){
                            $request = get_request();
                            $endpoint_data['controller']($request, $response);
                            send_response($response);
                            break;
                        }
                    }
                    // Si el código llega a esta parte, significa que ninguna ruta estuvo asociada,
                    // y por ende el usuario realizó mal la petición, o no hay rutas disponibles
                }

                $response['status'] = 404;
                $response['content_type'] = 'text/plain';
                $response['body'] = "404\nNinguna respuesta para las petición $method ".$_SERVER['REQUEST_URI'];
                send_response($respose);
            } catch (Exception $e) {
                $log->route('error', $e->getMessage());
            } finally {
                send_response($response);
            }

        }
    }
}
?>