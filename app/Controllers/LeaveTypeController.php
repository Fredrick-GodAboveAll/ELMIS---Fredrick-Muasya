<?php
namespace App\Controllers;

class LeaveTypeController extends Controller
{
    public function index()
    {
        $title = 'Leave Types';
        $currentPage = 'leave_types';
        $content = __DIR__ . '/../Views/leave_types/index.php';
        include __DIR__ . '/../Views/layouts/admin.php';
    }
}
