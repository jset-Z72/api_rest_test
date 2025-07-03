<?php
namespace Vendor {
    class Logger {
        private $locates;
        private $log_avaiable;

        public function __construct($files) {
            $this->locates = [
                'models' => file_exists($files['MODELS']) ? $files['MODELS'] : '',
                'app' => file_exists($files['APP']) ? $files['APP'] : '',
                'routes' => file_exists($files['ROUTES']) ? $files['ROUTES'] : '',
            ];

            foreach($files as $key => $value){
                if(!file_exists($value)){
                    try {
                        file_put_contents($value, '');
                    } catch (\Exception $e) {
                        // Define function for register logs
                        // in case error in files
                        $this->log_avaiable = false;
                        echo $e->getMessage();
                        return;
                    }
                }
            }

            // In case of avaiable file logs
            $this->log_avaiable = true;
        }

        // Register log
        private function put_log($locate, $message, $level){
            if($this->log_avaiable){
                file_put_contents($this->locates[$locate], $message, FILE_APPEND | LOCK_EX);
            } elseif ($level == 'error') {
                echo '<pre>',$message,'</pre>',"\n";
            }
        }

        // Functions logs
        public function model($level, $msg){
            $fecha = date('Y-m-d H:i:s');
            $log = "[".strtoupper($level)."][" . $fecha . "] " . $msg . "\n";
            $this->put_log('models', $log, $level);
        }

        public function app($level, $msg){
            $fecha = date('Y-m-d H:i:s');
            $log = "[".strtoupper($level)."][" . $fecha . "] " . $msg . "\n";
            $this->put_log('app', $log, $level);
        }

        public function route($level, $msg){
            $fecha = date('Y-m-d H:i:s');
            $log = "[".strtoupper($level)."][" . $fecha . "] " . $msg . "\n";
            $this->put_log('routes', $log, $level);
        }
    }
}
?>