<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$adminName = $_SESSION['role_name'] ?? 'Admin';
$adminAvatar = $_SESSION['admin_avatar'] ?? base_url('assets/dist/img/user2-160x160.jpg');
?>

<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button" aria-label="Toggle sidebar"><i class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="<?= base_url('admin/dashboard') ?>" class="nav-link">Home</a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="<?= base_url('admin/contact') ?>" class="nav-link">Contact</a>
    </li>
  </ul>

  <ul class="navbar-nav ml-auto">
    <li class="nav-item">
      <a class="nav-link" data-widget="navbar-search" href="#" role="button" aria-label="Toggle search">
        <i class="fas fa-search"></i>
      </a>
      <div class="navbar-search-block">
        <form class="form-inline" action="<?= base_url('search') ?>" method="GET">
          <div class="input-group input-group-sm">
            <input class="form-control form-control-navbar" name="q" type="search" placeholder="Search" aria-label="Search" />
            <div class="input-group-append">
              <button class="btn btn-navbar" type="submit" aria-label="Submit search">
                <i class="fas fa-search"></i>
              </button>
              <button class="btn btn-navbar" type="button" data-widget="navbar-search" aria-label="Close search">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
        </form>
      </div>
    </li>

    <li class="nav-item">
      <a class="nav-link" data-widget="fullscreen" href="#" role="button" aria-label="Toggle fullscreen">
        <i class="fas fa-expand-arrows-alt"></i>
      </a>
    </li>

    <li class="nav-item dropdown user-menu">
      <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
        <img src="<?= htmlspecialchars($adminAvatar) ?>" class="user-image img-circle elevation-2" alt="User Image" />
        <span class="d-none d-md-inline"><?= htmlspecialchars($adminName) ?></span>
      </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <a href="<?= base_url('admin/profile') ?>" class="dropdown-item">
          <i class="fas fa-user mr-2"></i> Profil
        </a>
        <div class="dropdown-divider"></div>
        <a href="<?= base_url('admin/set_password') ?>" class="dropdown-item">
          <i class="fas fa-key mr-2"></i> Set Password
        </a>
        <div class="dropdown-divider"></div>
        <a href="<?= base_url('logout') ?>" class="dropdown-item">
          <i class="fas fa-sign-out-alt mr-2"></i> Logout
        </a>
      </div>
    </li>
  </ul>
</nav>
