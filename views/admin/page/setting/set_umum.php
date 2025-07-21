<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-edit"></i> Setting Profile Web</h3>
        <div class="card-tools">
            <button type="button" class="btn bg-info btn-sm" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            <button type="button" class="btn bg-info btn-sm" data-card-widget="remove"><i class="fas fa-times"></i></button>
        </div>
    </div>
    <div class="card-body">
        <form action="<?= base_url('admin/setting/simpan_pengaturan') ?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="site_name">Nama Situs</label>
                <input type="text" class="form-control" id="site_name" name="site_name" value="<?= htmlspecialchars($pengaturan['site_name'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label for="maintenance_mode">Mode Pemeliharaan</label>
                <select id="maintenance_mode" name="maintenance_mode" class="form-control">
                    <option value="0" <?= ($pengaturan['maintenance_mode'] ?? 0) == 0 ? 'selected' : '' ?>>Nonaktif</option>
                    <option value="1" <?= ($pengaturan['maintenance_mode'] ?? 0) == 1 ? 'selected' : '' ?>>Aktif</option>
                </select>
            </div>
            <div class="form-group">
                <label for="contact_number">Nomor Kontak</label>
                <input type="text" class="form-control" id="contact_number" name="contact_number" value="<?= htmlspecialchars($pengaturan['contact_number'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label for="address">Alamat</label>
                <textarea class="form-control" id="address" name="address" rows="2"><?= htmlspecialchars($pengaturan['address'] ?? '') ?></textarea>
            </div>
            <div class="form-group">
                <label for="logo_besar">Logo Besar</label>
                <input type="file" class="form-control-file" id="logo_besar" name="logo_besar" accept="image/*">
                <?php if (!empty($pengaturan['logo_besar'])): ?>
                    <img src="<?= base_url('assets/images/setting' . $pengaturan['logo_besar']) ?>" alt="Logo Besar" class="img-fluid mt-2" width="100">
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="logo_kecil">Logo Kecil</label>
                <input type="file" class="form-control-file" id="logo_kecil" name="logo_kecil" accept="image/*">
                <?php if (!empty($pengaturan['logo_kecil'])): ?>
                    <img src="<?= base_url('assets/images/setting' . $pengaturan['logo_kecil']) ?>" alt="Logo Kecil" class="img-fluid mt-2" width="50">
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
        </form>
    </div>
</div>
<script src="<?= base_url('assets/plugins/sweetalert2/sweetalert2.min.js') ?>"></script>
<?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: 'Pengaturan berhasil disimpan.',
            timer: 2000,
            showConfirmButton: false
        }).then(() => {
            window.history.replaceState(null, null, window.location.pathname);
        });
    </script>
<?php endif; ?>