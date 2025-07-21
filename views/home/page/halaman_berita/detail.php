<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <h2 class="mb-3"><?= htmlspecialchars($berita['judul'], ENT_QUOTES) ?></h2>

            <p class="text-muted mb-3">
                Diposting oleh <?= htmlspecialchars($berita['penulis'], ENT_QUOTES) ?> pada <?= date('d M Y', strtotime($berita['created_at'])) ?>
            </p>

            <?php if (!empty($berita['gambar'])) : ?>
                <img src="<?= base_url('assets/images/berita/' . rawurlencode($berita['gambar'])) ?>" class="img-fluid rounded mb-4" alt="<?= htmlspecialchars($berita['judul'], ENT_QUOTES) ?>">
            <?php endif; ?>

            <div class="berita-isi">
                <?= nl2br($berita['isi']) ?>
            </div>

            <a href="<?= base_url('berita') ?>" class="btn btn-sm btn-outline-secondary mt-4">&larr; Kembali ke daftar berita</a>
        </div>
    </div>
</div>
