# LEAVE MANAGEMENT SYSTEM – Complete Documentation (v3)

NOTICE: This repository is proprietary software (not open source). All rights reserved. See the [LICENSE](LICENSE) file for terms.

This document is a complete, page-by-page reference for the project's frontend views and corresponding controllers (excluding the `public/` folder). Use this as the canonical navigation and page index for developers and maintainers.

Table of contents
- Overview
- Project structure (pages only)
	- `app/Views/auth`
	- `app/Views/dashboard`
	- `app/Views/leave_management`
	- `app/Views/holidays`
	- `app/Views/employees`
	- `app/Views/departments`
	- `app/Views/reports`
	- `app/Views/apps`
	- `app/Views/emails`
	- `app/Views/user`
	- `app/Views/layouts` and `partials`
- Controllers mapping (key controllers)
- Database & migrations
- How to run
- Next steps and recommendations

Overview
This project implements a custom PHP MVC framework. The following sections document every page (view) under `app/Views`, grouped by area, with the expected controller entry points and purpose. For file locations see the paths below.

Project pages (detailed)

app/Views/auth (authentication & account pages)
- `login.php` — Login form (AuthController::login, AuthController::doLogin handles POST).
- `register.php` — Registration page (AuthController::register, AuthController::doRegister).
- `forgot-password.php` — Request password reset form (AuthController::forgotPassword, doForgotPassword).
- `reset-password.php` — Password reset form shown via token (AuthController::resetPassword, doResetPassword).
- `confirm-mail.php` — 'Check your email' confirmation (AuthController::confirmMail).
- `auth_check_mail.php` — Helper view for email verification flow.
- `verify-email.php` — Email verification success page (AuthController::verifyEmail flow).
- `lock-screen.php` — Lock-screen requiring re-authentication (AuthController::lockScreen, doUnlock).
- `logout.php` — Logged out confirmation (AuthController::logoutPage).
- `offline.php` — Offline notice page (AuthController::offline).
- `network-error.php` — Network error page for offline checks.

app/Views/dashboard (dashboard and analytics)
- `index.php` — Main dashboard (DashboardController::index). Shows totals and widgets.
- `dashboard_overview.php` — Dashboard overview widgets and quick stats.
- `dashboard_analytics.php` — Analytics view (DashboardController::analytics).

app/Views/leave_management (leave workflows)
- `index.php` — Leave management index (LeaveController::index).
- `leave_applications.php` — List of leave applications and details.
- `leave_types.php` — Manage leave categories (LeaveTypeController::index).

app/Views/holidays
- `index.php` — Holidays list (HolidaysController::index).
- `new_holiday_list.php` — Create new holiday list form (HolidaysController::newHolidayList).
- `Hout.php` — Resource listing / special holidays page (HolidaysController::Hout_list).

app/Views/employees
- `index.php` — Employee listing (EmployeeController::index).
- `employee-departments.php` — Employee department mapping UI.
- `employee-bulk.php` — CSV bulk import for employees.
- `add-employee.php` — Add employee form.

app/Views/departments
- `index.php` — Departments list (DepartmentController::index).
- `d-overview.php` — Department overview page.
- `d-structure.php` — Department structure visualization.

app/Views/reports
- `index.php` — Reports dashboard and export entry points (ReportsController::index).

app/Views/apps (application widgets)
- `apps_chat.php` — Chat widget demo UI.
- `apps_calender.php` — Calendar widget and modal triggers.

app/Views/emails (email templates)
- `verify-email.php` — Email content for account verification.
- `reset-password.php` — Email content for password reset.

app/Views/user
- `profile.php` — User profile page.
- `settings.php` — User account settings page.
- `use.html` — Static example/test page (legacy).

