<?php
$host = 'localhost';
$db   = 'metafora';
$user = 'root';
$pass = '';

$pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);

// Get all menus
$menus = $pdo->query("SELECT id, label, link FROM menu")->fetchAll(PDO::FETCH_ASSOC);

foreach ($menus as $menu) {
    // Generate permission name exactly as Menu model does
    // $perm_name = 'menu_' . str_replace(' ', '_', strtolower($menu->label));
    // Actually, in CC-Core it's usually menu_ + lowercase label with spaces replaced by underscore, AND special chars removed?
    // Let's just create 'menu_' . strtolower(str_replace([' ', '&', '(', ')'], ['_', 'and', '', ''], $menu['label']));
    // Wait, earlier I saw 'menu_hr_&_absensi'. So '&' is NOT replaced by 'and'.
    $perm_name = 'menu_' . strtolower(str_replace(' ', '_', $menu['label']));
    
    // Check if permission exists
    $stmt = $pdo->prepare("SELECT id FROM aauth_perms WHERE name = ?");
    $stmt->execute([$perm_name]);
    $perm = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$perm) {
        // Create permission
        $stmt = $pdo->prepare("INSERT INTO aauth_perms (name, definition) VALUES (?, ?)");
        $stmt->execute([$perm_name, 'Menu ' . $menu['label']]);
        $perm_id = $pdo->lastInsertId();
    } else {
        $perm_id = $perm['id'];
    }
    
    // Assign to group 1
    $stmt = $pdo->prepare("INSERT IGNORE INTO aauth_perm_to_group (perm_id, group_id) VALUES (?, 1)");
    $stmt->execute([$perm_id]);
}

echo "All menu permissions synced and granted to Super Admin (Group 1)!\n";


