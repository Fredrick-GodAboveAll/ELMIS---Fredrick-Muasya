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
$router->get('/departments', 'DepartmentController@index', [AuthMiddleware::class]);
$router->post('/departments', 'DepartmentController@store', [AuthMiddleware::class]);
$router->post('/departments/delete', 'DepartmentController@delete', [AuthMiddleware::class]);
// Department deployment page
$router->get('/departments/deployment', 'DepartmentController@deployment', [AuthMiddleware::class]);

// Reports Route 
$router->get('/reports', 'ReportsController@index', [AuthMiddleware::class]);


// LEAVE ROUTES 

$router->get('/leaves', 'LeaveController@index', [AuthMiddleware::class]);
$router->get('/leave-types', 'LeaveController@LeaveType', [AuthMiddleware::class]);
$router->get('/leave-applications', 'LeaveController@leaveApplications', [AuthMiddleware::class]);
$router->post('/leave-types', 'LeaveController@storeLeaveType', [AuthMiddleware::class]);
$router->get('/leave-periods', 'LeaveController@LeavePeriod', [AuthMiddleware::class]);
$router->post('/leave-periods/update', 'LeaveController@updateLeavePeriodStatus', [AuthMiddleware::class]);
$router->post('/leave-periods/delete', 'LeaveController@deleteLeavePeriod', [AuthMiddleware::class]);
$router->get('/new-leave-period', 'LeaveController@NewLeavePeriod', [AuthMiddleware::class]);
$router->post('/new-leave-period', 'LeaveController@storeLeavePeriod', [AuthMiddleware::class]);
$router->get('/leave-policies', 'LeaveController@LeavePolicy', [AuthMiddleware::class]);
$router->get('/holiday-list', 'LeaveController@HolidayList', [AuthMiddleware::class]);

// Tools: Leave Calculator test (isolated)
$router->get('/tools/leave-calculator', 'ToolsController@leaveCalculator', [AuthMiddleware::class]);
$router->post('/tools/leave-calculator', 'ToolsController@leaveCalculator', [AuthMiddleware::class]);

// HOLIDAY ROUTES 

$router->get('/holidays', 'HolidaysController@index', [AuthMiddleware::class]);
$router->get('/holidays/new', 'HolidaysController@newHolidayList', [AuthMiddleware::class]);
$router->get('/holidays/hout', 'HolidaysController@Hout_list', [AuthMiddleware::class]);


// SYTEM TOOLS ROUTES ---- for making work easier and seeing the system clock

$router->get('/system-calender', 'SystemToolsController@SystemCalender', [AuthMiddleware::class]);
// Unified bulk actions UI (single page for downloads/uploads).
// The view at `/bulk-actions` contains upload forms that POST to
// the `/bulk-import/*` endpoints defined below. Access is restricted
// to authenticated users via `AuthMiddleware`.
$router->get('/bulk-actions', 'SystemToolsController@SystemBulkUpload', [AuthMiddleware::class]);

$router->get('/bulk-actions', 'SystemToolsController@SystemBulkUpload', [AuthMiddleware::class]);

// Bulk import routes
// Template download endpoints (GET) and upload handlers (POST).
// These endpoints expect multipart form uploads with `import_file`
// and the CSRF token included in the form. Protected with AuthMiddleware.
$router->get('/bulk-import/employees/template', 'BulkImportController@employeesTemplate', [AuthMiddleware::class]);
$router->post('/bulk-import/employees', 'BulkImportController@importEmployees', [AuthMiddleware::class]);
$router->get('/bulk-import/leave/template', 'BulkImportController@leaveTemplate', [AuthMiddleware::class]);
$router->post('/bulk-import/leave', 'BulkImportController@importLeave', [AuthMiddleware::class]);
$router->get('/bulk-import/allowances/template', 'BulkImportController@allowancesTemplate', [AuthMiddleware::class]);
$router->post('/bulk-import/allowances', 'BulkImportController@importAllowances', [AuthMiddleware::class]);

// USER ROUTES ---- the one using the system ADMIN later we will figure out the other user 

$router->get('/user-profiles', 'UserController@index', [AuthMiddleware::class]);
$router->get('/user/settings', 'UserController@SystemSetting', [AuthMiddleware::class]);



// LEAVE ROUTES

$router->get('/holidays', 'HolidaysController@index', [AuthMiddleware::class]);

// Admin-only route example
$router->get('/admin/users', 'AdminController@index',
 [AuthMiddleware::class, [RoleMiddleware::class, 'admin']]);