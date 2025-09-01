<?php
require_once __DIR__ . '/../app/Controllers/AuthController.php';
$auth = new AuthController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $auth->resetPassword($_POST['token'] ?? '', $_POST['senha'] ?? '');
    exit;
}
$auth->resetPasswordPage();
