document.addEventListener('DOMContentLoaded', () => {
  const modal = document.getElementById('payment-modal');
  const openBtn = document.getElementById('openPayment'); // vamos criar já já
  const closeBtn = modal?.querySelector('.pay-close');
  const form = document.getElementById('payment-form');
  const method = document.getElementById('pay-method');
  const cardFields = document.getElementById('card-fields');
  const msg = document.getElementById('pay-msg');

  const open = () => { if(modal) modal.style.display = 'flex'; };
  const close = () => { if(modal) modal.style.display = 'none'; msg.textContent=''; };

  // abre modal no clique
  if (openBtn) openBtn.addEventListener('click', (e) => { e.preventDefault(); open(); });

  // fecha
  closeBtn?.addEventListener('click', close);
  window.addEventListener('click', (e) => { if (e.target === modal) close(); });

  // Alternar campos de cartão
  const toggleCard = () => {
    const isCard = method.value === 'credit' || method.value === 'debit';
    cardFields.hidden = !isCard;
  };
  method?.addEventListener('change', toggleCard);
  toggleCard();

  // Envio fictício
  form?.addEventListener('submit', async (e) => {
    e.preventDefault();
    msg.textContent = 'Processando…';
    // validações simples
    if (method.value !== 'pix') {
      const num = document.getElementById('card-number').value.trim();
      const exp = document.getElementById('card-exp').value.trim();
      const cvv = document.getElementById('card-cvv').value.trim();
      if (num.replace(/\s/g,'').length < 16 || !/^\d{2}\/\d{2}$/.test(exp) || cvv.length < 3) {
        msg.textContent = 'Dados do cartão inválidos.';
        msg.style.color = '#c00';
        return;
      }
    }
    // simulação de processamento
    await new Promise(r => setTimeout(r, 1200));
    msg.textContent = 'Pagamento aprovado! Redirecionando…';
    msg.style.color = '#2e7d32';
    setTimeout(() => {
      close();
      // redirecione onde quiser após pagar
      window.location.href = '<?= BASE_URL ?>/router.php?page=dashboard';
    }, 900);
  });
});
