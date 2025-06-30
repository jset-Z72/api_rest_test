<?php
    require_once('get_crud_queries/get_queries.php');

    class Model {
        private $connection;
        private $table_map;

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

                // Get templates for prepare queries

                echo '<pre>';
                echo print_r($queries);
                echo '</pre>';
                // Prepare CRUD queries
                $this->select_query = $this->connection->prepare($queries['select']);
                $this->update_query = $this->connection->prepare($queries['update']);
                $this->create_query = $this->connection->prepare($queries['insert']);
                $this->delete_query = $this->connection->prepare($queries['delete']);

                $this->table_map = $table_map;

            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }

        // Crud functions
        public function Select(?callable $where = null) {
            // Excecute SELECT query to table.
            // $where is a closure for filter data
            // after query
            $this->select_query->execute();
            $data = $this->select_query->fetchAll(PDO::FETCH_ASSOC);
            if(isset($where)){
                $data = array_filter($data, $where);
            }
            return $data;
        }

        public function Create($data) {
            foreach($data as $key => $value){
                $this->create_query->bindValue(':'.$key, $value);
            }
            $this->create_query->execute($data);
            return $data;
        }

        public function Update($data){
            foreach($data as $key => $value){
                $this->update_query->bindValue(':'.$key, $value);
            }
            $this->update_query->execute($data);
            return $data;
        }
        
        public function Delete($data){
            foreach($data as $key => $value){
                $this->delete_query->bindValue(':'.$key, $value);
            }
            $this->delete_query->execute($data);
            return $data;
        }
    }
?>