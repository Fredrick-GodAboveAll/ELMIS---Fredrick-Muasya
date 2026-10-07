<?php
namespace App\Controllers;

class ReportsController extends Controller
{
    public function index()
    {

        $title = 'Reports Dashboard';
        $currentPage = 'reports'; // This must match the navigation logic
        $content = __DIR__ . '/../Views/reports/index.php';
        include __DIR__ . '/../Views/layouts/admin.php';
    }
}
