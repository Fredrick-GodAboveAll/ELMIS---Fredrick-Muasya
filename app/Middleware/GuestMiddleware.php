<?php
namespace App\Middleware;
use App\Core\Session;
class GuestMiddleware
{
 public function handle()
 {
 if (Session::has('user_id')) {
 header('Location: /dashboard');
 exit;
 }
 }
}
