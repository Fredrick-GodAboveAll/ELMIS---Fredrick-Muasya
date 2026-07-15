<?php
namespace App\Core;

class Csrf
{
    /**
     * Generate or retrieve CSRF token
     * Always generates a new one on each page load
     */
    public static function generate()
    {
        // Always create a new token for security
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        return $_SESSION['csrf_token'];
    }

    /**
     * Validate CSRF token from POST data
     * Does not delete token - allows page reloads
     */
    public static function validate($token)
    {
        // Ensure the token exists in the session and matches the submitted value.
        if (!isset($_SESSION['csrf_token'])) {
            throw new \Exception('CSRF token not found in session');
        }

        if (empty($token) || $token !== $_SESSION['csrf_token']) {
            throw new \Exception('Invalid CSRF token');
        }

        // Generate a new token for the next request
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        
        return true;
    }
}