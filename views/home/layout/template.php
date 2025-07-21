<!DOCTYPE html>
<html lang="id">
<head>
    <?php include __DIR__ . '/head.php'; ?>
</head>
<body class="hold-transition layout-top-nav">

<div class="wrapper">

    <?php include __DIR__ . '/navbar.php'; ?>

    <div class="content-wrapper" id="content">
        <?php
        // Panggil page/index.php yang akan handle loading konten halaman
        include __DIR__ . '/../page/index.php';
        ?>
    </div>

    <?php include __DIR__ . '/footer.php'; ?>

</div>

</body>
</html>
