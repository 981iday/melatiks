// melatiks.table.js — Plugin DataTables untuk Melatiks (Bootstrap 4 Style)

window.MelatiksTable = (function () {
  const initDefaultTables = function () {
    $('table.table-custom').DataTable({
      responsive: true,
      autoWidth: false,
      lengthChange: true,
      pageLength: 10,
      ordering: true,
      columnDefs: [
        {
          targets: 'no-sort',
          orderable: false
        }
      ],
      language: bahasaID
    });
  };

  const initKategoriTable = function () {
    const el = $('#tabel-kategori');
    if (el.length) {
      el.DataTable({
        responsive: true,
        autoWidth: false,
        pageLength: 10,
        ordering: true,
        columnDefs: [
          { targets: 3, orderable: false }
        ],
        language: bahasaID
      });
    }
  };

  const initLaporanTable = function () {
    const el = $('#tabel-laporan');
    if (el.length) {
      el.DataTable({
        responsive: true,
        dom: 'Bfrtip',
        buttons: ['copy', 'excel', 'pdf', 'print'],
        language: bahasaID
      });
    }
  };

  const bahasaID = {
    search: "Cari:",
    lengthMenu: "Tampilkan _MENU_ entri",
    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
    infoEmpty: "Tidak ada data tersedia",
    infoFiltered: "(disaring dari total _MAX_ entri)",
    zeroRecords: "Data tidak ditemukan",
    paginate: {
      first: "Awal",
      last: "Akhir",
      next: "→",
      previous: "←"
    }
  };

  const init = function () {
    initDefaultTables();
    initKategoriTable();
    initLaporanTable();
  };

  // Public API
  return {
    init: init
  };
})();
