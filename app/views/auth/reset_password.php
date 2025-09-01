<?php
// app/Views/auth/reset_password.php
$token = $_GET['token'] ?? '';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Redefinir senha - MercaFácil</title>
<link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
</head>
<body class="auth-body">
  <div class="auth-card">
    <h2 class="auth-title">Redefinir senha</h2>

    <?php if (!empty($_SESSION['error'])): ?>
      <div class="alert error"><?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <form method="post" action="<?= BASE_URL ?>/router.php?page=reset" class="auth-form">
      <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
      <input type="password" name="password" placeholder="Nova senha" required />
      <button type="submit" class="btn primary">Salvar nova senha</button>
    </form>

    <div class="auth-links">
      <a href="<?= BASE_URL ?>/router.php?page=login">Voltar ao login</a>
    </div>
  </div>
</body>
</html>
