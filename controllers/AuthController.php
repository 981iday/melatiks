<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// kode login controller berikutnya...


require_once __DIR__ . '/../helpers/url.php'; // helper base_url

class AuthController
{
    protected $pdo;

    public function __construct()
    {
        require __DIR__ . '/../config/connection.php';
        $this->pdo = $pdo;
    }

    public function showLogin()
    {
        $title = "Login Melatiks";
        include __DIR__ . '/../views/login.php';
    }

    public function processLogin()
    {
        $username = trim($_POST['username'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if ($username === '' || $password === '') {
            $_SESSION['error'] = 'Username dan password wajib diisi.';
            header('Location: ' . base_url('login'));
            exit;
        }

        $stmt = $this->pdo->prepare("
    SELECT u.id, u.username, u.password, u.nama, u.role_id, r.role_name
    FROM users u
    JOIN roles r ON u.role_id = r.id
    WHERE u.username = ?
");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Login sukses → simpan session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['nama'] = $user['nama'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role_id'] = $user['role_id'];        // <== tambah ini
            $_SESSION['role_name'] = $user['role_name'];

            header('Location: ' . base_url('dashboard'));
            exit;
        } else {
            $_SESSION['error'] = 'Username atau password salah.';
            header('Location: ' . base_url('login'));
            exit;
        }
    }

    public function showRegister()
    {
        $stmt = $this->pdo->query("SELECT id, role_name FROM roles");
        $roles = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $title = "Daftar Akun Melatiks";
        include __DIR__ . '/../views/daftar.php';
    }

    public function processRegister()
    {
        $username  = trim($_POST['username'] ?? '');
        $password  = $_POST['password'] ?? '';
        $password2 = $_POST['password2'] ?? '';
        $role_id   = $_POST['role_id'] ?? '';

        if ($username === '' || $password === '' || $role_id === '') {
            $_SESSION['error'] = 'Semua field wajib diisi.';
            header('Location: ' . base_url('daftar'));
            exit;
        }

        if ($password !== $password2) {
            $_SESSION['error'] = 'Password tidak cocok.';
            header('Location: ' . base_url('daftar'));
            exit;
        }

        $check = $this->pdo->prepare("SELECT id FROM users WHERE username = ?");
        $check->execute([$username]);

        if ($check->rowCount() > 0) {
            $_SESSION['error'] = 'Username sudah digunakan.';
            header('Location: ' . base_url('daftar'));
            exit;
        }

        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare("INSERT INTO users (username, password, role_id) VALUES (?, ?, ?)");
        $saved = $stmt->execute([$username, $hashed, $role_id]);

        if ($saved) {
            $_SESSION['success'] = 'Registrasi berhasil, silakan login.';
            header('Location: ' . base_url('login'));
            exit;
        } else {
            $_SESSION['error'] = 'Registrasi gagal, coba lagi.';
            header('Location: ' . base_url('daftar'));
            exit;
        }
    }

    public function logout()
    {
        session_destroy();
        header("Location: " . base_url());
        exit;
    }
}
