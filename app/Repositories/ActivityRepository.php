<?php
require_once __DIR__ . '/../Database/Database.php';

class ActivityRepository {
    private $db;
      public function __construct(){ 
    $this->db = Database::connect();
} 

    public function add($userId, $tipo, $descricao) {
        $st = $this->db->prepare("INSERT INTO activities (user_id, tipo, descricao) VALUES (?, ?, ?)");
        return $st->execute([$userId, $tipo, $descricao]);
    }

    public function listByUser($userId) {
        $st = $this->db->prepare("SELECT * FROM activities WHERE user_id = ? ORDER BY criado_em DESC");
        $st->execute([$userId]);
        return $st->fetchAll();
    }
}
