# Page Creation Skill

Use when:
- creating new pages, views, controllers, and routes in the PHP MVC framework
- setting up navigation with dynamic active/show states
- implementing session management and authentication checks
- adding new features that require new pages or modifying existing page workflows
- understanding the complete page creation process from view to navigation

## What this skill covers
- creating view files with proper PHP variable setup
- building controllers with authentication and data handling
- adding routes with middleware protection
- implementing dynamic sidebar navigation
- session management integration
- complete page creation workflow

### Files to review
- `PAGE_CREATION_GUIDE.md` (comprehensive documentation)
- `app/Views/layouts/admin.php` (main layout template)
- `app/Views/layouts/partials/_nav_2.php` (sidebar navigation)
- `routes/web.php` (routing configuration)
- `app/Controllers/DashboardController.php` (controller example)
- `app/Views/dashboard/index.php` (view example)
- `app/Controllers/ReportsController.php` (new page example)
- `app/Views/reports/index.php` (new view example)

### Key Concepts
- `$currentPage` variable for navigation highlighting
- Controller structure with authentication checks
- Route registration with AuthMiddleware
- Dynamic navigation using PHP conditionals
- Session handling with Session class
- Layout inclusion with `$content` variable

### Common Patterns
- Views start with `<?php $currentPage = 'page_name'; ?>`
- Controllers extend base Controller class
- Routes use `[AuthMiddleware::class]` for protection
- Navigation uses `in_array($currentPage, ['page1', 'page2'])` for dropdowns
- Session checks with `Session::has('user')` and redirects

### Examples
- Reports page: Complete implementation example
- Dashboard: Complex page with multiple sections
- Navigation: Dynamic active/show state management

### Troubleshooting
- Undefined variable errors: Use null coalescing `??` operator
- Navigation not highlighting: Check `$currentPage` matches exactly
- Routes not working: Verify controller method exists and middleware is applied
- Session issues: Ensure Session class is imported and used correctly