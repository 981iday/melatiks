document.addEventListener('DOMContentLoaded', function () {
  const params = new URLSearchParams(window.location.search);

  const type = params.get('type');     // 'success', 'error', 'info', 'warning'
  const msg = params.get('msg');       // Pesan khusus
  const success = params.get('success');
  const update = params.get('update');
  const deleteFlag = params.get('delete');
  const error = params.get('error');
  const highlight = params.get('highlight'); // ID data yang mau disorot

  const showAlert = (icon, title, text, timer = 2000, showConfirmButton = false) => {
    Swal.fire({
      icon,
      title,
      text,
      timer,
      showConfirmButton
    }).then(() => {
      // Bersihkan parameter dari URL
      const cleanUrl = new URL(window.location);
      ['success', 'update', 'delete', 'error', 'msg', 'type', 'highlight'].forEach(p => {
        cleanUrl.searchParams.delete(p);
      });
      window.history.replaceState(null, null, cleanUrl.pathname);
    });
  };

  // === Urutan Prioritas Notifikasi ===
  if (type && msg) {
    showAlert(type, capitalize(type), decodeURIComponent(msg));
  } else if (success === '1') {
    showAlert('success', 'Berhasil!', 'Data berhasil disimpan.');
  } else if (update === '1') {
    showAlert('success', 'Berhasil!', 'Data berhasil diperbarui.');
  } else if (deleteFlag === '1') {
    showAlert('success', 'Berhasil!', 'Data berhasil dihapus.');
  } else if (error === '1') {
    showAlert('error', 'Gagal!', 'Terjadi kesalahan saat menyimpan data.', 3000, true);
  }

  // === Highlight Baris Jika Ada Duplicate / Target ===
  if (highlight) {
    const row = document.querySelector(`[data-id="${highlight}"]`);
    if (row) {
      row.classList.add('table-warning');
      row.scrollIntoView({ behavior: 'smooth', block: 'center' });

      // Hapus highlight setelah beberapa detik
      setTimeout(() => {
        row.classList.remove('table-warning');
      }, 4000); // 4 detik cukup buat pengguna sadar
    }
  }

  function capitalize(str) {
    return str.charAt(0).toUpperCase() + str.slice(1);
  }
});
