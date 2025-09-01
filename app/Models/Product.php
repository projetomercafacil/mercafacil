<?php
// app/Models/Product.php
require_once __DIR__ . '/../Database/Database.php';

class Product
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function getById(int $id): ?array
    {
        $st = $this->db->prepare("SELECT id, name, price, code, category FROM products WHERE id = :id LIMIT 1");
        $st->execute([':id' => $id]);
        $row = $st->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }
}
