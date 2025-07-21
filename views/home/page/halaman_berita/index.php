<?php
// Gunakan koneksi global $db (PDO)
global $db;

$beritaList = [];

if ($db instanceof PDO) {
    try {
        $stmt = $db->prepare("SELECT id, judul, isi, gambar, penulis, created_at FROM berita WHERE status = 'publish' ORDER BY created_at DESC LIMIT 10");
        $stmt->execute();
        $beritaList = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "<div class='alert alert-danger'>Gagal mengambil data berita: " . htmlspecialchars($e->getMessage()) . "</div>";
        return;
    }
} else {
    echo "<div class='alert alert-danger'>Koneksi database tidak tersedia.</div>";
    return;
}
?>

<div class="container py-4">
    <h2 class="text-center mb-4 text-danger">Berita Terbaru</h2>

    <div class="row">
        <?php if (empty($beritaList)) : ?>
            <div class="col-12 text-center">
                <div class="alert alert-info">Belum ada berita yang tersedia.</div>
            </div>
        <?php else : ?>
            <?php foreach ($beritaList as $row) : ?>
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm h-100">
                        <?php if (!empty($row['gambar'])) : ?>
                            <img src="<?= base_url('assets/images/berita/' . rawurlencode($row['gambar'])) ?>" class="card-img-top" alt="<?= htmlspecialchars($row['judul'], ENT_QUOTES) ?>">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($row['judul'], ENT_QUOTES) ?></h5>
                            <p class="card-text">
                                <?php
                                $cuplikan = strip_tags($row['isi']);
                                echo mb_substr($cuplikan, 0, 150) . (mb_strlen($cuplikan) > 150 ? '...' : '');
                                ?>
                            </p>
                            <small class="text-muted">
                                Diposting oleh <?= htmlspecialchars($row['penulis'], ENT_QUOTES) ?> pada <?= date('d M Y', strtotime($row['created_at'])) ?>
                            </small>
                        </div>
                        <div class="card-footer text-end bg-white border-top-0">
                            <a href="<?= base_url('berita/detail/' . urlencode($row['id'])) ?>" class="btn btn-sm btn-outline-primary">Baca Selengkapnya</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
