<?php
$base = '/melatiks'; // Sesuaikan folder kamu
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login Melatiks</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= $base ?>/assets/plugins/fontawesome/css/all.min.css" />
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?= $base ?>/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css" />
  <!-- AdminLTE style -->
  <link rel="stylesheet" href="<?= $base ?>/assets/dist/css/adminlte.min.css" />
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="<?= $base ?>/"><b>Melatiks</b>Admin</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">

      <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert-danger">
          <?= htmlspecialchars($_SESSION['error']) ?>
        </div>
        <?php unset($_SESSION['error']); ?>
      <?php endif; ?>

      <p class="login-box-msg">Silakan masuk untuk memulai sesi Anda</p>

      <form action="<?= $base ?>/auth/login" method="post">
        <div class="input-group mb-3">
          <input type="text" name="username" class="form-control" placeholder="Username" required autofocus />
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password" required />
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember" name="remember" />
              <label for="remember">Ingat Saya</label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Masuk</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <p class="mb-1 mt-3">
        <a href="<?= $base ?>/reset_pass.php">Lupa password?</a>
      </p>
      <p class="mb-0">
        <a href="<?= $base ?>/daftar.php" class="text-center">Daftar akun baru</a>
      </p>

    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="<?= $base ?>/assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= $base ?>/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= $base ?>/assets/dist/js/adminlte.min.js"></script>

</body>
</html>
