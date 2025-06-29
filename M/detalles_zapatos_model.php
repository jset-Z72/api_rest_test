<?php 
    // $db_connection presente en ./init.php

    require_once('internal/model.php');

	$Detalles_zapatos_model = new Model(
		[
			'table_name' => 'detalles_zapatos',
			'fields' => [
				'Id' => [
					'primary_key' => 1,
					'auto_set' => 1,
				],
				'Cod_zapato' => 1,
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
?>