<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Infrastructure\Controllers\RegisterUserController;
use DI\Container;

$container = require __DIR__ . '/../src/Config/dependencies.php';
$controller = $container->get(RegisterUserController::class);
// print_r("sdssdsWWWWWWWWWdsd");die;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['REQUEST_URI'] === '/register') {
    $controller->handle();
} else {
    http_response_code(404);
    echo json_encode(["error" => "Not Found"]);
}

// $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// if ($uri === '/register' && $_SERVER['REQUEST_METHOD'] === 'POST') {
//     $controller = new RegisterUserController();
//     $controller->handle();
// } else {
//     http_response_code(404);
//     echo json_encode(["error" => "Not Found"]);
// }