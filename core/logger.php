<?php
    class Logger {
        private $model_file;
        private $app_file;
        private $route_file;

        public function __construct($files) {
            $this->model_file = file_exists($files['MODELS']) ? $files['MODELS'] : '';
            $this->app_file = file_exists($files['APP']) ? $files['APP'] : '';
            $this->route_file = file_exists($files['ROUTES']) ? $files['ROUTES'] : '';

            foreach($files as $key => $value){
                if(!file_exists($value)){
                    try {
                        file_put_contents($value, '');
                    } catch (Exception $e) {
                        echo $e->getMessage();
                    }
                }
            }
        }

        public function model($level, $msg){
            $fecha = date('Y-m-d H:i:s');
            $log = "[".strtoupper($level)."][" . $fecha . "] " . $msg . "\n";
            file_put_contents($this->model_file, FILE_APPEND | LOCK_EX);
        }

        public function app($level, $msg){
            $fecha = date('Y-m-d H:i:s');
            $log = "[".strtoupper($level)."][" . $fecha . "] " . $msg . "\n";
            file_put_contents($this->app_file, FILE_APPEND | LOCK_EX);
        }

        public function route($level, $msg){
            $fecha = date('Y-m-d H:i:s');
            $log = "[".strtoupper($level)."][" . $fecha . "] " . $msg . "\n";
            file_put_contents($this->route_file, FILE_APPEND | LOCK_EX);
        }
    }
?>