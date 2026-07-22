# Holiday Page Creation Guide

This guide explains how to create a new holiday-related page in this system and wire it into the existing MVC structure.

## Goal
Create a new page such as `new_holiday_list.php` that:
- is accessible from the Holidays list page
- keeps the sidebar active item as `holidays`
- uses the admin layout
- follows the existing route/controller/view pattern

## Required Files
For a new holiday page, you normally need:

1. A controller method in `app/Controllers/HolidaysController.php`
2. A route in `routes/web.php`
3. A PHP view file in `app/Views/holidays/`
4. Optional: related CSS/JS assets if the page needs custom date pickers or select controls

## Example Pattern

### 1. Add a controller method
In `app/Controllers/HolidaysController.php`:

```php
public function newHolidayList()
{
    $title = 'New Holiday List';
    $currentPage = 'holidays';
    $content = '../app/Views/holidays/new_holiday_list.php';
    include '../app/Views/layouts/admin.php';
}
```

### 2. Add a route
In `routes/web.php`:

```php
$router->get('/holidays/new', 'HolidaysController@newHolidayList', [AuthMiddleware::class]);
```

### 3. Create the page view
In `app/Views/holidays/new_holiday_list.php`:

```php
<?php $currentPage = 'holidays'; ?>

<nav aria-label="breadcrumb" class="mb-3">
  <ol class="breadcrumb mb-0">
    <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
    <li class="breadcrumb-item"><a href="/holidays">Holiday List</a></li>
    <li class="breadcrumb-item active" aria-current="page">New Holiday List</li>
  </ol>
</nav>
```

### 4. Use the admin layout
Your page should always load through:

```php
include '../app/Views/layouts/admin.php';
```

This ensures the sidebar, topbar, styles, and JS assets are inherited.

## Important Notes
- Always set `$currentPage` at the top of the view file.
- Keep the value aligned with the sidebar key so the correct nav item remains active.
- Use route names that are consistent with the feature, for example:
  - `/holidays`
  - `/holidays/new`
  - `/holidays/edit`
- Use `AuthMiddleware::class` for authenticated pages.

## Reusable Button Pattern
If you want a page action button to open a new page:

```php
<a class="btn btn-falcon-default btn-sm" href="/holidays/new" type="button">
  <span class="fas fa-plus" data-fa-transform="shrink-3 down-2"></span>
  <span class="d-none d-sm-inline-block ms-1">Add Holiday</span>
</a>
```

## Future Checklist
When creating any new page:

1. Decide the feature section key (`dashboard`, `employees`, `holidays`, etc.)
2. Create a controller method
3. Add the route
4. Create the view file
5. Set `$currentPage` in the view
6. Link the button or menu item to the route
7. Keep the breadcrumb consistent with the section
8. Verify the page loads via the admin layout

## Example Summary for the Holidays Feature
- List page: `app/Views/holidays/index.php`
- New page: `app/Views/holidays/new_holiday_list.php`
- Controller: `app/Controllers/HolidaysController.php`
- Route: `/holidays/new`
- Active sidebar key: `holidays`
