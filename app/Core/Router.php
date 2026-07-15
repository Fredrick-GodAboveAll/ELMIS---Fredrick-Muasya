<?php
namespace App\Core;
class Router
{
 protected $routes = [];
 public function get($uri, $action, $middleware = [])
 {
 $this->addRoute('GET', $uri, $action, $middleware);
 }
 public function post($uri, $action, $middleware = [])
 {
 $this->addRoute('POST', $uri, $action, $middleware);
 }
 protected function addRoute($method, $uri, $action, $middleware)
 {
 $this->routes[] = compact('method','uri','action','middleware');
 }
 public function dispatch($uri, $method)
 {
 $uri = strtok($uri, '?');
 foreach ($this->routes as $route) {
 if ($route['method'] === $method && $route['uri'] === $uri) {
 foreach ($route['middleware'] as $mw) {
 if (is_string($mw)) {
 (new $mw())->handle();
 } elseif (is_array($mw)) {
 $class = $mw[0];
 $args = array_slice($mw, 1);
 $reflector = new \ReflectionClass($class);
 $reflector->newInstanceArgs($args)->handle();
 }
 }
 return $this->callAction($route['action']);
 }
 }
 http_response_code(404);
 include __DIR__ . '/../Views/errors/404.php';
 exit;
 }
 protected function callAction($action)
 {
 list($controller, $method) = explode('@', $action);
 $controller = "App\\Controllers\\{$controller}";
 return (new $controller())->$method();
 }
}