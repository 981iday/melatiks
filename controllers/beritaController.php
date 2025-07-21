<?php
require_once __DIR__ . '/../models/beritaModel.php';

class beritaController
{
    protected $db;
    protected $model;

    public function __construct()
    {
        global $db;
        $this->db = $db;
        $this->model = new beritaModel($db);
    }

    public function index()
    {
        $title = "Manajemen Berita";
        $berita = $this->model->semuaBerita();
        $kategori = $this->model->semuaKategori();

        $page = "berita"; // akan include views/admin/page/berita.php
        include __DIR__ . '/../views/admin/layout/template.php';
    }

    public function simpan()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (empty($_SESSION['user_id'])) {
                $_SESSION['error'] = "Anda harus login untuk menambahkan berita.";
                header("Location: " . base_url('admin/berita'));
                exit;
            }

            // Ambil semua kategori valid dari model
            $kategoriValid = array_column($this->model->semuaKategori(), 'id_kategori'); // ambil semua id_kategori

            // Ambil kategori_id dari form, cast ke int untuk keamanan
            $kategori_id = isset($_POST['kategori_id']) ? (int)$_POST['kategori_id'] : null;

            // Cek kategori_id, jika kosong atau tidak valid, set jadi NULL
            if (empty($kategori_id) || !in_array($kategori_id, $kategoriValid)) {
                $kategori_id = null;
            }

            $upload_dir = __DIR__ . '/../assets/images/berita/';
            $gambar = '';

            if (!empty($_FILES['gambar']['name'])) {
                $ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
                $gambar = 'berita_' . time() . '.' . $ext;
                move_uploaded_file($_FILES['gambar']['tmp_name'], $upload_dir . $gambar);
            }

            $data = [
                'judul'      => $_POST['judul'] ?? '',
                'isi'        => $_POST['isi'] ?? '',
                'gambar'     => $gambar,
                'penulis_id' => $_SESSION['user_id'],
                'kategori_id' => $kategori_id,
                'tag'        => $_POST['tag'] ?? '',
                'status'     => $_POST['status'] ?? 'draft'
            ];

            if ($this->model->tambahBerita($data)) {
                $_SESSION['success'] = "Berita berhasil ditambahkan.";
                header("Location: " . base_url('admin/berita'));
            } else {
                $_SESSION['error'] = "Gagal menyimpan berita.";
                header("Location: " . base_url('admin/berita?modal=tambah'));
            }
            exit;
        }
    }


    public function edit($id)
    {
        $berita = $this->model->getById($id);
        if (!$berita) {
            echo "<p class='text-danger'>Data tidak ditemukan.</p>";
            return;
        }

        echo json_encode($berita); // dikonsumsi AJAX dan di-render di modal
    }

    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $upload_dir = __DIR__ . '/../assets/images/berita/';
            $gambar = $_POST['gambar_lama'] ?? '';

            if (!empty($_FILES['gambar']['name'])) {
                // Hapus gambar lama jika ada
                if (!empty($gambar) && file_exists($upload_dir . $gambar)) {
                    unlink($upload_dir . $gambar);
                }

                $ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
                $gambar = 'berita_' . time() . '.' . $ext;
                move_uploaded_file($_FILES['gambar']['tmp_name'], $upload_dir . $gambar);
            }

            $data = [
                'judul' => $_POST['judul'] ?? '',
                'isi' => $_POST['isi'] ?? '',
                'gambar' => $gambar,
                'penulis_id' => $_SESSION['user_id'],
                'kategori_id' => $_POST['kategori_id'] ?? null,
                'tag' => $_POST['tag'] ?? '',
                'status' => $_POST['status'] ?? 'draft'
            ];

            if ($this->model->updateBerita($id, $data)) {
                $_SESSION['success'] = "Berita berhasil diperbarui.";
            } else {
                $_SESSION['error'] = "Gagal memperbarui berita.";
            }

            header("Location: " . base_url('admin/berita'));
            exit;
        }
    }

    public function hapus($id)
    {
        $berita = $this->model->getById($id);

        if (!empty($berita['gambar'])) {
            $path = __DIR__ . '/../assets/images/berita/' . $berita['gambar'];
            if (file_exists($path)) {
                unlink($path);
            }
        }

        $this->model->hapusBerita($id);
        $_SESSION['success'] = "Berita berhasil dihapus.";
        header("Location: " . base_url('admin/berita'));
        exit;
    }

    /**
     * Halaman daftar berita untuk pengunjung (frontend)
     */
    public function publicIndex()
    {
        $beritaList = $this->model->getBeritaPublik(10);
        $title = "Berita Terbaru";

        include __DIR__ . '/../views/home/page/halaman_berita/berita.php';
    }

    /**
     * Halaman detail berita untuk pengunjung (frontend)
     */

    public function detail($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM berita WHERE id = :id AND status = 'publish' LIMIT 1");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $berita = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$berita) {
            echo "<div class='alert alert-danger text-center'>Berita tidak ditemukan atau belum dipublikasikan.</div>";
            return;
        }

        // Buat variabel global supaya bisa diakses di template
        global $berita;

        // Tampilkan layout umum dan isinya detail berita
        $page = 'halaman_berita/detail'; // views/home/page/halaman_berita/detail.php
        include __DIR__ . '/../views/home/layout/template.php';
    }
}
