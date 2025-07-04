<?php
namespace Vendor\Model\get_crud_queries {
    require_once('table_map_utils.php');
    use \Exception;

    function get_queries($table_map) {
        try {
            // Genera las 4 consultas para la preparación del CRUD
            // SELECT, INSERT, UPDATE y DELETE
        
            $queries = [
                'select' => '',
                'insert' => '',
                'update' => '',
                'delete' => '',
            ];

            $recognized_data = validate_table_map($table_map);
            $query_fields = get_query_fields($table_map);

            $queries['select'] =
                'SELECT ' .$query_fields['select']. ' FROM "' .$table_map['table_name']. '"' .
                ($recognized_data['status_field'] !== '' ?
                    ' WHERE "' .$recognized_data['status_field']. '" = true'
                :
                    '')
                . ';'
            ;

            $queries['insert'] = 
                'INSERT INTO "' .$table_map['table_name']. '" (' .$query_fields['create']['fields']. ') VALUES ('.
                $query_fields['create']['params']. ');'
            ;

            $queries['update'] = 
                'UPDATE "' .$table_map['table_name']. '" SET ' . $query_fields['update']['params'].
                ' WHERE "'. $recognized_data['primary_key']. '" = :' .$recognized_data['primary_key'].
                ($recognized_data['status_field'] !== '' ?
                     ' AND "' . $recognized_data['status_field']. '" = true;'
                :
                    ';')
            ;

            $queries['delete'] = $recognized_data['status_field'] ?
                'UPDATE "' .$table_map['table_name']. '" SET "' .$recognized_data['status_field'].
                '" = false WHERE "'. $recognized_data['primary_key']. '" = :' .$recognized_data['primary_key']. " ;"
            :
                'DELETE FROM "' .$table_map['table_name']. '" WHERE "'.
                $recognized_data['primary_key']. '" = :' .$recognized_data['primary_key']. " ;"
            ;


            return $queries;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
?>