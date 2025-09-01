<?php
require_once __DIR__ . '/../Repositories/ProductRepository.php';
require_once __DIR__ . '/../Repositories/ShopRepository.php';

class ProductController {
    public function index(): void {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $userId = $_SESSION['user']['id'] ?? 0;

        $filters = [
            'q' => $_GET['q'] ?? '',
            'category' => $_GET['category'] ?? '',
            'min' => $_GET['min'] ?? '',
            'max' => $_GET['max'] ?? '',
            'sort'=> $_GET['sort'] ?? ''
        ];

        $page = max(1, (int)($_GET['p'] ?? 1));
        $perPage = 12;
        $offset = ($page-1)*$perPage;

        $repo = new ProductRepository();
        $data = $repo->search($filters, $perPage, $offset);

        $favRepo = new ShopRepository();
        $favorites = [];
        if ($userId) {
            foreach($data['items'] as $it) {
                $favorites[$it['id']] = $favRepo->isFavorite($userId, (int)$it['id']);
            }
        }

        $totalPages = (int)ceil($data['total']/$perPage);

        /* atividade de busca */
        if ($userId && ($filters['q'] || $filters['category'] || $filters['min']!=='' || $filters['max']!=='')) {
            $favRepo->addActivity($userId, 'search', $filters);
        }

        $products = $data['items'];
        require __DIR__ . '/../views/partials/header.php';
        require __DIR__ . '/../views/products/index.php';
   
    }

    public function toggleFavorite(): void {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $userId = $_SESSION['user']['id'] ?? 0;
        if (!$userId){ http_response_code(403); exit('noauth'); }

        $pid = (int)($_POST['product_id'] ?? 0);
        if (!$pid){ http_response_code(400); exit('noprod'); }

        $s = new ShopRepository();
        $fav = $s->toggleFavorite($userId, $pid);
        $s->addActivity($userId, $fav ? 'favorite_add' : 'favorite_remove', ['product_id'=>$pid]);

        header('Content-Type: application/json');
        echo json_encode(['favorite'=>$fav]);
    }

    public function scanHandler(): void {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $code = trim($_POST['code'] ?? '');
        if (!$code){ $_SESSION['flash'] = 'Informe um código válido.'; header('Location: '.BASE_URL.'/router.php?page=dashboard'); exit; }

        $pr = new ProductRepository();
        $prod = $pr->byCode($code);
        if (!$prod){ $_SESSION['flash'] = 'Produto não encontrado para o código '.$code; header('Location: '.BASE_URL.'/router.php?page=dashboard'); exit; }

        $shop = new ShopRepository();
        $cartId = $shop->getOrCreateCartId((int)$_SESSION['user']['id']);
        $shop->addToCart($cartId, (int)$prod['id'], 1);
        $shop->addActivity((int)$_SESSION['user']['id'], 'scan_add', ['code'=>$code,'product_id'=>$prod['id']]);

        $_SESSION['flash'] = 'Produto adicionado ao carrinho: '.$prod['name'];
        header('Location: '.BASE_URL.'/router.php?page=products'); exit;
    }
}
