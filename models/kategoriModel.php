<?php

class KategoriModel
{
    protected $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM kategori ORDER BY id_kategori DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM kategori WHERE id_kategori = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ?: null;
    }

    public function getByNama($nama)
    {
        $query = $this->db->prepare("SELECT * FROM kategori WHERE nama_kategori = ?");
        $query->execute([$nama]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }


    public function existsByNama($nama)
    {
        $query = $this->db->prepare("SELECT COUNT(*) FROM kategori WHERE nama_kategori = ?");
        $query->execute([$nama]);
        return $query->fetchColumn() > 0;
    }


    public function insert(array $data): bool
    {
        $stmt = $this->db->prepare("
            INSERT INTO kategori (nama_kategori, slug)
            VALUES (:nama_kategori, :slug)
        ");
        return $stmt->execute([
            ':nama_kategori' => $data['nama_kategori'],
            ':slug' => $data['slug']
        ]);
    }

    public function update(int $id, array $data): bool
    {
        $stmt = $this->db->prepare("
            UPDATE kategori
            SET nama_kategori = :nama_kategori, slug = :slug
            WHERE id_kategori = :id
        ");
        return $stmt->execute([
            ':nama_kategori' => $data['nama_kategori'],
            ':slug' => $data['slug'],
            ':id' => $id
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM kategori WHERE id_kategori = ?");
        return $stmt->execute([$id]);
    }
}
