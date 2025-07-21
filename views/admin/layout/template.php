<?php
// Header
include __DIR__ . '/head.php';
include __DIR__ . '/navbar.php';
include __DIR__ . '/sidebar.php';

// Buat breadcrumb otomatis jika tidak diset manual di controller
if (!isset($breadcrumb)) {
    $uri = $_SERVER['REQUEST_URI'] ?? '';
    $path = parse_url($uri, PHP_URL_PATH);
    $segments = explode('/', trim($path, '/'));

    // Cari posisi 'admin' dan ambil setelahnya
    $adminIndex = array_search('admin', $segments);
    if ($adminIndex !== false) {
        $breadcrumb = array_slice($segments, $adminIndex);
    } else {
        $breadcrumb = ['Dashboard'];
    }

    // Format agar huruf besar & bersih
    $breadcrumb = array_map(function ($seg) {
        return ucwords(str_replace(['-', '_'], ' ', $seg));
    }, $breadcrumb);
}
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><?= $title ?? 'Dashboard' ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <?php if (isset($breadcrumb) && is_array($breadcrumb)): ?>
                            <?php foreach ($breadcrumb as $index => $crumb): ?>
                                <?php if ($index === array_key_last($breadcrumb)): ?>
                                    <li class="breadcrumb-item active"><?= htmlspecialchars($crumb ?? '') ?></li>
                                <?php else: ?>
                                    <li class="breadcrumb-item"><?= htmlspecialchars($crumb ?? '') ?></li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <?php
            $konten = __DIR__ . '/../page/' . ($page ?? '') . '/index.php';

            if (file_exists($konten)) {
                include $konten;
            } else {
                echo "<div class='alert alert-danger'>Konten tidak ditemukan: <code>$konten</code></div>";
            }
            ?>
        </div>
    </section>
</div>

<?php include __DIR__ . '/footer.php'; ?>
