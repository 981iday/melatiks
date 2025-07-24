// kategori.js

$.ajaxSetup({
  headers: {
    'X-Requested-With': 'XMLHttpRequest'
  }
});

function showAlert(message, type = 'success') {
  const alertBox = $('#alert-box');
  alertBox
    .removeClass('d-none alert-success alert-danger')
    .addClass(type === 'success' ? 'alert-success' : 'alert-danger')
    .text(message)
    .slideDown();

  setTimeout(() => alertBox.slideUp(300, () => alertBox.addClass('d-none')), 3000);
}


$(document).ready(function () {
  const stopwords = ['dan', 'yang', 'untuk', 'dengan', 'pada', 'dari', 'ini', 'itu', 'adalah', 'ke'];

  function generateSlug(text) {
    return (text || '')
      .toLowerCase()
      .trim()
      .replace(/[^a-z0-9\s-]/g, '')
      .replace(/\s+/g, '-')
      .replace(/-+/g, '-');
  }

  function generateTagsFromText(text) {
    return (text || '')
      .toLowerCase()
      .replace(/[^a-z0-9\s]/g, '')
      .split(/\s+/)
      .filter(word => word.length > 3 && !stopwords.includes(word))
      .reduce((acc, word) => {
        acc[word] = (acc[word] || 0) + 1;
        return acc;
      }, {});
  }

  function getTopTags(freqObj, limit = 5) {
    return Object.entries(freqObj)
      .sort((a, b) => b[1] - a[1])
      .slice(0, limit)
      .map(entry => entry[0]);
  }

  function updateTagPreview(tags, containerId) {
    const container = document.getElementById(containerId);
    if (!container) return;
    container.innerHTML = '';
    tags.forEach(tag => {
      const span = document.createElement('span');
      span.textContent = tag;
      span.className = 'badge badge-info me-1';
      container.appendChild(span);
    });
  }

  // === Tambah Kategori ===
  function autoGenerateSlugAndTagsTambah() {
    const nama = $('#tambah-kategori-nama').val();
    $('#tambah-kategori-slug').val(generateSlug(nama));
    const tags = getTopTags(generateTagsFromText(nama));
    updateTagPreview(tags, 'tambah-kategori-tag-preview');
  }

  $('#tambah-kategori-nama').on('input', autoGenerateSlugAndTagsTambah);

  function resetModalTambah() {
    $('#form-tambah-kategori')[0].reset();
    $('#tambah-kategori-tag-preview').html('');
  }

  window.bukaModalTambahKategori = function () {
    resetModalTambah();
    $('#bukaModalTambahKategori').modal('show');
  };

  $('#form-tambah-kategori').on('submit', function (e) {
    e.preventDefault();
    const form = $(this);
    const formData = new FormData(this);
    form.find('.text-danger').remove();

    $.ajax({
      url: form.attr('action'),
      type: 'POST',
      data: formData,
      contentType: false,
      processData: false,
      dataType: 'json',
      success: function (res) {
        if (res.success) {
          $('#bukaModalTambahKategori').modal('hide');
          showAlert(res.message, 'success');
          setTimeout(() => location.reload(), 1500);
        } else {
          if (res.errors) {
            for (const field in res.errors) {
              const input = form.find(`[name="${field}"]`);
              const errText = $('<small class="text-danger d-block mt-1"></small>').text(res.errors[field]);
              input.after(errText);
            }
          }
          showAlert(res.message, 'error');
        }
      },
      error: function () {
        showAlert('Terjadi kesalahan saat mengirim data.', 'error');
      }
    });
  });

  // === Edit Kategori ===
  function autoGenerateSlugAndTagsEdit() {
    const nama = $('#edit-kategori-nama').val();
    $('#edit-kategori-slug').val(generateSlug(nama));
    const tags = getTopTags(generateTagsFromText(nama));
    updateTagPreview(tags, 'edit-kategori-tag-preview');
  }

  $('#edit-kategori-nama').on('input', autoGenerateSlugAndTagsEdit);

  function resetModalEdit() {
    $('#form-edit-kategori')[0].reset();
    $('#edit-kategori-tag-preview').html('');
  }

  function isiModalEdit(data) {
    $('#edit-kategori-id').val(data.id_kategori);
    $('#edit-kategori-nama').val(data.nama_kategori);
    $('#edit-kategori-slug').val(data.slug || '');
    const tags = getTopTags(generateTagsFromText(data.nama_kategori));
    updateTagPreview(tags, 'edit-kategori-tag-preview');
  }

  window.bukaModalEditKategori = function (id) {
    $.ajax({
      url: base_url + 'admin/kategori/edit/' + id,
      type: 'GET',
      dataType: 'json',
      success: function (data) {
        resetModalEdit();
        isiModalEdit(data);
        $('#bukaModalEditKategori').modal('show');
      },
      error: function () {
        showAlert('Gagal mengambil data kategori.', 'error');
      }
    });
  };

  $('#form-edit-kategori').on('submit', function (e) {
    e.preventDefault();
    const formData = new FormData(this);
    const id = $('#edit-kategori-id').val();

    $.ajax({
      url: base_url + 'admin/kategori/update/' + id,
      type: 'POST',
      data: formData,
      contentType: false,
      processData: false,
      dataType: 'json',
      success: function (res) {
        if (res.success) {
          $('#bukaModalEditKategori').modal('hide');
          showAlert(res.message, 'success');
          setTimeout(() => location.reload(), 1500);
        } else {
          showAlert(res.message, 'error');
        }
      },
      error: function () {
        showAlert('Gagal mengirim data ke server.', 'error');
      }
    });
  });

  // === Hapus Kategori ===
 window.hapusKategori = function (id) {
  $.ajax({
    url: base_url + 'admin/kategori/hapus/' + id,
    type: 'POST',
    dataType: 'json',
    success: function (res) {
      showAlert(res.message, res.success ? 'success' : 'error');
      if (res.success) {
        setTimeout(() => location.reload(), 1500);
      }
    },
    error: function () {
      showAlert('Gagal menghapus kategori.', 'error');
    }
  });
};

function refreshKategoriTable() {
  console.log("Memuat ulang tabel...");
  $.ajax({
    url: base_url + 'admin/kategori/data',
    type: 'GET',
    dataType: 'json',
    success: function (data) {
      console.log("Data berhasil diterima:", data);
      const tbody = $('#kategori-tbody');
      tbody.empty();

      if (!Array.isArray(data) || data.length === 0) {
        tbody.append('<tr><td colspan="4" class="text-center">Belum ada data kategori.</td></tr>');
        return;
      }

      data.forEach((kategori, index) => {
        tbody.append(`
          <tr>
            <td>${index + 1}</td>
            <td>${kategori.nama_kategori}</td>
            <td>${kategori.slug}</td>
            <td>
              <button class="btn btn-sm btn-primary" onclick="bukaModalEditKategori(${kategori.id_kategori})">Edit</button>
              <button class="btn btn-sm btn-danger" onclick="hapusKategori(${kategori.id_kategori})">Hapus</button>
            </td>
          </tr>
        `);
      });
    },
    error: function (xhr, status, error) {
      console.error("Error saat ambil data kategori:", status, error);
      showAlert('Gagal memuat data kategori.', 'error');
    }
  });
}


});
