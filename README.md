
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
│   │       │   ├── berita.php 
│   │       │   ├── kategori.php     
│   │       │   ├── tag_berita.php     
│   │       │   └── index.php 
│   │       ├── mapel/   
│   │       │   ├── data.php 
│   │       │   ├── edit.php       
│   │       │   └── hapus.php  
│   │       ├── setting/   
│   │       │   ├── set_umum.php 
│   │       │   ├── hakakses.php  
│   │       │   ├── profile_web.php     
│   │       │   └── index.php 
│   │       └── mapel/               
│   ├── home.php/       
│   │   ├── layout/   
│   │   │   ├── head.php    -->css   
│   │   │   ├── navbar.php  
│   │   │   ├── footer.php  -->j
│   │   │   ├── template.php    -->template utama 
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
│   ├── autoload.php
│   ├── access.php                          <= function has_access($allowedRoles)
│   └── url.php                             <= function base_url($path = '') 
├── index.php <= routing
├── logout.php                   
├── .htaccess                   
└── README.md 

views/home.php/
├── layout/
│   ├── head.php        => CSS & meta
│   ├── navbar.php      => Navigasi atas
│   ├── footer.php      => Footer & script JS
│   ├── template.php    => Struktur utama HTML
│   └── index.php       => Loader utama
├── page/
│   ├── halaman profile/    => content
│   └── halaman berita       => content

semua content menggunakan pagelayer yang memiliki id 