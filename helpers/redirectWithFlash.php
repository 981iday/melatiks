<?php
if (!function_exists('redirectWithFlash')) {
    function redirectWithFlash($type, $message, $redirect = 'admin/kategori') {
        $query = http_build_query([
            'type' => $type,
            'msg' => $message
        ]);
        header("Location: " . base_url() . $redirect . '?' . $query);
        exit;
    }
}
