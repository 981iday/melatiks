// plashmessage.js
$(document).ready(function () {
  const query = new URLSearchParams(window.location.search);

  const showAlert = (type, title, text, timer = 2000, showConfirmButton = false) => {
    Swal.fire({
      icon: type,
      title: title,
      text: text,
      timer: timer,
      showConfirmButton: showConfirmButton
    }).then(() => {
      // Bersihkan parameter di URL
      window.history.replaceState(null, null, window.location.pathname);
    });
  };

  if (query.get('success') === '1') {
    showAlert('success', 'Berhasil!', 'Data berhasil disimpan.');
  }

  if (query.get('update') === '1') {
    showAlert('success', 'Berhasil!', 'Data berhasil diperbarui.');
  }

  if (query.get('delete') === '1') {
    showAlert('success', 'Berhasil!', 'Data berhasil dihapus.');
  }

  if (query.get('error') === '1') {
    showAlert('error', 'Gagal!', 'Terjadi kesalahan saat menyimpan data.', 3000, true);
  }

  // Tambahan: jika ada parameter pesan khusus dari backend
  const custom = query.get('msg');
  const type = query.get('type'); // success / error / info / warning

  if (custom && type) {
    showAlert(type, type.charAt(0).toUpperCase() + type.slice(1), decodeURIComponent(custom));
  }
});
document.addEventListener('DOMContentLoaded', function () {
  const params = new URLSearchParams(window.location.search);
  const success = params.get('success');
  const error = params.get('error');
  const msg = params.get('msg');

  if (success || error) {
    Swal.fire({
      icon: success ? 'success' : 'error',
      title: success ? 'Berhasil!' : 'Gagal!',
      text: msg || (success ? 'Berhasil.' : 'Terjadi kesalahan.'),
      timer: 2000,
      showConfirmButton: false
    }).then(() => {
      const url = new URL(window.location);
      url.searchParams.delete('success');
      url.searchParams.delete('error');
      url.searchParams.delete('msg');
      window.history.replaceState(null, null, url.pathname + url.search);
    });
  }
});
