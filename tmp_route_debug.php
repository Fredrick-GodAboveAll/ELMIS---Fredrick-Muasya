<?php
$path = __DIR__ . '/routes/web.php';
$raw = file_get_contents($path);
$first16 = bin2hex(substr($raw, 0, 16));
echo "FIRST16={$first16}\n";
$pos = strpos($raw, '/employee-categories');
echo "POS=" . ($pos === false ? 'false' : (string)$pos) . "\n";
if ($pos !== false) {
    $slice = substr($raw, max(0, $pos - 20), 80);
    echo "SLICE=" . json_encode($slice) . "\n";
    foreach (str_split($slice) as $ch) {
        echo ord($ch) . ' ';
    }
    echo "\n";
}
