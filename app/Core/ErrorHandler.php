<?php
namespace App\Core;
class ErrorHandler
{
 public function register()
 {
 set_error_handler([$this, 'handleError']);
 set_exception_handler([$this, 'handleException']);
 }
 public function handleError($level, $message, $file, $line)
 {
 if (error_reporting() & $level) {
 throw new \ErrorException($message, 0, $level, $file, $line);
 }
 }
 public function handleException($exception)
 {
 $log = date('Y-m-d H:i:s') . ' - ' . $exception->getMessage()
 . ' in ' . $exception->getFile() . ':' . $exception->getLine() . PHP_EOL;
 file_put_contents(STORAGE_PATH . '/logs/error.log', $log, FILE_APPEND);
 $config = require __DIR__ . '/../../config/app.php';
 if ($config['debug']) {
 echo "<h1>Exception</h1>";
 echo "<p>" . $exception->getMessage() . "</p>";
 echo "<pre>" . $exception->getTraceAsString() . "</pre>";
 } else {
 http_response_code(500);
 include __DIR__ . '/../Views/errors/500.php';
 }
 exit;
 }
}
