<?php

/**
 * Compara una ruta de API real con un patrón de ruta y extrae los valores de los parámetros.
 *
 * @param_name string $api_uri La ruta de la API real (ej. '/api/user/001').
 * @param_name string $endpoint La ruta con patrones (ej. '/api/user/:id').
 * @return array Un array asociativo con los nombres de los patrones como claves y las coincidencias como valores,
 * o un array vacío si no hay coincidencia.
 */
function matchApiRoute(string $api_uri, string $endpoint): array
{
    $params = []; // Array para almacenar los resultados finales
    $param_names = []; // Array para almacenar el orden y nombres de los patrones

    // 1. Convertir el patrón de ruta a una expresión regular
    // Expresión regular para encontrar ":nombre_patron"
    // Captura el nombre del patrón sin el ":"
    $param_name_patterns = '/:(\w+)/';

    // Usar preg_replace_callback para construir la regex final y capturar los nombres de los patrones
    $endpoint_pattern = preg_replace_callback(
        $param_name_patterns,
        function ($match) use (&$param_names) {
            $param_name = $match[1]; // El nombre del patrón (ej. "id")
            $param_names[] = $param_name; // Guardar el nombre para el orden

            // Reemplazar ":nombre" con un grupo de captura nombrado (?P<nombre>[^/]+)
            // [^/]+ significa "uno o más caracteres que no sean una barra (/)".
            // Esto asegura que capture el segmento entre barras.
            return '(?P<' . $param_name . '>[^/]+)';
        },
        $endpoint
    );

    // Añadir delimitadores y anclajes para que coincida con la ruta completa
    // ^ para el inicio de la cadena, $ para el final
    $endpoint_pattern = '#^' . $endpoint_pattern . '$#';

    // 2. Realizar la coincidencia de la API Route con la expresión regular final
    if (preg_match($endpoint_pattern, $api_uri, $param_matches)) {
        // 3. Construir el array asociativo de resultados
        foreach ($param_names as $name) {
            // Acceder a la coincidencia por el nombre del grupo de captura
            if (isset($param_matches[$name])) {
                $params[$name] = $param_matches[$name];
            }
        }
    }

    return $params;
}

// --- Ejemplos de uso ---

header('Content-type: text/plain');
// Ejemplo 1: Patrón simple
$api_uri1 = '/api/user/001';
$endpoint1 = '/api/user/:id';
$result1 = matchApiRoute($api_uri1, $endpoint1);
echo "API Route: " . $api_uri1 . "\n";
echo "Pattern Route: " . $endpoint1 . "\n";
echo "Resultado: " . print_r($result1, true) . "\n";
// Debería devolver: Array ( [id] => 001 )

echo "--------------------\n";

// Ejemplo 2: Múltiples patrones
$api_uri2 = '/productos/electronica/televisores/samsung_qled_55';
$endpoint2 = '/productos/:categoria/:subcategoria/:producto_slug';
$result2 = matchApiRoute($api_uri2, $endpoint2);
echo "API Route: " . $api_uri2 . "\n";
echo "Pattern Route: " . $endpoint2 . "\n";
echo "Resultado: " . print_r($result2, true) . "\n";
/*
Debería devolver:
Array
(
    [categoria] => electronica
    [subcategoria] => televisores
    [producto_slug] => samsung_qled_55
)
*/

echo "--------------------\n";

// Ejemplo 3: Sin coincidencia
$api_uri3 = '/api/order/view';
$endpoint3 = '/api/user/:id';
$result3 = matchApiRoute($api_uri3, $endpoint3);
echo "API Route: " . $api_uri3 . "\n";
echo "Pattern Route: " . $endpoint3 . "\n";
echo "Resultado: " . print_r($result3, true) . "\n";
// Debería devolver: Array ()

echo "--------------------\n";

// Ejemplo 4: Coincidencia parcial (no debería coincidir por los anclajes ^$)
$api_uri4 = '/api/user/001/details';
$endpoint4 = '/api/user/:id';
$result4 = matchApiRoute($api_uri4, $endpoint4);
echo "API Route: " . $api_uri4 . "\n";
echo "Pattern Route: " . $endpoint4 . "\n";
echo "Resultado: " . print_r($result4, true) . "\n";
// Debería devolver: Array ()

echo "--------------------\n";

// Ejemplo 5: Patrones en diferentes posiciones
$api_uri5 = '/version/v2/items/new';
$endpoint5 = '/version/:num_version/items/:status';
$result5 = matchApiRoute($api_uri5, $endpoint5);
echo "API Route: " . $api_uri5 . "\n";
echo "Pattern Route: " . $endpoint5 . "\n";
echo "Resultado: " . print_r($result5, true) . "\n";
/*
Debería devolver:
Array
(
    [num_version] => v2
    [status] => new
)
*/

?>