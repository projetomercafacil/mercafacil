<?php
require_once __DIR__ . '/../Repositories/ShopRepository.php';

class ProfileController {
    public function index(): void {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $userId = $_SESSION['user']['id'] ?? 0;
        $repo = new ShopRepository();
        $acts = $userId ? $repo->activitiesOf($userId, 30) : [];

        require __DIR__ . '/../views/partials/header.php';
        require __DIR__ . '/../views/profile/index.php';
        require __DIR__ . '/../views/partials/footer.php';
    }
}
