<?php
require_once __DIR__ . '/../Database/Database.php';

class UserRepository {
    private $db;
       public function __construct(){ 
    $this->db = Database::connect();} 

    public function findByEmail($email) {
        $st = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $st->execute([$email]);
        return $st->fetch();
    }

    public function findById($id) {
        $st = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $st->execute([$id]);
        return $st->fetch();
    }

    public function createUser($nome, $email, $senha) {
        $hash = password_hash($senha, PASSWORD_BCRYPT);
        $st = $this->db->prepare("INSERT INTO users (nome, email, senha) VALUES (?, ?, ?)");
        return $st->execute([$nome, $email, $hash]);
    }

    public function saveResetToken($email, $token) {
        $exp = date('Y-m-d H:i:s', strtotime('+1 hour'));
        $st = $this->db->prepare("UPDATE users SET reset_token = ?, reset_expiration = ? WHERE email = ?");
        return $st->execute([$token, $exp, $email]);
    }

    public function findByToken($token) {
        $st = $this->db->prepare("SELECT * FROM users WHERE reset_token = ? AND reset_expiration > NOW()");
        $st->execute([$token]);
        return $st->fetch();
    }

    public function updatePasswordByEmail($email, $novaSenha) {
        $hash = password_hash($novaSenha, PASSWORD_BCRYPT);
        $st = $this->db->prepare("UPDATE users SET senha = ?, reset_token = NULL, reset_expiration = NULL WHERE email = ?");
        return $st->execute([$hash, $email]);
    }
}
