<?php 
namespace Assets\Model {
	// Definición del modelo de clasificaion
    require_once('internal/model/model.php');

	use Vendor\Model\Model;
	function Clasificacion_model(&$db_connection) {
		return new Model(
		[
			'table_name' => 'clasificacion',
			'fields' => [
				'Id' => [
					'primary_key' => 1,
					'auto_set' => 1,
				],
				'Cod_clasificacion' => 1,
				'Descripcion' => 1,
			]
		],
		$db_connection);
	}
}
?>