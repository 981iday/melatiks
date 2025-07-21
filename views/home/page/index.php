<?php
global $db;

try {
    $stmt = $db->query("SELECT slug, title FROM pages WHERE is_active = 1 ORDER BY position ASC");
    $pages = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!$pages) {
        echo "<div class='alert alert-warning text-center'>Belum ada halaman yang ditampilkan.</div>";
        return;
    }

    foreach ($pages as $page) {
        $slug = $page['slug'];
        $file = __DIR__ . '/halaman_' . $slug . '/index.php';

        echo "<section id='{$slug}' class='py-5'>";
        if (file_exists($file)) {
            include $file;
        } else {
            echo "<div class='container text-center text-muted'><em>Halaman <strong>{$slug}</strong> belum tersedia.</em></div>";
        }
        echo "</section>";
    }
} catch (Exception $e) {
    echo "<div class='alert alert-danger'>Gagal memuat halaman: " . htmlspecialchars($e->getMessage()) . "</div>";
}
