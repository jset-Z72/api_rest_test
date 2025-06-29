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
?>