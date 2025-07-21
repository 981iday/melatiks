<?php
// Ambil role yang dipilih
$selectedRoleId = isset($_GET['role_id']) ? (int) $_GET['role_id'] : 1;

// Pastikan variabel $roles sudah ada dari controller, jika tidak ada bisa diambil di sini
// $roles = $db->query("SELECT id, role_name FROM roles ORDER BY id ASC")->fetchAll(PDO::FETCH_KEY_PAIR);

// Ambil semua data permission dari tabel permissions dengan kolom is_active
$hak_akses = $db->query("SELECT id, name, route, is_active FROM permissions ORDER BY sort_order ASC")->fetchAll(PDO::FETCH_ASSOC);

// Ambil permission yang sudah diberikan ke role tertentu
$stmt = $db->prepare("SELECT permission_id FROM role_permissions WHERE role_id = ?");
$stmt->execute([$selectedRoleId]);
$existingPermissions = $stmt->fetchAll(PDO::FETCH_COLUMN);

// Konversi ke integer untuk cocokkan tipe data
$existingPermissions = array_map('intval', $existingPermissions);

// Pastikan currentUserRoleId tersedia
if (!isset($currentUserRoleId)) {
  $currentUserRoleId = $_SESSION['role_id'] ?? null;
}
?>


<div class="card card-primary card-outline">
  <div class="card-header">
    <h3 class="card-title"><i class="fas fa-edit"></i> Setting Hak Akses</h3>
    <div class="card-tools">
      <button type="button" class="btn bg-info btn-sm" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
      <button type="button" class="btn bg-info btn-sm" data-card-widget="remove"><i class="fas fa-times"></i></button>
    </div>
  </div>
  <div class="card-body">
    <div class="row">

      <?php
      // Pastikan variabel ini sudah ada, jika belum bisa ambil dari session sebagai fallback
      if (!isset($currentUserRoleId)) {
        $currentUserRoleId = $_SESSION['role_id'] ?? null;
      }
      ?>

      <div class="col-5 col-sm-3">
        <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
          <?php foreach ($roles as $roleId => $roleName):
            if ($roleId == 1 && $currentUserRoleId != 1) continue;

            $active = ($selectedRoleId === (int)$roleId) ? 'active' : '';
          ?>
            <a href="?role_id=<?= $roleId ?>" class="nav-link <?= $active ?>" role="tab"><?= htmlspecialchars($roleName) ?></a>
          <?php endforeach; ?>
        </div>
      </div>



      <!-- Permission List -->
      <div class="col-7 col-sm-9">
        <form action="<?= htmlspecialchars(base_url('admin/setting/simpan_hakakses')) ?>" method="post">
          <input type="hidden" name="role_id" value="<?= htmlspecialchars($selectedRoleId) ?>">

          <div class="form-group">
            <label for="permissions">Hak Akses untuk <strong><?= htmlspecialchars($roles[$selectedRoleId]) ?></strong></label>
            <div class="form-check">
              <?php foreach ($hak_akses as $permission): ?>
                <?php if ((int)$permission['is_active'] !== 1) continue; ?>
                <div class="form-check mb-1 border-bottom pb-1">
                  <input class="form-check-input"
                    type="checkbox"
                    name="permission_ids[]"
                    value="<?= htmlspecialchars($permission['id']) ?>"
                    id="permission_<?= htmlspecialchars($permission['id']) ?>"
                    <?= in_array((int)$permission['id'], $existingPermissions, true) ? 'checked' : '' ?>>
                  <label class="form-check-label" for="permission_<?= htmlspecialchars($permission['id']) ?>">
                    <strong><?= $permission['id'] ?></strong> - <?= htmlspecialchars($permission['name']) ?> (<?= htmlspecialchars($permission['route']) ?>)
                  </label>
                </div>
              <?php endforeach; ?>
            </div>
          </div>

          <button type="submit" class="btn btn-success btn-sm">Simpan Hak Akses</button>
        </form>
      </div>

    </div>
  </div>
</div>

<!-- SweetAlert2 -->
<script src="<?= base_url('assets/plugins/sweetalert2/sweetalert2.min.js') ?>"></script>
<?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
  <script>
    Swal.fire({
      icon: 'success',
      title: 'Berhasil!',
      text: 'Hak akses berhasil disimpan.',
      timer: 2000,
      showConfirmButton: false
    }).then(() => {
      window.history.replaceState(null, null, window.location.pathname);
    });
  </script>
<?php endif; ?>

<?php if (isset($_GET['error']) && $_GET['error'] == 1): ?>
  <script>
    Swal.fire({
      icon: 'error',
      title: 'Gagal!',
      text: 'Terjadi kesalahan saat menyimpan hak akses.',
      timer: 2000,
      showConfirmButton: false
    }).then(() => {
      window.history.replaceState(null, null, window.location.pathname);
    });
  </script>
<?php endif; ?>