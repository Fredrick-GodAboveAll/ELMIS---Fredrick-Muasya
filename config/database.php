<?php
$envPath = dirname(__DIR__) . '/.env';

if (file_exists($envPath)) {
    $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#')) {
            continue;
        }

        if (strpos($line, '=') === false) {
            continue;
        }

        [$name, $value] = explode('=', $line, 2);
        $name = trim($name);
        $value = trim($value, " \t\n\r\0\x0B\"'");

        if ($name !== '') {
            $_ENV[$name] = $value;
            putenv("{$name}={$value}");
        }
    }
}

return [
    'host' => getenv('DB_HOST') ?: ($_ENV['DB_HOST'] ?? 'localhost'),
    'name' => getenv('DB_NAME') ?: ($_ENV['DB_NAME'] ?? 'leave_management'),
    'user' => getenv('DB_USER') ?: ($_ENV['DB_USER'] ?? 'root'),
    'pass' => getenv('DB_PASS') ?: ($_ENV['DB_PASS'] ?? ''),
];