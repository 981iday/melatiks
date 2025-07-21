<?php
require_once __DIR__ . '/../helpers/env.php';
load_env();

$host = env('DB_HOST', 'localhost');
$db = env('DB_NAME', 'melatiks_db');
$user = env('DB_USER', 'root');
$pass = env('DB_PASS', '');

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    if (env('APP_DEBUG', false)) {
        die("Koneksi gagal: " . $e->getMessage());
    } else {
        die("Koneksi database gagal. Silakan hubungi admin.");
    }
}
