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
            $this->mailer->Subject = 'Reset your password';

            $appUrl = rtrim($this->getEnv('APP_URL', 'http://localhost:8000'), '/');
            $resetLink = $appUrl . '/reset-password?token=' . urlencode($token);
            $appName = $this->getEnv('APP_NAME', 'e-Leave Management System');

            $this->mailer->Body = $this->getPasswordResetTemplate($resetLink, $appName);
            $this->mailer->AltBody = "Password Reset Request\n\nYou requested a password reset.\n\nReset link: {$resetLink}\n\nThis link expires in 60 minutes.";

            $this->mailer->send();
            return true;
        } catch (Exception $e) {
            error_log("Email sending failed: " . $this->mailer->ErrorInfo);
            return false;
        }
    }

    private function getPasswordResetTemplate($resetLink, $appName)
    {
        return <<<HTML
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Reset your password</title>
<style>
body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
img { -ms-interpolation-mode: bicubic; border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; }
body { margin: 0; padding: 0; width: 100% !important; height: 100% !important; }
.email-container { width: 600px; }
@media screen and (max-width: 600px) {
.email-container { width: 100% !important; max-width: 100% !important; }
.fluid-padding { padding-left: 24px !important; padding-right: 24px !important; }
.h1-mobile { font-size: 22px !important; line-height: 30px !important; }
.btn-table { width: 100% !important; }
.btn-td { width: 100% !important; text-align: center !important; }
}
</style>
</head>
<body style="margin:0; padding:0; background-color:#f5f5f5;">

<div style="display:none; font-size:1px; line-height:1px; max-height:0; max-width:0; opacity:0; overflow:hidden; mso-hide:all;">
A password reset was requested for your $appName account. &nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;
</div>

<center role="article" aria-roledescription="email" lang="en" style="width:100%;">
<table role="presentation" class="email-container" align="center" cellpadding="0" cellspacing="0" border="0" width="100%" style="max-width:600px; margin:0 auto; background-color:#ffffff;">

<tr>
<td style="padding:48px 40px 0 40px;">
<svg width="34" height="34" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg">
<rect x="4" y="6" width="26" height="22" rx="3" stroke="#1F7A5C" stroke-width="2"/>
<path d="M4 12h26" stroke="#1F7A5C" stroke-width="2"/>
<path d="M11 3v6M23 3v6" stroke="#1F7A5C" stroke-width="2" stroke-linecap="round"/>
<path d="M10.5 20.5l3.5 3.5 8-8" stroke="#1F7A5C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
</td>
</tr>

<tr>
<td style="padding:24px 40px 0 40px; font-family:'Segoe UI', Arial, sans-serif;">
<h1 class="h1-mobile" style="margin:0; font-size:28px; line-height:36px; font-weight:700; color:#1a1a1a;">
Reset your password
</h1>
</td>
</tr>

<tr>
<td style="padding:20px 40px 0 40px; font-family:'Segoe UI', Arial, sans-serif;">
<p style="margin:0; font-size:15px; line-height:24px; color:#555;">
A password reset was requested for your <strong>$appName</strong> account. If this was you, use the button below to set a new password.
</p>
</td>
</tr>

<tr>
<td style="padding:32px 40px 0 40px; text-align:center;">
<table role="presentation" class="btn-table" cellpadding="0" cellspacing="0" border="0" style="margin:0 auto;">
<tr>
<td style="border-radius:6px; background-color:#1F7A5C; text-align:center;">
<a href="$resetLink" target="_blank" style="display:inline-block; padding:14px 40px; font-family:'Segoe UI', Arial, sans-serif; font-size:16px; font-weight:700; color:#ffffff; text-decoration:none; border-radius:6px;">
Reset Password
</a>
</td>
</tr>
</table>
</td>
</tr>

<tr>
<td style="padding:28px 40px 0 40px; font-family:'Segoe UI', Arial, sans-serif;">
<p style="margin:0; font-size:13px; line-height:20px; color:#777;">
<strong>Link expires in 60 minutes.</strong> If the button above doesn't work, copy and paste this link:
</p>
<p style="margin:8px 0 0 0; font-size:12px; line-height:18px; color:#0066cc; word-break:break-all;">
<a href="$resetLink" style="color:#0066cc; text-decoration:underline;">$resetLink</a>
</p>
</td>
</tr>

<tr>
<td style="padding:24px 40px 40px 40px; border-top:1px solid #e5e5e5; font-family:'Segoe UI', Arial, sans-serif;">
<p style="margin:0; font-size:12px; line-height:18px; color:#999;">
Didn't request a password reset? No problem — just ignore this email and your password will remain unchanged.
</p>
</td>
</tr>

</table>
</center>
</body>
</html>
HTML;
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