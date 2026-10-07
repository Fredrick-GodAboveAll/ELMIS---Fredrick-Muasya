# Employee Categories Page Guide

This document explains how the Employee Categories page was added, how it works, what files were changed, the main issues we encountered, and how to safely revert it back to the original state if needed.

---

## 1. What this page is for

The Employee Categories page is a generic HR management screen used to group employees into broad categories such as:

- Permanent Staff
- Contract Staff
- Interns
- Part-Time Staff

It is intentionally simple and does not yet connect to a database table or a full CRUD system. It is designed as a starter page that follows the existing app patterns and can later be extended into a real admin module.

The purpose is to:

- organize employees by classification
- make workforce reporting simpler
- provide a clean area for HR setup and policy grouping
- match the app's existing style and navigation structure

---

## 2. What changed in the project

The page was added using the system's normal MVC pattern.

### Files changed

1. Controller
   - app/Controllers/EmployeeController.php

2. Route registration
   - routes/web.php

3. Sidebar navigation
   - app/Views/layouts/partials/_nav_2.php

4. New page view
   - app/Views/employees/categories.php

---

## 3. How the page works internally

The system follows a simple MVC flow:

1. The browser visits a URL
2. The router matches the URL to a controller method
3. The controller prepares data and chooses a view file
4. The view renders HTML using the admin layout
5. The sidebar highlights the current page using currentPage

### Real flow for this page

The route is:

```php
$router->get('/employee-categories', 'EmployeeController@categories', [AuthMiddleware::class]);
```

This tells the router:

- when the user opens /employee-categories
- run the categories() method in EmployeeController
- require authentication through AuthMiddleware

Then in the controller:

```php
public function categories()
{
    $title = 'Employee Categories';
    $currentPage = 'employee_categories';
    $content = '../app/Views/employees/categories.php';
    include '../app/Views/layouts/admin.php';
}
```

This does three important things:

- sets the page title
- sets the currentPage value used by the sidebar to know which menu item is active
- tells the app which view file to render

The admin layout then loads the page content and the navigation partial, so the new page looks like the rest of the project.

---

## 4. How the view is structured

The new page file is:

- app/Views/employees/categories.php

This file starts with:

```php
<?php $currentPage = 'employee_categories'; ?>
```

This is critical because the sidebar checks the current page value and highlights the correct menu item.

The page contains:

- breadcrumb navigation
- top action button
- header section titled "# Employee categories"
- category cards
- overview table
- short HR explanation text

This is generic content only. No database logic is attached yet.

---

## 5. How the navigation was connected

The left-side navigation is controlled in:

- app/Views/layouts/partials/_nav_2.php

The employee menu was updated to include the new category item under the Employees section.

Example structure:

```php
<ul class="nav collapse <?php echo (in_array($currentPage, ['employees', 'employee_categories'])) ? 'show' : ''; ?>" id="employees">
    <li class="nav-item">
        <a class="nav-link <?php echo ($currentPage === 'employees') ? 'active' : ''; ?>" href="/employees">
            <div class="d-flex align-items-center"><span class="nav-link-text ps-1">employee list</span></div>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link <?php echo ($currentPage === 'employee_categories') ? 'active' : ''; ?>" href="/employee-categories">
            <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Employee categories</span></div>
        </a>
    </li>
</ul>
```

This ensures:

- the employees dropdown stays open when you are on the page
- the Employee categories link is highlighted as active

---

## 6. The issues we had and how to avoid them

These are the most common mistakes in this project when adding a page.

### Issue 1: Page loads but menu does not highlight

Cause:

- currentPage in the view and the menu logic do not match

Example:

- view: employee_categories
- nav check: employees

Fix:

- make both use the same key such as employee_categories

### Issue 2: 404 Page Not Found

Cause:

- route was missing or the controller method name was incorrect

Example:

- route file has /employee-categories but controller method is categories() and it is spelled correctly
- if route says @category but method is categories(), it will fail

Fix:

- route and method names must match exactly

### Issue 3: White screen or blank page

Cause:

- view file path in the controller is wrong
- PHP syntax error in the view
- missing semicolon or brace

Fix:

- confirm the view path is correct, for example:

```php
$content = '../app/Views/employees/categories.php';
```

- run PHP lint checks after editing

### Issue 4: Page not accessible because authentication is missing

Cause:

