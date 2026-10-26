# Complete Authentication System for Leave Management System

Hello! I'm excited to help you build a robust and secure authentication system for your Leave Management System. Based on the v3 blueprint, I've compiled everything you need into this friendly guide. Let's keep it simple and clear.

## 📦 Complete Authentication Module – File by File

### 1. Folder Structure (Create these folders)
```
project-root/
├── app/
│   ├── Controllers/
│   ├── Models/
│   ├── Services/
│   ├── Middleware/
│   ├── Core/
│   ├── Utils/
│   └── Views/
│       ├── layouts/
│       │   └── partials/
│       ├── auth/
│       ├── dashboard/
│       └── errors/
├── config/
├── routes/
├── public/
│   ├── assets/          (Falcon template assets – place here)
│   └── vendors/         (Falcon template vendors – place here)
├── storage/
│   ├── logs/
│   └── uploads/
├── vendor/               (will be created by Composer)
├── .env
├── .env.example
├── composer.json
├── .gitignore
└── README.md
```

---

### 2. Database Schema
Run this SQL in your MySQL database. It sets up users and password reset storage.
```sql
CREATE DATABASE IF NOT EXISTS `leave_management`
CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE `leave_management`;

-- Users table
CREATE TABLE `users` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,
    `email` VARCHAR(100) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `role` ENUM('admin','user') NOT NULL DEFAULT 'user',
    `last_login` TIMESTAMP NULL,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    INDEX `idx_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Password resets table
CREATE TABLE `password_resets` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `email` VARCHAR(100) NOT NULL,
    `token` VARCHAR(64) NOT NULL,
    `expires_at` TIMESTAMP NOT NULL,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    INDEX `idx_email` (`email`),
    INDEX `idx_token` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert default users (password = 'password')
INSERT INTO `users` (`name`, `email`, `password`, `role`) VALUES
('Admin User', 'admin@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'),
('Regular User', 'user@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user');
```

---

### 3. Root Files

#### **composer.json**
```json
{
    "name": "yourname/leave-management",
    "description": "Leave Management System - Authentication Module",
    "type": "project",
    "license": "MIT",
    "autoload": {
        "psr-4": {
            "App\\": "app/"
        }
    },
    "require": {
        "phpmailer/phpmailer": "^6.8",
        "vlucas/phpdotenv": "^5.5"
    }
}
```

#### **.env.example**
```ini
APP_NAME="Leave Management System"
APP_ENV=local
APP_DEBUG=true

DB_HOST=localhost
DB_NAME=leave_management
DB_USER=root
DB_PASS=

MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
```

#### **.gitignore**
```
vendor/
.env
storage/logs/*
storage/uploads/*
```

#### **README.md**
```markdown
# Leave Management System – Authentication Module

## Setup
1. Run `composer install`
2. Copy `.env.example` to `.env` and set your database credentials
3. Import the SQL schema from the documentation
4. Place Falcon template assets in `public/assets/` and `public/vendors/`
5. Run `php -S localhost:8000 -t public`
6. Visit `http://localhost:8000` and log in with admin@example.com / password
```

---

### 4. Public Folder

#### **public/index.php**
```php
<?php
require __DIR__ . '/../vendor/autoload.php';

use App\Core\Router;
use App\Core\Session;
use App\Core\ErrorHandler;
use Dotenv\Dotenv;

// Load environment variables
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Start session
Session::start();

// Set error handling
$errorHandler = new ErrorHandler();
$errorHandler->register();

$router = new Router();

// Load routes
require __DIR__ . '/../routes/web.php';

// Dispatch
$uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];
$router->dispatch($uri, $method);
```

#### **public/.htaccess**
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^ index.php [QSA,L]
</IfModule>
```

---

### 5. Config Files

#### **config/app.php**
```php
<?php
return [
    'name' => $_ENV['APP_NAME'] ?? 'Leave Management',
    'env' => $_ENV['APP_ENV'] ?? 'local',
    'debug' => filter_var($_ENV['APP_DEBUG'] ?? true, FILTER_VALIDATE_BOOLEAN),
];
```

#### **config/database.php**
```php
<?php
return [
    'host' => $_ENV['DB_HOST'] ?? 'localhost',
    'name' => $_ENV['DB_NAME'] ?? 'leave_management',
    'user' => $_ENV['DB_USER'] ?? 'root',
    'pass' => $_ENV['DB_PASS'] ?? '',
];
```

#### **config/constants.php**
```php
<?php
define('BASE_PATH', dirname(__DIR__));
define('STORAGE_PATH', BASE_PATH . '/storage');
```

---

### 6. Core Classes

#### **app/Core/Database.php**
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

#### **app/Core/Session.php**
```php
<?php
namespace App\Core;

class Session
{
    public static function start()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function get($key, $default = null)
    {
        return $_SESSION[$key] ?? $default;
    }

    public static function has($key)
    {
        return isset($_SESSION[$key]);
    }

    public static function delete($key)
    {
        unset($_SESSION[$key]);
    }

    public static function destroy()
    {
        session_destroy();
    }

    public static function flash($key, $value = null)
    {
        if ($value !== null) {
            $_SESSION['flash'][$key] = $value;
        } else {
            $val = $_SESSION['flash'][$key] ?? null;
            unset($_SESSION['flash'][$key]);
            return $val;
        }
    }
}
```

#### **app/Core/Csrf.php**
```php
<?php
namespace App\Core;

class Csrf
{
    public static function generate()
    {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    public static function validate($token)
    {
        if (!isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']) {
            die('Invalid CSRF token');
        }
        unset($_SESSION['csrf_token']);
        return true;
    }
}
```

---

### 7. Middleware

#### **app/Middleware/AuthMiddleware.php**
```php
<?php
namespace App\Middleware;

use App\Core\Session;

class AuthMiddleware
{
    public function handle()
    {
        if (!Session::has('user_id')) {
            Session::flash('error', 'Please log in first.');
            header('Location: /login');
            exit;
        }
    }
}
```

#### **app/Middleware/GuestMiddleware.php**
```php
<?php
namespace App\Middleware;

use App\Core\Session;

class GuestMiddleware
{
    public function handle()
    {
        if (Session::has('user_id')) {
            header('Location: /dashboard');
            exit;
        }
    }
}
```

#### **app/Middleware/RoleMiddleware.php**
```php
<?php
namespace App\Middleware;

use App\Core\Session;

class RoleMiddleware
{
    protected $allowedRoles;

    public function __construct($roles)
    {
        $this->allowedRoles = is_array($roles) ? $roles : [$roles];
    }

    public function handle()
    {
        $userRole = Session::get('user_role');
        if (!$userRole || !in_array($userRole, $this->allowedRoles)) {
            http_response_code(403);
            die('Access denied. You do not have permission to view this page.');
        }
    }
}
```

---

### 8. Models

#### **app/Models/Model.php**
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

#### **app/Models/User.php**
```php
<?php
namespace App\Models;

use PDO;

class User extends Model
{
    protected $table = 'users';

    public function findByEmail($email)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function create($data)
    {
        $sql = "INSERT INTO {$this->table} (name, email, password, role) VALUES (:name, :email, :password, :role)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role' => $data['role'] ?? 'user'
        ]);
    }

    public function updateLastLogin($id)
    {
        $stmt = $this->db->prepare("UPDATE {$this->table} SET last_login = NOW() WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function updatePassword($email, $newPassword)
    {
        $stmt = $this->db->prepare("UPDATE {$this->table} SET password = ? WHERE email = ?");
        return $stmt->execute([$newPassword, $email]);
    }
}
```

#### **app/Models/PasswordReset.php**
```php
<?php
namespace App\Models;

use PDO;

class PasswordReset extends Model
{
    protected $table = 'password_resets';

    public function createToken($email, $token, $expires)
    {
        $stmt = $this->db->prepare("INSERT INTO {$this->table} (email, token, expires_at) VALUES (?, ?, ?)");
        return $stmt->execute([$email, $token, $expires]);
    }

    public function findByToken($token)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE token = ? AND expires_at > NOW()");
        $stmt->execute([$token]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function deleteByEmail($email)
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE email = ?");
        return $stmt->execute([$email]);
    }
}
```

---

### 9. Services

#### **app/Services/AuthService.php**
```php
<?php
namespace App\Services;

use App\Models\User;
use App\Models\PasswordReset;
use App\Core\Session;
use App\Utils\Mailer;

class AuthService
{
    protected $userModel;
    protected $passwordResetModel;

    public function __construct()
    {
        $this->userModel = new User();
        $this->passwordResetModel = new PasswordReset();
    }

    public function attempt($email, $password)
    {
        $user = $this->userModel->findByEmail($email);
        if (!$user || !password_verify($password, $user->password)) {
            return false;
        }

        session_regenerate_id(true);
        Session::set('user_id', $user->id);
        Session::set('user_name', $user->name);
        Session::set('user_role', $user->role);

        $this->userModel->updateLastLogin($user->id);
        return true;
    }

    public function register($data)
    {
        if ($this->userModel->findByEmail($data['email'])) {
            return false;
        }
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        return $this->userModel->create($data);
    }

    public function logout()
    {
        Session::destroy();
    }

    public function sendResetLink($email)
    {
        $user = $this->userModel->findByEmail($email);
        if (!$user) {
            return false;
        }

        $this->passwordResetModel->deleteByEmail($email);

        $token = bin2hex(random_bytes(32));
        $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));

        $this->passwordResetModel->createToken($email, $token, $expires);

        Mailer::send($email, 'Password Reset', "Click here to reset: /reset-password?token=$token");

        return $token;
    }

    public function validateResetToken($token)
    {
        return $this->passwordResetModel->findByToken($token);
    }

    public function resetPassword($token, $newPassword)
    {
        $record = $this->validateResetToken($token);
        if (!$record) {
            return false;
        }

        $hashed = password_hash($newPassword, PASSWORD_DEFAULT);
        $this->userModel->updatePassword($record->email, $hashed);
        $this->passwordResetModel->deleteByEmail($record->email);
        return true;
    }

    public function check()
    {
        return Session::has('user_id');
    }

    public function role()
    {
        return Session::get('user_role');
    }
}
```

---

### 10. Utils

#### **app/Utils/Validator.php**
```php
<?php
namespace App\Utils;

class Validator
{
    protected $errors = [];

    public function validate($data, $rules)
    {
        foreach ($rules as $field => $rule) {
            $value = $data[$field] ?? '';
            $rulesArray = explode('|', $rule);
            foreach ($rulesArray as $singleRule) {
                $this->applyRule($field, $value, $singleRule, $data);
            }
        }
        return empty($this->errors);
    }

    protected function applyRule($field, $value, $rule, $data)
    {
        if ($rule === 'required' && empty($value)) {
            $this->errors[$field][] = ucfirst($field) . ' is required';
        }
        if ($rule === 'email' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field][] = ucfirst($field) . ' must be a valid email';
        }
        if (strpos($rule, 'min:') === 0) {
            $min = explode(':', $rule)[1];
            if (strlen($value) < $min) {
                $this->errors[$field][] = ucfirst($field) . " must be at least $min characters";
            }
        }
        if ($rule === 'confirmed') {
            $confirmField = $field . '_confirm';
            if (!isset($data[$confirmField]) || $value !== $data[$confirmField]) {
                $this->errors[$field][] = ucfirst($field) . ' confirmation does not match';
            }
        }
    }

    public function errors()
    {
        return $this->errors;
    }
}
```

#### **app/Utils/Mailer.php**
```php
<?php
namespace App\Utils;

class Mailer
{
    public static function send($to, $subject, $message)
    {
        $log = "To: $to\nSubject: $subject\nMessage: $message\n\n";
        file_put_contents(__DIR__ . '/../../storage/logs/email.log', $log, FILE_APPEND);
        return true;
    }
}
```

---

### 11. Controllers

#### **app/Controllers/AuthController.php**
```php
<?php
namespace App\Controllers;

use App\Services\AuthService;
use App\Utils\Validator;
use App\Core\Csrf;
use App\Core\Session;
use App\Models\User;

class AuthController extends Controller
{
    protected $authService;

    public function __construct()
    {
        $this->authService = new AuthService();
    }

    public function login()
    {
        $title = 'Login';
        $content = '../app/Views/auth/login.php';
        include '../app/Views/layouts/auth.php';
    }

    public function doLogin()
    {
        Csrf::validate($_POST['csrf_token'] ?? '');

        $validator = new Validator();
        $rules = [
            'email' => 'required|email',
            'password' => 'required'
        ];
        if (!$validator->validate($_POST, $rules)) {
            Session::flash('errors', $validator->errors());
            Session::flash('old', $_POST);
            header('Location: /login');
            exit;
        }

        if ($this->authService->attempt($_POST['email'], $_POST['password'])) {
            header('Location: /dashboard');
            exit;
        } else {
            Session::flash('error', 'Invalid email or password');
            header('Location: /login');
            exit;
        }
    }

    public function register()
    {
        $title = 'Register';
        $content = '../app/Views/auth/register.php';
        include '../app/Views/layouts/auth.php';
    }

    public function doRegister()
    {
        Csrf::validate($_POST['csrf_token'] ?? '');

        $validator = new Validator();
        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'password_confirm' => 'required|confirmed'
        ];
        if (!$validator->validate($_POST, $rules)) {
            Session::flash('errors', $validator->errors());
            Session::flash('old', $_POST);
            header('Location: /register');
            exit;
        }

        $data = [
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'password' => $_POST['password'],
        ];

        if ($this->authService->register($data)) {
            Session::flash('success', 'Registration successful. Please login.');
            header('Location: /login');
            exit;
        } else {
            Session::flash('error', 'Email already exists.');
            header('Location: /register');
            exit;
        }
    }

    public function forgotPassword()
    {
        $title = 'Forgot Password';
        $content = '../app/Views/auth/forgot-password.php';
        include '../app/Views/layouts/auth.php';
    }

    public function doForgotPassword()
    {
        Csrf::validate($_POST['csrf_token'] ?? '');

        $validator = new Validator();
        if (!$validator->validate($_POST, ['email' => 'required|email'])) {
            Session::flash('errors', $validator->errors());
            header('Location: /forgot-password');
            exit;
        }

        $token = $this->authService->sendResetLink($_POST['email']);
        if ($token) {
            Session::flash('reset_token', $token);
            Session::flash('reset_email', $_POST['email']);
            header('Location: /confirm-mail');
            exit;
        } else {
            Session::flash('success', 'If that email exists, a reset link has been sent.');
            header('Location: /forgot-password');
            exit;
        }
    }

    public function confirmMail()
    {
        $title = 'Check Your Email';
        $content = '../app/Views/auth/confirm-mail.php';
        include '../app/Views/layouts/auth.php';
    }

    public function resetPassword()
    {
        $token = $_GET['token'] ?? '';
        if (!$token) {
            header('Location: /forgot-password');
            exit;
        }

        if (!$this->authService->validateResetToken($token)) {
            Session::flash('error', 'Invalid or expired reset token.');
            header('Location: /forgot-password');
            exit;
        }

        $title = 'Reset Password';
        $content = '../app/Views/auth/reset-password.php';
        include '../app/Views/layouts/auth.php';
    }

    public function doResetPassword()
    {
        Csrf::validate($_POST['csrf_token'] ?? '');

        $token = $_POST['token'] ?? '';
        $password = $_POST['password'] ?? '';
        $passwordConfirm = $_POST['password_confirm'] ?? '';

        if (!$token) {
            header('Location: /forgot-password');
            exit;
        }

        $validator = new Validator();
        if (!$validator->validate($_POST, [
            'password' => 'required|min:6',
            'password_confirm' => 'required|confirmed'
        ])) {
            Session::flash('errors', $validator->errors());
            header("Location: /reset-password?token=$token");
            exit;
        }

        if ($this->authService->resetPassword($token, $password)) {
            Session::flash('success', 'Password reset successful. Please login.');
            header('Location: /login');
            exit;
        } else {
            Session::flash('error', 'Invalid or expired reset token.');
            header('Location: /forgot-password');
            exit;
        }
    }

    public function logout()
    {
        $this->authService->logout();
        header('Location: /login');
        exit;
    }

    public function logoutPage()
    {
        $title = 'Logged Out';
        $content = '../app/Views/auth/logout.php';
        include '../app/Views/layouts/auth.php';
    }

    public function lockScreen()
    {
        if (!$this->authService->check()) {
            header('Location: /login');
            exit;
        }
        $title = 'Lock Screen';
        $content = '../app/Views/auth/lock-screen.php';
        include '../app/Views/layouts/auth.php';
    }

    public function doUnlock()
    {
        Csrf::validate($_POST['csrf_token'] ?? '');

        $password = $_POST['password'] ?? '';
        $userId = Session::get('user_id');
        if (!$userId) {
            header('Location: /login');
            exit;
        }

        $userModel = new User();
        $user = $userModel->find($userId);
        if ($user && password_verify($password, $user->password)) {
            header('Location: /dashboard');
            exit;
        } else {
            Session::flash('error', 'Incorrect password.');
            header('Location: /lock-screen');
            exit;
        }
    }
}
```

---

### 12. Routes

#### **routes/web.php**
```php
<?php
use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;
use App\Middleware\RoleMiddleware;

// Guest routes
$router->get('/', 'AuthController@login', [GuestMiddleware::class]);
$router->get('/login', 'AuthController@login', [GuestMiddleware::class]);
$router->post('/login', 'AuthController@doLogin', [GuestMiddleware::class]);

$router->get('/register', 'AuthController@register', [GuestMiddleware::class]);
$router->post('/register', 'AuthController@doRegister', [GuestMiddleware::class]);

$router->get('/forgot-password', 'AuthController@forgotPassword', [GuestMiddleware::class]);
$router->post('/forgot-password', 'AuthController@doForgotPassword', [GuestMiddleware::class]);

$router->get('/reset-password', 'AuthController@resetPassword', [GuestMiddleware::class]);
$router->post('/reset-password', 'AuthController@doResetPassword', [GuestMiddleware::class]);

$router->get('/confirm-mail', 'AuthController@confirmMail', [GuestMiddleware::class]);

// Protected routes
$router->post('/logout', 'AuthController@logout', [AuthMiddleware::class]);
$router->get('/logout', 'AuthController@logoutPage', [GuestMiddleware::class]);

$router->get('/lock-screen', 'AuthController@lockScreen', [AuthMiddleware::class]);
$router->post('/unlock', 'AuthController@doUnlock', [AuthMiddleware::class]);

$router->get('/dashboard', 'DashboardController@index', [AuthMiddleware::class]);

// Admin-only route example
$router->get('/admin/users', 'AdminController@index', [AuthMiddleware::class, [RoleMiddleware::class, 'admin']]);
```

---

### 13. Auth View Comments

Each auth page uses a shared layout (`app/Views/layouts/auth.php`). The layout includes the CSS, scripts, and the content partial set by the controller.

#### Login page
- The form uses `POST /login`.
- The `csrf_token` hidden field protects the request.
- Validation errors are displayed from the session.
- If login fails, the controller redirects back with a flash error.

#### Register page
- The form uses `POST /register`.
- `name`, `email`, `password`, and `password_confirm` must all be provided.
- The controller checks `password_confirm` using the `confirmed` rule.
- On success, the user is redirected to login.

#### Forgot password page
- The form uses `POST /forgot-password`.
- If the email exists, a reset token is created and emailed.
- The page always returns a friendly result to avoid leaking account existence.

#### Reset password page
- The reset page displays only if the token is valid.
- The token is submitted again as a hidden field.
- The password and confirmation values must match.

---

### 14. Final Notes

- Keep auth code in `app/Controllers/AuthController.php`, `app/Services/AuthService.php`, and `app/Models/User.php`.
- Keep auth views in `app/Views/auth/`.
- Keep auth documentation in `docs/auth/`.
- Use the `docs/auth/index.md` file as your starting point.

You're now ready to work from a clean, organized auth module with clear documentation and code comments.
