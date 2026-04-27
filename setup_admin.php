<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/config/app.php';

$db = new PDO('mysql:host=localhost;dbname=worthycitdb;charset=utf8mb4', 'root', '');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$email = 'citelord@worthycite.com';
$password = 'Lord19872026@';
$hash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
$name = 'CiteLord';

// Drop if exists
$db->prepare("DELETE FROM users WHERE email = ?")->execute([$email]);

$stmt = $db->prepare("INSERT INTO users (name, email, password_hash, plan, is_admin, created_at) VALUES (?, ?, ?, 'elite', 1, NOW())");
$stmt->execute([$name, $email, $hash]);

echo "Admin user CiteLord created successfully.\n";
