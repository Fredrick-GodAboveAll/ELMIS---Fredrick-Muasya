<?php
namespace App\Controllers;

use App\Models\Department;

class DepartmentController extends Controller
{
    public function index()
    {
        $departmentModel = new Department();
        $departments = $departmentModel->all();

        $title = 'Departments';
        $currentPage = 'departments';
        $content = '../app/Views/departments/index.php';
        include '../app/Views/layouts/admin.php';
    }
}
