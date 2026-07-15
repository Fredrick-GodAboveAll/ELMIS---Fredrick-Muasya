<?php
require __DIR__ . '/../vendor/autoload.php';

use App\Core\Router;
use App\Core\Session;
use App\Controllers\ErrorController;

Session::start();

// Error reporting (disable in production)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Exception handler
set_exception_handler(function ($exception) {
    // Log the error (you can write to a file)
    error_log($exception->getMessage());

    // Show 500 page
    $controller = new ErrorController();
    $controller->serverError($exception->getMessage());
});

// Error handler that converts PHP errors to exceptions
set_error_handler(function ($severity, $message, $file, $line) {
    throw new \ErrorException($message, 0, $severity, $file, $line);
});

$router = new Router();
require __DIR__ . '/../routes/web.php';

$uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];
$router->dispatch($uri, $method);