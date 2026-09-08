<?php
$pdo = new PDO('mysql:host=localhost;dbname=metafora;charset=utf8', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

echo "=== CRM_FOLLOWUP_NOTES SCHEMA ===\n";
$stmt = $pdo->query("DESCRIBE crm_followup_notes");
print_r($stmt->fetchAll(PDO::FETCH_ASSOC));

echo "\n=== SAMPLE NOTES DATA ===\n";
$stmt2 = $pdo->query("SELECT * FROM crm_followup_notes ORDER BY id DESC LIMIT 10");
print_r($stmt2->fetchAll(PDO::FETCH_ASSOC));
