<?php require_once __DIR__ . '/../../../config/config.php'; ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- CORRIGIDO: faltava a barra após BASE_URL -->
  <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">

  <title>Produtos</title>

  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background: #f9fafb;
      color: #222;
    }

    .mobile-page {
      max-width: 480px;
      margin: 0 auto;
      background: #f9fafb;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    /* Barra de busca */
    .searchbar {
      display: flex;
      align-items: center;
      padding: 12px;
      background: #fff;
      border-bottom: 1px solid #ddd;
      gap: 8px;
      margin-bottom: 12px;
    }
    .search-form { flex: 1; }
    .search-input {
      width: 100%;
      padding: 12px 15px;
      border: 1px solid #ddd;
      border-radius: 10px;
      font-size: 14px;
      transition: 0.2s;
    }
    .search-input:focus {
      border-color: #c00;
      box-shadow: 0 0 0 2px rgba(204,0,0,0.15);
      outline: none;
    }

    /* Barra de filtros */
    .filter-bar {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      align-items: center;
      padding: 12px;
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.08);
      margin: 0 12px 20px;
    }
    .filter-select,
    .filter-price {
      padding: 10px 12px;
      border: 1px solid #ddd;
      border-radius: 8px;
      font-size: 14px;
      min-width: 120px;
      transition: all 0.2s ease;
    }
    .filter-select:focus,
    .filter-price:focus {
      border-color: #c00;
      box-shadow: 0 0 0 2px rgba(204,0,0,0.15);
      outline: none;
    }
    .filter-price-range {
      display: flex;
      align-items: center;
      gap: 6px;
    }
    .filter-price-range span { font-weight: bold; color: #555; }
    .btn-filter {
      background: #c00;
      color: #fff;
      border: none;
      padding: 10px 18px;
      border-radius: 8px;
      font-size: 14px;
      font-weight: 600;
      cursor: pointer;
      transition: background 0.2s ease;
    }
    .btn-filter:hover { background: #a00; }

    /* Cabeçalho seção */
    .section-head { padding: 12px; }
    .section-head h2 { margin: 0; font-size: 18px; }
    .muted { color: #666; font-size: 13px; }

    /* Grid de cards */
    .grid-cards {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 16px;
      justify-content: center;
      max-width: 600px;
      margin: 0 auto 20px;
      padding: 0 12px;
    }

    /* ESTILO DO CARD (.product) */
    .product {
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
      padding: 12px;
      text-align: center;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      min-height: 150px;
    }
    .product h3 {
      margin: 6px 0 4px;
      font-size: 15px;
    }
    .product p {
      margin: 0 0 8px;
      font-weight: bold;
      color: #222;
    }
    .add-to-cart {
      background: #d32f2f;
      color: #fff;
      border: none;
      border-radius: 8px;
      padding: 8px 12px;
      font-weight: 700;
      cursor: pointer;
      transition: background .2s;
    }
    .add-to-cart:hover { background: #b71c1c; }
    .open-cart {
      background: #555;
      color: #fff;
      border: none;
      border-radius: 8px;
      padding: 8px 12px;
      font-weight: 700;
      cursor: pointer;
      transition: background .2s;
      grid-column: 1 / -1; /* ocupa a linha inteira */
    }
    .open-cart:hover { background: #333; }

    /* Paginação */
    .pagination {
      display: flex;
      justify-content: center;
      gap: 6px;
      padding: 12px;
    }
    .page {
      padding: 6px 10px;
      border-radius: 6px;
      border: 1px solid #ddd;
      text-decoration: none;
      color: #333;
      font-size: 13px;
    }
    .page.on { background: #c00; color: #fff; border-color: #c00; }

    /* Checkout bar */
    .checkout-bar {
      display: flex;
      gap: 10px;
      padding: 10px;
      border-top: 1px solid #ddd;
      background: #fff;
      position: sticky;
      bottom: 0;
    }
    .btn-pay {
      background: #d32f2f;
      color: #fff;
      border: none;
      border-radius: 8px;
      padding: 10px 18px;
      font-weight: 700;
      cursor: pointer;
      width: 100%;
    }
    .btn-pay:hover { background: #b71c1c; }

    /* Modal do carrinho */
    .cart-modal {
      position: fixed;
      inset: 0;
      background: rgba(0,0,0,0.6);
      display: none;
      align-items: center;
      justify-content: center;
      z-index: 1000;
    }
    .cart-content {
      background: #fff;
      padding: 20px;
      border-radius: 12px;
      width: 420px;
      max-height: 80vh;
      overflow-y: auto;
      box-shadow: 0 8px 20px rgba(0,0,0,0.4);
      position: relative;
      animation: fadeIn 0.3s ease-in-out;
    }
    .cart-content h2 {
      margin: 0 0 10px;
      font-size: 20px;
      color: #d32f2f;
      border-bottom: 2px solid #eee;
      padding-bottom: 10px;
    }
    .cart-content .close {
      position: absolute;
      top: 12px;
      right: 16px;
      font-size: 22px;
      cursor: pointer;
      color: #555;
    }
    .cart-item {
      padding: 8px 0;
      border-bottom: 1px solid #f1f1f1;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .cart-item a.remove {
      color: #d32f2f;
      text-decoration: none;
      font-size: 14px;
      margin-left: 10px;
    }
    .cart-content .btn {
      display: block;
      text-align: center;
      background: #d32f2f;
      color: #fff;
      padding: 10px;
      margin-top: 15px;
      border-radius: 6px;
      font-weight: bold;
      text-decoration: none;
      transition: background .2s;
    }
    .cart-content .btn:hover { background: #b71c1c; }

    .cart-count {
    background: red;
    color: white;
    font-size: 12px;
    font-weight: bold;
    border-radius: 50%;
    padding: 2px 6px;
    position: relative;
    top: -10px;
    left: -5px;
}


    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-20px); }
      to   { opacity: 1; transform: translateY(0); }
    }
    .botaomodalcart{
       display: inline-block;
    background: #c00;
    color: #fff;
    font-weight: bold;
    padding: 10px 15px;
    border-radius: 6px;
    text-decoration: none;
    transition: 0.2s;
    }
    .modal {
  position: fixed;
  top: 0; left: 0;
  width: 100%; height: 100%;
  background: rgba(0,0,0,0.6);
  display: flex;
  align-items: center;
  justify-content: center;
}
.modal-content {
  background: #fff;
  padding: 20px;
  border-radius: 8px;
  min-width: 300px;
}
.close {
  float: right;
  font-size: 22px;
  cursor: pointer;
}

  </style>
</head>
<body>
<section class="mobile-page">

  <!-- Busca -->
  <div class="searchbar">
    <form method="get" action="<?= BASE_URL ?>/router.php" class="search-form">
      <input type="hidden" name="page" value="products">
      <input class="search-input" name="q" value="<?= htmlspecialchars($filters['q']??'') ?>" placeholder="Buscar produtos">
    </form>
  </div>

  <!-- Filtros -->
  <form method="get" action="<?= BASE_URL ?>/router.php" class="filter-bar">
    <input type="hidden" name="page" value="products">

    <select name="category" class="filter-select">
      <option value="">Categoria</option>
      <?php foreach(['Mercearia','Bebidas','Frios','Limpeza'] as $c): ?>
        <option value="<?= $c ?>" <?= ($filters['category']??'')===$c?'selected':'' ?>><?= $c ?></option>
      <?php endforeach; ?>
    </select>

    <div class="filter-price-range">
      <input type="number" step="0.01" name="min" placeholder="Min" value="<?= htmlspecialchars($filters['min']??'') ?>" class="filter-price">
      <span>-</span>
      <input type="number" step="0.01" name="max" placeholder="Max" value="<?= htmlspecialchars($filters['max']??'') ?>" class="filter-price">
    </div>

    <select name="sort" class="filter-select">
      <option value="">Ordenar</option>
      <option value="price_asc" <?= ($filters['sort']??'')==='price_asc'?'selected':'' ?>>Preço ↑</option>
      <option value="price_desc" <?= ($filters['sort']??'')==='price_desc'?'selected':'' ?>>Preço ↓</option>
      <option value="name" <?= ($filters['sort']??'')==='name'?'selected':'' ?>>Nome</option>
    </select>

    <button class="btn-filter">Filtrar</button>
  </form>

  <div class="section-head">
    <h2>Produtos</h2>
    <span class="muted"><?= $data['total'] ?? 0 ?> produtos</span>
  </div>

  <!-- LISTA DE PRODUTOS -->
  <div class="grid-cards">
    <?php foreach ($products as $p): ?>
      <div class="product">
        <h3><?= htmlspecialchars($p['name']) ?></h3>
        <p>R$ <?= number_format($p['price'], 2, ',', '.') ?></p>
      <button class="add-to-cart" data-id="<?= (int)$p['id'] ?>">Adicionar ao Carrinho</button>

      </div>
    <?php endforeach; ?>

    <!-- Botão para abrir modal manualmente -->
  <button data-open-cart class="open-cart">🛒 Ver Carrinho</button>

  </div>

  <?php if(($totalPages ?? 1) > 1): ?>
    <div class="pagination">
      <?php for($i=1;$i<=$totalPages;$i++):
        $q = $_GET; $q['p']=$i; $qs=http_build_query($q); ?>
        <a class="page <?= ($i==$page)?'on':'' ?>" href="<?= BASE_URL ?>/router.php?<?= $qs ?>"><?= $i ?></a>
      <?php endfor; ?>
    </div>
  <?php endif; ?>


  <?php include __DIR__ . '/../partials/payment-modal.php';
 ?>
</section>
<!-- Modal do Carrinho -->
<div id="cartModal" class="cart-modal" style="display: none;">
    <div class="cart-modal-content">
        <span class="close">&times;</span>
        <h2>🛒 Seu Carrinho</h2>
        <div id="cartItems"><p>Carregando...</p></div>
        <h3>Total: R$ <span id="cartTotal">0.00</span></h3>
        <button class="botaomodalcart" id="checkoutBtn">Finalizar Compra</button>
  </div>



</div>
<!-- Modal de Checkout -->


<!-- Passa BASE_URL para o JS em arquivo -->
<script>window.BASE_URL = "<?= BASE_URL ?>";</script>

<!-- CORRIGIDO: se o arquivo está em public/js/cart.js, a URL é /js/cart.js -->
<script src="<?= BASE_URL ?>/assets/js/cart.js"></script>
<?php include __DIR__ . '/../partials/cart-modal.php'; ?>
<script>const BASE_URL = "<?= BASE_URL ?>";</script>
<script src="<?= BASE_URL ?>public/assets/js/cart.js"></script>

<script>
  document.getElementById("btnFinalizarCompra").addEventListener("click", function () {
    // abre o modal de pagamento
    document.getElementById("paymentModal").style.display = "block";
});

document.getElementById("checkoutBtn").addEventListener("click", function() {
    fetch("router.php?page=checkout_process", {
        method: "POST",
        body: new URLSearchParams({ payment_method: "pix" }) // só exemplo
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert("✅ " + data.message);
        } else {
            alert("⚠️ " + data.message);
        }
    });
});
document.getElementById("btnFinalizarCompra").addEventListener("click", function () {
    let metodo = document.querySelector('input[name="payment_method"]:checked');

    if (!metodo) {
        alert("⚠️ Selecione um método de pagamento.");
        return;
    }

    fetch("router.php?page=checkout_process", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "payment_method=" + metodo.value
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert("✅ " + data.message);
            // opcional: limpar carrinho
            document.getElementById("cartItems").innerHTML = "";
            document.getElementById("cartTotal").innerText = "R$ 0,00";
        } else {
            alert("⚠️ " + data.message);
        }
    })
    .catch(err => console.error("Erro:", err));
});

</script>
</body>
</html>
