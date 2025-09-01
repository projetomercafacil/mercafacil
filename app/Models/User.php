<?php
// app/Models/User.php
require_once __DIR__ . '/../Database/Database.php';

class User
{
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    // Cria usuário (password já deve vir com hash OU faremos o hash aqui)
    public function create($name, $email, $passwordPlain)
    {
        $hash = password_hash($passwordPlain, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$name, $email, $hash]);
    }

    public function findByEmail($email)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    public function findById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ? LIMIT 1");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // Reset de senha
    public function saveResetToken($email, $token)
    {
        $stmt = $this->db->prepare(
            "UPDATE users SET reset_token = ?, reset_token_expire = DATE_ADD(NOW(), INTERVAL 1 HOUR) WHERE email = ?"
        );
        return $stmt->execute([$token, $email]);
    }

    public function findByToken($token)
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM users WHERE reset_token = ? AND reset_token_expire > NOW() LIMIT 1"
        );
        $stmt->execute([$token]);
        return $stmt->fetch();
    }

    public function updatePassword($id, $newPasswordPlain)
    {
        $hash = password_hash($newPasswordPlain, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("UPDATE users SET password = ? WHERE id = ?");
        return $stmt->execute([$hash, $id]);
    }

    public function clearToken($id)
    {
        $stmt = $this->db->prepare("UPDATE users SET reset_token = NULL, reset_token_expire = NULL WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
