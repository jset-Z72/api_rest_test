<?php 
namespace Vendor\Route\__core__ {
    use \json_validate;

    // For responses
    function default_response_converter_html($body) {
        return [
            'content_type' => 'text/html',
            'body' => $body
        ];
    }

    function default_response_converter_text($body) {
        return [
            'content_type' => 'text/plain',
            'body' => $body
        ];
    }

    function default_response_converter_json($body) {
        return [
            'content_type' => 'application/json',
            'body' => json_encode($body, JSON_UNESCAPED_UNICODE),
        ];
    }

    // For requestes
    function default_request_converter_json(&$body) {
        $body = json_decode($body, true);
        if(!isset($body)){
            $body = array();
       }

    }
}
?>