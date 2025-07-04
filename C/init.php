<?php
    // Carga todas los controladores
    foreach(glob(__DIR__ . '/*_controller.php') as $dir){
        require_once($dir);
    }
?>