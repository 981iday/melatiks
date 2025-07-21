<?php
if (!function_exists('base_url')) {
    function base_url($path = '') {
        // Ambil base URL lengkap dari global (misal: https://domain.com/melatiks)
        $base = $GLOBALS['base_url'] ?? '';

        // Jika belum ada base_url, bangun dari base folder default (misal 'melatiks')
        if (empty($base)) {
            // Folder aplikasi, nanti tinggal ganti 'melatiks' sesuai environment
            $appFolder = $GLOBALS['APP_BASE_FOLDER'] ?? 'melatiks';

            // Bangun base URL default dari server info
            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
            $host = $_SERVER['HTTP_HOST'];
            $base = $protocol . '://' . $host . '/' . trim($appFolder, '/');
        }

        // Pastikan base tanpa slash di akhir, path tanpa slash di depan, lalu digabung dengan satu slash
        return rtrim($base, '/') . '/' . ltrim($path, '/');
    }
}