app/Views/layouts and partials
- `layouts/auth.php` — Authentication layout used by auth pages.
- `layouts/admin.php` — Main admin layout used by all app pages.
- `layouts/partials/_nav_1.php`, `_nav_2.php`, `_nav_3.php` — Sidebar/navigation fragments.
- `layouts/partials/_offcanvas.php` — Offcanvas UI element used in admin layout.
- `layouts/partials/_footer.php` — Footer fragment.
- `layouts/partials/_session_auth_modal.php` — Session expiry/reauth modal.
- `layouts/partials/_calender_modals.php` — Calendar modals used by calendar page.

Controllers (key mapping)
- `app/Controllers/AuthController.php` — All auth flows (login, register, password reset, email verify, lock/unlock, logout).
- `app/Controllers/DashboardController.php` — Dashboard, analytics, uses `App/Core/Database` for stats.
- `app/Controllers/EmployeeController.php` — Employee list and management.
- `app/Controllers/DepartmentController.php` — Department pages.
- `app/Controllers/LeaveController.php` — Leave management index and views.
- `app/Controllers/LeaveTypeController.php` — Leave type management.
- `app/Controllers/HolidaysController.php` — Holiday CRUD and special pages.
- `app/Controllers/ReportsController.php` — Reports dashboard and exports.
- `app/Controllers/ErrorController.php` — Renders `errors/404.php` and `errors/500.php`.

Database & migrations
- Canonical schema and seeds: `config/database.sql`.
- Security migration additions: `database/migrations/add_security_features.sql` (adds `failed_login_attempts`, `locked_until`, `email_verified`, `login_attempts`, `email_verification_tokens`).

How to run (development)
1. Install dependencies:
```bash
composer install
```
2. Create `.env` from `.env.example` and set DB credentials.
3. Import `config/database.sql` into MySQL.
4. Serve the app from project root:
```bash
php -S localhost:8000 -t public
```
5. Open `http://localhost:8000` and log in with the seeded users (if imported): `admin@example.com` / `password`.

Notes about exports and assets
- The project currently includes a client-side export implementation; the recommended approach is server-side exports using `phpoffice/phpspreadsheet` (see `docs/EXPORT_IMPLEMENTATION_GUIDE.md`).

Next steps (recommended, ordered)
1. Add automated tests (phpunit) for core auth flows and critical controllers.
2. Add CI workflow (GitHub Actions) to run tests and static analysis for PRs.
3. Add static analysis (`phpstan` or `psalm`) and `php-cs-fixer` for consistent style.
4. Add dependency scanning (`composer audit`) to CI and pin critical dependency versions.
5. Implement server-side export endpoint with `phpoffice/phpspreadsheet` and tests for it.

Contributing & support
- This repository is proprietary. For changes, coordinate with the maintainers and obtain written permission before redistributing.
- For licensing or contribution questions contact: fredrickmuasya553@gmail.com

----

If you want, I can now: add `phpunit` with starter tests (auth), scaffold a GitHub Actions workflow, or add `phpstan`/`php-cs-fixer`. Tell me which you'd prefer and I'll implement it.

---

## 📁 Project Structure

