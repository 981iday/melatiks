<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <!-- Full width column -->
      <section class="col-lg-12 connectedSortable">
        <!-- Card: Daftar Kategori -->
        <div class="card card-primary card-outline">
          <div class="card-header ">
            <h3 class="card-title mb-0">
              <i class="fas fa-tags mr-1"></i> Daftar Kategori
            </h3>
            <div class="card-tools">
              <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#bukaModalTambahKategori">
                <i class="fas fa-plus"></i> Tambah
              </button>
              <button type="button" class="btn btn-sm bg-info" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
              <button type="button" class="btn btn-sm bg-info" data-card-widget="remove">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>

          <div class="card-body">
            <table id="tabel-kategori" class="table table-bordered table-striped table-hover text-sm">
              <div id="alert-box" class="alert d-none mt-2" role="alert"></div>
              <thead>
                <tr>
                  <th style="width: 50px;">No</th>
                  <th>Nama Kategori</th>
                  <th>Slug</th>
                  <th style="width: 100px;">Aksi</th>
                </tr>
              </thead>
              <tbody id="kategori-tbody">
                <?php foreach ($kategori as $i => $k): ?>
                  <tr>
                    <td><?= $i + 1 ?></td>
                    <td><?= htmlentities($k['nama_kategori']) ?></td>
                    <td><?= htmlentities($k['slug']) ?></td>
                    <td class="text-center">
                      <button class="btn btn-sm btn-light" onclick="bukaModalEditKategori(<?= $k['id_kategori'] ?>)">
                        <i class="fas fa-edit text-primary"></i>
                      </button>
                      <button type="button" class="btn btn-sm btn-light" onclick="hapusKategori(<?= htmlspecialchars($k['id_kategori']) ?>)">
                        <i class="fas fa-trash text-danger"></i>
                      </button>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </section>

    </div>
  </div>
</section>

<!-- Modal Tambah -->
<div class="modal fade" id="bukaModalTambahKategori" tabindex="-1" role="dialog" aria-labelledby="bukaModalTambahKategoriLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form id="form-tambah-kategori" action="<?= base_url('admin/kategori/tambah') ?>" method="post">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="bukaModalTambahKategoriLabel">Tambah Kategori</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="tambah-kategori-nama">Nama Kategori</label>
            <input type="text" class="form-control" id="tambah-kategori-nama" name="nama" required>
          </div>
          <div class="form-group">
            <label for="tambah-kategori-slug">Tag Otomatis</label>
            <input type="text" class="form-control" id="tambah-kategori-slug" name="tag" readonly>
            <small class="form-text text-muted">Tag dihasilkan otomatis dari nama kategori.</small>
            <div id="tambah-kategori-tag-preview" class="mt-2"></div>
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
<div class="modal fade" id="bukaModalEditKategori" tabindex="-1" role="dialog" aria-labelledby="bukaModalEditKategoriLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form id="form-edit-kategori" method="post">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="bukaModalEditKategoriLabel">Edit Kategori</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <!-- Input hidden untuk ID kategori -->
          <input type="hidden" id="edit-kategori-id" name="id">

          <div class="form-group">
            <label for="edit-kategori-nama">Nama Kategori</label>
            <input type="text" class="form-control" id="edit-kategori-nama" name="nama" required autocomplete="off">
          </div>
          <div class="form-group">
            <label for="edit-kategori-slug">Slug (Otomatis)</label>
            <input type="text" class="form-control" id="edit-kategori-slug" name="slug" readonly>
            <small class="form-text text-muted">Slug dihasilkan otomatis dari nama kategori.</small>
          </div>
          <div class="form-group">
            <label>Preview Tag</label>
            <div id="edit-kategori-tag-preview" class="mt-2"></div>
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



<!-- Inject base_url sebelum JS kustom -->
<script>
  const base_url = "<?= base_url() ?>";
</script>

<!-- Kemudian include JS -->
<script src="<?= base_url('assets/plugins/sweetalert2/sweetalert2.min.js') ?>"></script>
<script src="<?= base_url('assets/js/kategori.js') ?>"></script>