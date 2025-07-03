<?php
// index.php - Punto único de entrada

// Configuración inicial
header('Content-Type: text/plain');

// Obtener método HTTP
$method = $_SERVER['REQUEST_METHOD'];

// Obtener ruta solicitada
$request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$routes = explode('/', trim($request_uri, '/'));

// Quitar el directorio base si es necesario
$base_path = 'api'; // ajusta esto según tu estructura
if ($routes[0] === $base_path) {
    array_shift($routes);
}

// Determinar controlador y acción
$controller_name = $routes[0] ?? 'home';
$action_name = $routes[1] ?? 'index';
$param = $routes[2] ?? null;

echo "{ \"Endpoint\": \"$request_uri\", \"Method\": \"$method\", \"Complete_url\": \"".$_SERVER['REQUEST_URI']."\" }"
, "\n";
echo preg_replace("/^.+index.php/", "", $request_uri);
echo "\n";
echo print_r($_SERVER);
echo "\n";
echo print_r($_REQUEST);
echo "\n";
echo print_r($_GET);
echo "Hola mundo: <texto> \n";
echo "json validate: ",print_r(json_validate('{"name": "Pedro"}')),"\n";

/* ---
// Función para cargar controladores
function loadController($controller_name) {
    $controller_file = "controllers/{$controller_name}Controller.php";
    
    if (file_exists($controller_file)) {
        require_once $controller_file;
        $controller_class = ucfirst($controller_name) . 'Controller';
        return new $controller_class();
    }
    
    http_response_code(404);
    echo json_encode(['error' => 'Endpoint no encontrado']);
    exit;
}

// Router principal
switch ("$controller_name/$action_name") {
    case 'usuarios/listar':
        $controller = loadController('usuarios');
        $controller->listar();
        break;
        
    case 'usuarios/obtener':
        $controller = loadController('usuarios');
        $controller->obtener($param);
        break;
        
    case 'productos/catalogo':
        $controller = loadController('productos');
        $controller->catalogo();
        break;
        
    case 'home/index':
        echo json_encode(['message' => 'Bienvenido a la API']);
        break;
        
    default:
        http_response_code(404);
        echo json_encode(['error' => 'Ruta no encontrada']);
        break;
} --- */
?>
