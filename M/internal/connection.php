<?php
    require_once(__DIR__ . '/../core/utils.php');

    class Connection extends PDO {

        // private $driver;
        // private $host;
        // private $port;
        // private $user;
        // private $password;
        // private $database;

        public function __construct(array $DSN = [
            'DB_DRIVER' => 'mysql',
            'DB_HOST' => 'localhost',
            'DB_PORT' => '3306',
            'DB_USER' => 'root',
            'DB_PASS' => '',
            'DB_NAME' => ''
        ]) {
            // Constructor

            $dsn = get_dsn($DSN);

            try {
                parent::__construct($dsn);
                $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $err) {
                echo $err->getMessage();
            }
        }
    }

?>
