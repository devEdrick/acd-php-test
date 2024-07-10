<?php

// Load Composer's autoloader
require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use FastRoute\Dispatcher;
use function FastRoute\simpleDispatcher;

// Load environment variables from .env file
$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// Load routes callback function
$routesCallback = require __DIR__ . '/../routes.php';

// Create FastRoute dispatcher
$dispatcher = simpleDispatcher($routesCallback);

// Fetch method and URI from $_SERVER
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

// Dispatch route
$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

// Handle route dispatch result
switch ($routeInfo[0]) {
    case Dispatcher::NOT_FOUND:
        // Handle 404 Not Found
        http_response_code(404);
        echo '404 - Not Found';
        break;
    case Dispatcher::METHOD_NOT_ALLOWED:
        // Handle 405 Method Not Allowed
        $allowedMethods = $routeInfo[1];
        http_response_code(405);
        echo '405 - Method Not Allowed';
        break;
    case Dispatcher::FOUND:
        // Extract handler and parameters
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];

        // Split handler like 'App\Controllers\CallHeaderController@index' into class and method
        [$controllerClass, $method] = explode('@', $handler);

        // Ensure controller class exists
        if (!class_exists($controllerClass)) {
            http_response_code(404);
            echo '404 - Controller Class Not Found';
            break;
        }

        // Instantiate controller
        $controller = new $controllerClass();

        // Call controller method if exists
        if (!method_exists($controller, $method)) {
            http_response_code(404);
            echo '404 - Method Not Found';
            break;
        }

        // Call controller method with parameters
        call_user_func_array([$controller, $method], $vars);
        break;
}
