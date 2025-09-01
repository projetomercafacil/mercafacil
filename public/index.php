<?php
// Entrada única da aplicação quando você acessa /mercafacil/public/
session_start();

// Se quiser, redirecione logado para o dashboard
$dest = isset($_SESSION['user']) ? 'dashboard' : 'login';
header('Location: router.php?page=' . $dest);
exit;
