<?php
namespace App\Controllers;

use App\Services\EmployeeCategoryService;

class EmployeeCategoryController extends Controller
{
    public function index()
    {
        $service = new EmployeeCategoryService();
        $data = $service->getPageData();

        $categories = $data['categories'];
        $members = $data['members'];
        $total = $data['total'];
        $firstKey = $data['firstKey'];

        $title = 'Employee Categories';
        $currentPage = 'employee_categories';
        $content = __DIR__ . '/../Views/employees/categories.php';
        include __DIR__ . '/../Views/layouts/admin.php';
    }
}
