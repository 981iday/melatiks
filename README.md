# Melatiks

Aplikasi web berbasis PHP dengan arsitektur MVC menggunakan AdminLTE4 dan Bootstrap 4,  
dirancang untuk manajemen sekolah dengan fitur multi-role, berita, pengguna, dan pengaturan sistem.

---

## Daftar Isi

- [Deskripsi](#deskripsi)  
- [Instalasi](#instalasi)  
- [Konfigurasi](#konfigurasi)  
- [Struktur Folder](#struktur-folder)  
- [Panduan Git](#panduan-git)  
- [Penggunaan Environment (.env)](#penggunaan-environment-env)  
- [Kontak](#kontak)

---

## Deskripsi

Melatiks adalah platform manajemen sekolah yang modular dan mudah dikembangkan,  
menggunakan PHP murni dengan pendekatan MVC serta integrasi AdminLTE dan Bootstrap 4.

---

## Instalasi

1. Clone repository:

    ```bash
    git clone https://github.com/981iday/melatiks.git
    cd melatiks
    ```

2. Install dependencies menggunakan Composer:

    ```bash
    composer install
    ```

3. Buat file `.env` di root project dengan isi konfigurasi (contoh di bawah).

4. Sesuaikan konfigurasi database di `.env`.

5. Jalankan server lokal (misal Laragon, XAMPP) dan akses aplikasi via browser.

---

## Konfigurasi

File `.env` minimal berisi:

# 1. Cek status file
git status

# 2. Tambah semua perubahan ke staging area
git add .

# 3. Tambah file tertentu ke staging
git add path/to/file.php

# 4. Commit perubahan dengan pesan singkat tapi jelas
git commit -m "Pesan singkat perubahan"

# 5. Kirim (push) commit ke remote repository
git push origin master

# 6. Ambil (pull) update terbaru dari remote
git pull origin master

# 7. Buat branch baru untuk fitur/percobaan
git checkout -b nama_branch_baru

# 8. Pindah ke branch lain
git checkout nama_branch

# 9. Gabungkan branch ke branch utama (master)
git checkout master
git merge nama_branch

# 10. Batalkan perubahan di file sebelum di-add
git checkout -- path/to/file.php

# 11. Lihat log commit singkat
git log --oneline

./git-melatiks.sh


melatiks/HTML:5/Adminlte4/bootstrap 4/
├── assets/                     
│   ├── js/
│   ├── dist/                   
│   ├── plugins/                
│   └── images/ 
│       ├── setting/  
│       ├── berita/    
│       └──  users/             
├── config/
│   ├── connection.php
│   └── database.php            
├── controllers/  
│   ├── AuthController.php  
│   ├── DashboardController.php  
│   ├── HomeController.php  
│   ├── MenuController.php  
│   ├── SettingController.php   
│   ├── beritaController.php        
│   └── UserController.php              
├── models/            
│   ├── beritaModel.php                 
│   └── ModelMenu.php       
├── views/                      
│   ├── admin/       
│   │   ├── layout/   
│   │   │   ├── head.php 
│   │   │   ├── navbar.php  
│   │   │   ├── footer.php  
│   │   │   └── template.php        
│   │   ├── dasboard/   
│   │   │   ├── superadmin.php  
│   │   │   ├── admin.php 
│   │   │   ├── operator.php 
│   │   │   ├── kepalasekolah.php   
│   │   │   └── siswa.php      
│   │   └── page/              
│   │       ├── users/   
│   │       │   └── index.php 
│   │       ├── sistem/                 
│   │       │   ├── setting_menu.php 
│   │       │   ├── ajax.php       
│   │       │   └── index.php 
│   │       ├── berita/   
│   │       │   ├── modal_tambah_berita.php 
│   │       │   ├── modal_edit_berita.php     
│   │       │   ├── modal_hapus_berita.php     
│   │       │   └── index.php tetapi ajax di sini semua atau external
│   │       ├── pages/   
│   │       │   ├── data.php 
│   │       │   ├── edit.php       
│   │       │   └── index.php  
│   │       ├── setting/   
│   │       │   ├── set_umum.php 
│   │       │   ├── hakakses.php  
│   │       │   ├── profile_web.php     
│   │       │   └── index.php 
│   │       └── mapel/               
│   ├── home.php/       
│   │   ├── layout/   
│   │   │   ├── head.php      
│   │   │   ├── navbar.php  
│   │   │   ├── footer.php  
│   │   │   ├── template.php    
│   │   │   └── index.php             
│   │   ├── page/   
│   │   │   ├── halaman_profile/index.php  
│   │   │   ├── halaman_sejarah/index.php   
│   │   │   ├── halaman_tentangkami/index.php 
│   │   │   ├── halaman_pendaftaran/index.php  
│   │   │   └── index.php 
│   ├── login.php               
│   ├── daftar.php             
│   └── resset_pass.php        
├── routes/
│   └── web.php                
├── storage/
│   └── logs/                   
├── helpers/
│   ├── config.php
│   ├── env.php
│   ├── setting.php
│   ├── autoload.php
│   ├── access.php                         
│   └── url.php  
├── vendor/                          
├── index.php 
├── logout.php  
├── .htaccess
├── .env
├── .composer.json
├── .composer.lock
├── .htaccess
├── .gitignore                 
├── git-melatiks.sh                  
└── README.md 

git push -u origin master

