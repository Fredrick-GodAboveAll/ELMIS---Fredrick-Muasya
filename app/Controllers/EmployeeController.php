<?php
namespace App\Controllers;

class EmployeeController extends Controller
{
    public function index()
    {
        $title = 'Employees';
        $currentPage = 'employees';
        $content = '../app/Views/employees/index.php';
        include '../app/Views/layouts/admin.php';
    }
}

