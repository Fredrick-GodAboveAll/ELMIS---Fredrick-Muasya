# LEAVE MANAGEMENT SYSTEM – Complete Documentation (v3)

A comprehensive, production‑ready PHP‑based Leave Management System built on a custom MVC architecture. It features secure authentication, role‑based access (admin/user), employee management, leave tracking, holiday management, and a modern responsive UI powered by the Falcon Bootstrap template.

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

This project is open‑source and available under the MIT License.

---

**Happy coding!** Build a robust leave management solution on this solid foundation.