```
project-root/
│
├── app/
│   ├── Controllers/           # Handle HTTP requests and responses
│   │   ├── Controller.php     # Base controller
│   │   ├── AuthController.php # Login, logout, registration, password reset
│   │   ├── DashboardController.php
│   │   ├── EmployeeController.php
│   │   ├── LeaveController.php
│   │   ├── HolidayController.php
│   │   ├── DepartmentController.php
│   │   ├── LeaveTypeController.php
│   │   └── ErrorController.php
│   │
│   ├── Models/                 # Database interaction
│   │   ├── Model.php
│   │   ├── User.php
│   │   ├── PasswordReset.php
│   │   ├── Employee.php
│   │   ├── Leave.php
│   │   ├── Holiday.php
│   │   ├── Department.php
│   │   └── LeaveType.php
│   │
│   ├── Services/                # Business logic layer
│   │   ├── AuthService.php
│   │   ├── EmployeeService.php
│   │   ├── LeaveService.php
│   │   ├── HolidayService.php
│   │   ├── DepartmentService.php
│   │   └── LeaveTypeService.php
│   │
│   ├── Middleware/               # Request filters
│   │   ├── AuthMiddleware.php    # Ensures user is logged in
│   │   ├── GuestMiddleware.php   # Redirects if already logged in
│   │   └── RoleMiddleware.php    # Checks user role (admin/user)
│   │
│   ├── Core/                      # Framework foundation
│   │   ├── Router.php
│   │   ├── Database.php
│   │   ├── Session.php
│   │   ├── ErrorHandler.php
│   │   └── Csrf.php
│   │
│   ├── Utils/                      # Helpers
│   │   ├── Validator.php
│   │   └── Mailer.php
│   │
│   └── Views/                       # UI templates
│       ├── layouts/
│       │   ├── auth.php
│       │   ├── admin.php
│       │   └── partials/
│       │       ├── _navbar.php
│       │       └── _offcanvas.php
│       ├── auth/                    # Login, register, password reset pages
│       ├── dashboard/
│       ├── employees/
│       ├── leaves/
│       ├── holidays/
│       ├── departments/
│       ├── leave_types/
│       └── errors/                   # 404, 500 pages
│
├── config/                           # Configuration files
│   ├── app.php
│   ├── database.php
│   └── constants.php
│
├── routes/                           # Route definitions
│   └── web.php
│
├── public/                            # Web root
│   ├── index.php                      # Front controller
│   ├── .htaccess                       # Apache routing
│   ├── assets/                          # Compiled CSS, JS, images (Falcon template - included)
│   └── vendors/                         # Third‑party frontend libraries (Falcon template - included)
│
├── storage/                             # File storage
│   ├── logs/                              # Application logs
│   └── uploads/                           # User uploaded files
│
├── vendor/                                # Composer dependencies
│
├── .env                                   # Environment variables (not committed)
├── .env.example                           # Example environment file
├── composer.json                          # PHP dependencies
├── .gitignore                             # Git ignore rules
└── README.md                               # This file
```

---

## Documentation

- The main project documentation is the top-level `README.md`.
- Authentication-specific docs are stored in `docs/auth/`.
- The definitive database schema and sample data are in `config/database.sql`.
- Some legacy offline docs exist in `docs/auth/`; review them later and remove any unused files.

**What's New (summary of repo state)**
- Project license marked proprietary (not open source).
- Server-side export recommended in `docs/EXPORT_IMPLEMENTATION_GUIDE.md` (use PhpSpreadsheet).
- Security migrations and improved schema present in `database/migrations` and `config/database.sql`.
- No automated tests or CI workflows currently configured (recommended next step).

**Next Steps (recommended, priority order)**
1. Add automated tests with `phpunit` for critical auth flows (login, reset, register).
2. Add CI (GitHub Actions) to run tests and static analysis on push/PR.
3. Add static analysis (`phpstan` or `psalm`) and a code style tool (`php-cs-fixer`).
4. Implement server-side exports using `phpoffice/phpspreadsheet` (see `docs/EXPORT_IMPLEMENTATION_GUIDE.md`).
5. Run `composer audit` and add dependency/version pinning where required.


## Authentication & Role‑Based Access

The system implements a secure authentication module with:

- **Registration** (optional) and **login**.
- **Password reset** with secure tokens stored in `password_resets` table.
- **Session regeneration** after login.
- **CSRF protection** on all forms.
- **Role‑based access**: `admin` (full access) and `user` (limited access). The `RoleMiddleware` can be applied to routes to restrict access.

Default users (all passwords are `password`):
- **Admin**: `admin@example.com` (full system access)
- **User**: `user@example.com` (limited access)

---

## ⚙️ Core Components

| Component       | Responsibility |
|-----------------|----------------|
| **Router**      | Maps URLs to controllers, runs middleware, dispatches requests. |
| **Database**    | Singleton PDO connection with prepared statements. |
| **Session**     | Wrapper for `$_SESSION` with flash messaging. |
| **ErrorHandler**| Converts errors to exceptions, logs them, displays friendly 404/500 pages. |
| **Csrf**        | Generates and validates CSRF tokens. |
| **Validator**   | Validates input data against rules (required, email, min, confirmed, etc.). |
| **Mailer**      | Dummy email logger (replace with PHPMailer for production). |

