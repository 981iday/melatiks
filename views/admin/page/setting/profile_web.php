<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-chart-pie mr-1"></i>
            Profil Sekolah
        </h3>
        <div class="card-tools">
            <button type="button" class="btn bg-info btn-sm" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            <button type="button" class="btn bg-info btn-sm" data-card-widget="remove"><i class="fas fa-times"></i></button>
        </div>
    </div><!-- /.card-header -->

    <div class="card-body">
        <div class="tab-content p-0">
            <!-- Include profil sekolah -->
        </div>
        <form action="<?= base_url('admin/setting/simpan_profil') ?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label>Nama Sekolah</label>
                <input type="text" class="form-control" name="nama_sekolah" value="<?= htmlspecialchars($profil['nama_sekolah'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label>Nama Kepala Sekolah</label>
                <input type="text" class="form-control" name="nama_kepala_sekolah" value="<?= htmlspecialchars($profil['nama_kepala_sekolah'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label>NPSN</label>
                <input type="text" class="form-control" name="npsn" value="<?= htmlspecialchars($profil['npsn'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label>NSS</label>
                <input type="text" class="form-control" name="nss" value="<?= htmlspecialchars($profil['nss'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label>Alamat Lengkap</label>
                <textarea name="alamat" class="form-control" rows="2"><?= htmlspecialchars($profil['alamat'] ?? '') ?></textarea>
            </div>
            <div class="form-group">
                <label>Status Sekolah</label>
                <select name="status" class="form-control">
                    <option value="Negeri" <?= ($profil['status'] ?? '') === 'Negeri' ? 'selected' : '' ?>>Negeri</option>
                    <option value="Swasta" <?= ($profil['status'] ?? '') === 'Swasta' ? 'selected' : '' ?>>Swasta</option>
                </select>
            </div>
            <div class="form-group">
                <label>Akreditasi</label>
                <input type="text" class="form-control" name="akreditasi" value="<?= htmlspecialchars($profil['akreditasi'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label>Sejarah Singkat</label>
                <textarea name="sejarah" class="form-control" rows="4"><?= htmlspecialchars($profil['sejarah'] ?? '') ?></textarea>
            </div>
            <div class="form-group">
                <label>Nama Yayasan</label>
                <textarea name="nama_yayasan" class="form-control" rows="3"><?= htmlspecialchars($profil['nama_yayasan'] ?? '') ?></textarea>
            </div>
            <div class="form-group">
                <label>Visi</label>
                <textarea name="visi" class="form-control"><?= htmlspecialchars($profil['visi'] ?? '') ?></textarea>
            </div>
            <div class="form-group">
                <label>Misi</label>
                <textarea name="misi" class="form-control" rows="4"><?= htmlspecialchars($profil['misi'] ?? '') ?></textarea>
            </div>
            <div class="form-group">
                <label>Logo Sekolah</label>
                <input type="file" class="form-control-file" name="logo" accept="image/*">
                <?php if (!empty($profil['logo'])): ?>
                    <img src="<?= base_url('assets/images/setting' . $profil['logo']) ?>" alt="Logo Sekolah" width="80" class="mt-2">
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-info btn-sm">Simpan Profil</button>
        </form>
    </div>
</div><!-- /.card-body -->
<!-- SweetAlert -->
<script src="<?= base_url('assets/plugins/sweetalert2/sweetalert2.min.js') ?>"></script>

<?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: 'Profil sekolah berhasil disimpan.',
            timer: 2000,
            showConfirmButton: false
        }).then(() => {
            // Hilangkan parameter GET setelah alert selesai
            window.history.replaceState(null, null, window.location.pathname);
        });
    </script>
<?php endif; ?>

<?php if (isset($_GET['error']) && $_GET['error'] == 1): ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: 'Terjadi kesalahan saat menyimpan data.',
            timer: 3000,
            showConfirmButton: true
        });
    </script>
<?php endif; ?>