<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">

            <!-- Left column -->
            <section class="col-lg-12 connectedSortable">
                <!-- Card: Profil Sekolah -->
                <section class="content">
                    <div class="card card-primary card-outline">
                        <div class="card-header ">
                            <h3 class="card-title"><i class="fas fa-newspaper">Data Berita</i> </h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addBeritaModal">
                                    <i class="fas fa-plus"></i> Tambah Berita
                                </button>
                                <button type="button" class="btn btn-sm bg-info" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                <button type="button" class="btn btn-sm bg-info" data-card-widget="remove"><i class="fas fa-times"></i></button>
                            </div>
                        </div>

                        <div class="card-body">
                            <?php if (!empty($berita)): ?>
                                <div class="table-responsive">
                                    <table id="tabel-berita" class="table table-bordered table-striped text-sm">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Judul</th>
                                                <th>Kategori</th>
                                                <th>Tag</th>
                                                <th>Penulis</th>
                                                <th>Status</th>
                                                <th>Gambar</th>
                                                <th style="width: 90px;">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($berita as $i => $b): ?>
                                                <tr>
                                                    <td><?= $i + 1 ?></td>
                                                    <td><?= htmlspecialchars($b['judul']) ?></td>
                                                    <td><?= htmlspecialchars($b['nama_kategori'] ?? '—') ?></td>
                                                    <td><?= htmlspecialchars($b['tag']) ?></td>
                                                    <td><?= htmlspecialchars($b['nama_penulis'] ?? 'Penulis tidak diketahui') ?></td>

                                                    <td>
                                                        <span class="badge badge-<?= $b['status'] === 'publish' ? 'success' : 'warning' ?>">
                                                            <?= ucfirst($b['status']) ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <?php if (!empty($b['gambar'])): ?>
                                                            <img src="<?= base_url('assets/images/berita/' . $b['gambar']) ?>" class="img-thumbnail" style="max-width: 100px;">
                                                        <?php else: ?>
                                                            <span class="badge badge-secondary">Tidak ada</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-sm btn-warning" onclick="editBerita(<?= $b['id'] ?>)">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger" onclick="hapusBerita(<?= $b['id'] ?>)">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>

                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle"></i> Belum ada berita yang ditambahkan.
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </section>
                <!-- Modal Tambah -->
                <div class="modal fade" id="addBeritaModal" tabindex="-1" role="dialog">
                    <div class="modal-dialog modal-lg" role="document">
                        <form id="form-tambah-berita" enctype="multipart/form-data" method="POST" action="<?= base_url('admin/berita/simpan') ?>">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Tambah Berita</h5>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>Judul</label>
                                        <input type="text" id="judul" name="judul" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="tag">Tag (otomatis dibuat dari Judul + Isi)</label>
                                        <input type="text" id="tag" name="tag" class="form-control" readonly placeholder="Tag otomatis muncul di sini...">
                                    </div>

                                    <div id="tag-preview" style="margin-top: 5px;"></div>
                                    <div class="form-group">
                                        <label>Isi</label>
                                        <textarea name="isi" class="form-control" rows="5" required></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Gambar</label>
                                        <input type="file" name="gambar" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Kategori</label>
                                        <div class="input-group">
                                            <select name="kategori_id" class="form-control" required>
                                                <?php foreach ($kategori as $k): ?>
                                                    <option value="<?= $k['id_kategori'] ?>"><?= htmlspecialchars($k['nama_kategori']) ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label>Status</label>
                                        <select name="status" class="form-control">
                                            <option value="draft">Draft</option>
                                            <option value="publish">Publish</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Modal Edit -->
                <div class="modal fade" id="editBeritaModal" tabindex="-1" role="dialog">
                    <div class="modal-dialog modal-lg" role="document">
                        <form id="form-edit-berita" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="gambar_lama" id="gambar-lama">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Berita</h5>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>

                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>Judul</label>
                                        <input type="text" name="judul" id="edit-judul" class="form-control" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Isi</label>
                                        <textarea id="edit-isi" name="isi" class="form-control" rows="5" required></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label>Kategori</label>
                                        <select name="kategori_id" id="edit-kategori" class="form-control" required>
                                            <option value="">-- Pilih Kategori --</option>
                                            <?php foreach ($kategori as $k): ?>
                                                <option value="<?= $k['id_kategori'] ?>"><?= $k['nama_kategori'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Tag</label>
                                        <input type="text" name="tag" id="edit-tag" class="form-control" readonly>
                                        <div id="edit-tag-preview" style="margin-top: 5px;"></div>
                                    </div>

                                    <div class="form-group">
                                        <label>Status</label>
                                        <select name="status" id="edit-status" class="form-control">
                                            <option value="draft">Draft</option>
                                            <option value="publish">Publish</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Gambar</label><br>
                                        <img id="preview-gambar-edit" src="" alt="Gambar" style="max-height: 150px; margin-bottom: 10px; display: none;"><br>
                                        <input type="file" name="gambar" class="form-control-file">
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                    <button type="submit" class="btn btn-warning">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</section><!-- /.content -->
<script>
    const base_url = '<?= base_url() ?>';
</script>
<script src="<?= base_url('assets/js/berita.js') ?>"></script>
