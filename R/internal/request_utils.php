<?php
namespace Vendor\Route\__base__ {


    function get_request() {
        // Genera el formato del request que será
        // pasado al controlador
        return [
            'body' => null,
            'params' => null,
        ];
    }

    function send_response($response) {
        // Envía la respuesta http dado el response
    }
}
?>