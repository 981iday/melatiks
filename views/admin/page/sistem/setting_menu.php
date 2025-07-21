<script src="<?= base_url('assets/plugins/jquery/jquery.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/jquery-ui/jquery-ui.min.js') ?>"></script>

<!-- CARD MENU LIST -->
<div class="card shadow-sm">
  <div class="card-header bg-info">
    <h3 class="card-title">
      <i class="fas fa-sitemap mr-2"></i> Menu List
    </h3>
    <div class="card-tools">
      <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Sembunyikan">
        <i class="fas fa-minus"></i>
      </button>
      <button type="button" class="btn btn-tool" data-card-widget="remove" title="Tutup">
        <i class="fas fa-times"></i>
      </button>
    </div>
  </div>

  <div id="menuList" class="card-body">
    <div class="mb-3 d-flex flex-wrap gap-2">
      <button id="btnExpandAll" class="btn btn-sm btn-outline-primary" title="Perluas semua menu">
        <i class="fas fa-plus-square"></i> Expand Semua
      </button>
      <button id="btnCollapseAll" class="btn btn-sm btn-outline-secondary" title="Tutup semua menu">
        <i class="fas fa-minus-square"></i> Collapse Semua
      </button>
      <button type="button" class="btn btn-sm btn-primary" id="btnAddMenu" title="Tambah menu baru">
        <i class="fas fa-plus"></i> Tambah Menu
      </button>
    </div>

    <?php
    function renderMenuList($menus, $parent_id = 0)
    {
      $hasChild = false;
      foreach ($menus as $menu) {
        if ((int)$menu['parent_id'] === (int)$parent_id) {
          if (!$hasChild) {
            echo '<ul class="list-group nested-sortable ' . ($parent_id != 0 ? 'ml-3' : '') . '" ' . ($parent_id == 0 ? 'id="sortableMenu"' : '') . '>';
            $hasChild = true;
          }

          echo '<li class="list-group-item p-2"
                 data-id="' . htmlspecialchars($menu['id']) . '"
                 data-parent-id="' . htmlspecialchars($menu['parent_id']) . '"
                 data-sort-order="' . htmlspecialchars($menu['sort_order']) . '"
                 data-route="' . htmlspecialchars($menu['route']) . '">';

          echo '<div class="d-flex justify-content-between align-items-center">';

          // Kiri: Drag handle + Icon + Nama
          echo '  <div class="d-flex align-items-center">';
          echo '    <span class="handle mr-3 text-muted" style="cursor: move;">';
          echo '      <i class="fas fa-ellipsis-v"></i><i class="fas fa-ellipsis-v"></i>';
          echo '    </span>';
          echo '    <i class="' . htmlspecialchars($menu['icon']) . ' text-primary mr-2"></i>';
          echo '    <span class="font-weight-bold">' . htmlspecialchars($menu['name']) . '</span>';
          echo '  </div>';

          // Kanan: tombol aktif/nonaktif + edit + hapus
          echo '  <div class="btn-group btn-group-sm">';
          echo '    <button type="button" class="btn btnToggleActive ' . ($menu['is_active'] ? 'btn-success' : 'btn-secondary') . '" 
                          data-active="' . $menu['is_active'] . '" 
                          data-id="' . htmlspecialchars($menu['id']) . '"
                          title="Aktif/Nonaktif">';
          echo        $menu['is_active'] ? '<i class="fas fa-check-circle"></i>' : '<i class="fas fa-times-circle"></i>';
          echo '    </button>';
          echo '    <button type="button" class="btn btn-warning btnEditMenu" data-id="' . htmlspecialchars($menu['id']) . '" title="Edit">';
          echo '      <i class="fas fa-edit"></i>';
          echo '    </button>';
          echo '    <button type="button" class="btn btn-danger btnDeleteMenu" data-id="' . htmlspecialchars($menu['id']) . '" title="Hapus">';
          echo '      <i class="fas fa-trash-alt"></i>';
          echo '    </button>';
          echo '  </div>';

          echo '</div>';

          // Rekursif submenu
          renderMenuList($menus, $menu['id']);

          echo '</li>';
        }
      }
      if ($hasChild) echo '</ul>';
    }

    renderMenuList($menus);
    ?>
  </div>

  <div class="card-footer d-flex justify-content-between">
    <button type="button" class="btn btn-info" id="btnUpdateSidebar" title="Refresh sidebar">
      <i class="fas fa-sync-alt"></i> Update Sidebar
    </button>
  </div>
