<?php
class ModelMenu
{
    protected $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getAllMenus(): array
    {
        try {
            $stmt = $this->db->query("SELECT id, name, route, icon, parent_id, sort_order, is_active FROM permissions ORDER BY sort_order ASC");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error getAllMenus: " . $e->getMessage());
            return [];
        }
    }

    public function getMenuById($id): array
    {
        try {
            $stmt = $this->db->prepare("SELECT id, name, route, icon, parent_id, sort_order, is_active FROM permissions WHERE id = ?");
            $stmt->execute([(int)$id]);
            $menu = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($menu) {
                return ['success' => true, 'data' => $menu];
            }
            return ['success' => false, 'message' => 'Menu tidak ditemukan'];
        } catch (PDOException $e) {
            error_log("Error getMenuById: " . $e->getMessage());
            return ['success' => false, 'message' => 'Database error: ' . $e->getMessage()];
        }
    }

    /**
     * Simpan menu baru atau update menu lama sekaligus update is_active.
     * Jika $id null atau 0 maka insert, jika ada maka update.
     */
    public function saveMenu($id, $name, $route, $icon, $parent_id, $sort_order, $is_active = 1): array
    {
        try {
            if ($id && $id > 0) {
                $stmt = $this->db->prepare("UPDATE permissions SET name = ?, route = ?, icon = ?, parent_id = ?, sort_order = ?, is_active = ? WHERE id = ?");
                $stmt->execute([
                    trim($name),
                    trim($route),
                    trim($icon),
                    (int)$parent_id,
                    (int)$sort_order,
                    (int)$is_active,
                    (int)$id
                ]);
            } else {
                $stmt = $this->db->prepare("INSERT INTO permissions (name, route, icon, parent_id, sort_order, is_active) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->execute([
                    trim($name),
                    trim($route),
                    trim($icon),
                    (int)$parent_id,
                    (int)$sort_order,
                    (int)$is_active
                ]);
            }
            return ['success' => true, 'message' => null];
        } catch (PDOException $e) {
            error_log("Error saveMenu: " . $e->getMessage());
            return ['success' => false, 'message' => 'Database error: ' . $e->getMessage()];
        }
    }

    /**
     * Update urutan dan parent_id menu berdasarkan array order:
     * [
     *    ['id'=>int, 'sort_order'=>int, 'parent_id'=>int],
     *    ...
     * ]
     */
    public function updateOrder(array $order): array
    {
        try {
            $this->db->beginTransaction();
            $stmt = $this->db->prepare("UPDATE permissions SET sort_order = ?, parent_id = ? WHERE id = ?");

            foreach ($order as $item) {
                $stmt->execute([
                    (int)$item['sort_order'],
                    (int)$item['parent_id'],
                    (int)$item['id']
                ]);
            }

            $this->db->commit();
            return ['success' => true];
        } catch (PDOException $e) {
            $this->db->rollBack();
            error_log("Error updateOrder: " . $e->getMessage());
            return ['success' => false, 'message' => 'Database error: ' . $e->getMessage()];
        }
    }

    /**
     * Toggle aktif/nonaktif menu
     */
    public function toggleActive($id, $isActive): array
    {
        try {
            $stmt = $this->db->prepare("UPDATE permissions SET is_active = ? WHERE id = ?");
            $stmt->execute([(int)$isActive, (int)$id]);
            return ['success' => true];
        } catch (PDOException $e) {
            error_log("Error toggleActive: " . $e->getMessage());
            return ['success' => false, 'message' => 'Database error: ' . $e->getMessage()];
        }
    }

    /**
     * Delete menu beserta submenunya (parent_id = id)
     */
    public function deleteMenu($id): array
    {
        try {
            $this->db->beginTransaction();

            // Hapus sub-menu
            $stmt1 = $this->db->prepare("DELETE FROM permissions WHERE parent_id = ?");
            $stmt1->execute([(int)$id]);

            // Hapus menu utama
            $stmt2 = $this->db->prepare("DELETE FROM permissions WHERE id = ?");
            $stmt2->execute([(int)$id]);

            $this->db->commit();

            return ['success' => true];
        } catch (PDOException $e) {
            $this->db->rollBack();
            error_log("Error deleteMenu: " . $e->getMessage());
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Dapatkan nilai maksimum sort_order yang ada di tabel permissions
     */
    public function getMaxSortOrder(): int
    {
        try {
            $stmt = $this->db->query("SELECT MAX(sort_order) as max_sort FROM permissions");
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return (int)($row['max_sort'] ?? 0);
        } catch (PDOException $e) {
            error_log("Error getMaxSortOrder: " . $e->getMessage());
            return 0;
        }
    }
}
