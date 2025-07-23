<section class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- ====== MINI WINDOWS / DRAGGABLE CARDS ====== -->
            <section class="col-lg-12 connectedSortable">
                <?php
                $colors = ['bg-info', 'bg-success', 'bg-warning', 'bg-danger', 'bg-primary', 'bg-secondary', 'bg-teal', 'bg-indigo'];
                ?>
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-sitemap mr-2"></i> Page Setting Halaman Utama
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn bg-info btn-sm" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                            <button type="button" class="btn bg-info btn-sm" data-card-widget="remove"><i class="fas fa-times"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row" id="mini-windows-container">
                            <?php foreach ($pages as $i => $page):
                                $color = $colors[$i % count($colors)];
                            ?>
                                <div class="col-lg-3 col-6 mb-3 draggable-card" id="page-<?= (int)$page['id'] ?>">
                                    <div class="small-box <?= $color ?> position-relative">
                                        <div class="inner">
                                            <h4><?= htmlspecialchars($page['title'], ENT_QUOTES, 'UTF-8') ?></h4>
                                            <p>Posisi: <?= (int)$page['position'] ?></p>
                                            <p>Status:
                                                <?php if ($page['is_active']): ?>
                                                    <span class="badge badge-success">Aktif</span>
                                                <?php else: ?>
                                                    <span class="badge badge-secondary">Nonaktif</span>
                                                <?php endif; ?>
                                            </p>
                                        </div>
                                        <div class="icon"><i class="fas fa-file-alt"></i></div>
                                        <div class="small-box-footer text-white-50">
                                            <?= substr(strip_tags($page['content']), 0, 60) ?>...
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="card-footer clearfix">
                        <button id="btnSavePagePosition" class="btn btn-success">
                            <i class="fas fa-save mr-1"></i> Simpan Perubahan Posisi
                        </button>
                    </div>

                </div>

        </div>
</section>

<!-- ====== TABLE LIST PAGE ====== -->
<section class="col-lg-12 connectedSortable">
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-sitemap mr-2"></i> List Pages</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-primary mb-3" id="btnOpenAddPageModal" data-toggle="modal" data-target="#modalTambahPage">
                    <i class="fas fa-plus-circle mr-1"></i> Tambah Halaman
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="pagesTable">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Judul</th>
                            <th>Slug</th>
                            <th>Status</th>
                            <th>Posisi</th>
                            <th>Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pages as $i => $page): ?>
                            <tr>
                                <td><?= $i + 1 ?></td>
                                <td><?= htmlspecialchars($page['title']) ?></td>
                                <td><small><?= htmlspecialchars($page['slug']) ?></small></td>
                                <td>
                                    <?php if ($page['is_active']): ?>
                                        <span class="badge badge-success">Aktif</span>
                                    <?php else: ?>
                                        <span class="badge badge-secondary">Nonaktif</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= (int)$page['position'] ?></td>
                                <td><small><?= date('d M Y', strtotime($page['created_at'])) ?></small></td>
                                <td>
                                    <button class="btn btn-sm btn-warning btn-edit-page" data-id="<?= $page['id'] ?>">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>

                                    <button class="btn btn-sm btn-danger btn-delete-page"
                                        data-id="<?= $page['id'] ?>"
                                        data-title="<?= htmlspecialchars($page['title'], ENT_QUOTES) ?>"
                                        data-toggle="modal" data-target="#modalDeletePage">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                    </tbody>

                </table>
            </div>
        </div>
    </div>
</section>
</div>
</div>
</section>

<div class="modal fade" id="modalTambahPage" tabindex="-1" role="dialog" aria-labelledby="modalTambahPageLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form action="<?= base_url('admin/pages/stores') ?>" method="POST" id="formTambahPage">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="modalTambahPageLabel">
                        <i class="fas fa-plus mr-2"></i> Tambah Halaman
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form Fields -->
                    <div class="form-group">
                        <label for="tambahPageTitle">Judul Halaman <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="title" id="tambahPageTitle" required>
                    </div>
                    <div class="form-group">
                        <label for="tambahPageSlug">Slug (URL) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="slug" id="tambahPageSlug" required>
                    </div>
                    <div class="form-group">
                        <label for="tambahPageContent">Konten</label>
                        <textarea class="form-control" name="content" id="tambahPageContent" rows="5" placeholder="Isi konten halaman di sini..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save mr-1"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="modalEditPage" tabindex="-1">
    <div class="modal-dialog">
        <form id="formEditPage" method="post" action="<?= base_url('admin/pages/ajax') ?>">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Halaman</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="editPageId" name="id">
                    <div class="form-group">
                        <label>Judul</label>
                        <input type="text" id="editPageTitle" name="title" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Slug</label>
                        <input type="text" id="editPageSlug" name="slug" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Konten</label>
                        <textarea id="editPageContent" name="content" class="form-control" rows="5"></textarea required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Hapus Page -->
<div class="modal fade" id="modalDeletePage" tabindex="-1" aria-labelledby="modalDeletePageLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="deletePageForm">
            <input type="hidden" name="id" id="deletePageId">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="modalDeletePageLabel"><i class="fas fa-trash mr-2"></i> Hapus Halaman</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Tutup">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Yakin ingin menghapus halaman <strong id="deletePageTitle"></strong>?</p>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>


