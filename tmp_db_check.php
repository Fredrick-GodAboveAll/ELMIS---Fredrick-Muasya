<?php
$cfg = require __DIR__ . '/config/database.php';
$dsn = "mysql:host={$cfg['host']};dbname={$cfg['name']};charset=utf8mb4";

try {
    $pdo = new PDO($dsn, $cfg['user'], $cfg['pass'], [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $cols = $pdo->query('SHOW COLUMNS FROM leave_policy_details')->fetchAll(PDO::FETCH_COLUMN);
    echo 'COLUMNS:' . PHP_EOL;
    foreach ($cols as $col) {
        echo $col . PHP_EOL;
    }
    echo '---' . PHP_EOL;
    foreach (['carry_forward', 'carry_forward_limit'] as $col) {
        echo $col . ':' . (in_array($col, $cols, true) ? 'yes' : 'no') . PHP_EOL;
    }
} catch (Throwable $e) {
    echo 'DB_ERROR:' . $e->getMessage() . PHP_EOL;
}
