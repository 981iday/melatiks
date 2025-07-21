<?php
// Ambil pengaturan situs dari controller
$siteName   = $settings['site_name'] ?? "Nama Website";


?>
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($siteName) ?></title>
<!-- css meta dan lainnya -->

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 4 -->
    <link rel="stylesheet" href="<?= base_url('assets/plugins/bootstrap/css/bootstrap.min.css') ?>">
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="<?= base_url('assets/plugins/fontawesome-free/css/all.min.css') ?>">

    <!-- AdminLTE -->
    <link rel="stylesheet" href="<?= base_url('assets/dist/css/adminlte.min.css') ?>">

    <!-- Animate & WOW.js (untuk efek animasi pagelayer) -->
    <link rel="stylesheet" href="<?= base_url('assets/plugins/animate/animate.min.css') ?>">

    <!-- Custom CSS (optional) -->
    <link rel="stylesheet" href="<?= base_url('assets/css/custom.css') ?>">
</head>
