<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <section class="col-lg-12 connectedSortable">
                <div class="card card-primary card-outline">
                    <div class="card-header ">
                        <h3 class="card-title"><i class="fa fa-table"></i> Data User</h3>
                        <!-- Tombol modal tambah user -->
                        <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addUserModal">
                                <i class="fas fa-user-plus"></i> Tambah User Baru
                            </button>

                            <button type="button" class="btn bg-info btn-sm" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                            <button type="button" class="btn bg-info btn-sm" data-card-widget="remove"><i class="fas fa-times"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="tabel-users" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Username</th>
                                    <th>Nama</th>
                                    <th>Role</th>
                                    <th>Terdaftar</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($users)): ?>
                                    <?php foreach ($users as $user): ?>
                                        <tr>
                                            <td><?= $user['id'] ?></td>
                                            <td><?= htmlspecialchars($user['username']) ?></td>
                                            <td><?= htmlspecialchars($user['nama']) ?></td>
                                            <td><?= htmlspecialchars($user['role_name']) ?></td>
                                            <td><?= date('d-m-Y', strtotime($user['created_at'])) ?></td>
                                            <td class="text-center">
                                                <!-- Tombol Edit -->
                                                <button class="btn btn-sm btn-warning" title="Edit"
                                                    onclick="editUser(
                                                    <?= (int)$user['id'] ?>,
                                                    '<?= addslashes(htmlspecialchars($user['username'], ENT_QUOTES)) ?>',
                                                    '<?= addslashes(htmlspecialchars($user['nama'], ENT_QUOTES)) ?>',
                                                    <?= isset($user['role_id']) ? (int)$user['role_id'] : 0 ?>
                                                )">
                                                    <i class="fas fa-edit"></i>
                                                </button>

                                                <!-- Tombol Hapus -->
                                                <button class="btn btn-sm btn-danger" title="Hapus"
                                                    onclick="hapusUser(<?= (int)$user['id'] ?>, '<?= addslashes(htmlspecialchars($user['username'], ENT_QUOTES)) ?>')">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </td>


                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center">Tidak ada data pengguna.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </div>
</section>

<!-- Modal Tambah User -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= base_url('admin/users/store') ?>" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Tambah User Baru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php if (!empty($_SESSION['error'])): ?>
                        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                        <script>
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: <?= json_encode($_SESSION['error']) ?>,
                            });
                        </script>
                        <?php unset($_SESSION['error']); ?>
                    <?php endif; ?>

                    <div class="form-group">
                        <label for="username">Username *</label>
                        <input type="text" name="username" id="username" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="nama">Nama *</label>
                        <input type="text" name="nama" id="nama" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password *</label>
                        <div class="input-group">
                            <input type="password" name="password" id="password" class="form-control" required>
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary toggle-password" type="button" data-target="password">
                                    <i class="fa fa-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password2">Konfirmasi Password *</label>
                        <div class="input-group">
                            <input type="password" name="password2" id="password2" class="form-control" required>
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary toggle-password" type="button" data-target="password2">
                                    <i class="fa fa-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="role_id">Role *</label>
                        <select name="role_id" id="role_id" class="form-control" required>
                            <option value="">-- Pilih Role --</option>
                            <?php foreach ($roles as $role): ?>
                                <option value="<?= $role['id'] ?>"><?= htmlspecialchars($role['role_name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Tambah User</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Edit User -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= base_url('admin/users/update') ?>" method="POST" id="formEditUser">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="edit_user_id">

                    <div class="form-group">
                        <label for="edit_username">Username *</label>
                        <input type="text" name="username" id="edit_username" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_nama">Nama *</label>
                        <input type="text" name="nama" id="edit_nama" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_password">Password (Kosongkan jika tidak ingin mengubah)</label>
                        <div class="input-group">
                            <input type="password" name="password" id="edit_password" class="form-control">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary toggle-password" type="button" data-target="edit_password">
                                    <i class="fa fa-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="edit_password2">Konfirmasi Password</label>
                        <div class="input-group">
                            <input type="password" name="password2" id="edit_password2" class="form-control">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary toggle-password" type="button" data-target="edit_password2">
                                    <i class="fa fa-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="edit_role_id">Role *</label>
                        <!-- ini form-nya -->
                        <select name="role_id" id="edit_role_id" class="form-control" required>
                            <option value="">-- Pilih Role --</option>
                            <?php foreach ($roles as $role): ?>
                                <option value="<?= $role['id'] ?>">
                                    <?= htmlspecialchars($role['role_name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Hapus User -->
<div class="modal fade" id="hapusUserModal" tabindex="-1" aria-labelledby="hapusUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="hapusUserModalLabel">Hapus User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus user <strong><span id="hapus_user_name"></span></strong>?</p>
                <p>Data yang dihapus tidak dapat dikembalikan!</p>
            </div>
            <div class="modal-footer">
                <form id="formHapusUser" action="" method="POST">
                    <button type="submit" class="btn btn-danger">Hapus</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const input = document.getElementById(targetId);
            const icon = this.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    });
</script>

<!-- SweetAlert2 -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        const urlParams = new URLSearchParams(window.location.search);
        const showModal = urlParams.get('modal');

        if (showModal === 'tambah') {
            $('#addUserModal').modal('show');
        }

        if (urlParams.get('error') === '1') {
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: <?= json_encode($_SESSION['error'] ?? 'Terjadi kesalahan.') ?>,
            });
            <?php unset($_SESSION['error']); ?>
        }

        if (urlParams.get('success') === '1') {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Data berhasil disimpan.',
                timer: 2000,
                showConfirmButton: false
            });
        }
    });
</script>


<script>
    function editUser(id, username, nama, roleId) {
        // Isi modal edit
        document.getElementById('edit_user_id').value = id;
        document.getElementById('edit_username').value = username;
        document.getElementById('edit_nama').value = nama;
        document.getElementById('edit_password').value = '';
        document.getElementById('edit_password2').value = '';
        document.getElementById('edit_role_id').value = roleId;

        // Set selected role
        const roleSelect = document.getElementById('edit_role_id');
        roleSelect.value = roleId;
        // Set action form update sesuai id user
        document.getElementById('formEditUser').action = '<?= base_url('admin/users/update/') ?>' + id;

        // Tampilkan modal
        $('#editUserModal').modal('show');
    }

    function hapusUser(id, username) {
        Swal.fire({
            title: `Yakin ingin menghapus user "${username}"?`,
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '<?= base_url('admin/users/hapus/') ?>' + id;
            }
        });
    }
</script>
<?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: 'Data berhasil disimpan.',
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
            text: 'Terjadi kesalahan saat menyimpan data.',
            timer: 3000,
            showConfirmButton: true
        });
    </script>
<?php endif; ?>