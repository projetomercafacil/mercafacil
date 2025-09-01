<?php
require_once __DIR__ . '/../app/Controllers/AuthController.php';
$auth = new AuthController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $auth->sendResetLink($_POST['email'] ?? '');
    exit;
}
$auth->forgotPassword();
