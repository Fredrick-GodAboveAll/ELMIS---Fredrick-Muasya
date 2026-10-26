# ELMIS Developer Guide

This is the main developer guide for the ELMIS project. It gives the current structure, working patterns, and project status in one place.

## Main documentation

1. [Project Overview](project-overview.md) - project purpose, modules, stack, and setup
2. [Architecture and Development Guide](architecture-and-development-guide.md) - MVC layout, routes, controllers, services, and page creation rules
3. [Leave Management Guide](leave-management-guide.md) - leave types, periods, entitlements, policies, holidays, and workflow logic
4. [Project Progress](progress.md) - current implementation status, remaining work, and next priorities

## Quick start

```bash
composer install
```

Import the database schema from:

- `config/database.sql`

Run the app:

```bash
php -S localhost:8000 -t public
```

Open:

```text
http://localhost:8000
```

## Project structure

- `app/Controllers` - request handling and route actions
- `app/Models` - database access and entity logic
- `app/Services` - validation, rules, and calculations
- `app/Views` - UI templates and admin pages
- `app/Core` - framework utilities and shared support
- `app/Middleware` - auth and role checks
- `routes/web.php` - URL routing
- `config/` - app, DB, and schema configuration
- `tests/` - automated project tests
- `docs/archive/` - older notes kept as historical reference

## Working pattern used in this project

This project follows a simple custom MVC structure:

- Controller: receives requests and prepares data
- Service: holds business logic and validation
- Model: talks to the database
- View: renders the page
- Middleware: protects routes and permissions

## How to use this guide

- Use the overview for the business domain and app setup.
- Use the architecture guide when adding pages, routes, or services.
- Use the leave guide when working on leave logic, entitlements, policies, or holidays.
- Update the progress file after a milestone or major feature completion.

## Important note

ELMIS is a custom PHP project, not a framework-based app. The architecture is intentionally practical and lightweight, and it follows the patterns already used across the current codebase.
