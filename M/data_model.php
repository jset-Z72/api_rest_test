<?php 
    // $db_connection presente en ./init.php

    require_once('internal/model.php');

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