<?php
namespace App\Middleware;
use App\Core\Session;
use App\Services\AuthService;
class AuthMiddleware
{
 public function handle()
 {
 if (!Session::has('user_id')) {
 Session::flash('error', 'Please log in first.');
 header('Location: /login');
 exit;
 }
 
 // Check session timeout (30 minutes)
 $authService = new AuthService();
 if (!$authService->checkSessionTimeout(30)) {
 Session::flash('error', 'Your session has expired. Please log in again.');
 header('Location: /login');
 exit;
 }
 }
}
