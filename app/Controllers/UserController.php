<?php
require_once __DIR__ . '/../Repositories/UserRepository.php';

class UserController {
    private $repo;

    public function __construct() {
        $this->repo = new UserRepository();
    }

    public function getProfile($id) {
        return $this->repo->findById($id);
    }
}
