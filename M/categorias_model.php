<?php 
namespace Assets\Model {
	// Definición del modelo de categorias
    require_once('internal/model/model.php');

	use Vendor\Model\Model;
	function Categorias_model(&$db_connection) {
		return new Model(
		[
			'table_name' => 'categorias',
			'fields' => [
				'Id' => [
					'primary_key' => 1,
					'auto_set' => 1,
				],
				'Descripcion' => 1,
			]
		],
		$db_connection);
	}
}
?>