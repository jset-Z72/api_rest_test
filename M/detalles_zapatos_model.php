<?php 
namespace Assets\Model {
	// Definición del modelo de detalles_zapatos
    require_once('internal/model/model.php');

	use Vendor\Model\Model;
	function Detalles_zapatos_model(&$db_connection) {
		return new Model(
		[
			'table_name' => 'detalles_zapatos',
			'fields' => [
				'Id' => [
					'primary_key' => 1,
					'auto_set' => 1,
				],
				'Cod_zapato' => 1,
				'Cod_color' => 1,
				'Descripcion' => 1,
				'Cod_categoria' => 1,
				'Cod_clasificacion' => 1,
				'Talla' => 1,
				'Activo' => [
					"status_field" => 1,
				],
			]
		],
		$db_connection);
	}
}
?>