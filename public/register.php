<?php
require_once __DIR__ . '/../app/Controllers/AuthController.php';
$auth = new AuthController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $auth->register(
        $_POST['nome'] ?? '',
        $_POST['email'] ?? '',
        $_POST['senha'] ?? '',
        $_POST['confirmar'] ?? ''
    );
    exit;
}
$auth->registerPage();
