<?php
// app/Views/auth/forgot_password.php
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Recuperar senha - MercaFácil</title>
<link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
</head>
<body class="auth-body">
  <div class="auth-card">
    <h2 class="auth-title">Recuperar senha</h2>

    <?php if (!empty($_SESSION['error'])): ?>
      <div class="alert error"><?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
    <?php endif; ?>
    <?php if (!empty($_SESSION['success'])): ?>
      <div class="alert success"><?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
    <?php endif; ?>

    <form method="post" action="<?= BASE_URL ?>/router.php?page=forgot" class="auth-form">
      <input type="email" name="email" placeholder="Seu e-mail" required />
      <button type="submit" class="btn primary">Enviar link</button>
    </form>

    <div class="auth-links">
      <a href="<?= BASE_URL ?>/router.php?page=login">Voltar ao login</a>
    </div>
  </div>
</body>
</html>
