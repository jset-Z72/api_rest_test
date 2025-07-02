<?php

/**
 * Compara una ruta de API real con un patrón de ruta y extrae los valores de los parámetros.
 *
 * @param string $apiRoute La ruta de la API real (ej. '/api/user/001').
 * @param string $patternRoute La ruta con patrones (ej. '/api/user/:id').
 * @return array Un array asociativo con los nombres de los patrones como claves y las coincidencias como valores,
 * o un array vacío si no hay coincidencia.
 */
function matchApiRoute(string $apiRoute, string $patternRoute): array
{
    $matches = []; // Array para almacenar los resultados finales
    $patternNames = []; // Array para almacenar el orden y nombres de los patrones

    // 1. Convertir el patrón de ruta a una expresión regular
    // Expresión regular para encontrar ":nombre_patron"
    // Captura el nombre del patrón sin el ":"
    $regexPatternForPatterns = '/:([a-zA-Z0-9_]+)/';

    // Usar preg_replace_callback para construir la regex final y capturar los nombres de los patrones
    $finalRegex = preg_replace_callback(
        $regexPatternForPatterns,
        function ($match) use (&$patternNames) {
            $patternName = $match[1]; // El nombre del patrón (ej. "id")
            $patternNames[] = $patternName; // Guardar el nombre para el orden

            // Reemplazar ":nombre" con un grupo de captura nombrado (?P<nombre>[^/]+)
            // [^/]+ significa "uno o más caracteres que no sean una barra (/)".
            // Esto asegura que capture el segmento entre barras.
            return '(?P<' . $patternName . '>[^/]+)';
        },
        $patternRoute
    );

    // Añadir delimitadores y anclajes para que coincida con la ruta completa
    // ^ para el inicio de la cadena, $ para el final
    $finalRegex = '#^' . $finalRegex . '$#';

    // 2. Realizar la coincidencia de la API Route con la expresión regular final
    if (preg_match($finalRegex, $apiRoute, $regexMatches)) {
        // 3. Construir el array asociativo de resultados
        foreach ($patternNames as $name) {
            // Acceder a la coincidencia por el nombre del grupo de captura
            if (isset($regexMatches[$name])) {
                $matches[$name] = $regexMatches[$name];
            }
        }
    }

    return $matches;
}

// --- Ejemplos de uso ---

header('Content-type: text/plain');
// Ejemplo 1: Patrón simple
$apiRoute1 = '/api/user/001';
$patternRoute1 = '/api/user/:id';
$result1 = matchApiRoute($apiRoute1, $patternRoute1);
echo "API Route: " . $apiRoute1 . "\n";
echo "Pattern Route: " . $patternRoute1 . "\n";
echo "Resultado: " . print_r($result1, true) . "\n";
// Debería devolver: Array ( [id] => 001 )

echo "--------------------\n";

// Ejemplo 2: Múltiples patrones
$apiRoute2 = '/productos/electronica/televisores/samsung_qled_55';
$patternRoute2 = '/productos/:categoria/:subcategoria/:producto_slug';
$result2 = matchApiRoute($apiRoute2, $patternRoute2);
echo "API Route: " . $apiRoute2 . "\n";
echo "Pattern Route: " . $patternRoute2 . "\n";
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
$apiRoute3 = '/api/order/view';
$patternRoute3 = '/api/user/:id';
$result3 = matchApiRoute($apiRoute3, $patternRoute3);
echo "API Route: " . $apiRoute3 . "\n";
echo "Pattern Route: " . $patternRoute3 . "\n";
echo "Resultado: " . print_r($result3, true) . "\n";
// Debería devolver: Array ()

echo "--------------------\n";

// Ejemplo 4: Coincidencia parcial (no debería coincidir por los anclajes ^$)
$apiRoute4 = '/api/user/001/details';
$patternRoute4 = '/api/user/:id';
$result4 = matchApiRoute($apiRoute4, $patternRoute4);
echo "API Route: " . $apiRoute4 . "\n";
echo "Pattern Route: " . $patternRoute4 . "\n";
echo "Resultado: " . print_r($result4, true) . "\n";
// Debería devolver: Array ()

echo "--------------------\n";

// Ejemplo 5: Patrones en diferentes posiciones
$apiRoute5 = '/version/v2/items/new';
$patternRoute5 = '/version/:num_version/items/:status';
$result5 = matchApiRoute($apiRoute5, $patternRoute5);
echo "API Route: " . $apiRoute5 . "\n";
echo "Pattern Route: " . $patternRoute5 . "\n";
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