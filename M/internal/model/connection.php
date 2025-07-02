<?php
namespace Vendor\Model\__base__ {
    use \PDO;
    use \PDOException;
    use function Vendor\Model\__core__\get_dsn;

    class Connection extends PDO {

        // private $driver;
        // private $host;
        // private $port;
        // private $user;
        // private $password;
        // private $database;
        public $log;

        public function __construct(array $DSN = [
            'DB_DRIVER' => 'mysql',
            'DB_HOST' => 'localhost',
            'DB_PORT' => '3306',
            'DB_USER' => 'root',
            'DB_PASS' => '',
            'DB_NAME' => ''
        ], &$log) {
            // Constructor

            $dsn = get_dsn($DSN);
            $this->log = &$log;

            try {
                parent::__construct($dsn);
                $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $log->model('info', 'successful connection to DSN:'.$dsn);
            } catch (PDOException $err) {
                $log->model('error',$err->getMessage());
            }
        }
    }
}
?>