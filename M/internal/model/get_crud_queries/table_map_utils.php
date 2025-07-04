<?php
namespace Vendor\Model\get_crud_queries {
    require_once(__DIR__ . '/../../../core/utils.php');
    use \Exception;
    use function Vendor\Model\__core__\validate_name_table;

    function validate_table_map(array $table_map){
        $recognized_data = [
            'primary_key' => '',
            'auto_sets' => array(),
            'status_field' => '',
        ];
        $pk_avaiable = false;
        $status_avaiable = false;

        // Validates fields
        validate_name_table($table_map['table_name']);
        foreach($table_map['fields'] as $key => $value){
            validate_name_table($key);

            // Validate primary key
            if(isset($value['primary_key'])){
                if($pk_avaiable){
                    throw new Exception("Ya existe una primary key");
                }

                $pk_avaiable = true;
                $recognized_data['primary_key'] = $key;
            }

            if(isset($value['status_field'])){
                if($status_avaiable){
                    throw new Exception("Ya existe un campo de eliminación lógica");
                }

                $status_avaiable = true;
                $recognized_data['status_field'] = $key;
            }

            if(isset($value['auto_set'])){
                $recognized_data['auto_sets'][] = $key;
            }
        }

        return $recognized_data;
    }
    
    function get_query_fields($table_map) {
        // Set variables for prepare queries
        $fields = [
            'select' => '',
            'update' => [
                'fields' => '',
                'params' => '',
            ],
            'create' => [
                'fields' => '',
                'params' => '',
            ],
        ];

        foreach($table_map['fields'] as $key => $value){
            if(!isset($value['status_field'])){
                // Crea los campos para la consulta select
                $fields['select'] = $fields['select'] . '"' . $key . '", ';

                // Crea los campos para hacer insert en la consulta
                if(!isset($value['auto_set'])){
                    $fields['create']['fields'] = $fields['create']['fields'] . '"' . $key . '", ';
                    $fields['create']['params'] = $fields['create']['params'] . ':' . $key . ', ';
                }

                // Crea los campos para hacer update en la consulta
                if(!isset($value['primary_key'])){
                    $fields['update']['fields'] = $fields['update']['fields'] . '"' . $key . '", ';
                    $fields['update']['params'] = $fields['update']['params'] . '"' . $key . '" = :' . $key . ', ';
                }
            }
        }

        $fields['select'] = mb_substr($fields['select'], 0, -2);
        $fields['update']['fields'] = mb_substr($fields['update']['fields'], 0, -2);
        $fields['update']['params'] = mb_substr($fields['update']['params'], 0, -2);
        $fields['create']['fields'] = mb_substr($fields['create']['fields'], 0, -2);
        $fields['create']['params'] = mb_substr($fields['create']['params'], 0, -2);

        return $fields;
    }
}
?>