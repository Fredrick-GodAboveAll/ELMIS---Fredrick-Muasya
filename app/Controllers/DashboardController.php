<?php
namespace App\Controllers;
use App\Core\Session;
use App\Core\Database;
class DashboardController extends Controller
{
 public function index()
 {
 $title = 'Dashboard';
 $currentPage = 'dashboard';
 $pdo = Database::getInstance();
 $stmt = $pdo->query('SELECT COUNT(*) AS total FROM employees');
 $employeeCount = $stmt->fetch()->total ?? 0;
 $content = '../app/Views/dashboard/index.php';
 include '../app/Views/layouts/admin.php';
 }

 public function analytics()
 {
 $title = 'Analytics';
 $currentPage = 'analytics';
 $content = '../app/Views/dashboard/dashboard_analytics.php';
 include '../app/Views/layouts/admin.php';
 }
}
