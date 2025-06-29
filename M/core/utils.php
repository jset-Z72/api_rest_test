<?php

    function validate_name_table($name) {
        if (!preg_match("/^\w+$/", $name)) {
            throw new Exception("Invalid table name: $name");
        }
    }

    function get_dsn(array $DSN = [
            'DB_DRIVER' => null,
            'DB_HOST' => null,
            'DB_PORT' => null,
            'DB_USER' => null,
            'DB_PASS' => null,
            'DB_NAME' => null
        ]) {
            $dsn = '';
            $dsn = !isset($DSN['DB_DRIVER']) ?: $dsn . $DSN['DB_DRIVER'] . ':';
            $dsn = !isset($DSN['DB_HOST']) ?: $dsn . 'host=' . $DSN['DB_HOST'] . ';';
            $dsn = !isset($DSN['DB_PORT']) ?: $dsn . 'port=' . $DSN['DB_PORT'] . ';';
            $dsn = !isset($DSN['DB_NAME']) ?: $dsn . 'dbname=' . $DSN['DB_NAME'] . ';';
            $dsn = !isset($DSN['DB_USER']) ?: $dsn . 'user=' . $DSN['DB_USER'] . ';';
            $dsn = !isset($DSN['DB_PASS']) ?: $dsn . 'password=' . $DSN['DB_PASS'];
        
            return $dsn;
        }
    
    function validate_table_map(array $table_map){
        $recognized_data = [
            'primary_key' => '',
            'auto_sets' => array(),
        ];
        $pk_avaiable = false;

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

            if(isset($value['auto_set'])){
                $recognized_data['auto_sets'][] = $key;
            }
        }

        return $recognized_data;
    }
    
    function get_query_fields($table_map, $recognized_data) {
        // Set variables for prepare queries
        $select_fields = '';
        $update_fields = ';';
        $update_set_fields = '';

        foreach($table_map['fields'] as $key => $value){
            $select_fields = $select_fields . '"' . $key . '", ';
            if(!isset($value['auto_sets'])){
            $update_set_fields = $update_set_fields . ':' . $key . ', ';
            // $str_update_fields = $str_update_fields . '"' . $key . '", ';
            if(!isset($value['auto_set'])){
                //$update_set_fields = $str_update_set_fields . ':' . $key . ', ';
                // if(!($pk_field === $key)){
                    //$str_update_fields = $str_update_fields . '"' . $key . '", ';
                // }
            }
        }
        }
    }
?>