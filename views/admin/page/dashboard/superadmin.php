<!-- Dashboard Superadmin -->


<section class="content">
  <div class="container-fluid">

    <!-- Statistik Kartu -->
    <div class="row">
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
          <div class="inner">
            <h3>12</h3>
            <p>Jumlah Pengguna</p>
          </div>
          <div class="icon">
            <i class="fas fa-users-cog"></i>
          </div>
          <a href="<?= base_url('admin/user') ?>" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>

      <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
          <div class="inner">
            <h3>35</h3>
            <p>Jumlah Guru</p>
          </div>
          <div class="icon">
            <i class="fas fa-chalkboard-teacher"></i>
          </div>
          <a href="<?= base_url('admin/page/guru/data.php') ?>" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>

      <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
          <div class="inner">
            <h3>89</h3>
            <p>Jumlah Siswa</p>
          </div>
          <div class="icon">
            <i class="fas fa-user-graduate"></i>
          </div>
          <a href="<?= base_url('admin/page/suswa/data.php') ?>" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>

      <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
          <div class="inner">
            <h3>8</h3>
            <p>Mata Pelajaran</p>
          </div>
          <div class="icon">
            <i class="fas fa-book"></i>
          </div>
          <a href="<?= base_url('admin/page/mapel/data.php') ?>" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
    </div>

    

  </div>
</section>
