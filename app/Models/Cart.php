<?php
// app/Models/Cart.php

class Cart
{
    public static function all(): array
    {
        return $_SESSION['cart'] ?? [];
    }

    public static function add(array $product, int $qty = 1): void
    {
        if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
        $id = (int)$product['id'];
        if (!isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id] = [
                'id' => $id,
                'name' => $product['name'],
                'price' => (float)$product['price'],
                'quantity' => 0,
            ];
        }
        $_SESSION['cart'][$id]['quantity'] += max(1, $qty);
    }

    public static function remove(int $id): void
    {
        if (isset($_SESSION['cart'][$id])) {
            unset($_SESSION['cart'][$id]);
        }
    }

    public static function clear(): void
    {
        unset($_SESSION['cart']);
    }

    public static function itemsWithTotals(): array
    {
        $items = [];
        $total = 0.0;

        foreach (self::all() as $item) {
            $sub = (float)$item['price'] * (int)$item['quantity'];
            $total += $sub;
            $items[] = [
                'id' => (int)$item['id'],
                'name' => $item['name'],
                'price' => (float)$item['price'],
                'quantity' => (int)$item['quantity'],
                'subtotal' => $sub,
            ];
        }

        return ['items' => $items, 'total' => $total];
    }
    
    public function getItems() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    return $_SESSION['cart'] ?? [];
}

}
