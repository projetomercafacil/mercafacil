<?php include __DIR__ . '/../partials/header.php'; ?>
<?php require_once __DIR__ . '/../../../config/config.php'; ?>
<section class="mobile-page center">
  <div class="avatar big"></div>
  <h2>Olá, <?= htmlspecialchars($_SESSION['user']['nome'] ?? 'Maria') ?>!</h2>

  <div class="list">
    <a class="pill tiny">💳 Pagamentos <small>Meus saldos e cartões</small></a>
    <a class="pill tiny">🎟️ Cupons <small>Meus cupons de desconto</small></a>
    <a class="pill tiny">🧾 Dados da conta <small>Minhas informações da conta</small></a>
    <a class="pill tiny">📚 Histórico <small>Registros das suas atividades</small></a>
    <a class="link-row">❓ Ajuda</a>
    <a class="link-row">⚙️ Configurações</a>
    <a class="btn-outline" href="<?= BASE_URL ?>/router.php?page=logout">Sair</a>
  </div>

  <h3 style="text-align:left">Últimas atividades</h3>
  <ul class="activity">
    <?php foreach($acts as $a): $p=json_decode($a['payload'],true); ?>
      <li><strong><?= htmlspecialchars($a['type']) ?></strong> —
        <span class="muted"><?= htmlspecialchars($a['created_at']) ?></span>
        <?php if($p){ ?><div class="muted small"><?= htmlspecialchars(json_encode($p, JSON_UNESCAPED_UNICODE)) ?></div><?php } ?>
      </li>
    <?php endforeach; ?>
  </ul>
</section>



<div class="layout">
  <aside class="sidebar">
    <div class="sidebar-brand">MercaFácil</div>
    <nav>
      <a href="<?= BASE_URL ?>router.php?page=dashboard">Dashboard</a>
      <a href="<?= BASE_URL ?>router.php?page=products">Produtos</a>
      <a href="<?= BASE_URL ?>router.php?page=favorites">Favoritos</a>
      <a href="<?= BASE_URL ?>router.php?page=profile" class="active">Perfil</a>
      <a href="<?= BASE_URL ?>logout.php" class="danger">Sair</a>
    </nav>
  </aside>
  <main class="content">
    <h2>Meu perfil</h2>
    <p><strong>Nome:</strong> <?= htmlspecialchars($user['nome']) ?></p>
    <p><strong>E-mail:</strong> <?= htmlspecialchars($user['email']) ?></p>
    <p><strong>Desde:</strong> <?= htmlspecialchars($user['criado_em']) ?></p>
  </main>
</div>
<?php include __DIR__ . '/../partials/footer.php'; ?>
