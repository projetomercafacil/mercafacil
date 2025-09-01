<div id="payment-modal" class="pay-modal" style="display:none">
  <div class="pay-dialog">
    <button class="pay-close" type="button" aria-label="Fechar">×</button>

    <h2 class="pay-title">Pagamento</h2>

    <form id="payment-form">
      <label class="pay-label">Método de pagamento</label>
      <select id="pay-method" name="method" class="pay-input">
        <option value="pix">Pix</option>
        <option value="credit">Cartão de Crédito</option>
        <option value="debit">Cartão de Débito</option>
      </select>

      <div id="card-fields" class="pay-card-fields" hidden>
        <label class="pay-label">Número do cartão</label>
        <input type="text" inputmode="numeric" maxlength="19" placeholder="0000 0000 0000 0000" class="pay-input" id="card-number">

        <div class="pay-row">
          <div>
            <label class="pay-label">Validade (MM/AA)</label>
            <input type="text" inputmode="numeric" maxlength="5" placeholder="MM/AA" class="pay-input" id="card-exp">
          </div>
          <div>
            <label class="pay-label">CVV</label>
            <input type="text" inputmode="numeric" maxlength="4" placeholder="123" class="pay-input" id="card-cvv">
          </div>
        </div>
      </div>

      <button id="pay-submit" type="submit" class="btn-primary pay-submit">Pagar</button>
      <p id="pay-msg" class="pay-msg" role="status" aria-live="polite"></p>
    </form>
  </div>
</div>
