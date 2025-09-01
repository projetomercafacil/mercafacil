<?php
// app/Controllers/PaymentController.php

require_once __DIR__ . '/../Repositories/CartRepository.php';

class PaymentController
{
    private CartRepository $repo;

    public function __construct()
    {
        $this->repo = new CartRepository();
    }

    public function checkout(): void
    {
        $cart = $this->repo->all();
        if (empty($cart['items'])) {
            $_SESSION['flash'] = 'Seu carrinho está vazio.';
            header('Location: ' . BASE_URL . 'router.php?page=products');
            exit;
        }

        require __DIR__ . '/../views/partials/header.php';
        require __DIR__ . '/../views/partials/payment-modal.php';
        require __DIR__ . '/../views/partials/footer.php';
    }

    public function process(): void
    {
        $method = $_POST['method'] ?? 'pix';

        $msg = match($method) {
            'pix' => "Pagamento via Pix realizado com sucesso!",
            'credit' => "Pagamento via Cartão de Crédito aprovado!",
            'debit' => "Pagamento via Cartão de Débito aprovado!",
            default => "Método de pagamento inválido!"
        };

        $this->repo->clear();

        require __DIR__ . '/../views/payment/success.php';
    }
}
