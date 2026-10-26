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
                'description' => 'Employee divisions for engagement type.',
                'preview' => ['Permanent', 'Contract', 'Intern', 'Casual'],
            ],
            [
                'slug' => 'employment-status',
                'title' => 'Employment Status',
                'table' => 'employment_statuses',
                'description' => 'Employee lifecycle categories.',
                'preview' => ['Active', 'Suspended', 'Resigned', 'Retired'],
            ],
            [
                'slug' => 'confirmation-status',
                'title' => 'Confirmation Status',
                'table' => 'confirmation_statuses',
                'description' => 'Employee confirmation and probation status.',
                'preview' => ['Probation', 'Confirmed (P&P)', 'Not Applicable'],
            ],
            [
                'slug' => 'gender',
                'title' => 'Gender',
                'table' => 'genders',
                'description' => 'Employee gender categories.',
                'preview' => ['Male', 'Female'],
            ],
            [
                'slug' => 'special-need',
                'title' => 'Special Need',
                'table' => 'special_needs',
                'description' => 'Employee support and accessibility categories.',
                'preview' => ['PWD', 'None'],
            ],
            [
                'slug' => 'job-group',
                'title' => 'Job Group',
                'table' => 'job_groups',
                'description' => 'Employee job grading categories.',
                'preview' => ['H', 'J', 'K', 'L', 'M', 'N', 'P', 'Q', 'R'],
            ],
            [
                'slug' => 'department',
                'title' => 'Department',
                'table' => 'departments',
                'description' => 'Employee organisational divisions.',
                'preview' => ['Human Resources', 'Finance', 'Energy', 'Operations'],
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
                'preview' => $definition['preview'] ?? [],
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
            'confirmation_statuses' => 'confirmation_status_id',
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

