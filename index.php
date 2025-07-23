<?php
// index.php (Router Utama)

require_once __DIR__ . '/vendor/autoload.php'; // Load dotenv dan autoload
require_once __DIR__ . '/helpers/url.php';
require_once __DIR__ . '/helpers/access.php';
require_once __DIR__ . '/helpers/settings.php';
require_once __DIR__ . '/config/connection.php';
require_once __DIR__ . '/helpers/config.php';


use Dotenv\Dotenv;

// Load .env dengan safeLoad supaya gak error kalau .env gak ada
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

// Set konfigurasi dari .env, fallback nilai default bila kosong
$GLOBALS['APP_BASE_FOLDER'] = $_ENV['APP_BASE_FOLDER'] ?? 'melatiks';
$GLOBALS['base_url'] = $_ENV['APP_URL'] ?? null;

global $db;
$db = $pdo;

// Mode debug (aktifkan jika perlu)
$debug = false;

// ─────────────────────────────────────────────
// Routing Request
$requestUri = $_SERVER['REQUEST_URI'] ?? '/';
$requestPath = parse_url($requestUri, PHP_URL_PATH);

// Buang base folder jika bukan root
$baseFolder = '/' . trim($GLOBALS['APP_BASE_FOLDER'], '/');
if ($baseFolder !== '/' && strpos($requestPath, $baseFolder) === 0) {
    $path = substr($requestPath, strlen($baseFolder));
} else {
    $path = $requestPath;
}

// Normalisasi path
$path = '/' . ltrim($path, '/');
$path = rtrim($path, '/');
if ($path === '') $path = '/';

// Debugging (jika aktif)
if ($debug) {
    echo "<pre>";
    echo "REQUEST_URI: " . $_SERVER['REQUEST_URI'] . "\n";
    echo "Parsed Path: $path\n";
    $routes = require __DIR__ . '/routes/web.php';
    print_r($routes);
    echo "</pre>";
    exit;
}

// ─────────────────────────────────────────────
// Routing
$routes = require __DIR__ . '/routes/web.php';

if (isset($routes[$path])) {
    $controllerName = $routes[$path]['controller'];
    $method = $routes[$path]['method'];
    $params = [];
} else {
    // Coba cocokkan dengan route dinamis
    $matched = false;
    foreach ($routes as $pattern => $info) {
        $regex = preg_replace('#\{[a-zA-Z_][a-zA-Z0-9_]*\}#', '([^/]+)', $pattern);
        $regex = '#^' . rtrim($regex, '/') . '$#';

        if (preg_match($regex, $path, $matches)) {
            array_shift($matches); // Hilangkan full match
            $controllerName = $info['controller'];
            $method = $info['method'];
            $params = $matches;
            $matched = true;
            break;
        }
    }

    if (!$matched) {
        http_response_code(404);
        echo "❌ 404 - Halaman <b>" . htmlspecialchars($path, ENT_QUOTES) . "</b> tidak ditemukan.";
        exit;
    }
}

// ─────────────────────────────────────────────
// Jalankan Controller
$controllerFile = __DIR__ . '/controllers/' . $controllerName . '.php';

if (!file_exists($controllerFile)) {
    http_response_code(500);
    echo "⚠️ File controller <b>" . htmlspecialchars($controllerFile, ENT_QUOTES) . "</b> tidak ditemukan.";
    exit;
}

require_once $controllerFile;

if (!class_exists($controllerName)) {
    http_response_code(500);
    echo "⚠️ Class controller <b>" . htmlspecialchars($controllerName, ENT_QUOTES) . "</b> tidak ditemukan.";
    exit;
}

$controller = new $controllerName($pdo); // Inject PDO ke constructor

if (!method_exists($controller, $method)) {
    http_response_code(500);
    echo "⚠️ Method <b>" . htmlspecialchars($method, ENT_QUOTES) . "</b> tidak ditemukan di controller <b>" . htmlspecialchars($controllerName, ENT_QUOTES) . "</b>.";
    exit;
}

call_user_func_array([$controller, $method], $params);
