<?php
namespace App\Controllers;
class ErrorController extends Controller
{
 public function notFound()
 {
 http_response_code(404);
 $title = '404 - Page Not Found';
 $content = __DIR__ . '/../Views/errors/404.php';
 include __DIR__ . '/../Views/layouts/auth.php';
 exit;
 }
 public function serverError()
 {
 http_response_code(500);
 $title = '500 - Server Error';
 $content = __DIR__ . '/../Views/errors/500.php';
 include __DIR__ . '/../Views/layouts/auth.php';
 exit;
 }
}