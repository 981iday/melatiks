<?php
/**
 * Menghasilkan URL dasar aplikasi, ditambah path opsional.
 * Menggunakan $GLOBALS['base_url'] jika ada, 
 * atau membangun dari protokol dan host server.
 *
 * @param string $path Path relatif yang ingin ditambahkan ke base URL
 * @return string URL lengkap
 */

if (!function_exists('base_url')) {
    function base_url($path = '') {
        // Pakai global base_url kalau ada dan bukan kosong
        if (!empty($GLOBALS['base_url'])) {
            $base = $GLOBALS['base_url'];
        } else {
            // Cek APP_BASE_FOLDER, default 'melatiks'
            $appFolder = !empty($GLOBALS['APP_BASE_FOLDER']) ? $GLOBALS['APP_BASE_FOLDER'] : 'melatiks';

            // Tentukan protokol, fallback ke 'http'
            $protocol = 'http';
            if (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] === 'on' || $_SERVER['HTTPS'] == 1)) {
                $protocol = 'https';
            } elseif (!empty($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443) {
                $protocol = 'https';
            }

            // Cek host, fallback ke localhost
            $host = $_SERVER['HTTP_HOST'] ?? 'localhost';

            // Bangun base URL
            $base = $protocol . '://' . $host . '/' . trim($appFolder, '/');
        }

        // Gabungkan base dan path, pastikan tidak double slash
        return rtrim($base, '/') . '/' . ltrim($path, '/');
    }
}