---

## 🗄️ Database Schema

The active schema is defined in `config/database.sql`. It includes:

- `users` – stores user credentials and roles (`admin`, `user`).
- `password_resets` – stores password reset tokens with expiry.
- `departments` – department list for future linking.
- `employees` – import-ready table for CSV upload with `gender`, `age`, `date_of_birth`, `designation`, `job_group`, `employment_status`, `engagement_type`, `rod_date`, `special_need`, and optional `department_id`.
- `leave_types` – leave categories like Annual, Sick, and Personal.
- `leaves` – leave records linked to employees and leave types.
- `holidays` – public holidays.

The dashboard uses the `employees` table count to display live Total Employees values instead of hard-coded numbers.

Use `config/database.sql` as the source of truth for schema definitions and sample seed data.

---

## 🚀 Quick Start

### 1. Install Dependencies
Make sure you have [Composer](https://getcomposer.org/) installed, then run:
```bash
composer install
```

### 2. Configure Environment
Copy `.env.example` to `.env` and update the database credentials:

**Sample `.env` content:**
```ini
DB_HOST=localhost
DB_NAME=leave_management
DB_USER=root
DB_PASS=your_password_here
SESSION_SECRET=your_random_secret_key_here
EMAIL_HOST=smtp.gmail.com
EMAIL_USER=your_email@gmail.com
EMAIL_PASS=your_app_password
```

### 3. Create Database
Import the SQL schema from `config/database.sql` into your MySQL server.

### 4. Serve the Application
From the project root, run:
```bash
php -S localhost:8000 -t public
```
Then open `http://localhost:8000` in your browser.

---

## 🧪 Testing the Authentication

- Visit `/login` and log in with `admin@example.com` / `password` or `user@example.com` / `password`.
- After login you will be redirected to the dashboard.
- Use the lock screen (`/lock-screen`) to re‑authenticate.
- Test the password reset flow via `/forgot-password` (emails are logged in `storage/logs/email.log`).

---

## 🛡️ Security Features

- **Password hashing** with `password_hash()` (bcrypt).
- **CSRF tokens** on all POST forms.
- **Session fixation protection** – session ID regenerated after login.
- **Prepared statements** – prevents SQL injection.
- **Role‑based middleware** – restricts access to admin pages.
- **Error handling** – no stack traces or sensitive info leaked in production.
- **Logging** – all errors and important events are logged.

---

## 🧩 Extending the System

To add new features (e.g., leave approval workflow, reports):

1. Create the necessary database table(s).
2. Build a **Model** for the new entity.
3. Create a **Service** class containing business logic.
4. Create a **Controller** to handle HTTP requests.
5. Add **Views** for the UI.
6. Define **routes** in `routes/web.php` and apply middleware as needed.
7. Update the navigation partial (`_navbar.php`) to include links.

All controllers should extend `App\Controllers\Controller`, and services should be instantiated in the controller's constructor or method.

---

## 📦 Dependencies

- **PHP** 7.4 or higher
- **MySQL** 5.7 or MariaDB
- **Composer**
- **PHPMailer** (optional, for real email sending)
- **vlucas/phpdotenv** (for environment variables)
- **Falcon Bootstrap Template** (frontend assets included in `public/assets/` and `public/vendors/`)

---

## 🤝 Contributing

Feel free to extend the system. If you find bugs or have feature requests, please open an issue or submit a pull request.

---

## 📄 License

NOTICE: This repository is proprietary software. All rights reserved.

Copyright (c) 2026 Fredrick-GodAboveAll

This code and associated files are the proprietary work of the copyright holder.
Redistribution, modification, or public distribution of this code is prohibited
without explicit written permission from the copyright holder. See the
[LICENSE](LICENSE) file for full terms and contact information.

---

**Happy coding!** Build a robust leave management solution on this solid foundation.