- route not protected with AuthMiddleware

Fix:

- use:

```php
$router->get('/employee-categories', 'EmployeeController@categories', [AuthMiddleware::class]);
```

### Issue 5: Page is present but not under the expected section

Cause:

- the menu item was added in the wrong place or not inside the correct dropdown

Fix:

- place it under the Employees menu group in the sidebar partial

### Issue 6: The page looks different from the rest of the app

Cause:

- the view did not use the admin layout or dashboard conventions

Fix:

- always render through the layout by setting the content variable and including admin.php

---

## 7. The whole process step by step

This is the full pattern for adding a page in this project.

### Step 1: Decide the URL

Choose a route path such as:

```php
/employee-categories
```

### Step 2: Add the route

Edit routes/web.php and add:

```php
$router->get('/employee-categories', 'EmployeeController@categories', [AuthMiddleware::class]);
```

### Step 3: Add the controller method

Edit app/Controllers/EmployeeController.php and add:

```php
public function categories()
{
    $title = 'Employee Categories';
    $currentPage = 'employee_categories';
    $content = '../app/Views/employees/categories.php';
    include '../app/Views/layouts/admin.php';
}
```

### Step 4: Create the view file

Create a file such as:

- app/Views/employees/categories.php

Set the current page at the top:

```php
<?php $currentPage = 'employee_categories'; ?>
```

Then add the actual HTML markup and page sections.

### Step 5: Connect sidebar navigation

Update the sidebar in:

- app/Views/layouts/partials/_nav_2.php

Add a link like:

```php
<a class="nav-link <?php echo ($currentPage === 'employee_categories') ? 'active' : ''; ?>" href="/employee-categories">
  <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Employee categories</span></div>
</a>
```

### Step 6: Test the page

Load the route in the browser and check:

- page opens without 404
- layout appears correctly
- sidebar stays active
- page content loads

### Step 7: Validate PHP syntax

Run this command:

```bash
php -l app/Controllers/EmployeeController.php
php -l routes/web.php
php -l app/Views/employees/categories.php
```

This confirms there are no basic PHP syntax issues.

---

## 8. How to reverse to normal

If you want to remove the Employee Categories page and restore the app to its original state, follow this process.

### Option A: Manual rollback

#### 1. Remove the route from routes/web.php

Delete:

```php
$router->get('/employee-categories', 'EmployeeController@categories', [AuthMiddleware::class]);
```

#### 2. Remove the controller method from EmployeeController.php

Delete this block:

```php
public function categories()
{
    $title = 'Employee Categories';
    $currentPage = 'employee_categories';
    $content = '../app/Views/employees/categories.php';
    include '../app/Views/layouts/admin.php';
}
```

#### 3. Remove the sidebar item from _nav_2.php

Delete the Employee categories link from the employees dropdown.

#### 4. Delete the view file

Remove:

- app/Views/employees/categories.php

This returns the app to the original state.

### Option B: Using git if available

If the project is tracked with git, the fastest rollback is:

```bash
git checkout -- app/Controllers/EmployeeController.php routes/web.php app/Views/layouts/partials/_nav_2.php
rm app/Views/employees/categories.php
```

Or for a more precise rollback to a previous commit:

```bash
git revert <commit-hash>
```

Use this only if you want to undo all related changes completely.

---

## 9. Recommended best practices

- Keep routes, controller names, and method names consistent
- Always set currentPage in every view
- Keep menu keys aligned with the view value
- Test after each page addition
- Avoid making database changes before the page UI is stable
- Keep generic pages simple before converting them into CRUD pages

---

## 10. The current state of this page

This page is currently a generic example page. It is connected and working based on the existing app architecture, but it does not yet include:

- database persistence
- edit functionality
- create and delete actions
- category persistence to a table
- role-based restrictions

It is a good foundation for a future admin module, and it follows the correct pattern for the project.

---

## 11. Final summary

The Employee Categories page was added using the same process as the rest of the app:

- route registration
- controller action
- view rendering
- sidebar navigation
- active state tracking

The most important lesson is: in this app, a page only works correctly when all four parts are aligned:

- route
- controller action
- view file
- navigation state

Once those match, the app behaves consistently and the page integrates cleanly with the rest of the system.

If you want the next step, the best improvement would be to turn this generic page into a real database-backed employee category management module with create, edit, delete, and status controls.
