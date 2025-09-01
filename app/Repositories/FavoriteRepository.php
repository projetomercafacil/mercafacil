<?php
require_once __DIR__ . '/../Database/Database.php';

class FavoriteRepository {
    private $db;
      public function __construct(){ 
    $this->db = Database::connect();} 

    public function add($userId, $productId) {
        $st = $this->db->prepare("INSERT IGNORE INTO favorites (user_id, product_id) VALUES (?, ?)");
        return $st->execute([$userId, $productId]);
    }

    public function listByUser($userId) {
        $st = $this->db->prepare("SELECT f.*, p.nome, p.preco, p.imagem
                                  FROM favorites f
                                  JOIN products p ON p.id = f.product_id
                                  WHERE f.user_id = ?");
        $st->execute([$userId]);
        return $st->fetchAll();
    }
}