</div>


<!-- Modal Tambah/Edit Menu -->
<div class="modal fade" id="menuModal" tabindex="-1" role="dialog" aria-labelledby="menuModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form id="formMenu" class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="menuModalLabel">Tambah Menu</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">

        <div class="form-group">
          <label for="menuName">Nama Menu</label>
          <input type="text" class="form-control" id="menuName" name="name" placeholder="Masukkan nama menu" required>
        </div>

        <div class="form-group">
          <label for="menuRoute">Route</label>
          <input type="text" class="form-control" id="menuRoute" name="route" placeholder="Contoh: admin/dashboard">
        </div>

        <div class="form-group">
          <label for="menuIcon">Icon (FontAwesome)</label>
          <input type="text" class="form-control" id="menuIcon" name="icon" placeholder="Contoh: fas fa-home">
          <small>
            <a href="https://fontawesome.com/icons?d=gallery&m=free" target="_blank" rel="noopener noreferrer">
              Cari icon FontAwesome gratis
            </a>
          </small>
        </div>


        <div class="form-group">
          <label for="menuParent">Parent Menu</label>
          <select class="form-control" id="menuParent" name="parent_id">
            <option value="0">[ Tidak ada - Menu Utama ]</option>
            <?php foreach ($menus as $m): ?>
              <option value="<?= $m['id'] ?>"><?= htmlspecialchars($m['name']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="form-check">
          <input type="checkbox" class="form-check-input" id="is_active" name="is_active" checked>
          <label class="form-check-label" for="is_active">Aktif</label>
        </div>
      </div>

      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Simpan</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
      </div>
      <input type="hidden" id="menuId" name="id">
      <input type="hidden" id="menuSortOrder" name="sort_order" value="0">
    </form>
  </div>
</div>

<script>
  $(function() {
    const BASE_URL = '<?= base_url("admin/sistem/ajax") ?>';
    const modal = $('#menuModal');
    const formMenu = $('#formMenu');

    // Show modal Tambah Menu
    $('#btnAddMenu').on('click', function() {
      $('#menuModalLabel').text('Tambah Menu');
      formMenu[0].reset();
      $('#menuId').val('');
      $('#is_active').prop('checked', true);
      // Pastikan required aktif
      $('#menuName').attr('required', true);
      modal.modal('show');
    });

    // Show modal for editing menu
    $('#sortableMenu').on('click', '.btnEditMenu', function() {
      const id = $(this).data('id');

      $.post(BASE_URL, {
        action: 'get_menu',
        id
      }, function(res) {
        console.log(res); // Untuk debugging

        if (res.success && res.data && res.data.data) {
          const m = res.data.data;

          $('#menuModalLabel').text('Edit Menu');
          $('#menuId').val(m.id);
          $('#menuName').val(m.name).removeAttr('required');
          $('#menuRoute').val(m.route);
          $('#menuIcon').val(m.icon);
          $('#menuParent').val(m.parent_id);
          $('#menuSortOrder').val(m.sort_order); // Tambahkan ini!
          $('#is_active').prop('checked', m.is_active == 1);
          modal.modal('show');
        } else {
          Swal.fire('Gagal', res.message || 'Gagal mengambil data menu.', 'error');
        }
      }, 'json').fail(xhr => {
        Swal.fire('Error', 'Gagal mengambil data: ' + xhr.status, 'error');
      });
    });



    // Submit form Tambah/Edit
    formMenu.on('submit', function(e) {
      e.preventDefault();

      // Validasi manual tambahan (optional)
      if (!$('#menuName').val().trim()) {
        Swal.fire('Validasi', 'Nama menu wajib diisi.', 'warning');
        return;
      }

      let formData = formMenu.serializeArray().filter(f => f.name !== 'is_active');
      formData.push({
        name: 'action',
        value: 'save_menu'
      });
      formData.push({
        name: 'is_active',
        value: $('#is_active').is(':checked') ? 1 : 0
      });

      $.post(BASE_URL, formData, function(res) {
        if (res.success) {
          Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: 'Menu berhasil disimpan.',
            timer: 1500,
            showConfirmButton: false
          }).then(() => location.reload());
        } else {
          Swal.fire('Gagal', res.message || 'Terjadi kesalahan.', 'error');
        }
      }, 'json').fail(xhr => {
        Swal.fire('Error', 'Gagal menyimpan data: ' + xhr.status, 'error');
      });
    });

    // Delete menu
    $('#sortableMenu').on('click', '.btnDeleteMenu', function() {
      const id = $(this).data('id');
      Swal.fire({
        title: 'Hapus Menu?',
        text: 'Menu dan submenunya akan dihapus!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal'
      }).then(result => {
        if (result.isConfirmed) {
          $.post(BASE_URL, {
            action: 'delete',
            id
          }, function(res) {
            if (res.success) {
              Swal.fire({
                icon: 'success',
                title: 'Dihapus',
                text: 'Menu berhasil dihapus.',
                timer: 1500,
                showConfirmButton: false
              }).then(() => location.reload());
            } else {
              Swal.fire('Gagal', res.message || 'Tidak bisa menghapus menu.', 'error');
            }
          }, 'json').fail(xhr => {
            Swal.fire('Error', 'Gagal menghapus: ' + xhr.status, 'error');
          });
        }
      });
    });

    // Expand/Collapse all
    $('#btnExpandAll').on('click', () => $('#sortableMenu ul').slideDown());
    $('#btnCollapseAll').on('click', () => $('#sortableMenu ul').slideUp());

    // Auto-save menu order after drag & drop
    function autoSaveOrder() {
      const order = [];

      function build(items, parentId = 0) {
        items.each(function(index, el) {
          const $el = $(el);
          const id = $el.data('id');
          if (!id) return;

          order.push({
            id: id,
            sort_order: index + 1,
            parent_id: parentId
          });

          const children = $el.children('ul').children('li');
          if (children.length) build(children, id);
        });
      }
      build($('#sortableMenu > li'), 0);

      $.post(BASE_URL, {
        action: 'update_order',
        order
      }, function(res) {
        if (!res.success) {
          console.error('Gagal simpan urutan:', res.message);
        }
      }, 'json').fail(xhr => console.error('Gagal simpan urutan:', xhr.status));
    }

    // Initialize nestedSortable drag & drop
    if ($.fn.nestedSortable) {
      $('#sortableMenu').nestedSortable({
        handle: '.handle',
        items: 'li',
        listType: 'ul',
        toleranceElement: '> div',
        placeholder: 'sortable-placeholder',
        maxLevels: 10,
        isTree: true,
        expandOnHover: 700,
        startCollapsed: false,
        relocate: autoSaveOrder
      });
    }

    // Toggle active/inactive
    $('#sortableMenu').on('click', '.btnToggleActive', function() {
      const $btn = $(this);
      const id = $btn.closest('li').data('id');
      const isActive = $btn.data('active');

      $.post(BASE_URL, {
        action: 'toggle_active',
        id: id,
        is_active: isActive ? 0 : 1
      }, function(res) {
        if (res.success) {
          $btn.data('active', isActive ? 0 : 1)
            .toggleClass('btn-success btn-secondary')
            .html(isActive ? '<i class="fas fa-times-circle"></i>' : '<i class="fas fa-check-circle"></i>');
        } else {
          Swal.fire('Gagal', res.message || 'Tidak bisa mengubah status.', 'error');
        }
      }, 'json').fail(xhr => {
        Swal.fire('Error', 'Gagal mengubah status: ' + xhr.status, 'error');
      });
    });

    // Refresh sidebar
    $('#btnUpdateSidebar').on('click', function() {
      Swal.fire({
        title: 'Memuat ulang sidebar...',
        didOpen: () => Swal.showLoading(),
        allowOutsideClick: false,
        allowEscapeKey: false,
        timer: 1000
      }).then(() => location.reload());
    });
  });

  // Enable bootstrap tooltip if needed
  $('[data-toggle="tooltip"]').tooltip();
</script>

<style>
  .sortable-placeholder {
    background: #f0f0f0;
    border: 2px dashed #999;
    height: 45px;
    margin-bottom: 5px;
  }
</style>