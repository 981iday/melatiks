<?php
// Ambil pengaturan situs dari controller
$siteName   = $settings['site_name'] ?? "Nama Website";

// Path logo dari database
$logoSmallFile = $settings['logo_kecil'] ?? 'logo_kecil.png';
$logoBigFile   = $settings['logo_besar'] ?? 'logo_besar.png';

// Lokasi file logo di assets
$logoSmallPath = 'assets/images/setting' . $logoSmallFile;
$logoBigPath   = 'assets/images/setting' . $logoBigFile;

// Cek keberadaan file, fallback ke default jika tidak ada
$logoSmall = file_exists($logoSmallPath) ? $logoSmallPath : 'assets/images/default-logo.png';
$logoBig   = file_exists($logoBigPath)   ? $logoBigPath   : 'assets/images/default-logo.png';
?>

<nav class="main-header navbar navbar-expand navbar-white navbar-light shadow-sm">
    <div class="container">
        <a href="<?= base_url() ?>" class="navbar-brand d-flex align-items-center">
            <img src="<?= base_url($logoBig) ?>" alt="<?= htmlspecialchars($siteName) ?>" class="brand-image me-2" style="height: 45px;">
        </a>

        <div class="d-flex ms-auto">
            <a href="<?= base_url('/daftar') ?>" class="btn btn-outline-success btn-sm me-2">Daftar</a>
            <a href="<?= base_url('/login') ?>" class="btn btn-success btn-sm">Login</a>
        </div>
    </div>
</nav>
