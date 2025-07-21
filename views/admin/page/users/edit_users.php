<?php
session_start();
if (!isset($user)) {
    echo "<div class='alert alert-danger'>Data user tidak ditemukan.</div>";
    return;
}
?>

<!-- Include AdminLTE/Bootstrap CSS di head.php -->
<div class="container mt-4">
    <h3>Edit User</h3>
    <?php if (!empty($_SESSION['error'])): ?>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '<?= htmlspecialchars($_SESSION['error']) ?>',
            });
        </script>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
    <form action="/admin/users/update/<?= $user['id'] ?>" method="POST">
        <div class="form-group">
            <label>Username *</label>
            <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Nama *</label>
            <input type="text" name="nama" value="<?= htmlspecialchars($user['nama']) ?>" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Role *</label>
            <select name="role_id" class="form-control" required>
                <option value="">-- Pilih Role --</option>
                <option value="1" <?= $user['role_id'] == 1 ? 'selected' : '' ?>>Superadmin</option>
                <option value="2" <?= $user['role_id'] == 2 ? 'selected' : '' ?>>Admin</option>
                <option value="3" <?= $user['role_id'] == 3 ? 'selected' : '' ?>>Operator</option>
                <!-- Sesuaikan dengan role di database -->
            </select>
        </div>
        <div class="form-group">
            <label>Password (kosongkan jika tidak ingin diubah)</label>
            <input type="password" name="password" class="form-control">
        </div>
        <div class="form-group">
            <label>Konfirmasi Password</label>
            <input type="password" name="password2" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">Update User</button>
        <a href="/admin/users" class="btn btn-secondary">Batal</a>
    </form>
</div>
