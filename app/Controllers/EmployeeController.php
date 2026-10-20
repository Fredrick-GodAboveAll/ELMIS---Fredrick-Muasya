<?php
namespace App\Controllers;

use App\Core\Database;
use App\Models\Employee;

class EmployeeController extends Controller
{
    private function categoryDefinitions(): array
    {
        return [
            [
                'slug' => 'employment-terms',
                'title' => 'Employment Terms',
                'table' => 'employment_terms',
                'description' => 'Manage contract types.',
            ],
            [
                'slug' => 'employment-status',
                'title' => 'Employment Status',
                'table' => 'employment_statuses',
                'description' => 'Track employee lifecycle.',
            ],
            [
                'slug' => 'gender',
                'title' => 'Gender',
                'table' => 'genders',
                'description' => 'Maintain identity options.',
            ],
            [
                'slug' => 'special-need',
                'title' => 'Special Need',
                'table' => 'special_needs',
                'description' => 'Record support and accommodation needs.',
            ],
            [
                'slug' => 'job-group',
                'title' => 'Job Group',
                'table' => 'job_groups',
                'description' => 'Organize job groups.',
            ],
            [
                'slug' => 'department',
                'title' => 'Department',
                'table' => 'departments',
                'description' => 'Set up company departments.',
            ],
        ];
    }

    public function index()
    {
        $employeeModel = new Employee();
        $employees = $employeeModel->all();

        $title = 'Employees';
        $currentPage = 'employees';
        $content = '../app/Views/employees/index.php';
        include '../app/Views/layouts/admin.php';
    }

    public function design()
    {
        $title = 'Employee Design';
        $currentPage = 'employee_design';
        $content = '../app/Views/employees/design.php';
        include '../app/Views/layouts/admin.php';
    }

    public function category()
    {
        $db = Database::getInstance();
        $definitions = $this->categoryDefinitions();
        $categories = [];

        foreach ($definitions as $definition) {
            $countSql = "SELECT COUNT(*) FROM {$definition['table']}";
            $count = (int) $db->query($countSql)->fetchColumn();

            $categories[] = [
                'slug' => $definition['slug'],
                'title' => $definition['title'],
                'description' => $definition['description'],
                'count' => $count,
            ];
        }

        $title = 'Employee Categories';
        $currentPage = 'employee_categories';
        $content = '../app/Views/employees/category.php';
        include '../app/Views/layouts/admin.php';
    }

    private function categoryEmployeeColumns(): array
    {
        return [
            'genders' => 'gender_id',
            'employment_terms' => 'employment_term_id',
            'employment_statuses' => 'employment_status_id',
            'job_groups' => 'job_group_id',
            'special_needs' => 'special_need_id',
            'departments' => 'department_id',
        ];
    }

    private function fetchEmployeeNamesForLookup(string $table, string $foreignKeyColumn, int $lookupId): string
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT full_name FROM employees WHERE {$foreignKeyColumn} = :lookup_id ORDER BY full_name ASC");
        $stmt->execute(['lookup_id' => $lookupId]);

        $names = array_values(array_filter($stmt->fetchAll(\PDO::FETCH_COLUMN), fn($name) => $name !== null && trim((string) $name) !== ''));

        if (empty($names)) {
            return '0 — —';
        }

        return count($names) . ' — ' . implode(', ', $names);
    }

    public function categoryView()
    {
        $db = Database::getInstance();
        $definitions = $this->categoryDefinitions();
        $slug = $_GET['category'] ?? $definitions[0]['slug'];

        $selected = null;
        foreach ($definitions as $definition) {
            if ($definition['slug'] === $slug) {
                $selected = $definition;
                break;
            }
        }

        if ($selected === null) {
            $selected = $definitions[0];
        }

        $table = $selected['table'];
        $count = (int) $db->query("SELECT COUNT(*) FROM {$table}")->fetchColumn();
        $rows = $db->query("SELECT * FROM {$table} ORDER BY id ASC")->fetchAll();

        $normalizedRows = [];
        foreach ($rows as $row) {
            $rowArray = is_object($row) ? get_object_vars($row) : (array) $row;
            $normalizedRows[] = $rowArray;
        }

        $employeeColumns = $this->categoryEmployeeColumns();
        $foreignKeyColumn = $employeeColumns[$table] ?? null;

        if ($foreignKeyColumn !== null) {
            foreach ($normalizedRows as $index => $rowArray) {
                $lookupId = (int) ($rowArray['id'] ?? 0);
                $normalizedRows[$index]['employee_names'] = $this->fetchEmployeeNamesForLookup($table, $foreignKeyColumn, $lookupId);
            }
        }

        $rows = $normalizedRows;

        $title = $selected['title'];
        $currentPage = 'employee_category_view';
        $content = '../app/Views/employees/category/view.php';
        include '../app/Views/layouts/admin.php';
    }

    public function categoryDetail()
    {
        $this->categoryView();
    }
}

