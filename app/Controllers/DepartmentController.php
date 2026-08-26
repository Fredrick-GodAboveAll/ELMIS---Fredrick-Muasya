<?php
namespace App\Controllers;

use App\Models\Department;
use App\Models\Employee;
use App\Core\Csrf;
use Exception;

class DepartmentController extends Controller
{
    public function index()
    {
        $departmentModel = new Department();
        $departments = $departmentModel->all();

        // Load employees for the head of department select
        $employeeModel = new Employee();
        $employees = $employeeModel->all();

        $title = 'Departments';
        $currentPage = 'departments';
        $content = '../app/Views/departments/index.php';
        include '../app/Views/layouts/admin.php';
    }

    public function deployment()
    {
        $employeeModel = new Employee();
        $employees = $employeeModel->allWithDepartment();

        $title = 'Department Deployment';
        $currentPage = 'departments';
        $content = '../app/Views/departments/deployment.php';
        include '../app/Views/layouts/admin.php';
    }

    public function store()
    {
        try {
            // Validate CSRF
            Csrf::validate($_POST['csrf_token'] ?? '');

            $name = trim((string) ($_POST['department_name'] ?? ''));
            $head = $_POST['head_of_department'] ?? null;
            $code = trim((string) ($_POST['department_code'] ?? ''));

            if ($name === '') {
                throw new Exception('Department name is required');
            }

            $departmentModel = new Department();

            // Check case-insensitive uniqueness
            if ($departmentModel->existsByNameCaseInsensitive($name)) {
                throw new Exception('A department with that name already exists');
            }

            // Do not generate a department code per user request; leave NULL
            $newId = $departmentModel->create([
                'name' => $name,
                'code' => $code !== '' ? $code : null,
                'head_of_department' => $head ?: null,
            ]);

            if ($newId) {
                // Success flash and redirect back to departments
                $_SESSION['flash_success'] = 'Department created successfully.';
                header('Location: /departments');
                exit;
            }

            throw new Exception('Failed to create department');

        } catch (Exception $e) {
            // For simplicity, set a flash message or include error in view
            $_SESSION['flash_error'] = $e->getMessage();
            header('Location: /departments');
            exit;
        }
    }

    public function delete()
    {
        try {
            Csrf::validate($_POST['csrf_token'] ?? '');

            $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
            if ($id <= 0) {
                throw new Exception('Invalid department id');
            }

            $departmentModel = new Department();

            if ($departmentModel->delete($id)) {
                $_SESSION['flash_success'] = 'Department deleted successfully.';
            } else {
                throw new Exception('Failed to delete department.');
            }

            header('Location: /departments');
            exit;

        } catch (Exception $e) {
            $_SESSION['flash_error'] = $e->getMessage();
            header('Location: /departments');
            exit;
        }
    }
}
