<?php
require_once __DIR__ . '/../Models/Cart.php';
require_once __DIR__ . '/../Models/Product.php';

class CheckoutController {
    private $cart;
    private $produtoModel;

    public function __construct() {
        $this->cart = new Cart();
        $this->produtoModel = new Product();
    }

    // Processar pagamento via AJAX
    public function process() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $items = $this->cart->getItems();
 // array de produtos
        if (empty($items)) {
            echo json_encode(["success" => false, "message" => "Carrinho vazio."]);
            return;
        }

        $method = $_POST['payment_method'] ?? '';
        $total = $this->cart->itemsWithTotals();

        if ($method) {
            // Simulação de pagamento
            $this->cart->clear();
            echo json_encode([
                "success" => true,
                "message" => "Pagamento de R$ " . number_format($total, 2, ',', '.') . " realizado com sucesso via $method!"
            ]);
        } else {
            echo json_encode([
                "success" => false,
                "message" => "Selecione um método de pagamento."
            ]);
        }
    }
}
