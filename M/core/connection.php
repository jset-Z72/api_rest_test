<?php

    class Connection extends PDO {

        private $driver;
        private $host;
        private $port;
        private $user;
        private $password;
        private $database;

        public function __construct(array $DSN = [
            'DB_DRIVER' => 'mysql',
            'DB_HOST' => 'localhost',
            'DB_PORT' => '3306',
            'DB_USER' => 'root',
            'DB_PASS' => '',
            'DB_NAME' => ''
        ]) {
            // Constructor
            $this->driver = $DSN['DB_DRIVER'];
            $this->host = $DSN['DB_HOST'];
            $this->port = $DSN['DB_PORT'];
            $this->password = $DSN['DB_PASS'];
            $this->database = $DSN['DB_NAME'];
            $this->user = $DSN['DB_USER'];

            $dsn = $this->driver.":host=".$this->host.";port=".$this->port.";dbname=".$this->database.";";

            try {
                parent::__construct($dsn, $this->user, $this->password);
                $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $err) {
                echo $err->getMessage();
            }
        }

        public function conectar(){

            $hostDB = "mysql:host=".$this->host.";dbname=".$this->database.";";

            try{

                $connection = new PDO($hostDB,$this->user,$this->password);
                $connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
                return $connection;

            } catch(PDOException $e){

                die("ERROR: ".$e->getMessage());

            }

        }

    }

?>
