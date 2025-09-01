<?php
// app/Views/auth/register.php
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Cadastro - MercaFácil</title>
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="auth-body">
  <div class="auth-card">
    <h2 class="auth-title">Criar conta</h2>

    <?php if (!empty($_SESSION['error'])): ?>
      <div class="alert error"><?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <form method="post" action="<?= BASE_URL ?>/router.php?page=register" class="auth-form">
      <input type="text" name="name" placeholder="Seu nome" required />
      <input type="email" name="email" placeholder="E-mail" required />
      <input type="password" name="password" placeholder="Senha" required />
      <button type="submit" class="btn primary">Cadastrar</button>
    </form>

    <div class="auth-links">
      <a href="<?= BASE_URL ?>/router.php?page=login">Já tem conta? Entrar</a>
    </div>
  </div>
</body>
</html>
