<?php
class HomeController
{
    protected $db;
    protected $settings;

    public function __construct()
    {
        global $db;
        $this->db = $db;

        if (function_exists('getSiteSettings')) {
            $this->settings = getSiteSettings($this->db);
        } else {
            $this->settings = [];
        }
    }

    public function index()
    {
        $pageSlug = $_GET['page'] ?? 'home';

        // Bisa kamu tambahkan logika page dinamis berdasarkan slug
        global $pageSlug;

        include __DIR__ . '/../views/home/layout/template.php';
    }
}
