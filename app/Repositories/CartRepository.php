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
    $items = $_SESSION['cart'] ?? [];

    // Normaliza a estrutura para o formato esperado no JS
    $normalized = array_map(function($item) {
        $subtotal = $item['price'] * $item['qty'];
        return [
            'id' => $item['id'],
            'name' => $item['name'],
            'price' => (float) $item['price'],
            'quantity' => (int) $item['qty'],  // JS espera "quantity"
            'subtotal' => $subtotal,           // JS espera "subtotal"
        ];
    }, $items);

    $total = array_sum(array_column($normalized, 'subtotal'));

    return [
        'items' => $normalized,
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
