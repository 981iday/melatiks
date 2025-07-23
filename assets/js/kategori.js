function bukaModalTambahKategori() {
    $('#kategoriModalTitle').text('Tambah Kategori');
    $('#form-kategori').attr('action', base_url + 'admin/kategori/simpan');
    $('#kategori-id').val('');
    $('#kategori-nama').val('');
    $('#kategoriModal').modal('show');

    // Fokus ke input nama saat modal muncul
    setTimeout(() => $('#kategori-nama').focus(), 500);
}

function bukaModalEditKategori(data) {
    if (!data || !data.id_kategori || !data.nama_kategori) {
        Swal.fire('Error', 'Data kategori tidak valid!', 'error');
        return;
    }

    $('#kategoriModalTitle').text('Edit Kategori');
    $('#form-kategori').attr('action', base_url + 'admin/kategori/update/' + data.id_kategori);
    $('#kategori-id').val(data.id_kategori);
    $('#kategori-nama').val(data.nama_kategori);
    $('#kategoriModal').modal('show');

    setTimeout(() => $('#kategori-nama').focus(), 500);
}

function hapusKategori(id) {
    Swal.fire({
        title: 'Hapus Kategori?',
        text: "Data tidak bisa dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        confirmButtonText: 'Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: base_url + 'admin/kategori/delete/' + id,
                type: 'POST',
                dataType: 'json',
                success: function (res) {
                    if (res.status === 'success') {
                        Swal.fire('Dihapus!', res.message, 'success').then(() => location.reload());
                    } else {
                        Swal.fire('Gagal!', res.message || 'Terjadi kesalahan.', 'error');
                    }
                },
                error: function (xhr, status, error) {
                    console.error('AJAX Error:', error);
                    Swal.fire('Gagal!', 'Gagal menghapus kategori.', 'error');
                }
            });
        }
    });
}
