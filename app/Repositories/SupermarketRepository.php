<?php
require_once __DIR__ . '/../Database/Database.php';

class SupermarketRepository {
    private $db;
      public function __construct(){ 
    $this->db = Database::connect();} 

    public function getAll() {
        return $this->db->query("SELECT * FROM supermarkets ORDER BY nome")->fetchAll();
    }
}
