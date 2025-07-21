<div class="container py-5">
    <h2 class="text-center text-danger mb-4">Berita Terbaru</h2>

    <div class="row">
        <?php if (!empty($beritaList)) : ?>
            <?php foreach ($beritaList as $row) : ?>
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm h-100">
                        <?php if (!empty($row['gambar'])) : ?>
                            <img src="<?= base_url('assets/images/berita/' . htmlspecialchars($row['gambar'])) ?>" class="card-img-top" alt="<?= htmlspecialchars($row['judul']) ?>">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($row['judul']) ?></h5>
                            <p class="card-text">
                                <?= mb_substr(strip_tags($row['isi']), 0, 150) ?>...
                            </p>
                            <small class="text-muted">Diposting oleh <?= htmlspecialchars($row['penulis']) ?> pada <?= date('d M Y', strtotime($row['created_at'])) ?></small>
                        </div>
                        <div class="card-footer text-end bg-white border-top-0">
                            <a href="<?= base_url('berita/' . $row['id']) ?>" class="btn btn-sm btn-outline-primary">Baca Selengkapnya</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <div class="col-12">
                <div class="alert alert-warning">Belum ada berita untuk ditampilkan.</div>
            </div>
        <?php endif; ?>
    </div>
</div>
