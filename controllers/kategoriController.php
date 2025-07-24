<?php
require_once __DIR__ . '/../models/KategoriModel.php';

class KategoriController
{
    protected $db;
    protected $model;

    public function __construct()
    {
        global $db;
        $this->db = $db;
        $this->model = new KategoriModel($db);
    }

    public function index()
    {
        $title = "Manajemen Kategori";
        $kategori = $this->model->getAll();
        $page = "kategori";

        include __DIR__ . '/../views/admin/layout/template.php';
    }

    public function tambah()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Metode tidak diizinkan.']);
            return;
        }

        $nama = trim($_POST['nama'] ?? '');
        $slug = $this->generateSlug($nama);

        if (empty($nama)) {
            http_response_code(422);
            echo json_encode([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => ['nama' => 'Nama kategori tidak boleh kosong.']
            ]);
            return;
        }

        if ($this->model->existsByNama($nama)) {
            http_response_code(409);
            echo json_encode([
                'success' => false,
                'message' => 'Kategori sudah ada.',
                'errors' => ['nama' => 'Kategori dengan nama tersebut sudah ada.']
            ]);
            return;
        }

        $result = $this->model->insert([
            'nama_kategori' => $nama,
            'slug' => $slug
        ]);

        echo json_encode([
            'success' => $result,
            'message' => $result ? 'Kategori berhasil ditambahkan.' : 'Gagal menambahkan kategori.'
        ]);
    }

    public function update($id)
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !is_numeric($id)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Permintaan tidak valid.']);
            return;
        }

        $nama = trim($_POST['nama'] ?? '');
        $slug = $this->generateSlug($nama);

        if (empty($nama)) {
            http_response_code(422);
            echo json_encode([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => ['nama' => 'Nama kategori tidak boleh kosong.']
            ]);
            return;
        }

        $existing = $this->model->getByNama($nama);
        if ($existing && $existing['id_kategori'] != $id) {
            http_response_code(409);
            echo json_encode([
                'success' => false,
                'message' => 'Nama kategori sudah digunakan.',
                'errors' => ['nama' => 'Kategori dengan nama tersebut sudah digunakan.']
            ]);
            return;
        }

        $result = $this->model->update($id, [
            'nama_kategori' => $nama,
            'slug' => $slug
        ]);

        echo json_encode([
            'success' => $result,
            'message' => $result ? 'Kategori berhasil diperbarui.' : 'Gagal memperbarui kategori.'
        ]);
    }

    public function hapus($id)
    {
        header('Content-Type: application/json');

        if (!is_numeric($id)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'ID tidak valid.']);
            return;
        }

        $result = $this->model->delete($id);

        echo json_encode([
            'success' => $result,
            'message' => $result ? 'Kategori berhasil dihapus.' : 'Gagal menghapus kategori.'
        ]);
    }

    public function edit($id)
    {
        header('Content-Type: application/json');

        if (!is_numeric($id)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'ID tidak valid.']);
            return;
        }

        $data = $this->model->getById($id);
        if ($data) {
            echo json_encode($data);
        } else {
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'Kategori tidak ditemukan.']);
        }
    }

    private function generateSlug($string)
    {
        $slug = preg_replace('/[^a-z0-9\s-]/i', '', $string);    // Hapus karakter aneh
        $slug = preg_replace('/[\s-]+/', '-', $slug);            // Ganti spasi jadi -
        return strtolower(trim($slug, '-'));
    }

    public function data()
{
    header('Content-Type: application/json');
    echo json_encode($this->model->getAll());
}

}
