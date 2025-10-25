<?php // app/Views/partials/cart-modal.php ?>
<div id="cartModal" class="cart-modal" style="display:none;">
  <div class="cart-content">
    <span class="close" aria-label="Fechar">×</span>
    <h2>🛒 Seu Carrinho</h2>

    <div id="cartItems"><p>Carregando...</p></div>

    <h3 style="margin-top:12px;">Total: R$ <span id="cartTotal">0,00</span></h3>

    <div style="display:flex; gap:10px; margin-top:12px;">
      <button id="btnFinalizarCompra" class="btn">Finalizar Compra</button>
      <button type="button" class="btn" id="closeCartBtn" style="background:#777;">Fechar</button>
    </div>
  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
  const cartModal = document.getElementById("cartModal");
  const cartItems = document.getElementById("cartItems");
  const cartTotal = document.getElementById("cartTotal");
  const closeCartBtn = document.getElementById("closeCartBtn");

  function loadCart() {
    fetch("<?= BASE_URL ?>/router.php?page=cart&ajax=1")
      .then(res => res.json())
      .then(data => {
        if (!data.items || data.items.length === 0) {
          cartItems.innerHTML = "<p>Seu carrinho está vazio.</p>";
          cartTotal.textContent = "0,00";
          return;
        }

        let html = "<ul style='list-style:none; padding:0'>";
 data.items.forEach(item => {
  html += `<li>${item.name} x ${item.quantity} - R$ ${(item.price * item.quantity).toFixed(2)}</li>`;
});
html += "</ul>";

cartItems.innerHTML = html;
cartTotal.textContent = data.total.toFixed(2);
      })
      .catch(err => {
        cartItems.innerHTML = "<p>Erro ao carregar carrinho.</p>";
        console.error(err);
      });
  }

  // Carregar carrinho sempre que abrir o modal
  document.querySelectorAll("[data-open-cart]").forEach(btn => {
    btn.addEventListener("click", () => {
      loadCart();
      cartModal.style.display = "block";
    });
  });

  closeCartBtn.addEventListener("click", () => {
    cartModal.style.display = "none";
  });
});
</script>
