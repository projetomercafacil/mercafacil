<?php
require_once __DIR__ . '/../Repositories/ShopRepository.php';

class FavoriteController {
    public function index(): void {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $userId = $_SESSION['user']['id'] ?? 0;

        $repo = new ShopRepository();
        $items = $userId ? $repo->favoritesOf($userId) : [];

        
        require __DIR__ . '/../views/favorites/index.php';
        require __DIR__ . '/../views/layout/footer.php';
    }
}
