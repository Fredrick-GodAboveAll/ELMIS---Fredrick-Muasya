<?php
namespace App\Controllers;

class ReportsController extends Controller
{
    public function index()
    {

        $title = 'Reports Dashboard';
        $currentPage = 'reports'; // This must match the navigation logic
        $content = '../app/Views/reports/index.php';
        include '../app/Views/layouts/admin.php';
    }
}
