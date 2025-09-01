<?php
require_once __DIR__ . '/../Database/Database.php';

class ProductRepository {
    private PDO $db;
  public function __construct(){ 
   $this->db = Database::connect();}


    public function search(array $filters, int $limit=24, int $offset=0): array {
        $where = []; $params = [];
        if (!empty($filters['q'])) { $where[] = "name LIKE :q"; $params[':q'] = '%'.$filters['q'].'%'; }
        if (!empty($filters['category'])) { $where[] = "category = :c"; $params[':c'] = $filters['category']; }
        if ($filters['min'] !== '' && $filters['min'] !== null) { $where[] = "price >= :min"; $params[':min'] = (float)$filters['min']; }
        if ($filters['max'] !== '' && $filters['max'] !== null) { $where[] = "price <= :max"; $params[':max'] = (float)$filters['max']; }

        $order = "created_at DESC";
        if (!empty($filters['sort'])) {
            $map = ['price_asc' => 'price ASC', 'price_desc' => 'price DESC', 'name' => 'name ASC'];
            $order = $map[$filters['sort']] ?? $order;
        }

        $whereSql = $where ? ('WHERE '.implode(' AND ', $where)) : '';
        $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM products $whereSql ORDER BY $order LIMIT :limit OFFSET :offset";
        $st = $this->db->prepare($sql);
        foreach($params as $k=>$v){ $st->bindValue($k, $v); }
        $st->bindValue(':limit', $limit, PDO::PARAM_INT);
        $st->bindValue(':offset', $offset, PDO::PARAM_INT);
        $st->execute();
        $items = $st->fetchAll(PDO::FETCH_ASSOC);
        $total = (int)$this->db->query("SELECT FOUND_ROWS()")->fetchColumn();
        return ['items'=>$items,'total'=>$total];
    }

    public function byId(int $id): ?array {
        $s=$this->db->prepare("SELECT * FROM products WHERE id=:id"); $s->execute([':id'=>$id]);
        $r=$s->fetch(PDO::FETCH_ASSOC); return $r ?: null;
    }

    public function byCode(string $code): ?array {
        $s=$this->db->prepare("SELECT * FROM products WHERE code=:c"); $s->execute([':c'=>$code]);
        $r=$s->fetch(PDO::FETCH_ASSOC); return $r ?: null;
    }
}
