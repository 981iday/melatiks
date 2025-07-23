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

        $page = "berita";
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

            $kategoriValid = array_column($this->model->semuaKategori(), 'id_kategori');
            $kategori_id = isset($_POST['kategori_id']) ? (int)$_POST['kategori_id'] : null;

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

            $judul   = $_POST['judul'] ?? '';
            $isi     = $_POST['isi'] ?? '';
            $status  = $_POST['status'] ?? 'draft';
            $tagForm = trim($_POST['tag'] ?? '');

            $kategoriNama = $this->model->getKategoriNamaById($kategori_id);
            $tag = $tagForm !== '' ? $tagForm : $this->generateTags($isi, $kategoriNama);

            $data = [
                'judul'       => $judul,
                'isi'         => $isi,
                'gambar'      => $gambar,
                'penulis_id'  => $_SESSION['user_id'],
                'kategori_id' => $kategori_id,
                'tag'         => $tag,
                'status'      => $status
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

    private function generateTags($text, $kategoriNama = '', $limit = 5)
    {
        $presetTags = [
            'Teknologi' => ['internet', 'gadget', 'software'],
            'Olahraga'  => ['sepakbola', 'atlet', 'pertandingan'],
            'Politik'   => ['pemerintah', 'partai', 'kebijakan'],
            'Ekonomi'   => ['bisnis', 'uang', 'pasar'],
            'Kesehatan' => ['dokter', 'virus', 'vaksin'],
            'Umum'      => ['berita', 'terbaru', 'update']
        ];

        $text = strtolower(strip_tags($text));
        $text = preg_replace('/[^a-z\s]/', '', $text);
        $words = explode(' ', $text);

        $stopwords = ['dan', 'yang', 'untuk', 'dengan', 'atau', 'ini', 'itu', 'dari', 'ke', 'di', 'pada'];
        $filtered = array_filter($words, fn($w) => strlen($w) > 3 && !in_array($w, $stopwords));

        $counts = array_count_values($filtered);
        arsort($counts);

        $topWords = array_slice(array_keys($counts), 0, $limit);

        if (empty($topWords)) {
            $kategoriNama = ucfirst(strtolower($kategoriNama));
            $topWords = $presetTags[$kategoriNama] ?? $presetTags['Umum'];
        }

        return implode(',', $topWords);
    }

    public function edit($id)
    {
        $berita = $this->model->getById($id);
        if (!$berita) {
            echo "<p class='text-danger'>Data tidak ditemukan.</p>";
            return;
        }

        echo json_encode($berita);
    }

    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $upload_dir = __DIR__ . '/../assets/images/berita/';
            $gambar = $_POST['gambar_lama'] ?? '';

            if (!empty($_FILES['gambar']['name'])) {
                if (!empty($gambar) && file_exists($upload_dir . $gambar)) {
                    unlink($upload_dir . $gambar);
                }

                $ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
                $gambar = 'berita_' . time() . '.' . $ext;
                move_uploaded_file($_FILES['gambar']['tmp_name'], $upload_dir . $gambar);
            }

            $data = [
                'judul'       => $_POST['judul'] ?? '',
                'isi'         => $_POST['isi'] ?? '',
                'gambar'      => $gambar,
                'penulis_id'  => $_SESSION['user_id'],
                'kategori_id' => $_POST['kategori_id'] ?? null,
                'tag'         => $_POST['tag'] ?? '',
                'status'      => $_POST['status'] ?? 'draft'
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

    public function publicIndex()
    {
        $beritaList = $this->model->getBeritaPublik(10);
        $title = "Berita Terbaru";

        include __DIR__ . '/../views/home/page/halaman_berita/berita.php';
    }

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

        global $berita;
        $page = 'halaman_berita/detail';
        include __DIR__ . '/../views/home/layout/template.php';
    }

}
