<?php
class PagesModel
{
    protected PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM pages ORDER BY position ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    public function getNextPosition(): int
    {
        $stmt = $this->db->query("SELECT COALESCE(MAX(position), 0) + 1 FROM pages");
        return (int) $stmt->fetchColumn();
    }

    public function create(array $data): bool
    {
        if (empty($data['title']) || empty($data['slug'])) {
            return false;
        }

        $sql = "INSERT INTO pages (title, slug, content, is_active, position, created_at) 
                VALUES (:title, :slug, :content, :is_active, :position, NOW())";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':title'     => $data['title'],
            ':slug'      => $data['slug'],
            ':content'   => $data['content'] ?? '',
            ':is_active' => isset($data['is_active']) ? (int)$data['is_active'] : 1,
            ':position'  => $data['position'] ?? $this->getNextPosition(),
        ]);
    }

    public function existsBySlug(string $slug): bool
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM pages WHERE slug = :slug");
        $stmt->execute([':slug' => $slug]);
        return (int) $stmt->fetchColumn() > 0;
    }

    public function getById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM pages WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    public function update(int $id, array $data): bool
    {
        if (empty($data['title']) || empty($data['slug'])) {
            return false;
        }

        $sql = "UPDATE pages SET title = :title, slug = :slug, content = :content, is_active = :is_active WHERE id = :id";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':title'     => $data['title'],
            ':slug'      => $data['slug'],
            ':content'   => $data['content'] ?? '',
            ':is_active' => isset($data['is_active']) ? (int)$data['is_active'] : 1,
            ':id'        => $id
        ]);
    }

    public function updatePageOrder(array $order): bool
    {
        if (empty($order)) return false;

        try {
            $this->db->beginTransaction();

            $stmt = $this->db->prepare("UPDATE pages SET position = :position WHERE id = :id");

            foreach ($order as $index => $id) {
                $stmt->execute([
                    ':position' => $index + 1,
                    ':id'       => (int) $id
                ]);
            }

            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->rollBack();
            error_log('Gagal update posisi halaman: ' . $e->getMessage());
            return false;
        }
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM pages WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
