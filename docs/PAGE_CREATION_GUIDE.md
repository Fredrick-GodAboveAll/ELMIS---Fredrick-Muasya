# PHP Page Creation Guide - Leave Management System

## Overview
This guide explains how to add new pages, controllers, and set up proper navigation with active/show states in the PHP Leave Management System. This framework uses a custom MVC architecture with Bootstrap 5 UI components.

## Table of Contents
1. [Creating a New Page](#creating-a-new-page)
2. [Creating a Controller](#creating-a-controller)
3. [Adding Routes](#adding-routes)
4. [Setting Up Navigation](#setting-up-navigation)
5. [Session Management](#session-management)
6. [Database Integration](#database-integration)
7. [Complete Example](#complete-example)
8. [Best Practices](#best-practices)
9. [Troubleshooting](#troubleshooting)

## Creating a New Page

### Step 1: Create the View File
Create a new PHP file in the appropriate views directory:

```php
<?php $currentPage = 'your_page_name'; ?>

<!-- Your page content here -->
<div class="row g-3 mb-3">
  <div class="col-xxl-12 col-xl-12">
    <div class="card">
      <div class="card-header">
        <h6 class="mb-0 mt-2 d-flex align-items-center">
          Your Page Title
          <span class="ms-1 text-400" data-bs-toggle="tooltip" data-bs-placement="top" title="Page description">
            <span class="far fa-question-circle" data-fa-transform="shrink-1"></span>
          </span>
        </h6>
      </div>
      <div class="card-body">
        <!-- Your content -->
        <p>Your page content goes here.</p>
      </div>
    </div>
  </div>
</div>
```

**Important:** Always set `$currentPage` at the top of your view file. This variable controls the navigation highlighting.

### Step 2: Directory Structure
Place your view files in the appropriate subdirectories:
- `app/Views/dashboard/` - Dashboard related pages
- `app/Views/employees/` - Employee management pages
- `app/Views/leaves/` - Leave management pages
- `app/Views/departments/` - Department pages
- `app/Views/holidays/` - Holiday pages
- `app/Views/leave_types/` - Leave type pages

## Creating a New Page

### Step 1: Create the View File
Create a new PHP file in the appropriate views directory:

```php
<?php $currentPage = 'your_page_name'; ?>

<!-- Your page content here -->
<div class="row g-3 mb-3">
  <div class="col-xxl-12 col-xl-12">
    <div class="card">
      <div class="card-header">
        <h5 class="fs-9 mb-0 text-nowrap py-2 py-xl-0">Your Page Title</h5>
      </div>
      <div class="card-body">
        <!-- Your content -->
        <p>Your page content goes here.</p>
      </div>
    </div>
  </div>
</div>
```

**Important:** Always set `$currentPage` at the top of your view file. This variable controls the navigation highlighting.

### Step 2: Directory Structure
Place your view files in the appropriate subdirectories:
- `app/Views/dashboard/` - Dashboard related pages
- `app/Views/employees/` - Employee management pages
- `app/Views/leaves/` - Leave management pages
- `app/Views/departments/` - Department pages
- `app/Views/holidays/` - Holiday pages
- `app/Views/leave_types/` - Leave type pages

## Creating a Controller

### Basic Controller Structure
Create a new controller in `app/Controllers/`:

```php
<?php
namespace App\Controllers;

class YourControllerName extends Controller
{
    public function index()
    {
        $title = 'Your Page Title';
        $currentPage = 'your_page_name'; // Must match the view's $currentPage
        $content = '../app/Views/your_directory/index.php';
        include '../app/Views/layouts/admin.php';
    }

    // Add more methods as needed
    public function create()
    {
        $title = 'Create New Item';
        $currentPage = 'your_page_name';
        $content = '../app/Views/your_directory/create.php';
        include '../app/Views/layouts/admin.php';
    }
}
```

### Controller Naming Convention
- File name: `YourControllerName.php`
- Class name: `YourControllerName`
- Extends: `Controller` (base controller class)

## Adding Routes

### Update routes/web.php
Add your routes to the routes file:

```php
// Add to the protected routes section (after line 25)
$router->get('/your-route', 'YourControllerName@index', [AuthMiddleware::class]);
$router->get('/your-route/create', 'YourControllerName@create', [AuthMiddleware::class]);
$router->post('/your-route/store', 'YourControllerName@store', [AuthMiddleware::class]);
```

### Route Structure
- **GET** routes for displaying pages
- **POST** routes for form submissions
- Always include `[AuthMiddleware::class]` for protected routes
- Use consistent URL patterns

## Setting Up Navigation

### Update Sidebar Navigation (_nav_2.php)

#### For Single Pages (no dropdown):
```php
<a class="nav-link <?php echo ($currentPage === 'your_page_name') ? 'active' : ''; ?>" href="/your-route" role="button">
  <div class="d-flex align-items-center">
    <span class="nav-link-icon"><span class="fas fa-your-icon"></span></span>
    <span class="nav-link-text ps-1">Your Page Name</span>
  </div>
</a>
```

#### For Dropdown Menus:
```php
<a class="nav-link dropdown-indicator <?php echo (in_array($currentPage, ['page1', 'page2'])) ? '' : 'collapsed'; ?>" href="#your-dropdown"
role="button" data-bs-toggle="collapse" aria-expanded="<?php echo (in_array($currentPage, ['page1', 'page2'])) ? 'true' : 'false'; ?>" aria-controls="your-dropdown">
  <div class="d-flex align-items-center">
    <span class="nav-link-icon"><span class="fas fa-your-icon"></span></span>
    <span class="nav-link-text ps-1">Your Section</span>
  </div>
</a>
<ul class="nav collapse <?php echo (in_array($currentPage, ['page1', 'page2'])) ? 'show' : ''; ?>" id="your-dropdown">
  <li class="nav-item">
    <a class="nav-link <?php echo ($currentPage === 'page1') ? 'active' : ''; ?>" href="/route1">
      <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Page 1</span></div>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link <?php echo ($currentPage === 'page2') ? 'active' : ''; ?>" href="/route2">
      <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Page 2</span></div>
    </a>
  </li>
</ul>
```

### Navigation Logic
- **Single pages**: Use `($currentPage === 'your_page_name') ? 'active' : ''`
- **Dropdown parents**: Use `in_array($currentPage, ['page1', 'page2'])` for multiple pages
- **aria-expanded**: Set to 'true' when dropdown should be open
- **show class**: Add 'show' class when dropdown should be expanded

## Database Integration

### Using the Database Class
The system uses PDO with a custom Database class for database operations:

```php
<?php
namespace App\Controllers;
use App\Core\Database;

class YourController extends Controller
{
    public function index()
    {
        $pdo = Database::getInstance();

        // Simple query
        $stmt = $pdo->query('SELECT COUNT(*) AS total FROM employees');
        $employeeCount = $stmt->fetch()->total ?? 0;

        // Prepared statement
        $stmt = $pdo->prepare('SELECT * FROM employees WHERE department_id = ?');
        $stmt->execute([$departmentId]);
        $employees = $stmt->fetchAll();

        // Insert operation
        $stmt = $pdo->prepare('INSERT INTO employees (name, email) VALUES (?, ?)');
        $stmt->execute([$name, $email]);

        $title = 'Your Page';
        $currentPage = 'your_page';
        $content = '../app/Views/your_directory/index.php';
        include '../app/Views/layouts/admin.php';
    }
}
```

### Database Methods
- `Database::getInstance()` - Get PDO instance
- `$pdo->query($sql)` - Execute simple queries
- `$pdo->prepare($sql)` - Prepare statements
- `$stmt->execute($params)` - Execute prepared statements
- `$stmt->fetch()` - Fetch single row
- `$stmt->fetchAll()` - Fetch all rows

## Environment Variables and dotenv

This system can use an `.env` file for sensitive credentials. The recommended package is `vlucas/phpdotenv`.

Add these settings to your `.env` file:

```bash
DB_HOST=localhost
DB_NAME=leave_management
DB_USER=root
DB_PASS=
```

Then load env variables at application boot in `public/index.php`:

```php
if (class_exists(\Dotenv\Dotenv::class)) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->safeLoad();
}
```

The database config file can then use `getenv('DB_HOST')` and related values.

## Complete Example

Let's create a "Reports" page as an example:

### 1. Create View (app/Views/reports/index.php)
```php
<?php $currentPage = 'reports'; ?>

<div class="row g-3 mb-3">
  <div class="col-xxl-12 col-xl-12">
    <div class="card">
      <div class="card-header">
        <h5 class="fs-9 mb-0 text-nowrap py-2 py-xl-0">Reports Dashboard</h5>
      </div>
      <div class="card-body">
        <p>Reports content goes here.</p>
      </div>
    </div>
  </div>
</div>
```

### 2. Create Controller (app/Controllers/ReportsController.php)
```php
<?php
namespace App\Controllers;
use App\Core\Session;

class ReportsController extends Controller
{
    public function index()
    {
        // Check authentication
        if (!Session::has('user')) {
            header('Location: /login');
            exit;
        }

        $title = 'Reports Dashboard';
        $currentPage = 'reports';
        $content = '../app/Views/reports/index.php';
        include '../app/Views/layouts/admin.php';
    }
}
```

### 3. Add Route (routes/web.php)
```php
$router->get('/reports', 'ReportsController@index', [AuthMiddleware::class]);
```

### 4. Update Navigation (_nav_2.php)
Add to the appropriate section:
```php
<a class="nav-link <?php echo ($currentPage === 'reports') ? 'active' : ''; ?>" href="/reports" role="button">
  <div class="d-flex align-items-center">
    <span class="nav-link-icon"><span class="fas fa-chart-bar"></span></span>
    <span class="nav-link-text ps-1">Reports</span>
  </div>
</a>
```

## Best Practices

1. **Consistent Naming**: Use lowercase with underscores for `$currentPage` values
2. **Security**: Always include `AuthMiddleware::class` for protected routes
3. **Session Checks**: Verify user authentication in controllers
4. **Error Handling**: Implement proper error handling and redirects
5. **Code Organization**: Keep controllers clean and views simple
6. **Navigation Logic**: Test navigation states on all pages
7. **Database Safety**: Use prepared statements for all user inputs
8. **Variable Safety**: Use null coalescing operator `??` for optional variables
9. **File Structure**: Follow the established directory structure
10. **Documentation**: Document any custom logic or complex operations

## Troubleshooting

### Navigation Not Highlighting
- Check that `$currentPage` matches exactly in both view and navigation
- Verify the PHP conditional logic in navigation
- Ensure the view file is being loaded correctly

### Page Not Loading
- Check route registration in `routes/web.php`
- Verify controller method exists and is named correctly
- Check file paths and permissions
- Review PHP error logs

### Session Issues
- Ensure Session class is properly imported
- Check session configuration in `config/app.php`
- Verify session data is being set correctly

### Database Connection Issues
- Verify Database class is imported
- Check database configuration in `config/database.php`
- Ensure PDO is available and configured correctly

### Undefined Variable Errors
- Use null coalescing operator: `$variable ?? 'default'`
- Check if variables are passed from controller to view
- Verify controller logic sets all required variables

---

**Created:** April 30, 2026
**Version:** 2.0
**Framework:** Custom PHP MVC
**Updated:** Added database integration, enhanced examples, improved troubleshooting