<?php
use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;
use App\Middleware\RoleMiddleware;
// Guest routes
$router->get('/', 'AuthController@login', [GuestMiddleware::class]);
$router->get('/login', 'AuthController@login', [GuestMiddleware::class]);
$router->post('/login', 'AuthController@doLogin', [GuestMiddleware::class]);
$router->get('/register', 'AuthController@register', [GuestMiddleware::class]);
$router->post('/register', 'AuthController@doRegister', [GuestMiddleware::class]);
$router->get('/forgot-password', 'AuthController@forgotPassword', [GuestMiddleware::class]);
$router->post('/forgot-password', 'AuthController@doForgotPassword', [GuestMiddleware::class]);
$router->get('/reset-password', 'AuthController@resetPassword', [GuestMiddleware::class]);
$router->post('/reset-password', 'AuthController@doResetPassword', [GuestMiddleware::class]);
$router->get('/confirm-mail', 'AuthController@confirmMail', [GuestMiddleware::class]);
$router->get('/verify-email', 'AuthController@verifyEmail', [GuestMiddleware::class]);
$router->get('/offline', 'AuthController@offline');
// Protected routes
$router->get('/logout', 'AuthController@logout');
$router->post('/logout', 'AuthController@logout');
$router->get('/lock-screen', 'AuthController@lockScreen', [AuthMiddleware::class]);
$router->post('/unlock', 'AuthController@doUnlock', [AuthMiddleware::class]);
$router->get('/dashboard', 'DashboardController@index', [AuthMiddleware::class]);
$router->get('/dashboard/analytics', 'DashboardController@analytics', [AuthMiddleware::class]);

// Future HR routes (pages will be added later)
$router->get('/employees', 'EmployeeController@index', [AuthMiddleware::class]);
$router->get('/employees/detail', 'EmployeeController@detail', [AuthMiddleware::class]);
$router->get('/employees/departments', 'EmployeeController@departments', [AuthMiddleware::class]);
$router->get('/employees/upload', 'EmployeeController@upload', [AuthMiddleware::class]);
$router->post('/employees/import', 'EmployeeController@import', [AuthMiddleware::class]);
$router->get('/departments', 'DepartmentController@index', [AuthMiddleware::class]);
$router->get('/leave-types', 'LeaveTypeController@index', [AuthMiddleware::class]);
$router->get('/leaves', 'LeaveController@index', [AuthMiddleware::class]);
$router->get('/holidays', 'HolidaysController@index', [AuthMiddleware::class]);
$router->get('/reports', 'ReportsController@index', [AuthMiddleware::class]);

// Admin-only route example
$router->get('/admin/users', 'AdminController@index',
 [AuthMiddleware::class, [RoleMiddleware::class, 'admin']]);