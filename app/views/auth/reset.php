<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="/mercafacil/public/assets/css/style.css">
</head>
<body>
<div class="auth-card">
  <div class="brand">
    <svg width="28" height="28" viewBox="0 0 24 24"><path d="M3 5h18v2H3V5zm2 4h14v10a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V9z"/></svg>
    <h1>MercaFácil</h1>
  </div>

  <?php if(!empty($_SESSION['flash'])): ?>
    <div class="alert"><?= htmlspecialchars($_SESSION['flash']); unset($_SESSION['flash']); ?></div>
  <?php endif; ?>

  <h2>Redefinir senha</h2>
  <form method="post" action="<?= BASE_URL ?>reset_password.php">
    <input type="hidden" name="token" value="<?= htmlspecialchars($_GET['token'] ?? '') ?>">
    <input type="password" name="senha" placeholder="Nova senha" required>
    <button type="submit" class="btn-primary">Salvar nova senha</button>
  </form>

  <div class="auth-links">
    <a class="link" href="<?= BASE_URL ?>login.php">Voltar ao login</a>
  </div>

  <button type="button" class="toggle-theme" id="themeToggle">🌙 Modo escuro</button>
</div>
  </body>
