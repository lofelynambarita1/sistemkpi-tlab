<?php
// Try connecting without any database first
try {
    $pdo = new PDO("mysql:host=127.0.0.1;port=3306", "root", "password123");
    echo "Connected without db\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

// Check MySQL error log path
echo "\nMySQL Service info:\n";
exec('sc query MySQL80', $output, $code);
echo implode("\n", $output) . "\n";
