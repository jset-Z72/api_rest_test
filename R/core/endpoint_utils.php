<?php
namespace Vendor\Route\__core__ {
    use \InvalidArgumentException;

    function get_endpoint_pattern(string $endpoint) {
        // Genera
        // Código extraido y modificado de Gemini
        $param_name_patterns = '/:(\w+)/';
        
        return '#^' . preg_replace_callback(
            $param_name_patterns,
            function ($match) {
                // Validar que el nombre del parámetro sea válido
                if (!preg_match('/^[a-zA-Z_\x80-\xff][a-zA-Z0-9_\x80-\xff]*$/', $match[1])) {
                    throw new InvalidArgumentException("Invalid parameter name: {$match[1]}");
                }
                return '(?P<' . $match[1] . '>[^/]+)';
            },
            $endpoint
        ) . '/?$#x';
    }

    /*function get_params(string $uri, string $endpoint_pattern): array {

        $params = array();

        // 2. Realizar la coincidencia de la API Route con la expresión regular final
        if (preg_match($endpoint_pattern, $uri, $params_result)) {
            // 3. Construir el array asociativo de resultados
            foreach ($params_result as $key => $value) {
                // Acceder a la coincidencia por el nombre del grupo de captura
                if (is_string($key)) {
                    $params[$key] = $value;
                }
            }
        }

        return $params;
    }*/
    
    function get_client_endpoint($uri, $main_file = 'index.php') {
        // Devuelve el endpoint, o la uri relativa de $uri,
        // sin incluir los argumentos o parámetros http.
        // $main_file representa el archivo de donde se ejecuta la api,
        // por defecto es el archivo principal (index.php)

        $client_endpoint = parse_url($uri, PHP_URL_PATH);
        return preg_replace(
            "/^.+" . str_replace('.', "\.", $main_file) . "/",
            '',
            $client_endpoint
        );
    }
}
?>