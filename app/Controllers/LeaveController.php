<?php
namespace App\Controllers;

class LeaveController extends Controller
{
    public function index()
    {
        $title = 'Leave Management';
        $currentPage = 'leave_management';
        $content = '../app/Views/leave_management/index.php';
        include '../app/Views/layouts/admin.php';
    }
}
