<?php
namespace App\Controllers;
class ErrorController extends Controller
{
 public function notFound()
 {
 http_response_code(404);
 $title = '404 - Page Not Found';
 $content = '../app/Views/errors/404.php';
 include '../app/Views/layouts/auth.php';
 exit;
 }
 public function serverError()
 {
 http_response_code(500);
 $title = '500 - Server Error';
 $content = '../app/Views/errors/500.php';
 include '../app/Views/layouts/auth.php';
 exit;
 }
}