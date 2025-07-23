<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <!-- Full width column -->
      <section class="col-lg-12 connectedSortable">
        <!-- Card: Daftar Kategori -->
        <div class="card card-primary card-outline">
          <div class="card-header">
            <h3 class="card-title"><i class="fas fa-newspaper mr-1"></i>Daftar Kategori</h3>
            <div class="card-tools">
              <button class="btn btn-sm btn-primary" onclick="bukaModalTambahKategori()">
                <i class="fas fa-plus"></i> Tambah
              </button>
              <button type="button" class="btn btn-sm bg-info" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              <button type="button" class="btn btn-sm bg-info" data-card-widget="remove"><i class="fas fa-times"></i></button>
            </div>
          </div>
          <div class="card-body">
            <table id="tabel-kategori" class="table table-bordered table-striped text-sm">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Kategori</th>
                  <th>Slug</th>
                  <th width="100">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($kategori as $i => $k): ?>
                <tr>
                  <td><?= $i + 1 ?></td>
                  <td><?= $k['nama_kategori'] ?></td>
                  <td><?= $k['slug'] ?></td>
                  <td class="text-center align-middle">
                    <button class="btn btn-sm px-1 py-0" onclick='bukaModalEditKategori(<?= json_encode($k) ?>)'>
                      <i class="fas fa-edit text-primary"></i>
                    </button>
                    <button class="btn btn-sm px-1 py-0" onclick="hapusKategori(<?= $k['id_kategori'] ?>)">
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

<!-- Modal Kategori -->
<div class="modal fade" id="kategoriModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-md" role="document">
    <form id="form-kategori">
      <input type="hidden" name="id" id="kategori-id">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="kategoriModalTitle">Tambah Kategori</h5>
          <button type="button" class="close" data-dismiss="modal">
            <span>&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Nama Kategori</label>
            <input type="text" name="nama_kategori" id="kategori-nama" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Slug</label>
            <input type="text" name="slug" id="kategori-slug" class="form-control" readonly>
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

<!-- Slug Generator -->
<script>
  function slugify(text) {
    return text.toString().toLowerCase()
      .replace(/\s+/g, '-')         // Ganti spasi dengan strip
      .replace(/[^\w\-]+/g, '')     // Hapus karakter non huruf/angka
      .replace(/\-\-+/g, '-')       // Ganti strip dobel jadi satu
      .replace(/^-+/, '')           // Hapus strip di awal
      .replace(/-+$/, '');          // Hapus strip di akhir
  }

  $(document).ready(function () {
    $('#kategori-nama').on('input', function () {
      const nama = $(this).val();
      $('#kategori-slug').val(slugify(nama));
    });
  });
</script>

<!-- SweetAlert Feedback -->
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
