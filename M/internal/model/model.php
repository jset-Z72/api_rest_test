<?php
namespace Vendor\Model {
    require_once('get_crud_queries/get_queries.php');
    use \Exception;
    use \PDO;

    use function Vendor\Model\get_crud_queries\get_queries;
    use function Vendor\Model\get_crud_queries\validate_table_map;

    class Model {
        private $connection;
        private $table_map;
        private $recognized_data;

        private $select_query;
        private $update_query;
        private $create_query;
        private $delete_query;

        

        public function __construct ($table_map, &$connection) {
            try {
            // Validation and recognized mapping
                $queries = get_queries($table_map);

                // Add connection
                $this->connection = $connection;
                $this->recognized_data = validate_table_map($table_map);
                $log = &$connection->log;

                // Get templates for prepare queries

                // echo '<pre>';
                // echo print_r($queries);
                // echo '</pre>';
                // Prepare CRUD queries
                $this->select_query = $this->connection->prepare($queries['select']);
                $this->update_query = $this->connection->prepare($queries['update']);
                $this->create_query = $this->connection->prepare($queries['insert']);
                $this->delete_query = $this->connection->prepare($queries['delete']);

                $this->table_map = $table_map;

            } catch (Exception $e) {
                $log->model('error', $e->getMessage());
            }
        }

        // Crud functions
        public function Select(?callable $where = null) {
            $log = &$this->connection->log;
            try {
                // Excecute SELECT query to table.
                // $where is a closure for filter data
                // after query
                $this->select_query->execute();
                $data = $this->select_query->fetchAll(PDO::FETCH_ASSOC);
                if(isset($where)){
                    $data = array_filter($data, $where);
                }
                return $data;
            } catch (Exception $e) {
                $log->model('error', $e->getMessage());
            }
        }

        public function Create($data) {
            $log = &$this->connection->log;
            try {
                foreach($data as $key => $value){
                        $this->create_query->bindValue(':'.$key, $value);
                    }
                return $this->create_query->execute();
            } catch (Exception $e) {
                $log->model('error', $e->getMessage());
            }
        }

        public function Update($data){
            $log = &$this->connection->log;
            try {
                foreach($data as $key => $value){
                    $this->update_query->bindValue(':'.$key, $value);
                }
                return $this->update_query->execute();
            } catch (Exception $e) {
                $log->model('error', $e->getMessage());
            }
        }
        
        public function Delete($pk){
            $log = &$this->connection->log;
            try {
                $this->delete_query->bindValue(':'.$this->recognized_data['primary_key'], $pk);
                return $this->delete_query->execute();
            } catch (Exception $e) {
                $log->model('error', $e->getMessage());
            }
        }
    }
}
?>