<?php

class kategoriModel
{
    protected $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function semuakategori()
    {

        $stmt = $this->db->query("SELECT * FROM kategori ORDER BY id_kategori ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    public function insert($data)
    {
        $sql = "INSERT INTO kategori_berita (nama_kategori, slug) VALUES (:nama_kategori, :slug)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    public function update($id, $data)
    {
        $sql = "UPDATE kategori_berita SET nama_kategori = :nama_kategori, slug = :slug WHERE id_kategori = :id";
        $stmt = $this->db->prepare($sql);
        $data['id'] = $id;
        return $stmt->execute($data);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM kategori_berita WHERE id_kategori = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    public function getAll()
    {
        return $this->db->query("SELECT * FROM kategori_berita ORDER BY id_kategori DESC")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM kategori_berita WHERE id_kategori = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
