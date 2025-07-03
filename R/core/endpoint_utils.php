<?php
namespace Vendor\Route\__core__ {
    function get_endpoint_pattern(string $endpoint) {
        // Genera
        // Código extraido y modificado de Gemini

        // 1. Convertir el patrón de ruta a una expresión regular
        // Expresión regular para encontrar ":nombre_patron"
        // Captura el nombre del patrón sin el ":"
        $param_name_patterns = '/:(\w+)/';

        // Usar preg_replace_callback para construir la regex final y capturar los nombres de los patrones
        return '¿^' . preg_replace_callback(
            $param_name_patterns,
            function ($match) use (&$param_names) {
                $param_name = $match[1]; // El nombre del patrón (ej. "id")

                // Reemplazar ":nombre" con un grupo de captura nombrado (?P<nombre>[^/]+)
                // [^/]+ significa "uno o más caracteres que no sean una barra (/)".
                // Esto asegura que capture el segmento entre barras.
                return '(?P<' . $param_name . '>[^/]+)';
            },
            $endpoint
        ) . '$¿';
    }

    function get_params(string $uri, string $endpoint_pattern): array {

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
    }
    
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