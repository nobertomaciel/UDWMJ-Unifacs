<?php
require_once __DIR__ . '/../src/bd.php';
require_once __DIR__ . '/../src/models.php';
require_once __DIR__ . '/../src/services.php';
require_once __DIR__ . '/../src/controllers.php';

$routes = require __DIR__ . '/../src/routes.php';

$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$basePath = '/api/public/index.php';
$uri = str_replace($basePath, '', $uri);

if ($uri === '') {
    $uri = '/';
}

function matchRoute($routePath, $uri, &$params) {
    $pattern = preg_replace('#\{[a-zA-Z_]+\}#', '([0-9]+)', $routePath);
    $pattern = "#^" . $pattern . "$#";

    if (preg_match($pattern, $uri, $matches)) {
        array_shift($matches);
        $params = $matches;
        return true;
    }
    return false;
}

foreach ($routes as $route) {
    [$httpMethod, $path, $handler] = $route;

    if ($method === $httpMethod) {
        $params = [];

        if (matchRoute($path, $uri, $params)) {
            call_user_func_array($handler, $params);
            exit;
        }
    }
}

jsonResponse(['error' => 'Not Found'], 404);
?>