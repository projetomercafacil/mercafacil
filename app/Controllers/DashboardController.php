<?php
// app/Controllers/DashboardController.php
require_once __DIR__ . '/../../config/config.php';

class DashboardController
{
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function index()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: " . BASE_URL . "/router.php?page=login");
            exit;
        }
        require __DIR__ . '/../Views/dashboard/index.php';
    }
}