<!-- jQuery dan Bootstrap -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function slugify(text) {
        return text.toString()
            .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
            .toLowerCase().trim()
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/\s+/g, '-').replace(/-+/g, '-');
    }

    function showAlert(icon, title, text, timer = 2500) {
        Swal.fire({ icon, title, text, timer, showConfirmButton: false });
    }

    $(document).ready(function () {
        // Auto-slug saat ngetik judul di modal tambah
        $('#tambahPageTitle').on('input', function () {
            $('#tambahPageSlug').val(slugify($(this).val()));
        });

        // Auto-slug saat ngetik judul di modal edit (hanya pasang sekali)
        $('#editPageTitle').on('input', function () {
            $('#editPageSlug').val(slugify($(this).val()));
        });

        // Buka modal tambah
        $('#btnOpenAddPageModal').on('click', function () {
            $('#formTambahPage')[0].reset();
            $('#modalTambahPageLabel').text('Tambah Halaman');
            $('#modalTambahPage').modal('show');
        });

        // Modal edit: ambil data via AJAX dan isi form modal
        $(document).on('click', '.btn-edit-page', function () {
            const id = $(this).data('id');

            $.post('<?= base_url("admin/pages/ajax") ?>', { action: 'get_by_id', id }, function (data) {
                if (data && data.id) {
                    $('#editPageId').val(data.id);
                    $('#editPageTitle').val(data.title);
                    $('#editPageSlug').val(data.slug);
                    $('#editPageContent').val(data.content);
                    $('#modalEditPage').modal('show');
                } else {
                    showAlert('error', 'Gagal', 'Data tidak ditemukan.');
                }
            }, 'json').fail(function (xhr) {
                showAlert('error', 'AJAX Error', `${xhr.status} - ${xhr.responseText}`);
            });
        });

        // Submit form edit (via AJAX)
        $('#formEditPage').on('submit', function (e) {
            e.preventDefault();
            const data = {
                action: 'update',
                id: $('#editPageId').val(),
                title: $('#editPageTitle').val(),
                slug: $('#editPageSlug').val(),
                content: $('#editPageContent').val(),
                is_active: 1 // sesuaikan jika pakai checkbox aktif/nonaktif
            };

            $.post('<?= base_url("admin/pages/ajax") ?>', data, function (res) {
                if (res.success) {
                    showAlert('success', 'Berhasil', 'Halaman diperbarui!');
                    $('#modalEditPage').modal('hide');
                    setTimeout(() => location.reload(), 1000);
                } else {
                    showAlert('error', 'Gagal', res.message || 'Update gagal.');
                }
            }, 'json').fail(function (xhr) {
                showAlert('error', 'AJAX Error', `${xhr.status} - ${xhr.responseText}`);
            });
        });

        // Pasang data ke modal hapus saat tombol ditekan
        $(document).on('click', '.btn-delete-page', function () {
            $('#deletePageId').val($(this).data('id'));
            $('#deletePageTitle').text($(this).data('title'));
            $('#modalDeletePage').modal('show');
        });

        // Submit form hapus via AJAX
        $('#deletePageForm').on('submit', function (e) {
            e.preventDefault();
            const id = $('#deletePageId').val();

            $.ajax({
                url: '<?= base_url("admin/pages/ajax") ?>',
                method: 'POST',
                dataType: 'json',
                data: {
                    action: 'delete',
                    id: id
                },
                success: function (res) {
                    if (res.success) {
                        showAlert('success', 'Berhasil', 'Halaman berhasil dihapus.', 1500);
                        $('#modalDeletePage').modal('hide');
                        setTimeout(() => location.reload(), 1500);
                    } else {
                        showAlert('error', 'Gagal', res.message || 'Gagal menghapus halaman.');
                    }
                },
                error: function (xhr) {
                    showAlert('error', 'Error', `AJAX Error: ${xhr.status}`);
                }
            });
        });

        // Drag & Drop + Simpan Urutan
        $('#mini-windows-container').sortable({
            placeholder: "card-placeholder",
            tolerance: "pointer",
            revert: true
        });

        $('#btnSavePagePosition').on('click', function () {
            const order = [];
            $('.draggable-card').each(function () {
                const id = $(this).attr('id')?.replace('page-', '');
                if (id) order.push(id);
            });

            if (order.length === 0) {
                showAlert('warning', 'Perhatian!', 'Tidak ada urutan yang disimpan.');
                return;
            }

            $.post('<?= base_url("admin/pages/ajax") ?>', {
                action: 'save_order',
                order: order
            }, function (res) {
                if (res.success) {
                    showAlert('success', 'Berhasil!', 'Posisi halaman berhasil disimpan!');
                } else {
                    showAlert('error', 'Gagal!', res.message || 'Gagal menyimpan posisi.');
                }
            }, 'json').fail(function () {
                showAlert('error', 'Gagal!', 'Gagal menyimpan posisi. Silakan coba lagi.');
            });
        });

        // Notifikasi dari PHP session
        <?php if (!empty($_SESSION['success'])): ?>
            showAlert('success', 'Berhasil', '<?= $_SESSION['success'] ?>');
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <?php if (!empty($_SESSION['error'])): ?>
            showAlert('error', 'Gagal', '<?= $_SESSION['error'] ?>');
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
    });
</script>