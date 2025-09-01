<?php
// separando POST do template
require_once __DIR__ . '/../app/Controllers/AuthController.php';
$auth = new AuthController();
$auth->login($_POST['email'] ?? '', $_POST['senha'] ?? '');
