<?php
namespace Assets\Controller {

    use Exception;

    // Controlador para el modelo clasificacion
    require_once('./M/init.php');
    use function Assets\Model\Clasificacion_model;

    class Clasificacion_controller {

        private $db_connection;
        
        public function __construct(&$db_connection){
            $this->db_connection = $db_connection;
        }

        function all($request, &$response){
            // Hace un select para todos los elementos de la tabla
            // Obtiene la dirección del logger
            $log = $this->db_connection->log;
            try {
                $clasificacion_controller = Clasificacion_model($this->db_connection);
                $response['body'] = array( 'data' => $clasificacion_controller->Select());
                $response['status'] = 200;

            } catch (Exception $e) {
                $log->controller('error', $e->getMessage());
                $response['status'] = 500;
                $response['body'] = [ 'message' => 'Error en el servidor! Contacte con su administrador.' ];

            } finally {
                $response['origin'] = "Controller: ".__METHOD__;
            }
        }

        function one($request, &$response){
            // Hace un select one para obtener un solo registro en función del pk
            // Obtiene la dirección del logger
            $log = $this->db_connection->log;
            try {
                $clasificacion_controller = Clasificacion_model($this->db_connection);
                $data_in = $clasificacion_controller->Select(
                    function($data) use ($request){
                        return $data['ci'] == $request['endpoint_params']['ci'];
                    }
                );
                if(empty($data_in)){
                    $response['status'] = 404;
                    $response['body'] = array('message' => 'Registro no encontrado');
                } else {
                    $response['status'] = 200;
                    $response['body'] = array('message' => 'Registro encontrado con exito');
                    foreach($data_in as $ket => $data){
                        $response['body']['data'] = $data;
                    }
                }

            } catch (Exception $e) {
                $log->controller('error', $e->getMessage());
                $response['status'] = 500;
                $response['body'] = [ 'message' => 'Error en el servidor! Contacte con su administrador.' ];

            } finally {
                $response['origin'] = "Controller: ".__METHOD__;
            }
        }
        
        function create($request, &$response){
            // Actualiza los datos e un registro
            // Obtiene la dirección del logger
            $log = $this->db_connection->log;
            try {
                $clasificacion_controller = Clasificacion_model($this->db_connection);
                $data_reg = $request['body'];
                $result = $clasificacion_controller->Create($data_reg);
                if(!$result){
                    $response['status'] = 400;
                    $response['body'] = array('message' => 'Malos datos de entrada');
                } else {
                    $response['status'] = 200;
                    $response['body'] = array('message' => 'Registro creado con exito');
                    $response['body']['data'] = $data_reg;
                }

            } catch (Exception $e) {
                $log->controller('error', $e->getMessage());
                $response['status'] = 500;
                $response['body'] = [ 'message' => 'Error en el servidor! Contacte con su administrador.' ];

            } finally {
                $response['origin'] = "Controller: ".__METHOD__;
            }
        }
        
        function update($request, &$response){
            // Hace un update one para en función del pk
            // Obtiene la dirección del logger
            $log = $this->db_connection->log;
            try {
                $clasificacion_controller = Clasificacion_model($this->db_connection);
                $data_in = array_merge($request['body'], [ 'ci' => $request['endpoint_params']['ci'] ]);
                $result = $clasificacion_controller->Update($data_in);

                if(!$result){
                    $response['status'] = 403;
                    $response['body'] = array('message' => 'Registro no se pudo actualizar');
                } else {
                    $response['status'] = 200;
                    $response['body'] = array('message' => 'Registro actualizado con exito');
                    foreach($data_in as $ket => $data){
                        $response['body']['data'] = $data;
                    }
                }

            } catch (Exception $e) {
                $log->controller('error', $e->getMessage());
                $response['status'] = 500;
                $response['body'] = [ 'message' => 'Error en el servidor! Contacte con su administrador.' ];

            } finally {
                $response['origin'] = "Controller: ".__METHOD__;
            }
        }
        
        function delete($request, &$response){
            // elimina unrequistro
            // Obtiene la dirección del logger
            $log = $this->db_connection->log;
            try {
                $clasificacion_controller = Clasificacion_model($this->db_connection);
                $pk = $request['endpoint_params']['ci'];
                $result = $clasificacion_controller->Delete($pk);
                if(!$result){
                    $response['status'] = 403;
                    $response['body'] = array('message' => 'No se pudo eliminar el registro');
                } else {
                    $response['status'] = 200;
                    $response['body'] = array('message' => 'Registro eliminado con exito');
                    $response['body']['data'] = array('ci' => $pk);
                }

            } catch (Exception $e) {
                $log->controller('error', $e->getMessage());
                $response['status'] = 500;
                $response['body'] = [ 'message' => 'Error en el servidor! Contacte con su administrador.' ];

            } finally {
                $response['origin'] = "Controller: ".__METHOD__;
            }
        }
    }
}
?>