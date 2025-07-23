<?php
require_once __DIR__ . '/../models/kategoriModel.php';

class kategoriController
{
    protected $db;
    protected $model;

    public function __construct()
    {
        global $db;
        $this->db = $db;
        $this->model = new kategoriModel($db);
    }

    public function index()
    {
        $title = "Manajemen Kategori";
        $kategori = $this->model->semuaKategori();


        $page = "kategori";
        include __DIR__ . '/../views/admin/layout/template.php';
    }

    public function simpan()
    {
        $nama = $_POST['nama_kategori'] ?? '';
        $slug = $this->slugify($nama);

        $data = ['nama_kategori' => $nama, 'slug' => $slug];

        if ($this->model->insert($data)) {
            echo json_encode(['status' => 'success', 'message' => 'Kategori berhasil ditambahkan.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menambahkan kategori.']);
        }
    }

    public function update($id)
    {
        $nama = $_POST['nama_kategori'] ?? '';
        $slug = $this->slugify($nama);

        $data = ['nama_kategori' => $nama, 'slug' => $slug];

        if ($this->model->update($id, $data)) {
            echo json_encode(['status' => 'success', 'message' => 'Kategori berhasil diperbarui.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal memperbarui kategori.']);
        }
    }

    public function delete($id)
    {
        if ($this->model->delete($id)) {
            echo json_encode(['status' => 'success', 'message' => 'Kategori berhasil dihapus.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus kategori.']);
        }
    }

    private function slugify($text)
    {
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = trim($text, '-');
        $text = preg_replace('~-+~', '-', $text);
        $text = strtolower($text);
        return !empty($text) ? $text : 'n-a';
    }
}
