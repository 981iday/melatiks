<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!-- Include AdminLTE/Bootstrap CSS di head.php -->
<div class="container mt-4">
    <!-- Button untuk membuka modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addUserModal">
        Tambah User Baru
    </button>

    <!-- Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Tambah User Baru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Menampilkan SweetAlert2 jika ada error -->
                    <?php if (!empty($_SESSION['error'])): ?>
                        <script>
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: '<?= htmlspecialchars($_SESSION['error']) ?>',
                            });
                        </script>
                        <?php unset($_SESSION['error']); ?>
                    <?php endif; ?>

                    <!-- Form untuk tambah user -->
                    <form action="/admin/users/store" method="POST">
                        <div class="form-group">
                            <label for="username">Username *</label>
                            <input type="text" name="username" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="nama">Nama *</label>
                            <input type="text" name="nama" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password *</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="password2">Konfirmasi Password *</label>
                            <input type="password" name="password2" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="role_id">Role *</label>
                            <select name="role_id" class="form-control" required>
                                <option value="">-- Pilih Role --</option>
                                <?php foreach ($roles as $role): ?>
                                    <option value="<?= $role['id'] ?>"><?= htmlspecialchars($role['role_name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Tambah User</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

