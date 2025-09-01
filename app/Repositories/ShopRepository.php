<?php
require_once __DIR__ . '/../Database/Database.php';

class ShopRepository {
    private PDO $db;
       public function __construct(){ 
    $this->db = Database::connect();} 

    /* Favoritos */
    public function isFavorite(int $userId, int $productId): bool {
        $s=$this->db->prepare("SELECT 1 FROM favorites WHERE user_id=:u AND product_id=:p");
        $s->execute([':u'=>$userId, ':p'=>$productId]);
        return (bool)$s->fetchColumn();
    }
    public function toggleFavorite(int $userId, int $productId): bool {
        if ($this->isFavorite($userId,$productId)) {
            $s=$this->db->prepare("DELETE FROM favorites WHERE user_id=:u AND product_id=:p");
            $s->execute([':u'=>$userId, ':p'=>$productId]);
            return false;
        } else {
            $s=$this->db->prepare("INSERT INTO favorites (user_id, product_id) VALUES (:u,:p)");
            $s->execute([':u'=>$userId, ':p'=>$productId]);
            return true;
        }
    }
      public function getAllShops()
    {
        $stmt = $this->db->query("SELECT * FROM shops");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function favoritesOf(int $userId): array {
        $s=$this->db->prepare("SELECT p.* FROM favorites f JOIN products p ON p.id=f.product_id WHERE f.user_id=:u ORDER BY p.name");
        $s->execute([':u'=>$userId]);
        return $s->fetchAll(PDO::FETCH_ASSOC);
    }

    /* Carrinho */
    public function getOrCreateCartId(int $userId): int {
        $s=$this->db->prepare("SELECT id FROM carts WHERE user_id=:u ORDER BY id DESC LIMIT 1");
        $s->execute([':u'=>$userId]);
        $id=$s->fetchColumn();
        if ($id) return (int)$id;
        $ins=$this->db->prepare("INSERT INTO carts (user_id) VALUES (:u)");
        $ins->execute([':u'=>$userId]);
        return (int)$this->db->lastInsertId();
    }
    public function addToCart(int $cartId, int $productId, int $qty=1): void {
        $s=$this->db->prepare("SELECT id, qty FROM cart_items WHERE cart_id=:c AND product_id=:p");
        $s->execute([':c'=>$cartId, ':p'=>$productId]);
        $row=$s->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $n=$row['qty']+$qty;
            $u=$this->db->prepare("UPDATE cart_items SET qty=:q WHERE id=:id");
            $u->execute([':q'=>$n, ':id'=>$row['id']]);
        } else {
            $i=$this->db->prepare("INSERT INTO cart_items (cart_id, product_id, qty) VALUES (:c,:p,:q)");
            $i->execute([':c'=>$cartId, ':p'=>$productId, ':q'=>$qty]);
        }
    }
    public function cartItems(int $cartId): array {
        $s=$this->db->prepare("SELECT ci.*, p.name, p.price FROM cart_items ci JOIN products p ON p.id=ci.product_id WHERE ci.cart_id=:c");
        $s->execute([':c'=>$cartId]);
        return $s->fetchAll(PDO::FETCH_ASSOC);
    }
    public function clearCart(int $cartId): void {
        $this->db->prepare("DELETE FROM cart_items WHERE cart_id=:c")->execute([':c'=>$cartId]);
    }

    /* Pedido */
    public function createOrder(int $userId, array $items, string $method): int {
        $total = 0;
        foreach($items as $it){ $total += $it['price'] * $it['qty']; }
        $o=$this->db->prepare("INSERT INTO orders (user_id,total,payment_method,status) VALUES (:u,:t,:m,'paid')");
        $o->execute([':u'=>$userId, ':t'=>$total, ':m'=>$method]);
        $orderId=(int)$this->db->lastInsertId();

        $oi=$this->db->prepare("INSERT INTO order_items (order_id,product_id,qty,price) VALUES (:o,:p,:q,:r)");
        foreach($items as $it){
            $oi->execute([':o'=>$orderId, ':p'=>$it['product_id'], ':q'=>$it['qty'], ':r'=>$it['price']]);
        }
        return $orderId;
    }

    /* Atividades & Notificações */
    public function addActivity(int $userId, string $type, array $payload=[]): void {
        $s=$this->db->prepare("INSERT INTO activities (user_id, type, payload) VALUES (:u,:t,:p)");
        $s->execute([':u'=>$userId, ':t'=>$type, ':p'=>json_encode($payload, JSON_UNESCAPED_UNICODE)]);
    }
    public function activitiesOf(int $userId, int $limit=50): array {
        $s=$this->db->prepare("SELECT * FROM activities WHERE user_id=:u ORDER BY id DESC LIMIT :l");
        $s->bindValue(':u',$userId); $s->bindValue(':l',$limit,PDO::PARAM_INT); $s->execute();
        return $s->fetchAll(PDO::FETCH_ASSOC);
    }
    public function createNotification(int $userId, string $title, string $body): void {
        $s=$this->db->prepare("INSERT INTO notifications (user_id,title,body) VALUES (:u,:t,:b)");
        $s->execute([':u'=>$userId, ':t'=>$title, ':b'=>$body]);
    }
    public function unreadCount(int $userId): int {
        $s=$this->db->prepare("SELECT COUNT(*) FROM notifications WHERE user_id=:u AND read_at IS NULL");
        $s->execute([':u'=>$userId]); return (int)$s->fetchColumn();
    }
}
