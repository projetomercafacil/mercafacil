<?php
require_once __DIR__ . '/../app/Controllers/AuthController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $auth = new AuthController();
    $email = $_POST['email'];
    $auth->esqueciSenha($email);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Recuperar Senha</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="container">
    <h2>Recuperar Senha</h2>
    <form method="POST">
        <input type="email" name="email" placeholder="Digite seu e-mail" required>
        <button type="submit" class="btn-primary">Enviar link</button>
    </form>
</div>
</body>
</html>
