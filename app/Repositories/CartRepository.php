<?php
// app/Repositories/CartRepository.php

class CartRepository
{
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    }

    public function all(): array
    {
        $items = $_SESSION['cart'];
        $total = array_reduce($items, function($sum, $item) {
            return $sum + ($item['price'] * $item['qty']);
        }, 0);

        return [
            'items' => $items,
            'total' => $total,
        ];
    }

    public function add(array $product, int $qty = 1): void
    {
        $id = $product['id'];
        if (!isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id] = [
                'id' => $id,
                'name' => $product['name'],
                'price' => $product['price'],
                'qty' => 0,
            ];
        }
        $_SESSION['cart'][$id]['qty'] += $qty;
    }

    public function remove(int $id): void
    {
        unset($_SESSION['cart'][$id]);
    }

    public function clear(): void
    {
        $_SESSION['cart'] = [];
    }
}
