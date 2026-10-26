# MVC Database Connection and Table Display Guide

This guide explains how to connect this PHP app to the database, fetch records using a model, pass the data through a controller, and display it in a view table with clean error handling.

---

## 1. Project structure

The app follows a simple MVC pattern:

- `app/Controllers/` → controller logic
- `app/Models/` → database queries and model classes
- `app/Views/` → HTML output
- `app/Core/Database.php` → database connection class
- `config/database.php` → database credentials

Example:

- Controller loads model data
- Model queries the database
- View loops through records and prints rows in HTML

---

## 2. Database connection setup

The app already has a database connection class in `app/Core/Database.php`.

Example:

```php
<?php
namespace App\Core;

use PDO;
use PDOException;

class Database
{
    private static $instance = null;
    private $pdo;

    private function __construct()
    {
        $config = require __DIR__ . '/../../config/database.php';

        try {
            $this->pdo = new PDO(
                "mysql:host={$config['host']};dbname={$config['name']};charset=utf8mb4",
                $config['user'],
                $config['pass'],
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                ]
            );
        } catch (PDOException $e) {
            die('Database connection failed: ' . $e->getMessage());
        }
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance->pdo;
    }
}
```

Database credentials are stored in:

```php
<?php
return [
    'host' => 'localhost',
    'name' => 'leave_management',
    'user' => 'root',
    'pass' => '',
];
```

Make sure the database name matches your MySQL database.

---

## 3. Base model pattern

The base model in `app/Models/Model.php` gives each model access to the database connection.

```php
<?php
namespace App\Models;

use App\Core\Database;
use PDO;

abstract class Model
{
    protected $db;
    protected $table;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function find($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}
```

This is the shared foundation for model classes.

---

## 4. Create a model for records

For departments, the model should sit in `app/Models/Department.php` and query the table.

Example:

```php
<?php
namespace App\Models;

use PDO;

class Department extends Model
{
    protected $table = 'departments';

    public function all()
    {
        $sql = "SELECT
                    d.id,
                    d.name,
                    d.code,
                    d.head_of_department,
                    COUNT(emp.payroll_number) AS employee_count
                FROM {$this->table} d
                LEFT JOIN employees emp ON emp.department_id = d.id
                GROUP BY d.id, d.name, d.code, d.head_of_department
                ORDER BY d.name ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
```

### Why this is MVC-friendly
- The model knows how to read data from the database
- The controller decides what receives that data
- The view simply renders the records

---

## 5. Fetch data in the controller

The controller should create a model instance and fetch records before loading the view.

Example in `app/Controllers/DepartmentController.php`:

```php
<?php
namespace App\Controllers;

use App\Models\Department;

class DepartmentController extends Controller
{
    public function index()
    {
        $departmentModel = new Department();

        try {
            $departments = $departmentModel->all();
        } catch (\Throwable $e) {
            $departments = [];
            $errorMessage = 'Unable to load departments at the moment.';
        }

        $title = 'Departments';
        $currentPage = 'departments';
        $content = '../app/Views/departments/index.php';

        include '../app/Views/layouts/admin.php';
    }
}
```

### Important notes
- Keep database logic in the model
- Keep page-specific logic in the controller
- Do not write SQL inside the view

---

## 6. Pass records to the view

The view is not supposed to query the database. It receives data from the controller.

Example in `app/Views/departments/index.php`:

```php
<?php $currentPage = 'departments'; ?>

<div class="card-body px-0 pt-0">
    <table class="table table-sm mb-0">
        <thead>
            <tr>
                <th>Department Name</th>
                <th>Employees</th>
                <th>Department Code</th>
                <th>Head of Department</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($departments)): ?>
                <?php foreach ($departments as $department): ?>
                    <tr>
                        <td><?= htmlspecialchars((string) ($department->name ?? 'N/A'), ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?= htmlspecialchars((string) ($department->employee_count ?? 0), ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?= htmlspecialchars((string) ($department->code ?? 'N/A'), ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?= htmlspecialchars((string) ($department->hod_name ?? 'Not assigned'), ENT_QUOTES, 'UTF-8'); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="text-center py-4">No departments found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
```

This pattern keeps the HTML clean and secure.

---

## 7. Secure output and error handling

### Always sanitize output
Use `htmlspecialchars()` when printing values from the database:

```php
<?= htmlspecialchars((string) $department->name, ENT_QUOTES, 'UTF-8'); ?>
```

This prevents cross-site scripting (XSS).

### Catch database errors
Wrap model calls in `try/catch`:

```php
try {
    $departments = $departmentModel->all();
} catch (\Throwable $e) {
    $departments = [];
    $errorMessage = 'Unable to load departments.';
}
```

### Show friendly messages
Use a message in the view if there is no data or the query fails:

```php
<?php if (!empty($errorMessage)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($errorMessage, ENT_QUOTES, 'UTF-8'); ?></div>
<?php endif; ?>
```

---

## 8. MVC flow summary

1. User visits `/departments`
2. Router maps the URL to `DepartmentController@index`
3. Controller creates `Department` model
4. Model queries the database and returns rows
5. Controller passes `$departments` into the view
6. View loops through the data and prints the table rows
7. If something fails, the app shows a safe error message instead of crashing

---

## 9. Good development pattern

When adding a new table, follow this pattern:

1. Create or update a table in MySQL
2. Add a model in `app/Models/`
3. Add a method like `all()` or `find()`
4. Use the model inside the controller
5. Render the data in the matching view
6. Escape output and handle exceptions

---

## 10. Example checklist

Before finishing any page, confirm these are true:

- [ ] Database credentials are correct
- [ ] Table exists in MySQL
- [ ] Model method uses the correct SQL
- [ ] Controller loads model data
- [ ] View loops through records
- [ ] Output is escaped with `htmlspecialchars()`
- [ ] Exceptions are caught and handled gracefully

---

## 11. Common mistakes

Avoid these common issues:

- Writing SQL directly in the view
- Forgetting `try/catch`
- Not escaping output
- Using wrong table or column names
- Not matching the controller and route
- Hardcoding data instead of using the database

---

## 12. Final recommendation

Keep the database access layer in models, keep the logic in controllers, and keep the HTML in views. That is the clean MVC approach and it makes the project easier to maintain and debug.

If you want, I can also create a matching `Employee` model and view example using the same pattern, or help add a proper `DepartmentController@store` and form for adding new departments.
