<?php
namespace App\Core;

use PDO;

class OfflineDetector
{
    private static $isOffline = null;

    /**
     * Check if system is in offline mode (no email/SMTP available)
     * 
     * @return bool true if offline, false if online
     */
    public static function isOffline()
    {
        if (self::$isOffline !== null) {
            return self::$isOffline;
        }

        // Check 1: Email environment variables configured
        $hasEmailConfig = !empty($_ENV['MAIL_HOST']) && 
                         !empty($_ENV['MAIL_USERNAME']) && 
                         !empty($_ENV['MAIL_PASSWORD']);

        if (!$hasEmailConfig) {
            self::$isOffline = true;
            return true;
        }

        // Check 2: Try to test SMTP connection
        $smtpHost = $_ENV['MAIL_HOST'] ?? 'smtp.gmail.com';
        $smtpPort = $_ENV['MAIL_PORT'] ?? 587;

        // Quick socket test (doesn't connect, just checks if port responds)
        $timeout = 2;
        $socket = @fsockopen($smtpHost, $smtpPort, $errno, $errstr, $timeout);

        if ($socket) {
            fclose($socket);
            self::$isOffline = false;
            return false;
        }

        // Cannot reach SMTP server = offline mode
        self::$isOffline = true;
        return true;
    }

    /**
     * Get user-friendly offline status message
     */
    public static function getOfflineMessage()
    {
        return "This feature requires an active internet connection and email service. Currently offline.";
    }

    /**
     * Check if specific feature is available
     */
    public static function canUseFeature($feature)
    {
        // Features that require online mode
        $onlineFeatures = [
            'email_verification',
            'password_reset_email',
            'email_notifications'
        ];

        if (in_array($feature, $onlineFeatures)) {
            return !self::isOffline();
        }

        // Default: feature is available
        return true;
    }

    /**
     * Force offline mode (for testing)
     */
    public static function forceOffline($offline = true)
    {
        self::$isOffline = $offline;
    }
}
