$(document).ready(function () {
  const stopwords = ['dan', 'yang', 'untuk', 'dengan', 'pada', 'dari', 'ini', 'itu', 'adalah', 'ke'];

  function generateTagsFromText(text) {
    const words = text
      .toLowerCase()
      .replace(/[^a-z0-9\s]/g, '')
      .split(/\s+/)
      .filter(word => word.length > 3 && !stopwords.includes(word));

    const freq = {};
    words.forEach(word => {
      freq[word] = (freq[word] || 0) + 1;
    });

    const sorted = Object.keys(freq).sort((a, b) => freq[b] - freq[a]);
    return sorted.slice(0, 5);
  }

  function updateTagPreview(tags, containerId) {
    const container = document.getElementById(containerId);
    if (!container) return;
    container.innerHTML = '';
    tags.forEach(tag => {
      const span = document.createElement('span');
      span.textContent = tag;
      span.className = 'badge badge-info mr-1';
      container.appendChild(span);
    });
  }

  function updateTagsTambah() {
    const judul = $('#judul').val();
    const tags = generateTagsFromText(judul);
    $('#tag').val(tags.join(', '));
    updateTagPreview(tags, 'tag-preview');
  }

  function updateTagsEdit() {
    const judul = $('#edit-judul').val();
    const tags = generateTagsFromText(judul);
    $('#edit-tag').val(tags.join(', '));
    updateTagPreview(tags, 'edit-tag-preview');
  }

  function renderExistingTagsEdit() {
    const tagString = $('#edit-tag').val();
    if (tagString.trim() !== '') {
      const tags = tagString.split(',').map(tag => tag.trim());
      updateTagPreview(tags, 'edit-tag-preview');
    } else {
      $('#edit-tag-preview').html('');
    }
  }

  function redirectWithFlash(status, message) {
    const url = new URL(window.location.href);
    url.searchParams.set(status, 1);
    url.searchParams.set('msg', message);
    window.location.href = url.toString();
  }

  // Input judul form tambah dan edit
  $('#judul').on('input', updateTagsTambah);
  $(document).on('input', '#edit-judul', updateTagsEdit);

  // AJAX tambah berita
  $('#form-tambah-berita').on('submit', function (e) {
    e.preventDefault();
    let formData = new FormData(this);

    $.ajax({
      url: $(this).attr('action'),
      type: 'POST',
      data: formData,
      contentType: false,
      processData: false,
      success: function () {
        $('#addBeritaModal').modal('hide');
        $('#form-tambah-berita')[0].reset();
        $('#tag-preview').html('');
        redirectWithFlash('success', 'Berita berhasil ditambahkan.');
      },
      error: function (xhr) {
        redirectWithFlash('error', xhr.responseText || 'Gagal menambahkan berita.');
      }
    });
  });

  // Fungsi buka modal edit dan load data
  window.editBerita = function (id) {
    $.get(base_url + 'admin/berita/edit/' + id, function (res) {
      let data;
      try {
        data = JSON.parse(res);
      } catch (e) {
        redirectWithFlash('error', 'Data tidak valid dari server.');
        return;
      }

      $('#form-edit-berita').attr('action', base_url + 'admin/berita/update/' + id);
      $('#edit-judul').val(data.judul);
      $('#edit-isi').val(data.isi);
      $('#edit-kategori').val(data.kategori_id);
      $('#edit-tag').val(data.tag);
      $('#edit-status').val(data.status);
      $('#gambar-lama').val(data.gambar);

      if (data.gambar) {
        $('#preview-gambar-edit').attr('src', base_url + 'assets/images/berita/' + data.gambar).show();
      } else {
        $('#preview-gambar-edit').hide();
      }

      $('#editBeritaModal').modal('show');
    }).fail(function () {
      redirectWithFlash('error', 'Gagal memuat data untuk diedit.');
    });
  };

  // AJAX update berita (form edit)
  $('#form-edit-berita').on('submit', function (e) {
    e.preventDefault();
    let formData = new FormData(this);

    $.ajax({
      url: $(this).attr('action'),
      type: 'POST',
      data: formData,
      contentType: false,
      processData: false,
      success: function () {
        $('#editBeritaModal').modal('hide');
        $('#form-edit-berita')[0].reset();
        $('#edit-tag-preview').html('');
        redirectWithFlash('success', 'Berita berhasil diperbarui.');
      },
      error: function (xhr) {
        redirectWithFlash('error', xhr.responseText || 'Gagal memperbarui berita.');
      }
    });
  });

  // Hapus berita
  window.hapusBerita = function (id) {
    Swal.fire({
      title: 'Yakin mau hapus?',
      text: "Data tidak bisa dikembalikan!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Ya, hapus!',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: base_url + 'admin/berita/hapus/' + id,
          type: 'POST',
          success: function () {
            redirectWithFlash('success', 'Berita berhasil dihapus.');
          },
          error: function () {
            redirectWithFlash('error', 'Terjadi kesalahan saat menghapus berita.');
          }
        });
      }
    });
  };
});
