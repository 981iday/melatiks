<?php
class UserController
{
    protected $db;

    public function __construct()
    {
        global $db;
        $this->db = $db;
    }

    // Menampilkan daftar pengguna dan modal tambah
    public function index()
    {
        try {
            $stmt = $this->db->query("
                SELECT u.id, u.username, u.nama, u.created_at, r.role_name
                FROM users u
                LEFT JOIN roles r ON u.role_id = r.id
                ORDER BY u.id ASC
            ");
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $users = [];
        }

        try {
            $stmt = $this->db->query("SELECT id, role_name FROM roles ORDER BY id ASC");
            $roles = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $roles = [];
        }

        $title = "Manajemen User";
        $page = "users"; // folder di views/admin/page/sistem

        // Bisa load model dan data jika perlu
        // $menus = $this->model->getMenus();

        include __DIR__ . '/../views/admin/layout/template.php';
    }

    // Menyimpan data user baru
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username']);
            $password = $_POST['password'];
            $password2 = $_POST['password2'];
            $nama = trim($_POST['nama']);
            $role_id = $_POST['role_id'];

            if (empty($username) || empty($password) || empty($password2) || empty($nama) || empty($role_id)) {
                header("Location: " . base_url('admin/users?modal=tambah&error=1'));
                exit;
            }

            if ($password !== $password2) {
                header("Location: " . base_url('admin/users?modal=tambah&error=1'));
                exit;
            }

            $stmt = $this->db->prepare("SELECT id FROM users WHERE username = ?");
            $stmt->execute([$username]);
            if ($stmt->fetch()) {
                header("Location: " . base_url('admin/users?modal=tambah&error=1'));
                exit;
            }

            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $this->db->prepare("INSERT INTO users (username, password, nama, role_id, created_at) VALUES (?, ?, ?, ?, NOW())");
            $success = $stmt->execute([$username, $hashed, $nama, $role_id]);

            if ($success) {
                header("Location: " . base_url('admin/users?success=1'));
            } else {
                header("Location: " . base_url('admin/users?modal=tambah&error=1'));
            }
            exit;
        }
    }

    // Menyimpan perubahan data user
public function update($id)
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = trim($_POST['username']);
        $nama = trim($_POST['nama']);
        $role_id = $_POST['role_id'];
        $password = $_POST['password'] ?? '';
        $password2 = $_POST['password2'] ?? '';

        if (empty($username) || empty($nama) || empty($role_id)) {
            header("Location: " . base_url("admin/users/edit/$id?error=1"));
            exit;
        }

        $stmt = $this->db->prepare("SELECT id FROM users WHERE username = ? AND id != ?");
        $stmt->execute([$username, $id]);
        if ($stmt->fetch()) {
            header("Location: " . base_url("admin/users/edit/$id?error=1"));
            exit;
        }

        if (!empty($password)) {
            if ($password !== $password2) {
                header("Location: " . base_url("admin/users/edit/$id?error=1"));
                exit;
            }
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $this->db->prepare("UPDATE users SET username = ?, nama = ?, role_id = ?, password = ? WHERE id = ?");
            $success = $stmt->execute([$username, $nama, $role_id, $hashed, $id]);
        } else {
            $stmt = $this->db->prepare("UPDATE users SET username = ?, nama = ?, role_id = ? WHERE id = ?");
            $success = $stmt->execute([$username, $nama, $role_id, $id]);
        }

        if ($success) {
            header("Location: " . base_url('admin/users?success=1'));
        } else {
            header("Location: " . base_url("admin/users/edit/$id?error=1"));
        }
        exit;
    }
}


    // Menghapus user
    public function hapus_users($id)
    {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = ?");
        $success = $stmt->execute([$id]);

        if ($success) {
            header("Location: " . base_url('admin/users?success=1'));
        } else {
            header("Location: " . base_url('admin/users?error=1'));
        }
        exit;
    }

    // Pendaftaran user dari frontend
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username']);
            $password = $_POST['password'];
            $password2 = $_POST['password2'];
            $role_id = $_POST['role_id'];

            if (empty($username) || empty($password) || empty($role_id)) {
                header("Location: ../views/daftar.php?error=Semua field wajib diisi");
                exit;
            }

            if ($password !== $password2) {
                header("Location: ../views/daftar.php?error=Password tidak cocok");
                exit;
            }

            $stmt = $this->db->prepare("SELECT id FROM users WHERE username = ?");
            $stmt->execute([$username]);
            if ($stmt->fetch()) {
                header("Location: ../views/daftar.php?error=Username sudah digunakan");
                exit;
            }

            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $this->db->prepare("INSERT INTO users (username, password, role_id) VALUES (?, ?, ?)");
            $stmt->execute([$username, $hashed, $role_id]);

            header("Location: ../views/login.php?status=registered");
            exit;
        }
    }
}
