<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Cek akses berdasarkan role.
 *
 * @param string|array $allowedRoles Role atau array role yang diperbolehkan, misalnya 'admin' atau ['admin','superadmin']
 * @return bool True jika role cocok, false jika tidak.
 */
function has_access($allowedRoles)
{
    if (!isset($_SESSION['role_name'])) {
        return false;
    }

    $userRole = $_SESSION['role_name'];

    if (is_array($allowedRoles)) {
        return in_array($userRole, $allowedRoles);
    }

    return $userRole === $allowedRoles;
}

/**
 * Ambil semua permission berdasarkan role_id dari DB.
 * Hasil sudah diurutkan berdasarkan sort_order.
 *
 * @param int $role_id
 * @param PDO $db
 * @return array
 */
function get_permissions_for_role($roleId, $db) {
    $sql = "SELECT p.*
            FROM permissions p
            JOIN role_permissions rp ON p.id = rp.permission_id
            WHERE rp.role_id = :role_id AND p.is_active = 1
            ORDER BY p.sort_order ASC";
    $stmt = $db->prepare($sql);
    $stmt->execute(['role_id' => $roleId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


/**
 * Cek apakah user memiliki permission berdasarkan route.
 *
 * @param string $route
 * @param array $permissions
 * @return bool
 */
function has_permission($route, $permissions)
{
    foreach ($permissions as $perm) {
        if ($perm['route'] === $route) {
            return true;
        }
    }
    return false;
}

/**
 * Susun permissions menjadi struktur pohon menu berdasarkan parent_id.
 *
 * @param array $permissions
 * @return array Tree array dengan key parent_id
 */
function build_menu_tree($permissions)
{
    $tree = [];

    foreach ($permissions as $perm) {
        $parentId = isset($perm['parent_id']) ? (int)$perm['parent_id'] : 0;
        $tree[$parentId][] = $perm;
    }

    return $tree;
}
