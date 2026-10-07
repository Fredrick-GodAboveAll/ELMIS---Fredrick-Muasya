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
        $content = __DIR__ . '/../Views/employees/index.php';
        include __DIR__ . '/../Views/layouts/admin.php';
    }

    public function categories()
    {
        $title = 'Employee Categories';
        $currentPage = 'employee_categories';
        $content = __DIR__ . '/../Views/employees/categories.php';
        include __DIR__ . '/../Views/layouts/admin.php';
    }
}

