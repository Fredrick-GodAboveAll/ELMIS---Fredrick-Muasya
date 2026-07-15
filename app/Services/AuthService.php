<?php
namespace App\Services;
use App\Models\User;
use App\Models\PasswordReset;
use App\Core\Session;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
class AuthService
{
 // AuthService contains the core user authentication and password reset behaviors.
 protected $userModel;
 protected $passwordResetModel;
 public function __construct()
 {
 $this->loadEnvFromDotEnvFile();
 $this->userModel = new User();
 $this->passwordResetModel = new PasswordReset();
 }
 public function attempt($email, $password)
 {
 // Verify the email/password combo and store the user in the session if valid.
 $user = $this->userModel->findByEmail($email);
 
 // Check if account is locked due to failed attempts
 if ($user && $user->locked_until && strtotime($user->locked_until) > time()) {
     $this->recordLoginAttempt($email, false);
     return false;
 }
 
 // Check if email is verified
 if ($user && !$user->email_verified) {
     $this->recordLoginAttempt($email, false);
     return 'unverified_email';
 }
 
 if (!$user || !password_verify($password, $user->password)) {
     // Record failed attempt and increment counter
     if ($user) {
         $failedAttempts = $user->failed_login_attempts + 1;
         $this->userModel->incrementFailedAttempts($user->id);
         
         // Lock account after 5 failed attempts for 30 minutes
         if ($failedAttempts >= 5) {
             $lockedUntil = date('Y-m-d H:i:s', time() + (30 * 60));
             $this->userModel->lockAccount($user->id, $lockedUntil);
         }
     }
     $this->recordLoginAttempt($email, false);
     return false;
 }
 
 // Successful login - reset failed attempts
 $this->userModel->resetFailedAttempts($user->id);
 
 session_regenerate_id(true);
 Session::set('user_id', $user->id);
 Session::set('user_name', $user->name);
 Session::set('user_role', $user->role);
 Session::set('session_started_at', time());
 
 $this->userModel->updateLastLogin($user->id);
 $this->recordLoginAttempt($email, true);
 return true;
 }
 public function register($data)
 {
     if ($this->userModel->findByEmail($data['email'])) {
         return 'duplicate';
     }
     $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
     $result = $this->userModel->create($data);
 
     if ($result) {
         if ($this->sendVerificationEmail($data['email'])) {
             return true;
         }
         $this->userModel->deleteByEmail($data['email']);
         return 'email_failed';
     }
     return false;
 }
 public function logout()
 {
 // Remove all session data and end the user session.
 Session::destroy();
 }
 public function sendResetLink($email)
 {
     $user = $this->userModel->findByEmail($email);
     if (!$user) {
         return 'not_found';
     }
 
     $this->passwordResetModel->deleteByEmail($email);
     $token = bin2hex(random_bytes(32));
 
     if ($this->passwordResetModel->createToken($email, $token, null)) {
         if ($this->sendPasswordResetEmail($email, $token)) {
             return true;
         }
         $this->passwordResetModel->deleteByEmail($email);
         return 'email_failed';
     }
     return 'email_failed';
 }

