<?php
return [

    // ─── Home & Auth ───────────────────────────────────────
    '/'                     => ['controller' => 'HomeController', 'method' => 'index'],
    '/login'                => ['controller' => 'AuthController', 'method' => 'showLogin'],
    '/daftar'               => ['controller' => 'AuthController', 'method' => 'showRegister'],
    '/auth/login'           => ['controller' => 'AuthController', 'method' => 'processLogin'],
    '/auth/daftar'          => ['controller' => 'AuthController', 'method' => 'processRegister'],
    '/logout'               => ['controller' => 'AuthController', 'method' => 'logout'],

    // ─── Dashboard & Data ──────────────────────────────────
    '/dashboard'            => ['controller' => 'DashboardController', 'method' => 'index'],
    '/users'                => ['controller' => 'UserController', 'method' => 'index'],
    '/datasiswa'            => ['controller' => 'DataController', 'method' => 'siswa'],
    '/dataguru'             => ['controller' => 'DataController', 'method' => 'guru'],


    '/admin/page_setting'                => ['controller' => 'PagesController', 'method' => 'index'],
    '/admin/page_setting/ajax'           => ['controller' => 'PagesController', 'method' => 'ajax'],
    '/admin/pages'           => ['controller' => 'PagesController', 'method' => 'index'],
    '/admin/pages/stores'    => ['controller' => 'PagesController', 'method' => 'store'],
    '/admin/pages/ajax' => ['controller' => 'PagesController', 'method' => 'ajax'],
    '/admin/pages/delete' => ['controller' => 'PagesController', 'method' => 'handleDelete'],



    // ─── Setting Section ───────────────────────────────────
    '/admin/setting'                       => ['controller' => 'SettingController', 'method' => 'index'],
    '/admin/setting/hakakses'              => ['controller' => 'SettingController', 'method' => 'index'],
    '/admin/setting/simpan_hakakses'       => ['controller' => 'SettingController', 'method' => 'simpanHakakses'],
    '/admin/setting/simpan_pengaturan'     => ['controller' => 'SettingController', 'method' => 'simpanPengaturan'],
    '/admin/setting/simpan_profil'         => ['controller' => 'SettingController', 'method' => 'simpanProfil'],

    // ─── Berita Publik (Frontend) ─────────────────────────────
    '/berita'                          => ['controller' => 'beritaController', 'method' => 'publicIndex'],
    '/berita/{id}'                     => ['controller' => 'beritaController', 'method' => 'detail'],
    // ─── Halaman Berita Publik ────────────────────────────────
    '/berita/detail/{id}'               => ['controller' => 'beritaController', 'method' => 'detail'],



    // ─── MenuController (drag-drop menu) ───────────────────
    '/admin/sistem'              => ['controller' => 'MenuController', 'method' => 'index'],
    '/admin/sistem/ajax'         => ['controller' => 'MenuController', 'method' => 'ajaxHandler'],
    '/admin/sistem/menu_edit'         => ['controller' => 'MenuController', 'method' => 'ajaxMenuEdit'],
    '/admin/sistem/menu_update'         => ['controller' => 'MenuController', 'method' => 'ajaxMenuUpdate'],
    '/admin/sistem/menu_hapus'         => ['controller' => 'MenuController', 'method' => 'ajaxMenuHapus'],

    // ─── User Management ───────────────────────────────────
    '/admin/users'                  => ['controller' => 'UserController', 'method' => 'index'],
    '/admin/users/store'            => ['controller' => 'UserController', 'method' => 'store'],
    '/admin/users/edit/{id}'        => ['controller' => 'UserController', 'method' => 'edit_users'],
    '/admin/users/update/{id}'      => ['controller' => 'UserController', 'method' => 'update'],
    '/admin/users/hapus/{id}'       => ['controller' => 'UserController', 'method' => 'hapus_users'],

    // ─── Modul Berita (NEW) ────────────────────────────────
    '/admin/berita'                     => ['controller' => 'beritaController', 'method' => 'index'],
    '/admin/berita/tambah'             => ['controller' => 'beritaController', 'method' => 'tambah'],
    '/admin/berita/simpan'             => ['controller' => 'beritaController', 'method' => 'simpan'],
    '/admin/berita/edit/{id}'          => ['controller' => 'beritaController', 'method' => 'edit'],
    '/admin/berita/update/{id}'        => ['controller' => 'beritaController', 'method' => 'update'],
    '/admin/berita/hapus/{id}'         => ['controller' => 'beritaController', 'method' => 'hapus'],
    '/admin/berita/kategori'           => ['controller' => 'beritaController', 'method' => 'index'],
    '/admin/berita/tag'                => ['controller' => 'beritaController', 'method' => 'tag'],

    // Daftar kategori
    '/admin/kategori' => ['controller' => 'KategoriController', 'method' => 'index'],
    '/admin/kategori/tambah' => ['controller' => 'KategoriController', 'method' => 'tambah'],
    '/admin/kategori/edit/{id}' => ['controller' => 'KategoriController', 'method' => 'edit'],
    '/admin/kategori/update/{id}' => ['controller' => 'KategoriController', 'method' => 'update'],
    '/admin/kategori/hapus/{id}' => ['controller' => 'KategoriController', 'method' => 'hapus'],
    '/admin/kategori/data' => ['controller' => 'KategoriController', 'method' => 'data'],


];
