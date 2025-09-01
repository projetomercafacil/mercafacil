
<?php include __DIR__ . '/../partials/header.php'; 
$user = $_SESSION['user'] ?? null;
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard - MercaFácil</title>
  <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
</head>
<body class="page">

  <!-- Saudação com avatar e notificação -->
  <main class="container">
    <div class="user-greeting">
      <div class="user-avatar">👤</div>
      <div class="user-info">
        <h2>Olá, <?= htmlspecialchars($user['name'] ?? ''); ?>!</h2>
        <span>Vamos às compras hoje?</span>
      </div>
      <div style="margin-left:auto; font-size:22px; color:#d32f2f; cursor:pointer;">🔔</div>
    </div>

    <!-- Botões principais -->
    <div class="dashboard-actions">
      <button class="action-btn action-primary">👜 Explorar Produtos</button>
      <button class="action-btn action-secondary">📋 Minhas Compras</button>
    </div>

    <!-- Informações da loja -->
    <div class="store-info">
      Você está na loja: <br>
      <strong>Supermercados BH - Centro</strong>
      <a href="#">Trocar loja</a>
    </div>

    <!-- Ofertas do dia -->
    <div class="offers">
      <h3>Ofertas do dia:</h3>
      <div class="offer-card">
        <img src="https://img.icons8.com/ios-filled/50/000000/fish.png" alt="Peixe">
        <div class="offer-text">
          Tilápia 400g R$23,43 <br>
          <small>Só hoje, não perca!</small>
        </div>
      </div>
    </div>

    <!-- Botão extra -->
    <button class="action-btn extra-action">🔍 Escanear produtos</button>
  </main>


</body>
</html>
<style>/* GERAL */
body.page {
  font-family: Arial, sans-serif;
  background: #fefcf9;
  margin: 0;
  padding: 0;
  display: flex;
  justify-content: center;
}

/* CONTAINER PRINCIPAL */
.container {
  width: 100%;
  max-width: 900px; /* centraliza conteúdo */
  margin: 20px auto;
  padding: 20px;
}

/* SAUDAÇÃO */
.user-greeting {
  display: flex;
  align-items: center;
  background: #fff;
  padding: 15px;
  border-radius: 12px;
  box-shadow: 0 2px 6px rgba(0,0,0,0.08);
  margin-bottom: 20px;
}

.user-avatar {
  font-size: 35px;
  margin-right: 15px;
}

.user-info h2 {
  margin: 0;
  font-size: 18px;
  font-weight: bold;
}

.user-info span {
  font-size: 14px;
  color: #666;
}

/* AÇÕES */
.dashboard-actions {
  display: flex;
  flex-direction: column;
  gap: 10px;
  margin-bottom: 20px;
}

.action-btn {
  border: none;
  padding: 14px;
  font-size: 15px;
  font-weight: bold;
  border-radius: 10px;
  cursor: pointer;
  text-align: left;
  transition: all 0.3s ease;
}

.action-primary {
  background: #ffeaea;
  color: #c62828;
}

.action-secondary {
  background: #fff3e0;
  color: #d84315;
}

.extra-action {
  background: #fff3e0;
  color: #e53935;
  margin-top: 15px;
}

/* OFERTAS */
.offers {
  margin: 20px 0;
}

.offer-card {
  display: flex;
  align-items: center;
  background: #fff;
  padding: 12px;
  border-radius: 10px;
  box-shadow: 0 2px 6px rgba(0,0,0,0.08);
}

.offer-card img {
  width: 40px;
  margin-right: 12px;
}

.offer-text {
  font-size: 14px;
}

.offer-text small {
  color: #777;
}

/* LOJA */
.store-info {
  background: #fffbea;
  padding: 12px;
  border-radius: 10px;
  font-size: 14px;
  margin-bottom: 20px;
}

.store-info strong {
  color: #333;
}

.store-info a {
  color: #e53935;
  text-decoration: none;
  font-size: 13px;
}
</style>
