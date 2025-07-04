<?php 
namespace Assets\Model {
	// Definición del modelo de Data
    require_once('internal/model/model.php');

	use Vendor\Model\Model;
	function Data_model(&$db_connection) {
		return new Model(
			[
				'table_name' => 'data',
				'fields' => [
					'ci' => [
						'primary_key' => 1,
					],
					'name' => 1,
					'surname' => 1,
					'year' => 1,
					'status' => [
						"status_field" => 1,
					],
				],
			],
			$db_connection
		);
	}
}
?>