document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("cartModal");
    const modalContent = document.getElementById("cartItems");
    const closeBtn = document.querySelector(".close");

    // abre modal
    document.querySelectorAll(".open-cart").forEach(btn => {
        btn.addEventListener("click", function () {
            fetchCart();
            modal.style.display = "flex";
        });
    });

    // fecha modal
    closeBtn.onclick = () => modal.style.display = "none";
    window.onclick = (e) => { if (e.target === modal) modal.style.display = "none"; };

    // carregar itens do carrinho
    function fetchCart() {
        fetch(BASE_URL + "/router.php?page=cart&ajax=1")
            .then(res => res.json())
            .then(data => {
                let html = "";
                let total = 0;

                data.items.forEach(item => {
                    total += item.subtotal;
                    html += `
                        <div class="cart-item">
                            <strong>${item.name}</strong> - R$ ${item.price.toFixed(2)} x ${item.quantity} 
                            = R$ ${item.subtotal.toFixed(2)}
                            <a href="#" class="remove" data-id="${item.id}">❌</a>
                        </div>`;
                });

                if (data.items.length === 0) {
                    html = "<p>Carrinho vazio.</p>";
                } else {
                    html += `
                        <h3>Total: R$ ${total.toFixed(2)}</h3>
                        <button id="checkoutBtn">Finalizar Compra</button>
                    `;
                }

                modalContent.innerHTML = html;

                // remover item
                document.querySelectorAll(".remove").forEach(btn => {
                    btn.addEventListener("click", function (e) {
                        e.preventDefault();
                        removeFromCart(this.dataset.id);
                    });
                });

                // botão checkout → abre formulário no modal
                const checkoutBtn = document.getElementById("checkoutBtn");
                if (checkoutBtn) {
                    checkoutBtn.addEventListener("click", showCheckoutForm);
                }
            });
    }

    // remover produto
    function removeFromCart(id) {
        fetch(BASE_URL + "/router.php?page=remove_from_cart&id=" + id + "&ajax=1")
            .then(() => fetchCart());
    }

    // adicionar produto
    document.querySelectorAll(".add-to-cart").forEach(btn => {
        btn.addEventListener("click", function () {
            const id = this.dataset.id;
            fetch(BASE_URL + "/router.php?page=add_to_cart&id=" + id + "&ajax=1")
                .then(() => {
                    fetchCart();
                    alert("✅ Item adicionado ao carrinho!");
                });
        });
    });

    // exibir formulário de checkout no modal
    function showCheckoutForm() {
        modalContent.innerHTML = `
            <h2>Pagamento</h2>
            <form id="checkoutForm">
                <label><input type="radio" name="payment_method" value="PIX"> PIX</label><br>
                <label><input type="radio" name="payment_method" value="Crédito"> Cartão de Crédito</label><br>
                <label><input type="radio" name="payment_method" value="Débito"> Cartão de Débito</label><br>
                <button type="submit">Confirmar Pagamento</button>
            </form>
            <div id="checkoutMessage"></div>
        `;

        document.getElementById("checkoutForm").addEventListener("submit", function (e) {
            e.preventDefault();

            const formData = new FormData(this);

            fetch(BASE_URL + "/router.php?page=checkout_process&ajax=1", {
                method: "POST",
                body: formData
            })
                .then(res => res.json())
                .then(data => {
                    document.getElementById("checkoutMessage").textContent = data.message;
                    if (data.success) {
                        setTimeout(() => {
                            modal.style.display = "none";
                            fetchCart();
                        }, 2000);
                    }
                });
        });
    }
});
// Abrir modal ao clicar em "Finalizar Compra"



document.getElementById("checkoutBtn").addEventListener("click", function() {
    fetch("router.php?page=checkout_process", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: new URLSearchParams({
            payment_method: "pix" // ou cartao, boleto...
        })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert("✅ " + data.message);
        } else {
            alert("⚠️ " + data.message);
        }
    })
    .catch(err => {
        alert("Erro no checkout: " + err);
    });
});




// Fechar modal
document.getElementById("closeCheckout").addEventListener("click", function() {
    document.getElementById("checkoutModal").style.display = "none";
});

// Enviar checkout
document.getElementById("checkout-form").addEventListener("submit", function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch("router.php?page=checkout_process", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert("✅ Pagamento realizado com sucesso!");
            document.getElementById("checkoutModal").style.display = "none";
        } else {
            alert("⚠️ " + data.message);
        }
    })
    .catch(err => console.error("Erro:", err));
});

