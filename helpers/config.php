<?php
if (!function_exists('config')) {
    /**
     * Ambil nilai konfigurasi dari environment (.env)
     * @param string $key Nama variabel .env
     * @param mixed $default Nilai default jika variabel tidak ditemukan
     * @return mixed
     */
    function config(string $key, $default = null) {
        // Cek dulu di $_ENV
        if (isset($_ENV[$key])) {
            return $_ENV[$key];
        }

        // Cek di getenv() (kadang $_ENV tidak selalu terisi tergantung konfigurasi PHP)
        $value = getenv($key);
        if ($value !== false) {
            return $value;
        }

        // Kalau gak ketemu, return default
        return $default;
    }
}
