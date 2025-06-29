<?php 
    require_once('internal/model.php');

    class Detalles_zapatos_model extends Model {
        public function __construct(&$connection) {
            parent::__construct(
                "detalles_zapatos",
                $connection,
            );
        }
    }
?>