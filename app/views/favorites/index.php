<?php include __DIR__ . '/../partials/header.php'; ?>
<?php require_once __DIR__ . '/../../../config/config.php'; ?>
<section class="mobile-page">
  <div class="section-head">
    <div>
      <h2>Favoritos</h2>
      <span class="muted"><?= count($items) ?> produtos</span>
    </div>
  </div>

  <div class="grid-cards">
    <?php foreach($items as $p): ?>
      <div class="card liked">
        <button class="fav" disabled>♥</button>
        <div class="prod">
          <div class="ph"></div>
          <div class="pn"><?= htmlspecialchars($p['name']) ?></div>
          <div class="pp">R$ <?= number_format($p['price'],2,',','.') ?></div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</section>


<div class="layout">
  <aside class="sidebar">
    <div class="sidebar-brand">MercaFácil</div>
    <nav>
      <a href="<?= BASE_URL ?>router.php?page=dashboard">Dashboard</a>
      <a href="<?= BASE_URL ?>router.php?page=products">Produtos</a>
      <a href="<?= BASE_URL ?>router.php?page=favorites" class="active">Favoritos</a>
      <a href="<?= BASE_URL ?>router.php?page=profile">Perfil</a>
      <a href="<?= BASE_URL ?>logout.php" class="danger">Sair</a>
    </nav>
  </aside>
  <main class="content">
    <h2>Seus favoritos</h2>
    <?php if(!empty($items)): ?>
      <ul class="list">
        <?php foreach($items as $i): ?>
          <li>
            <img class="thumb" src="<?= htmlspecialchars($i['imagem']) ?>" alt="<?= htmlspecialchars($i['nome']) ?>">
            <div>
              <div><?= htmlspecialchars($i['nome']) ?></div>
              <div class="muted">R$ <?= number_format($i['preco'], 2, ',', '.') ?></div>
            </div>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php else: ?>
      <p class="muted">Você ainda não favoritou produtos.</p>
    <?php endif; ?>
  </main>
</div>
<?php include __DIR__ . '/../partials/footer.php'; ?>
