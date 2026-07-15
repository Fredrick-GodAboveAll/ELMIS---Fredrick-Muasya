<?php
namespace App\Controllers;

class DepartmentController extends Controller
{
    public function index()
    {
        $title = 'Departments';
        $currentPage = 'departments';
        $content = '../app/Views/departments/index.php';
        include '../app/Views/layouts/admin.php';
    }
}
