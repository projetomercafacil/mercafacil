<?php
session_start();
if (!isset($_SESSION['user'])) { header('Location: login.php'); exit; }
$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Meu Perfil - Mercafácil</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="container">
  <img src="assets/img/logo.png" alt="Logo Mercafácil">
  <h2>Bem-vindo, <?= htmlspecialchars($user['nome']) ?>!</h2>
  <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
  <p><a href="logout.php">Sair</a></p>
</div>
</body>
</html>
