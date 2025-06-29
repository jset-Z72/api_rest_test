<?php
    abstract class Model {
        protected $connection;
        protected $table;

        protected $select_query;
        protected $update_query;
        protected $create_query;
        protected $delete_query;

        public function __construct ($table, &$connection) {
            $this->table = $table;
            $this->connection = $connection;

            $this->select_query = $this->connection->prepare("SELECT * FROM $this->table;");
            // $this->update_query = $this->connection->prepare("SELECT * FROM $this->table;");
            // $this->create_query = $this->connection->prepare("INSERT INTO * FROM $this->table;");
            // $this->delete_query = $this->connection->prepare("SELECT * FROM $this->table;");
        }

        public function Select($where) {
            //
            $this->select_query->execute();
            $data = $this->select_query->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }
    }
?>