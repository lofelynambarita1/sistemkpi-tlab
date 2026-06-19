<?php
// Try all common connection methods
$attempts = [
    ['host' => '127.0.0.1', 'port' => 3306, 'user' => 'root', 'pass' => 'password123', 'db' => 'kpi_system'],
    ['host' => '127.0.0.1', 'port' => 3306, 'user' => 'root', 'pass' => '', 'db' => 'kpi_system'],
    ['host' => 'localhost', 'port' => 3306, 'user' => 'root', 'pass' => 'password123', 'db' => 'kpi_system'],
    ['host' => '127.0.0.1', 'port' => 3307, 'user' => 'root', 'pass' => 'password123', 'db' => 'kpi_system'],
    ['host' => '127.0.0.1', 'port' => 3308, 'user' => 'root', 'pass' => 'password123', 'db' => 'kpi_system'],
];

foreach ($attempts as $a) {
    try {
        $pdo = new PDO("mysql:host={$a['host']};port={$a['port']};dbname={$a['db']}", $a['user'], $a['pass']);
        echo "SUCCESS: {$a['host']}:{$a['port']} / {$a['user']} / '{$a['pass']}' / {$a['db']}\n";
        $q = $pdo->query("SELECT COUNT(*) as c FROM users");
        $r = $q->fetch(PDO::FETCH_ASSOC);
        echo "Users: {$r['c']}\n";
        exit(0);
    } catch (Exception $e) {
        echo "FAIL: {$a['host']}:{$a['port']} - {$e->getMessage()}\n";
    }
}
