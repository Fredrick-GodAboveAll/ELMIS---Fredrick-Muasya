<?php
namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailService
{
    private $mailer;

    public function __construct()
    {
        $this->loadEnvFromDotEnvFile();

        $this->mailer = new PHPMailer(true);

        // Server settings
        $this->mailer->isSMTP();
        $this->mailer->Host = $this->getEnv('MAIL_HOST', 'smtp.gmail.com');
        $this->mailer->SMTPAuth = true;
        $this->mailer->Username = $this->getEnv('MAIL_USERNAME');
        $this->mailer->Password = $this->getEnv('MAIL_PASSWORD');
        $this->mailer->SMTPSecure = $this->getEnv('MAIL_ENCRYPTION', PHPMailer::ENCRYPTION_STARTTLS);
        $this->mailer->Port = (int) $this->getEnv('MAIL_PORT', 587);

        // Recipients
        $from = $this->getEnv('MAIL_FROM_ADDRESS', 'noreply@yourdomain.com');
        $fromName = $this->getEnv('MAIL_FROM_NAME', 'Leave Management System');
        $this->mailer->setFrom($from, $fromName);
    }

    public function sendPasswordReset($email, $token)
    {
        try {
            $this->mailer->addAddress($email);
            $this->mailer->isHTML(true);
            $this->mailer->Subject = 'Password Reset Request';

            $appUrl = rtrim($this->getEnv('APP_URL', 'http://localhost:8000'), '/');
            $resetLink = $appUrl . '/reset-password?token=' . urlencode($token);

            $this->mailer->Body = "
                <h2>Password Reset Request</h2>
                <p>You requested a password reset for your account.</p>
                <p>Click the link below to reset your password:</p>
                <a href='{$resetLink}' style='background-color: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Reset Password</a>
                <p>This link will expire in 1 hour.</p>
                <p>If you didn't request this, please ignore this email.</p>
            ";

            $this->mailer->AltBody = "Password Reset Request\n\nYou requested a password reset.\n\nReset link: {$resetLink}\n\nThis link expires in 1 hour.";

            $this->mailer->send();
            return true;
        } catch (Exception $e) {
            error_log("Email sending failed: " . $this->mailer->ErrorInfo);
            return false;
        }
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
}