# ELMS - Employee Leave Management System

This repository contains a custom PHP MVC leave management system built for HR, admin, and employee operations. It is designed to manage employee records, leave requests, departments, leave policies, financial years, holiday lists, and reporting workflows.

> This project is proprietary software. See the [LICENSE](LICENSE) file for licensing details.

## Overview

The application uses a lightweight custom MVC framework built in plain PHP. It includes:

- user authentication and role-based access control
- employee management and department structure
- leave type and leave entitlement setup
- leave application workflows
- financial year and holiday management
- dashboard summaries and administrative reports
- bulk import tooling for employee data

## Tech Stack

- PHP 8.1+
- MySQL / MariaDB
- Composer
- PHPMailer
- Custom MVC architecture with controllers, models, services, middleware, and views

## Core Modules

### Authentication and Access
- login, logout, registration, password reset, email verification
- role checks using middleware
- session management and CSRF protection

### Employees and Departments
- employee profile and filtering
- department setup and organization structure
- bulk import support for employee records

### Leave Management
- leave types
- leave policies and entitlements
- leave application handling
- leave tracking and review interfaces

### Holiday Management
The final implementation follows a persistent holiday-list model:

- a holiday list is persistent and not tied to a financial year
- each holiday row belongs to both a holiday list and a financial year
- the same list can be reused across multiple years
- the financial year is treated as a row-level property, not a list property

This model is documented in [docs/HOLIDAY_LIST_FY_MODEL.md](docs/HOLIDAY_LIST_FY_MODEL.md).

## Project Structure

```text
.
├── app/
│   ├── Controllers/
│   ├── Core/
│   ├── Middleware/
│   ├── Models/
│   ├── Services/
│   ├── Utils/
│   └── Views/
├── config/
│   ├── app.php
│   ├── constants.php
│   ├── database.php
│   └── database.sql
├── database/
│   ├── migrations/
│   └── schemas/
├── docs/
├── public/
│   └── index.php
├── routes/
│   └── web.php
├── tests/
├── vendor/
├── composer.json
├── LICENSE
├── phpunit.xml
├── Readme.md
└── ...
```

## Installation

### 1. Clone the project

```bash
git clone <repository-url>
cd "ELMS - fredrick muasya"
```

### 2. Install Composer dependencies

```bash
composer install
```

### 3. Configure the database

Import the SQL schema from:

- [config/database.sql](config/database.sql)

If you use migrations, review the scripts in:

- [database/migrations](database/migrations)

### 4. Run the application

```bash
php -S localhost:8000 -t public
```

Then open:

```text
http://localhost:8000
```

## Default Access

If the seeded data is loaded, the default admin credentials are usually:

- Email: admin@example.com
- Password: password

For a standard user:

- Email: user@example.com
- Password: password

## Holiday List Business Rule

The application follows this rule:

- Holiday lists persist across financial years.
- The financial year belongs to the holiday record itself.
- The list remains a permanent catalog item.
- Each holiday is tracked by list + year + date.

Example logic:

- `Kenya National Holidays` remains the same list across FY 2025/2026 and FY 2026/2027.
- Holiday entries for each year are separate rows under that same list.

This is the final model used by the app and is documented in [docs/HOLIDAY_LIST_FY_MODEL.md](docs/HOLIDAY_LIST_FY_MODEL.md).

## Database and Schema Notes

The schema and default data live in:

- [config/database.sql](config/database.sql)

Key tables in the application include:

- users
- employees
- departments
- leave_types
- leaves
- financial_years
- holiday_lists
- holidays
- password_resets

## Development Notes

This project is a custom implementation rather than a framework-based app. The main patterns are:

- Controller classes for request handling
- Model classes for database access
- Service classes for business logic
- Middleware for auth and access checks
- View templates under the app/Views folder

## Documentation Folder

The project includes several guides under:

- [docs](docs)

These cover things such as:

- bulk employee import
- export implementation
- holiday setup
- leave entitlement design
- department offcanvas patterns
- page creation and workflow documentation

## Important Notes

- The repository is not an open-source public project.
- The codebase is intended for internal or licensed use.
- Any use beyond the project’s agreed scope should be reviewed under the project license.

## Support

For questions or implementation updates, coordinate with the project maintainer or the assigned technical lead for this repository.

---

This README is intended to reflect the current project structure, business rules, and setup path for the ELMS application.


