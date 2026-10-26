# Architecture and Development Guide

## Project architecture

ELMIS uses a lightweight custom MVC pattern built in plain PHP. The codebase is organized by responsibility rather than by a framework convention.

### Core responsibilities

#### Controllers
- receive HTTP requests
- pass data to services
- decide which view to render
- handle redirects and flash messages

#### Services
- contain business logic and validation
- handle calculations and rule checks
- keep system logic out of the controller layer

#### Models
- handle database queries and persistence
- represent the project’s key database entities

#### Views
- render the admin pages and templates
- live under `app/Views`
- follow the project’s layout and page styling pattern

#### Middleware
- enforce authentication
- check roles and route access
- protect sensitive pages and actions

## Route structure

The route entries live in:

- `routes/web.php`

The project already includes routes for:

- authentication flows
- employee and department pages
- dashboard and reports
- leave pages
- holiday and policy setup
- bulk import tools
- admin-only screens

This is the central map for the application.

## Page creation flow

When creating a new page, use this order:

1. add a controller method
2. register the route in `routes/web.php`
3. create or update the relevant view in `app/Views/...`
4. set the active page key in the view
5. confirm auth/role restrictions
6. check that layout and asset paths still resolve correctly

### Example controller pattern

```php
public function index()
{
    $title = 'Example Page';
    $currentPage = 'example_page';
    $content = '../app/Views/example/page.php';
    include '../app/Views/layouts/admin.php';
}
```

### Example route pattern

```php
$router->get('/example-page', 'ExampleController@index', [AuthMiddleware::class]);
```

## Naming conventions used in the project

- controller files end with `Controller.php`
- model files represent a domain entity like `Employee.php` or `LeaveType.php`
- service files represent business modules like `LeaveCalculator.php`
- views are grouped by feature area such as `employees`, `departments`, or `leave_management`

## Schema and database rules

The main schema is kept in:

- `config/database.sql`

This should be treated as the canonical structure for the application’s core tables.

## Validation rules

The project is most maintainable when business validation lives in services rather than controllers. This keeps rules consistent across create, update, and calculation workflows.

This is especially important for leave logic because it touches entitlements, balances, dates, holidays, and policies.

## Security and integrity guidelines

- protect routes with middleware
- validate form submissions on the server
- do not trust browser input alone
- keep leave calculations and balances in the backend
- apply role checks where admin-only actions exist

## Layout and asset rule

A known issue in this project was broken layout assets when pages are opened from nested routes. The fix is to keep asset URLs root-relative.

Use patterns like:

- `/assets/css/theme.min.css`
- `/vendors/bootstrap/bootstrap.min.js`

instead of relative paths that depend on the current URL depth.

## Best practices for this codebase

- keep route names and controller names aligned
- keep logic out of the view layer
- prefer the service layer for validation and calculations
- stay consistent with existing module structure
- write tests for important rules and edge cases
- update docs as the project evolves

## Standard project pattern

The clean working pattern in this project is:

- Controller = request handling
- Service = business rules and calculations
- Model = database access
- View = presentation
- Middleware = access control

This is the foundation the project currently uses and the standard to follow for future work.
