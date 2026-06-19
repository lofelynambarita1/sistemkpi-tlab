<?php
$passwords = ['password123', '', 'root', 'admin', 'mysql'];
foreach ($passwords as $pwd) {
    try {
        $pdo = new PDO("mysql:host=127.0.0.1;port=3306;dbname=kpi_system", "root", $pwd);
        echo "SUCCESS with password: '$pwd'\n";
        $q = $pdo->query("SELECT COUNT(*) as c FROM users");
        $r = $q->fetch(PDO::FETCH_ASSOC);
        echo "Users count: " . $r['c'] . "\n";
        exit(0);
    } catch (Exception $e) {
        echo "FAIL with password: '$pwd' - " . $e->getMessage() . "\n";
    }
}
