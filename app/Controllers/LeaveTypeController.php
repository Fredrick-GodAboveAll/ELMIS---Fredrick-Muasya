<?php
namespace App\Controllers;

class LeaveTypeController extends Controller
{
    public function index()
    {
        $title = 'Leave Types';
        $currentPage = 'leave_types';
        $content = '../app/Views/leave_types/index.php';
        include '../app/Views/layouts/admin.php';
    }
}
