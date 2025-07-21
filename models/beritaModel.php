<?php

class beritaModel
{
    protected $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    // Ambil semua berita + join kategori & user
    public function semuaBerita()
    {
        $sql = "SELECT 
                b.*, 
                k.nama_kategori AS nama_kategori,
                u.nama AS nama_penulis
            FROM berita b
            LEFT JOIN kategori k ON b.kategori_id = k.id_kategori
            LEFT JOIN users u ON b.penulis_id = u.id
            ORDER BY b.created_at DESC";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // Ambil satu berita by ID
    public function getById($id)
    {
        $sql = "SELECT * FROM berita WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Tambah berita
    public function tambahBerita($data)
    {
        $sql = "INSERT INTO berita 
                (judul, isi, gambar, penulis_id, kategori_id, tag, status, created_at)
            VALUES 
                (:judul, :isi, :gambar, :penulis_id, :kategori_id, :tag, :status, NOW())";

        $stmt = $this->db->prepare($sql);

        // Pastikan kategori_id bisa NULL jika kosong agar tidak error foreign key
        $kategori_id = !empty($data['kategori_id']) ? $data['kategori_id'] : null;

        // Gunakan bindValue dengan tipe data yang tepat
        $stmt->bindValue(':judul', $data['judul'], PDO::PARAM_STR);
        $stmt->bindValue(':isi', $data['isi'], PDO::PARAM_STR);
        $stmt->bindValue(':gambar', $data['gambar'], PDO::PARAM_STR);
        $stmt->bindValue(':penulis_id', $data['penulis_id'], PDO::PARAM_INT);
        if ($kategori_id === null) {
            $stmt->bindValue(':kategori_id', null, PDO::PARAM_NULL);
        } else {
            $stmt->bindValue(':kategori_id', $kategori_id, PDO::PARAM_INT);
        }
        $stmt->bindValue(':tag', $data['tag'], PDO::PARAM_STR);
        $stmt->bindValue(':status', $data['status'], PDO::PARAM_STR);

        return $stmt->execute();
    }


    // Update berita
    public function updateBerita($id, $data)
    {
        $sql = "UPDATE berita SET
                    judul       = :judul,
                    isi         = :isi,
                    gambar      = :gambar,
                    penulis_id  = :penulis_id,
                    kategori_id = :kategori_id,
                    tag         = :tag,
                    status      = :status,
                    updated_at  = NOW()
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':judul'      => $data['judul'],
            ':isi'        => $data['isi'],
            ':gambar'     => $data['gambar'],
            ':penulis_id' => $data['penulis_id'],
            ':kategori_id' => $data['kategori_id'],
            ':tag'        => $data['tag'],
            ':status'     => $data['status'],
            ':id'         => $id
        ]);
    }

    // Hapus berita
    public function hapusBerita($id)
    {
        $stmt = $this->db->prepare("DELETE FROM berita WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // Ambil semua kategori
    public function semuaKategori()
    {
        $stmt = $this->db->query("SELECT id_kategori, nama_kategori FROM kategori ORDER BY nama_kategori ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Ambil semua penulis
    public function semuaPenulis()
    {
        $stmt = $this->db->query("SELECT id, nama FROM users ORDER BY nama ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBeritaPublik($limit = 10)
    {
        $stmt = $this->db->prepare("SELECT id, judul, isi, gambar, penulis, created_at FROM berita WHERE status = 'publish' ORDER BY created_at DESC LIMIT :limit");
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
