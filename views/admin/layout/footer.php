<!-- /.content-wrapper -->
<footer class="main-footer">
  <strong>&copy; 2024-2025 <a href="<?= base_url() ?>/">melatiks</a>.</strong>
  All rights reserved.
  <div class="float-right d-none d-sm-inline-block">
    <b>Version</b> 3.2.0
  </div>
</footer>
</div>
<!-- ./wrapper -->

<!-- ==================== JAVASCRIPT ==================== -->

<!-- jQuery (WAJIB PALING ATAS) -->
<script src="<?= base_url('assets/plugins/jquery/jquery.min.js') ?>"></script>

<!-- jQuery UI -->
<script src="<?= base_url('assets/plugins/jquery-ui/jquery-ui.min.js') ?>"></script>
<script>
  // Hindari konflik jQuery UI dengan Bootstrap
  $.widget.bridge('uibutton', $.ui.button);
</script>

<!-- Bootstrap 4 -->
<script src="<?= base_url('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>

<!-- AdminLTE -->
<script src="<?= base_url('assets/dist/js/adminlte.js') ?>"></script>

<!-- Plugin Tambahan -->
<script src="<?= base_url('assets/plugins/chart.js/Chart.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/sparklines/sparkline.js') ?>"></script>
<script src="<?= base_url('assets/plugins/jquery-knob/jquery.knob.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/moment/moment.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/daterangepicker/daterangepicker.js') ?>"></script>
<script src="<?= base_url('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/summernote/summernote-bs4.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') ?>"></script>

<!-- DataTables -->
<script src="<?= base_url('assets/plugins/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/jszip/jszip.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/pdfmake/pdfmake.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/pdfmake/vfs_fonts.js') ?>"></script>
<script src="<?= base_url('assets/plugins/datatables-buttons/js/buttons.html5.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/datatables-buttons/js/buttons.print.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/datatables-buttons/js/buttons.colVis.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/sweetalert2/sweetalert2.min.js') ?>"></script>
<script src="<?= base_url('assets/js/flashMessage.js') ?>"></script>


<!-- Nested Sortable (jika digunakan) -->
<script src="<?= base_url('assets/nestedSortable/jquery.mjs.nestedSortable.js') ?>"></script>

<!-- Plugin Table Custom Melatiks -->
<script src="<?= base_url('assets/js/melatiks.table.js') ?>"></script>

<!-- Inisialisasi Global -->
<script>
  $(function () {
    // Inisialisasi semua fitur ketika DOM siap
    MelatiksTable.init();

    // Tooltip
    $('[title]').tooltip();

    // Padding TBody
    $('table tbody td').each(function () {
      const fontSize = $(this).css('font-size');
      if (parseFloat(fontSize) <= 14) {
        $(this).css({
          'padding-top': '4px',
          'padding-bottom': '4px',
          'line-height': '1.2'
        });
      }
    });

    // Padding THead
    $('table thead th').each(function () {
      const fontSize = $(this).css('font-size');
      if (parseFloat(fontSize) <= 14) {
        $(this).css({
          'padding-top': '6px',
          'padding-bottom': '6px',
          'line-height': '1.4'
        });
      }
    });

    // DataTable: Pengguna
    if ($("#tabel-users").length) {
      $("#tabel-users").DataTable({
        responsive: true,
        lengthChange: false,
        autoWidth: false,
        buttons: ["copy", "csv", "excel", "pdf", "print"]
      }).buttons().container().appendTo('#tabel-users_wrapper .col-md-6:eq(0)');
    }

    // DataTable: Berita
    if ($("#tabel-berita").length) {
      $("#tabel-berita").DataTable({
        responsive: true,
        lengthChange: false,
        autoWidth: false,
        buttons: ["copy", "csv", "excel", "pdf", "print"]
      }).buttons().container().appendTo('#tabel-berita_wrapper .col-md-6:eq(0)');
    }

    // Sortable
    $("#mini-windows-container").sortable({
      items: '.draggable-card',
      placeholder: "ui-state-highlight",
      update: function () {
        const order = [];
        $(".draggable-card").each(function () {
          order.push($(this).attr('id').replace('page-', ''));
        });
        console.log("Urutan baru:", order);
        // $.post('/save-order', { order: order });
      }
    });

    // Event tombol edit halaman (contoh)
    $('.btn-edit-page').on('click', function () {
      // aksi
    });
  });
</script>

<!-- Tambahan CSS Inline -->
<style>
  .ui-state-highlight {
    height: 40px;
    background-color: #f4f6f9;
    border: 2px dashed #ccc;
    margin-bottom: 5px;
  }

  .draggable-card {
    cursor: move;
    margin-bottom: 20px;
  }
</style>
<style>
.swal2-container {
  z-index: 1060 !important;
}
</style>


</body>
</html>
