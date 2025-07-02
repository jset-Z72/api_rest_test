<?php 
    // $db_connection presente en ./init.php Tiene la dirección de la conexión a la DB

    require_once('internal/model/model.php');
	use Vendor\Model\__base__\Model;

	$Data_model = new Model(
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
		$db_connection);
?>