 protected function sendPasswordResetEmail($email, $token)
 {
     $appUrl = $this->getEnv('APP_URL', 'http://localhost:8000');
     $resetLink = rtrim($appUrl, '/') . '/reset-password?token=' . urlencode($token);
     $subject = 'Password Reset Request';
     $message = "Click the link below to reset your password:\r\n\r\n{$resetLink}";
     $fromAddress = $this->getEnv('MAIL_FROM_ADDRESS', 'noreply@yourdomain.com');
     $fromName = $this->getEnv('MAIL_FROM_NAME', 'Leave Management');
     $headers = "From: {$fromAddress}\r\n";
     $headers .= "Reply-To: {$fromAddress}\r\n";
     $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

     $smtpHost = $this->getEnv('MAIL_HOST', null);
     $smtpPort = (int) $this->getEnv('MAIL_PORT', 587);
     $smtpUser = $this->getEnv('MAIL_USERNAME', null);
     $smtpPass = $this->getEnv('MAIL_PASSWORD', null);
     $smtpSecure = $this->getEnv('MAIL_ENCRYPTION', PHPMailer::ENCRYPTION_STARTTLS);

     if ($smtpHost && $smtpUser && $smtpPass) {
         try {
             $mail = new PHPMailer(true);
             $mail->isSMTP();
             $mail->SMTPDebug = SMTP::DEBUG_OFF;
             $mail->Host = $smtpHost;
             $mail->SMTPAuth = true;
             $mail->Username = $smtpUser;
             $mail->Password = $smtpPass;
             $mail->SMTPSecure = $smtpSecure;
             $mail->Port = $smtpPort;
             $mail->setFrom($fromAddress, $fromName);
             $mail->addReplyTo($fromAddress, $fromName);
             $mail->addAddress($email);
             $mail->isHTML(true);
             $mail->Subject = $subject;
             $mail->Body = "<p>Click the link below to reset your password:</p><p><a href=\"{$resetLink}\">{$resetLink}</a></p>";
             $mail->AltBody = "Click the link below to reset your password:\n\n{$resetLink}";
             $mail->send();
             return true;
         } catch (\Exception $e) {
             error_log('Password reset email exception: ' . $e->getMessage());
             error_log('PHPMailer ErrorInfo: ' . ($mail->ErrorInfo ?? 'N/A'));
             return false;
         }
     }

     return mail($email, $subject, $message, $headers);
 }
 public function validateResetToken($token)
 {
 return $this->passwordResetModel->findByToken($token);
 }
 public function resetPassword($token, $newPassword)
 {
 $record = $this->validateResetToken($token);
 if (!$record) return false;
 
 // Verify email exists in users table
 $user = $this->userModel->findByEmail($record->email);
 if (!$user) return false;
 
 $hashed = password_hash($newPassword, PASSWORD_DEFAULT);
 $success = $this->userModel->updatePassword($record->email, $hashed);
 
 if ($success) {
     // Update password_changed_at timestamp and reset failed attempts
     $this->userModel->updatePasswordChangedAt($user->id);
     $this->userModel->resetFailedAttempts($user->id);
     $this->userModel->unlockAccount($user->id);
     
     // Delete all reset tokens for this email
     $this->passwordResetModel->deleteByEmail($record->email);
     return true;
 }
 return false;
 }

 private function getEnv(string $key, $default = null)
 {
 if (isset($_ENV[$key])) {
 return $_ENV[$key];
 }
 $value = getenv($key);
 if ($value !== false) {
 return $value;
 }
 return $default;
 }

 private function loadEnvFromDotEnvFile()
 {
 $envPath = dirname(__DIR__, 2) . '/.env';
 if (!file_exists($envPath)) {
 return;
 }
 $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
 foreach ($lines as $line) {
 $line = trim($line);
 if ($line === '' || $line[0] === '#') {
 continue;
 }
 if (strpos($line, '=') === false) {
 continue;
 }
 [$name, $value] = explode('=', $line, 2);
 $name = trim($name);
 $value = trim($value);
 $value = trim($value, '"');
 if (getenv($name) === false) {
 putenv("{$name}={$value}");
 $_ENV[$name] = $value;
 $_SERVER[$name] = $value;
 }
 }
 }
 public function check() { return Session::has('user_id'); }
 public function role() { return Session::get('user_role'); }
 
 // Record login attempts for audit trail
 private function recordLoginAttempt($email, $success = false)
 {
     $ip = $_SERVER['REMOTE_ADDR'] ?? '';
     $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
     
     // Insert into login_attempts table if it exists
     try {
         $stmt = $this->userModel->getDb()->prepare(
             "INSERT INTO login_attempts (email, ip_address, user_agent, success) VALUES (?, ?, ?, ?)"
         );
         $stmt->execute([$email, $ip, $userAgent, $success ? 1 : 0]);
     } catch (\Exception $e) {
         // Table might not exist yet, silently fail
     }
 }
 
