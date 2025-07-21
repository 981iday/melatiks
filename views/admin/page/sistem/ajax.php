<?php
// admin/view/page/sistem/ajax.php

require_once __DIR__ . '/../../../../config/database.php';
require_once __DIR__ . '/../../../../models/ModelMenu.php';

// Tampilkan error hanya saat pengembangan
ini_set('display_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

// Cek session login
session_start();
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode([
        'success' => false,
        'message' => 'Unauthorized'
    ]);
    exit;
}

try {
    $db = $pdo; // dari config/database.php
    $model = new ModelMenu($db);

    $action = $_POST['action'] ?? '';
    $response = ['success' => false, 'message' => 'Invalid action'];

    switch ($action) {
        case 'save':
            $id         = $_POST['id'] ?? null;
            $name       = trim($_POST['name'] ?? '');
            $route      = trim($_POST['route'] ?? '');
            $icon       = trim($_POST['icon'] ?? '');
            $parent_id  = (int)($_POST['parent_id'] ?? 0);
            $sort_order = (int)($_POST['sort_order'] ?? 0);

            if ($name === '' || $route === '') {
                http_response_code(400);
                echo json_encode([
                    'success' => false,
                    'message' => 'Nama dan Route wajib diisi.'
                ]);
                exit;
            }

            $id = $id !== '' ? (int)$id : null;
            $response = $model->saveMenu($id, $name, $route, $icon, $parent_id, $sort_order);
            break;

        case 'update_order':
            $rawOrder = $_POST['order'] ?? [];

            if (!is_array($rawOrder)) {
                http_response_code(400);
                throw new Exception("Data urutan tidak valid.");
            }

            $order = array_map(function ($item) {
                return [
                    'id' => (int)$item['id'],
                    'sort_order' => (int)$item['sort_order'],
                    'parent_id' => (int)$item['parent_id'],
                ];
            }, $rawOrder);

            $response = $model->updateOrder($order);
            break;

        default:
            http_response_code(400);
            $response['message'] = "Aksi tidak dikenali.";
            break;
    }

    echo json_encode($response);

} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Server Error: ' . $e->getMessage()
    ]);
}
