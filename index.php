<?php
// index.php

require_once __DIR__ . '/helpers/url.php';
require_once __DIR__ . '/helpers/access.php';
require_once __DIR__ . '/config/connection.php';
require_once __DIR__ . '/helpers/settings.php';

global $db;
$db = $pdo;

// Aktifkan debug mode jika ingin melihat info routing
$debug = false;

// Konfigurasi base folder (ubah jika root domain langsung)
$baseFolder = '/melatiks'; // Jika sudah di root hosting, ganti jadi ''

// Normalisasi base folder agar konsisten
$baseFolder = rtrim($baseFolder, '/');
if ($baseFolder !== '' && $baseFolder[0] !== '/') {
    $baseFolder = '/' . $baseFolder;
}

// Buat base_url dinamis, contoh: https://domain.com/melatiks
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'];
$base_url = $protocol . '://' . $host . $baseFolder;
$GLOBALS['base_url'] = rtrim($base_url, '/'); // global bisa diakses dari mana saja

// Ambil URI saat ini
$requestUri = $_SERVER['REQUEST_URI'] ?? '/';

// Hilangkan query string jika ada
$requestPath = parse_url($requestUri, PHP_URL_PATH);

// Hilangkan base folder dari path, jika ada
if ($baseFolder !== '' && strpos($requestPath, $baseFolder) === 0) {
    $path = substr($requestPath, strlen($baseFolder));
} else {
    $path = $requestPath;
}

// Normalisasi path
$path = '/' . ltrim($path, '/');
$path = rtrim($path, '/');
if ($path === '') {
    $path = '/';
}

// DEBUG (opsional)
if ($debug) {
    echo "<pre>";
    echo "REQUEST_URI: " . $_SERVER['REQUEST_URI'] . "\n";
    echo "Parsed path: $path\n";

    $routes = require __DIR__ . '/routes/web.php';
    echo "Routes:\n";
    print_r(array_keys($routes));
    echo "</pre>";
    exit;
}

// Load route definitions
$routes = require __DIR__ . '/routes/web.php';

// ─────────────────────────────────────────────
// 🔍 Cek apakah path cocok dengan route statis
if (isset($routes[$path])) {
    $controllerName = $routes[$path]['controller'];
    $method = $routes[$path]['method'];
    $params = [];
} else {
    // 🔁 Coba cocokkan route dinamis dengan parameter
    $matched = false;
    foreach ($routes as $routePattern => $routeInfo) {
        // Ubah {parameter} menjadi regex grup
        $regex = preg_replace('#\{[a-zA-Z_][a-zA-Z0-9_]*\}#', '([^/]+)', $routePattern);
        $regex = '#^' . rtrim($regex, '/') . '$#';

        if (preg_match($regex, $path, $matches)) {
            array_shift($matches); // hapus full match

            $controllerName = $routeInfo['controller'];
            $method = $routeInfo['method'];
            $params = $matches;
            $matched = true;
            break;
        }
    }

    if (!$matched) {
        http_response_code(404);
        echo "❌ 404 - Halaman <b>$path</b> tidak ditemukan.";
        exit;
    }
}

// ─────────────────────────────────────────────
// 📦 Jalankan Controller dan Method
$controllerFile = __DIR__ . '/controllers/' . $controllerName . '.php';

if (file_exists($controllerFile)) {
    require_once $controllerFile;

    if (class_exists($controllerName)) {
        $controller = new $controllerName();

        if (method_exists($controller, $method)) {
            call_user_func_array([$controller, $method], $params);
        } else {
            http_response_code(500);
            echo "⚠️ Method <b>$method</b> tidak ditemukan di controller <b>$controllerName</b>.";
        }
    } else {
        http_response_code(500);
        echo "⚠️ Class controller <b>$controllerName</b> tidak ditemukan.";
    }
} else {
    http_response_code(500);
    echo "⚠️ File controller <b>$controllerFile</b> tidak ditemukan.";
}