 // Send email verification link after registration
 private function sendVerificationEmail($email)
 {
     $token = bin2hex(random_bytes(32));
     
     try {
         $stmt = $this->userModel->getDb()->prepare(
             "INSERT INTO email_verification_tokens (email, token, expires_at) VALUES (?, ?, DATE_ADD(NOW(), INTERVAL 24 HOUR))"
         );
         $stmt->execute([$email, $token]);
     } catch (\Exception $e) {
         // Table might not exist yet
         return false;
     }
     
     $appUrl = $this->getEnv('APP_URL', 'http://localhost:8000');
     $verifyLink = rtrim($appUrl, '/') . '/verify-email?token=' . urlencode($token);
     $subject = 'Verify Your Email Address';
     $message = "Please click the link below to verify your email address:\r\n\r\n<{$verifyLink}>";
     $headers = "From: noreply@yourdomain.com\r\n";
     $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
     
     $smtpHost = $this->getEnv('MAIL_HOST', null);
     $smtpUser = $this->getEnv('MAIL_USERNAME', null);
     $smtpPass = $this->getEnv('MAIL_PASSWORD', null);
     $smtpPort = $this->getEnv('MAIL_PORT', 587);
     $smtpSecure = $this->getEnv('MAIL_ENCRYPTION', PHPMailer::ENCRYPTION_STARTTLS);
     
     if ($smtpHost && $smtpUser && $smtpPass) {
         try {
             $mail = new PHPMailer(true);
             $mail->isSMTP();
             $mail->Host = $smtpHost;
             $mail->SMTPAuth = true;
             $mail->Username = $smtpUser;
             $mail->Password = $smtpPass;
             $mail->SMTPSecure = $smtpSecure;
             $mail->Port = $smtpPort;
             $mail->setFrom($smtpUser, 'Leave Management');
             $mail->addAddress($email);
             $mail->isHTML(true);
             $mail->Subject = $subject;
             $mail->Body = "<p>Please click the link below to verify your email address:</p><p><a href=\"{$verifyLink}\">{$verifyLink}</a></p>";
             $mail->AltBody = "Please click the link below to verify your email address:\n\n<{$verifyLink}>";
             $mail->send();
             return true;
         } catch (\Exception $e) {
             error_log('Email verification error: ' . $e->getMessage());
             return false;
         }
     }
     
     return mail($email, $subject, $message, $headers);
 }
 
 // Verify email token and mark email as verified
 public function verifyEmail($token)
 {
     try {
         $stmt = $this->userModel->getDb()->prepare(
             "SELECT * FROM email_verification_tokens WHERE token = ? AND expires_at > NOW()"
         );
         $stmt->execute([$token]);
         $record = $stmt->fetch(\PDO::FETCH_OBJ);
         
         if (!$record) return false;
         
         // Update user email_verified and email_verified_at
         $stmt = $this->userModel->getDb()->prepare(
             "UPDATE users SET email_verified = 1, email_verified_at = NOW() WHERE email = ?"
         );
         $stmt->execute([$record->email]);
         
         // Delete used token
         $stmt = $this->userModel->getDb()->prepare(
             "DELETE FROM email_verification_tokens WHERE token = ?"
         );
         $stmt->execute([$token]);
         
         return true;
     } catch (\Exception $e) {
         return false;
     }
 }
 
 // Check session timeout (30 minutes default)
 public function checkSessionTimeout($timeoutMinutes = 30)
 {
     $sessionStartedAt = Session::get('session_started_at');
     if (!$sessionStartedAt) return false;
     
     $currentTime = time();
     $elapsedMinutes = ($currentTime - $sessionStartedAt) / 60;
     
     if ($elapsedMinutes > $timeoutMinutes) {
         $this->logout();
         return false;
     }
     return true;
 }
}
