<?php
namespace App\Middleware;
use App\Core\Session;
class RoleMiddleware
{
 protected $allowedRoles;
 public function __construct($roles)
 {
 $this->allowedRoles = is_array($roles) ? $roles : [$roles];
 }
 public function handle()
 {
 $userRole = Session::get('user_role');
 if (!$userRole || !in_array($userRole, $this->allowedRoles)) {
 http_response_code(403);
 die('Access denied. You do not have permission to view this page.');
 }
 }
}