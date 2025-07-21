<?php

require_once __DIR__ . '/../models/ModelMenu.php';

class MenuController
{
    protected $db;
    protected $currentUserRoleId;
    protected $model;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        global $db;
        $this->db = $db;
        $this->model = new ModelMenu($this->db);

        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        $this->currentUserRoleId = $_SESSION['role_id'] ?? null;
    }

    public function index()
    {
        $menus = $this->model->getAllMenus();

        $title = "Pengaturan Sistem";
        $page = "sistem"; // folder di views/admin/page/sistem

        // Bisa load model dan data jika perlu
        // $menus = $this->model->getMenus();

        include __DIR__ . '/../views/admin/layout/template.php';
    }

    public function ajaxHandler()
    {
        header('Content-Type: application/json');
        $action = $_POST['action'] ?? '';

        try {
            switch ($action) {
                case 'get_menu':
                    $id = (int)($_POST['id'] ?? 0);
                    if ($id <= 0) {
                        echo json_encode(['success' => false, 'message' => 'ID tidak valid']);
                        return;
                    }
                    $menu = $this->model->getMenuById($id);
                    if ($menu) {
                        echo json_encode(['success' => true, 'data' => $menu]);
                    } else {
                        echo json_encode(['success' => false, 'message' => 'Menu tidak ditemukan']);
                    }
                    break;

                case 'save_menu':
                    $id        = isset($_POST['id']) && $_POST['id'] !== '' ? (int)$_POST['id'] : null;
                    $name      = trim($_POST['name'] ?? '');
                    $route     = trim($_POST['route'] ?? '');
                    $icon      = trim($_POST['icon'] ?? '');
                    $parent_id = isset($_POST['parent_id']) ? (int)$_POST['parent_id'] : 0;
                    $sort_order = isset($_POST['sort_order']) ? (int)$_POST['sort_order'] : 0;
                    $is_active = (isset($_POST['is_active']) && ($_POST['is_active'] == '1' || $_POST['is_active'] === 1)) ? 1 : 0;

                    if ($name === '') {
                        echo json_encode(['success' => false, 'message' => 'Nama menu wajib diisi']);
                        return;
                    }

                    if ($id === null && $sort_order <= 0) {
                        $maxSort = $this->model->getMaxSortOrder();
                        $sort_order = $maxSort + 1;
                    }

                    $result = $this->model->saveMenu($id, $name, $route, $icon, $parent_id, $sort_order, $is_active);
                    echo json_encode($result);
                    break;

                case 'update_order':
                    $order = $_POST['order'] ?? [];
                    if (!is_array($order)) {
                        http_response_code(400);
                        echo json_encode(['success' => false, 'message' => 'Data urutan tidak valid']);
                        return;
                    }
                    $result = $this->model->updateOrder($order);
                    echo json_encode($result);
                    break;

                case 'toggle_active':
                    $id = (int)($_POST['id'] ?? 0);
                    $isActive = (int)($_POST['is_active'] ?? 0);
                    if ($id <= 0) {
                        echo json_encode(['success' => false, 'message' => 'ID tidak valid']);
                        return;
                    }
                    $result = $this->model->toggleActive($id, $isActive);
                    echo json_encode($result);
                    break;

                case 'delete':
                    $id = (int)($_POST['id'] ?? 0);
                    if ($id <= 0) {
                        echo json_encode(['success' => false, 'message' => 'ID tidak valid']);
                        return;
                    }
                    $result = $this->model->deleteMenu($id);
                    echo json_encode($result);
                    break;

                default:
                    http_response_code(400);
                    echo json_encode(['success' => false, 'message' => 'Aksi tidak valid']);
                    break;
            }
        } catch (Exception $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Server error: ' . $e->getMessage()]);
        }
    }
}
