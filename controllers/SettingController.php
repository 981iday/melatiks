<?php
class SettingController
{
    protected $db;
    protected $currentUserRoleId;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        global $db;
        $this->db = $db;

        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        $this->currentUserRoleId = $_SESSION['role_id'] ?? null;
    }

    public function index()
    {
        $title = "Pengaturan Sistem";

        try {
            // Tampilkan hanya permissions yang aktif
            $hak_akses = $this->db->query("SELECT * FROM permissions WHERE is_active = 1 ORDER BY sort_order ASC")->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $hak_akses = [];
        }

        try {
            $stmt = $this->db->query("SELECT id, role_name FROM roles ORDER BY id ASC");
            $roles = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
        } catch (PDOException $e) {
            $roles = [];
        }

        $selectedRoleId = isset($_GET['role_id']) ? (int)$_GET['role_id'] : 1;

        try {
            $stmt = $this->db->prepare("SELECT permission_id FROM role_permissions WHERE role_id = ?");
            $stmt->execute([$selectedRoleId]);
            $existingPermissions = $stmt->fetchAll(PDO::FETCH_COLUMN);
            // Pastikan tipe data int untuk pengecekan in_array nanti
            $existingPermissions = array_map('intval', $existingPermissions);
        } catch (PDOException $e) {
            $existingPermissions = [];
        }

        try {
            $pengaturan = $this->db->query("SELECT * FROM settings LIMIT 1")->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $pengaturan = [];
        }

        try {
            $profil = $this->db->query("SELECT * FROM profil_sekolah LIMIT 1")->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $profil = [];
        }

        // Pastikan variabel ini diteruskan ke view supaya bisa dipakai
        $currentUserRoleId = $this->currentUserRoleId;

        $title = "Pengaturan Web";
        $page = "setting"; // folder di views/admin/page/sistem

        // Bisa load model dan data jika perlu
        // $menus = $this->model->getMenus();

        include __DIR__ . '/../views/admin/layout/template.php';
    }

    public function simpanHakakses()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $role_id = (int)($_POST['role_id'] ?? 0);
            $permission_ids = $_POST['permission_ids'] ?? [];

            // Pastikan permission_ids bertipe int
            $permission_ids = array_map('intval', $permission_ids);

            try {
                $stmt = $this->db->prepare("DELETE FROM role_permissions WHERE role_id = ?");
                $stmt->execute([$role_id]);

                if (!empty($permission_ids)) {
                    $stmtInsert = $this->db->prepare("INSERT INTO role_permissions (role_id, permission_id) VALUES (?, ?)");
                    foreach ($permission_ids as $pid) {
                        $stmtInsert->execute([$role_id, $pid]);
                    }
                }

                header("Location: " . base_url('admin/setting/hakakses?role_id=' . $role_id . '&success=1'));
                exit;
            } catch (PDOException $e) {
                die("Error menyimpan hak akses: " . $e->getMessage());
            }
        }

        header("Location: " . base_url('admin/setting/hakakses'));
        exit;
    }

    public function simpanPengaturan()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $site_name = $_POST['site_name'] ?? '';
            $maintenance_mode = isset($_POST['maintenance_mode']) ? 1 : 0; // Checkbox biasanya
            $contact_number = $_POST['contact_number'] ?? '';
            $address = $_POST['address'] ?? '';

            $logo_besar = null;
            $logo_kecil = null;
            $upload_dir = __DIR__ . '/../assets/images/setting/';

            if (!empty($_FILES['logo_besar']['name'])) {
                $ext = pathinfo($_FILES['logo_besar']['name'], PATHINFO_EXTENSION);
                $logo_besar = 'logo_besar.' . $ext;
                move_uploaded_file($_FILES['logo_besar']['tmp_name'], $upload_dir . $logo_besar);
            }

            if (!empty($_FILES['logo_kecil']['name'])) {
                $ext = pathinfo($_FILES['logo_kecil']['name'], PATHINFO_EXTENSION);
                $logo_kecil = 'logo_kecil.' . $ext;
                move_uploaded_file($_FILES['logo_kecil']['tmp_name'], $upload_dir . $logo_kecil);
            }

            try {
                $stmt = $this->db->prepare("
                    INSERT INTO settings (site_name, maintenance_mode, contact_number, address, logo_besar, logo_kecil)
                    VALUES (?, ?, ?, ?, ?, ?)
                    ON DUPLICATE KEY UPDATE
                        site_name = VALUES(site_name),
                        maintenance_mode = VALUES(maintenance_mode),
                        contact_number = VALUES(contact_number),
                        address = VALUES(address),
                        logo_besar = IF(VALUES(logo_besar) != '', VALUES(logo_besar), logo_besar),
                        logo_kecil = IF(VALUES(logo_kecil) != '', VALUES(logo_kecil), logo_kecil)
                ");
                $stmt->execute([
                    $site_name,
                    $maintenance_mode,
                    $contact_number,
                    $address,
                    $logo_besar ?? '',
                    $logo_kecil ?? ''
                ]);

                header("Location: " . base_url('admin/setting?success=1'));
                exit;
            } catch (PDOException $e) {
                die("Gagal menyimpan pengaturan: " . $e->getMessage());
            }
        }
    }

    public function simpanProfil()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                $_POST['nama_sekolah'] ?? '',
                $_POST['nama_kepala_sekolah'] ?? '',
                $_POST['npsn'] ?? '',
                $_POST['nss'] ?? '',
                $_POST['alamat'] ?? '',
                $_POST['status'] ?? '',
                $_POST['akreditasi'] ?? '',
                $_POST['sejarah'] ?? '',
                $_POST['nama_yayasan'] ?? '',
                $_POST['visi'] ?? '',
                $_POST['misi'] ?? ''
            ];

            $logo = null;
            $upload_dir = __DIR__ . '/../assets/images/setting/';
            if (!empty($_FILES['logo']['name'])) {
                $ext = pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION);
                $logo = 'logo_sekolah.' . $ext;
                move_uploaded_file($_FILES['logo']['tmp_name'], $upload_dir . $logo);
            }

            try {
                $stmt = $this->db->prepare("
                    INSERT INTO profil_sekolah (
                        nama_sekolah, nama_kepala_sekolah, npsn, nss, alamat, status,
                        akreditasi, sejarah, nama_yayasan, visi, misi, logo
                    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                    ON DUPLICATE KEY UPDATE
                        nama_sekolah = VALUES(nama_sekolah),
                        nama_kepala_sekolah = VALUES(nama_kepala_sekolah),
                        npsn = VALUES(npsn),
                        nss = VALUES(nss),
                        alamat = VALUES(alamat),
                        status = VALUES(status),
                        akreditasi = VALUES(akreditasi),
                        sejarah = VALUES(sejarah),
                        nama_yayasan = VALUES(nama_yayasan),
                        visi = VALUES(visi),
                        misi = VALUES(misi),
                        logo = IF(VALUES(logo) != '', VALUES(logo), logo)
                ");
                $stmt->execute([...$data, $logo ?? '']);

                header("Location: " . base_url('admin/setting?success=1'));
                exit;
            } catch (PDOException $e) {
                die("Gagal menyimpan profil: " . $e->getMessage());
            }
        }
    }
}
