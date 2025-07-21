<!-- Main content -->
 <section class="content">
    <div class="container-fluid">
        <div class="row">

            <!-- Left column -->
            <section class="col-lg-6 connectedSortable">
                <!-- Card: Profil Sekolah -->

                <?php require_once __DIR__ . '/profile_web.php'; ?>

            </section><!-- /.col -->

            <!-- Right column -->
            <section class="col-lg-6 connectedSortable">
                <!-- Include Pengaturan Hak Akses -->
                <?php require_once __DIR__ . '/hakakses.php'; ?>

                <!-- Include Pengaturan Umum -->
                <?php require_once __DIR__ . '/set_umum.php'; ?>
            </section><!-- /.col -->

        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</section><!-- /.content -->