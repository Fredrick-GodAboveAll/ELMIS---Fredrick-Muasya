<?php
namespace App\Services;

use App\Core\Database;
use App\Models\EmployeeCategoryModel;
use PDO;

class EmployeeCategoryService
{
    protected $db;
    protected $employeeModel;

    public function __construct()
    {
        $this->db = Database::getInstance();
        $this->employeeModel = new EmployeeCategoryModel();
    }

    public function getPageData()
    {
        $categories = $this->loadCategories();
        $employees = $this->getEmployees();
        $members = $this->buildMembers($categories, $employees);

        $cleanCategories = [];
        foreach ($categories as $slug => $category) {
            $cleanCategories[$slug] = [
                'title' => $category['title'],
                'icon' => $category['icon'],
                'color' => $category['color'],
                'role' => $category['role'],
                'description' => $category['description'],
                'layout' => $category['layout'],
                'values' => $category['values'],
            ];
        }

        $firstKey = '';
        foreach ($categories as $slug => $category) {
            $firstKey = $slug;
            break;
        }

        return [
            'categories' => $cleanCategories,
            'members' => $members,
            'total' => count($employees),
            'firstKey' => $firstKey,
        ];
    }

    private function loadCategories()
    {
        $categorySql = "SELECT id, slug, title, icon, color, role, description, field, layout, sort_order
            FROM employee_categories
            WHERE is_active = 1
            ORDER BY sort_order ASC";

        $valueSql = "SELECT category_id, label, payroll_code, effect, sort_order
            FROM employee_category_values
            WHERE is_active = 1
            ORDER BY category_id ASC, sort_order ASC";

        $categoryStmt = $this->db->query($categorySql);
        $valueStmt = $this->db->query($valueSql);

        $categories = [];
        $categoryRows = $categoryStmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($categoryRows as $row) {
            $slug = $row['slug'];
            $categories[$slug] = [
                'id' => (int) $row['id'],
                'title' => $row['title'],
                'icon' => $row['icon'],
                'color' => $row['color'],
                'role' => $this->humanizeRole($row['role']),
                'description' => $row['description'],
                'field' => $row['field'],
                'layout' => $row['layout'],
                'values' => [],
                'map' => [],
            ];
        }

        $valueRows = $valueStmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($valueRows as $row) {
            $categoryId = (int) $row['category_id'];
            $label = $row['label'];
            $payrollCode = (string) $row['payroll_code'];
            $effect = $row['effect'];

            foreach ($categories as $slug => $category) {
                if ((int) $category['id'] === $categoryId) {
                    $categories[$slug]['values'][$label] = $effect;
                    $categories[$slug]['map'][$payrollCode] = $label;
                    break;
                }
            }
        }

        return $categories;
    }

    private function humanizeRole($role)
    {
        $map = [
            'base' => 'Base policy',
            'impact' => 'Impact only',
            'filter' => 'Filter only',
        ];

        return $map[$role] ?? ucfirst((string) $role);
    }

    private function getEmployees()
    {
        return $this->employeeModel->allForCategories();
    }

    private function buildMembers($categories, $employees)
    {
        $members = [];

        foreach ($categories as $slug => $category) {
            $members[$slug] = [];

            foreach ($category['map'] as $payrollCode => $label) {
                $members[$slug][$label] = [];
            }

            foreach ($employees as $employee) {
                $employeeValue = isset($employee[$category['field']])
                    ? (string) $employee[$category['field']]
                    : '';

                if ($employeeValue !== '' && isset($category['map'][$employeeValue])) {
                    $label = $category['map'][$employeeValue];
                    if (isset($members[$slug][$label])) {
                        $members[$slug][$label][] = $employee;
                    }
                }
            }
        }

        return $members;
    }
}
