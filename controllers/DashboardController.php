<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class DashboardController
{
    public function index()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . base_url('login'));
            exit;
        }

        $title = "Halaman Dashboard";
        $breadcrumb = ["Admin", "Dashboard"]; // Untuk breadcrumb lebih dari 1 level
        $page = "dashboard"; // nama folder di views/admin/page/

        include __DIR__ . '/../views/admin/layout/template.php';
    }
}
