<?php
require_once __DIR__ . '/../app/Controllers/AuthController.php';
$auth = new AuthController();
$auth->register(
    $_POST['nome'] ?? '',
    $_POST['email'] ?? '',
    $_POST['senha'] ?? '',
    $_POST['confirmar'] ?? ''
);
