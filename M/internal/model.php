<?php
    require_once(__DIR__ . '/../core/utils.php');

    class Model {
        private $connection;
        private $table_map;

        private $select_query;
        private $update_query;
        private $create_query;
        private $delete_query;

        

        public function __construct ($table_map, &$connection) {
            try {
                // for prepare queries
                $pk_field = '';
                $str_update_set_fields = '';    // (:field_1, :field_2, ...)
                $str_update_fields = '';        // ("field_1", "field_2", ...)
                $str_select_fields = '';        // ("primary_key", "auto_set_value_1", "field_1", ...)

                // Validation and setter prepare queries
                $pk_avaiable = false;
                validate_name_table($table_map['table_name']);
                foreach($table_map['fields'] as $key => $value){
                    validate_name_table($key);

                    // Validate primary key
                    if(isset($value['primary_key'])){
                        if($pk_avaiable){
                            throw new Exception("Ya existe una primary key");
                        }

                        $pk_avaiable = true;
                        $pk_field = $key;
                    }

                    // Set variables for prepare queries
                    $str_select_fields = $str_select_fields . '"' . $key . '", ';
                    if(!isset($value['auto_set'])){
                        $str_update_set_fields = $str_update_set_fields . ':' . $key . ', ';
                        if(!($pk_field === $key)){
                            $str_update_fields = $str_update_fields . '"' . $key . '", ';
                        }
                    }
                }

                // Add connection
                $this->connection = $connection;

                // Get templates for prepare queries
                $table_name = $table_map['table_name'];
                // Prepare CRUD queries
                // echo "<pre>select: ".$str_select_fields."\n</pre>";
                echo "<pre>update_fields: ".$str_update_fields."\n</pre>";
                echo "<pre>update_set_fields: ".$str_update_set_fields."\n</pre>";

                $this->select_query = $this->connection->prepare(
                    'SELECT ' .mb_substr($str_select_fields, 0, -2). 'FROM "' .$table_name. '";'
                );

                // $this->update_query = $this->connection->prepare('UPDATE "$table_name" SET ;');

                $this->create_query = $this->connection->prepare(
                    'INSERT INTO "' .$table_name. '" (' .mb_substr($str_update_fields, 0, -2). ') '.
                    'VALUES (' .mb_substr($str_update_set_fields, 0, -2). ');'
                );

                // $this->delete_query = $this->connection->prepare("SELECT * FROM $this->table;);

            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }

        // Crud functions
        public function Select(callable $where) {
            // Excecute SELECT query to table.
            // $where is a closure for filter data
            // after query
            $this->select_query->execute();
            $data = $this->select_query->fetchAll(PDO::FETCH_ASSOC);
            if(isset($where)){
                $data = array_filter($data, $where, ARRAY_FILTER_USE_BOTH);
            }
            return $data;
        }

        public function Create($data) {
            $this->select_query->execute($data);
            return $data;
        }
    }
?>