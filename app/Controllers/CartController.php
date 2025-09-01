<?php
// app/Controllers/CartController.php

require_once __DIR__ . '/../Models/Product.php';
require_once __DIR__ . '/../Repositories/CartRepository.php';

class CartController
{
    private CartRepository $repo;

    public function __construct()
    {
        $this->repo = new CartRepository();
    }

    public function show(): void
    {
        $data = $this->repo->all();

        if (!empty($_GET['ajax'])) {
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($data);
            return;
        }

        $products = $data['items'];
        $total = $data['total'];
        require __DIR__ . '/../views/cart/cart.php';
    }

    public function add(): void
    {
        $id = (int)($_POST['id'] ?? $_GET['id'] ?? 0);
        if ($id <= 0) {
            $this->json(['ok' => false, 'msg' => 'ID inválido']);
            return;
        }

        $product = (new Product())->getById($id);
        if (!$product) {
            $this->json(['ok' => false, 'msg' => 'Produto não encontrado']);
            return;
        }

        $this->repo->add($product, 1);

        if (!empty($_POST['ajax']) || !empty($_GET['ajax'])) {
            $this->json(['ok' => true] + $this->repo->all());
            return;
        }

        header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? BASE_URL . 'router.php?page=products'));
    }

    public function remove(): void
    {
        $id = (int)($_POST['id'] ?? $_GET['id'] ?? 0);
        if ($id > 0) {
            $this->repo->remove($id);
        }

        if (!empty($_POST['ajax']) || !empty($_GET['ajax'])) {
            $this->json(['ok' => true] + $this->repo->all());
            return;
        }

        header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? BASE_URL . 'router.php?page=products'));
    }

    private function json(array $payload): void
    {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($payload);
    }
}
