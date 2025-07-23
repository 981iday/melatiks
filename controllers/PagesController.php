<?php
require_once __DIR__ . '/../models/PagesModel.php';

class PagesController
{
    protected $db;
    protected $model;

    public function __construct(PDO $db)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->db = $db;
        $this->model = new PagesModel($this->db);
    }

    public function index()
    {
        $pages = $this->model->getAll();
        $title = "Pengaturan Halaman";
        $page  = "page_setting";

        include __DIR__ . '/../views/admin/layout/template.php';
    }

    public function store()
    {
        $title   = trim($_POST['title'] ?? '');
        $slug    = trim($_POST['slug'] ?? '');
        $content = $_POST['content'] ?? '';

        if ($title === '' || $slug === '') {
            $_SESSION['error'] = "Judul dan Slug wajib diisi.";
            return $this->redirectBackWithModal('tambah');
        }

        if ($this->model->existsBySlug($slug)) {
            $_SESSION['error'] = "Slug '{$slug}' sudah digunakan. Gunakan slug lain.";
            return $this->redirectBackWithModal('tambah');
        }

        $data = [
            'title'     => $title,
            'slug'      => $slug,
            'content'   => $content,
            'is_active' => 1,
            'position'  => $this->model->getNextPosition(),
        ];

        $created = $this->model->create($data);

        $_SESSION[$created ? 'success' : 'error'] = $created
            ? "Halaman berhasil ditambahkan."
            : "Gagal menyimpan halaman baru.";

        return $this->redirectBack();
    }

    public function ajax()
    {
        $action = $_POST['action'] ?? '';

        switch ($action) {
            case 'get_by_id':
                $this->handleGetById();
                break;
            case 'update':
                $this->handleUpdate();
                break;
            case 'delete':
                $this->handleDelete();
                break;
            case 'save_order':
                $this->handleSaveOrder();
                break;
            default:
                echo json_encode(['success' => false, 'message' => 'Aksi tidak dikenali']);
                break;
        }
    }

    private function handleGetById()
    {
        $id = (int) ($_POST['id'] ?? 0);
        $page = $this->model->getById($id);

        if ($page) {
            echo json_encode($page);
        } else {
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'Halaman tidak ditemukan']);
        }
    }

    private function handleUpdate()
    {
        $id        = (int) ($_POST['id'] ?? 0);
        $title     = trim($_POST['title'] ?? '');
        $slug      = trim($_POST['slug'] ?? '');
        $content   = $_POST['content'] ?? '';
        $is_active = isset($_POST['is_active']) ? (int) $_POST['is_active'] : 1;

        if ($id <= 0 || $title === '' || $slug === '') {
            echo json_encode(['success' => false, 'message' => 'Data tidak lengkap.']);
            return;
        }

        $data = [
            'title'     => $title,
            'slug'      => $slug,
            'content'   => $content,
            'is_active' => $is_active
        ];

        $updated = $this->model->update($id, $data);

        echo json_encode([
            'success' => $updated,
            'message' => $updated ? 'Halaman berhasil diperbarui.' : 'Gagal update halaman.'
        ]);
    }

    private function handleDelete()
    {
        $id = (int) ($_POST['id'] ?? 0);

        if ($id <= 0) {
            echo json_encode(['success' => false, 'message' => 'ID tidak valid.']);
            return;
        }

        $deleted = $this->model->delete($id);

        echo json_encode([
            'success' => $deleted,
            'message' => $deleted ? 'Halaman berhasil dihapus.' : 'Gagal menghapus halaman.'
        ]);
    }

    private function handleSaveOrder()
    {
        $order = $_POST['order'] ?? [];

        if (!is_array($order) || empty($order)) {
            echo json_encode(['success' => false, 'message' => 'Data urutan tidak valid.']);
            return;
        }

        $updated = $this->model->updatePageOrder($order);

        echo json_encode([
            'success' => $updated,
            'message' => $updated ? 'Urutan halaman diperbarui.' : 'Gagal menyimpan urutan.'
        ]);
    }

    protected function redirectBackWithModal(string $modalName)
    {
        $url = base_url("admin/pages?modal={$modalName}&error=1");
        header("Location: $url");
        exit;
    }

    protected function redirectBack()
    {
        header("Location: " . base_url("admin/pages"));
        exit;
    }
}
