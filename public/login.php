<?php
require_once __DIR__ . '/../app/Controllers/AuthController.php';
$auth = new AuthController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $auth->login($_POST['email'] ?? '', $_POST['senha'] ?? '');
    exit;
}
$auth->loginPage();
