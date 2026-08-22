<?php
namespace App\Controllers;

use App\Models\Employee;

class EmployeeController extends Controller
{
    public function index()
    {
        $employeeModel = new Employee();
        $employees = $employeeModel->all();

        $title = 'Employees';
        $currentPage = 'employees';
        $content = '../app/Views/employees/index.php';
        include '../app/Views/layouts/admin.php';
    }
}

