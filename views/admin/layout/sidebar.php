<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../../helpers/access.php'; // fungsi get_permissions_for_role
global $db;

// Ambil info user dari session
$roleId = $_SESSION['role_id'] ?? null;
$nama = $_SESSION['nama'] ?? 'Guest';
$avatar = $_SESSION['admin_avatar'] ?? 'assets/dist/img/user2-160x160.jpg';

$permissions = [];
if ($roleId) {
    $permissions = get_permissions_for_role($roleId, $db);
}

// Susun menuTree berdasarkan parent_id
$menuTree = [];
foreach ($permissions as $perm) {
    $parentId = $perm['parent_id'] ?? 0;
    $menuTree[$parentId][] = $perm;
}

// Fungsi rekursif untuk render menu dan submenu
function isMenuActive($menuRoute) {
    $currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    return $currentPath === '/' . ltrim($menuRoute, '/');
}

function renderMenu($items, $menuTree)
{
    foreach ($items as $item) {
        $hasChildren = isset($menuTree[$item['id']]);
        $activeClass = isMenuActive($item['route']) ? 'active' : '';
        ?>
        <li class="nav-item <?= $hasChildren ? 'has-treeview' : '' ?> <?= $activeClass ?>">
            <a href="<?= base_url($item['route']) ?>" class="nav-link <?= $activeClass ?>">
                <i class="nav-icon <?= htmlspecialchars($item['icon']) ?>"></i>
                <p>
                    <?= htmlspecialchars($item['name']) ?>
                    <?php if ($hasChildren): ?>
                        <i class="right fas fa-angle-left"></i>
                    <?php endif; ?>
                </p>
            </a>
            <?php if ($hasChildren): ?>
                <ul class="nav nav-treeview">
                    <?php renderMenu($menuTree[$item['id']], $menuTree); ?>
                </ul>
            <?php endif; ?>
        </li>
        <?php
    }
}

?>

<!-- Sidebar Layout -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="<?= base_url('dashboard') ?>" class="brand-link">
    <img src="<?= base_url('assets/images/settinglogo_kecil.png') ?>" alt="Sekolah Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">Admin Panel</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- User Panel -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="<?= htmlspecialchars(base_url(ltrim($avatar, '/'))) ?>" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="<?= base_url('admin/profile') ?>" class="d-block"><?= htmlspecialchars($nama) ?></a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <?php
        if (isset($menuTree[0])) {
            renderMenu($menuTree[0], $menuTree);
        } else {
            echo '<li class="nav-item"><a class="nav-link">Tidak ada menu</a></li>';
        }
        ?>
      </ul>
    </nav>
  </div>
</aside>
