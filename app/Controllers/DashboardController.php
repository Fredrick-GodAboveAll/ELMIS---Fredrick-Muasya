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
 $content = __DIR__ . '/../Views/dashboard/index.php';
 include __DIR__ . '/../Views/layouts/admin.php';
 }

 public function analytics()
 {
 $title = 'Analytics';
 $currentPage = 'analytics';
 $content = __DIR__ . '/../Views/dashboard/dashboard_analytics.php';
 include __DIR__ . '/../Views/layouts/admin.php';
 }
}
