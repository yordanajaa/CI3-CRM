<?php
$pdo = new PDO('mysql:host=localhost;dbname=metafora;charset=utf8', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

echo "=== CRM_BROADCAST_LOGS SCHEMA ===\n";
$stmt = $pdo->query("DESCRIBE crm_broadcast_logs");
print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
