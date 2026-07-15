<?php
namespace App\Controllers;
use App\Core\Session;

class ReportsController extends Controller
{
    public function index()
    {
        // Check if user is authenticated
        if (!Session::has('user')) {
            header('Location: /login');
            exit;
        }

        $title = 'Reports Dashboard';
        $currentPage = 'reports'; // This must match the navigation logic
        $content = '../app/Views/reports/index.php';
        include '../app/Views/layouts/admin.php';
    }
}
