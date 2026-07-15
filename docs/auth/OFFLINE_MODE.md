# Offline Mode Guide for fleave

## What Works Offline ✅

These features work **without internet or email** as long as MySQL is running locally:

- **Login/Logout** - Session-based auth works offline
- **Registration** - Creates users in local database
- **CSRF Protection** - Token generation/validation works offline
- **Password Hashing** - `password_hash()` and `password_verify()` work offline
- **Session Timeout** - 30-minute inactivity timeout works offline
- **Account Lockout** - Failed login tracking and lockout works offline
- **Access Control** - Role-based middleware (`admin`/`user`) works offline
- **Dashboard & Leave Management** - All data is local, works offline
- **Employee Management** - Local database operations

## What Requires Internet/Email ❌

These features need SMTP email setup and internet:

- **Email Verification** - Sends verification email after registration
- **Password Reset Emails** - Sends reset link via email
- **Email Notifications** - Any email-based alerts

---

## Configuration for Offline Mode

### Option 1: Disable Email Verification (Simplest)

Edit `app/Controllers/AuthController.php` and update the registration:

```php
public function doRegister()
{
    // ... validation code ...
    
    if ($this->authService->register($data)) {
        // Skip email verification in offline mode
        // Mark email as verified immediately
        $user = new User();
        $user->verifyEmail($data['email']);
        
        Session::flash('success', 'Registration successful. Please login.');
        header('Location: /login');
        exit;
    }
}
```

Or add this SQL to auto-verify new users:

```php
// In AuthService::register() after creating user
$stmt = $this->db->prepare("
    UPDATE users 
    SET email_verified = 1, email_verified_at = NOW() 
    WHERE email = ?
");
$stmt->execute([$data['email']]);
```

### Option 2: Remove Password Reset Email (Keep Offline)

For offline mode, use a simple password reset code (no email):

```php
// In AuthController::forgotPassword()
public function doForgotPassword()
{
    Csrf::validate($_POST['csrf_token'] ?? '');
    
    $email = $_POST['email'] ?? '';
    $user = (new User())->findByEmail($email);
    
    if (!$user) {
        Session::flash('error', 'User not found');
        header('Location: /forgot-password');
        exit;
    }
    
    // Generate a simple reset code (no email needed)
    $resetCode = substr(str_shuffle('0123456789'), 0, 6); // 6-digit code
    
    // Store in database
    $stmt = $this->db->prepare("
        INSERT INTO password_resets (email, token, expires_at) 
        VALUES (?, ?, DATE_ADD(NOW(), INTERVAL 1 HOUR))
    ");
    $stmt->execute([$email, $resetCode]);
    
    // Show the code to user (offline mode)
    Session::flash('reset_code', $resetCode);
    Session::flash('reset_email', $email);
    header('Location: /confirm-mail');
    exit;
}
```

### Option 3: Skip Email Entirely (Offline Friendly)

Remove email requirements from the auth flow:

```php
// In AuthService::attempt()
public function attempt($email, $password)
{
    $user = $this->userModel->findByEmail($email);
    
    if (!$user || !password_verify($password, $user->password)) {
        return false;
    }
    
    // Skip email verification check for offline mode
    // if (!$user->email_verified) {
    //     return 'unverified_email';
    // }
    
    session_regenerate_id(true);
    Session::set('user_id', $user->id);
    Session::set('user_name', $user->name);
    Session::set('user_role', $user->role);
    
    $this->userModel->updateLastLogin($user->id);
    return true;
}
```

---

## Setup for Offline Use

### 1. Install MySQL Locally
Download and install MySQL Community Server (free):
- Windows: https://dev.mysql.com/downloads/mysql/
- macOS: `brew install mysql`
- Linux: `sudo apt-get install mysql-server`

### 2. Start MySQL Service
```bash
# Windows (PowerShell)
Start-Service MySQL80

# macOS
brew services start mysql

# Linux
sudo service mysql start
```

### 3. Create Database and Tables
```bash
mysql -u root -p < config/database.sql
```

### 4. Run fleave Locally
```bash
# Start PHP built-in server
php -S localhost:8000 -t public

# Or use Apache/Nginx locally
```

### 5. Access Offline
```
http://localhost:8000
```

---

## Login Credentials (Offline)

After setup, use:

**Admin Account:**
- Email: `admin@example.com`
- Password: `password`

**User Account:**
- Email: `user@example.com`
- Password: `password`

---

## Handling Network Errors

Create an error handler for offline scenarios:

```php
// app/Core/Database.php
try {
    $this->pdo = new PDO(
        "mysql:host={$config['host']};dbname={$config['name']};charset=utf8mb4",
        $config['user'],
        $config['pass'],
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    // Show offline error page instead of 500 error
    header('Location: /network-error');
    exit;
}
```

The system includes a `/network-error` page that displays when the database is unavailable.

---

## Summary: Offline Capability

| Feature | Works Offline? | Notes |
|---------|---|---|
| Login | ✅ Yes | Session-based, no internet needed |
| Registration | ✅ Yes | Remove email verification requirement |
| Password Reset | ⚠️ Partial | Use reset code instead of email |
| Leave Requests | ✅ Yes | All data stored locally |
| Dashboard | ✅ Yes | No external data needed |
| Reports | ✅ Yes | Offline data analysis |
| Email Alerts | ❌ No | Requires internet & SMTP |
| Sync to Cloud | ❌ No | Requires internet |

**Recommendation:** Remove email verification and password reset emails for a fully offline experience. Users can change passwords via admin panel instead.
