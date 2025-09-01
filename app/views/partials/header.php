<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>MercaFácil</title>
    <link rel="stylesheet" href="/mercafacil/public/assets/css/style.css">
    <script>
    const BASE_URL = "<?= BASE_URL ?>";
</script>

</head>
<body>



<header class="header">
    <div class="header-container">
        <!-- Logo -->
        <div class="header-logo">
            <a href="index.php?page=dashboard">
                <h2>🛒 Mercafácil</h2>
            </a>
        </div>

        <!-- Menu -->
        <nav class="header-nav">
            <a href="router.php?page=dashboard">Início</a>
            <a href="router.php?page=products">Produtos</a>
            <a href="router.php?page=favorites">Favoritos</a>
            <a href="router.php?page=profile">Perfil</a>
        </nav>

 





        <!-- Ações -->
        <div class="header-actions">
            <?php if (isset($_SESSION['user'])): ?>
                <span class="welcome">Olá, <?= htmlspecialchars($_SESSION['user']['name']) ?>!</span>
                <a href="logout.php" class="btn-logout">Sair</a>
            <?php else: ?>
                <a href="index.php" class="btn-login">Entrar</a>
            <?php endif; ?>

            <!-- Botão Dark Mode -->
            <button id="toggle-dark" class="btn-dark">🌙</button>
        </div>
    </div>
</header>
<script src="<?= BASE_URL ?>/assets/js/cart.js"></script>
<script>
// Toggle dark mode
document.addEventListener("DOMContentLoaded", () => {
    const toggleDark = document.getElementById("toggle-dark");
    toggleDark.addEventListener("click", () => {
        document.body.classList.toggle("dark");
        document.querySelector(".header").classList.toggle("dark");
        document.querySelector(".footer").classList.toggle("dark");

        // Atualiza o ícone
        if (document.body.classList.contains("dark")) {
            toggleDark.textContent = "☀️";
        } else {
            toggleDark.textContent = "🌙";
        }
    });
});
</script>
</body>
<style>
/* HEADER */
.header {
    background: #ffffff;
    border-bottom: 1px solid #ddd;
    padding: 15px 0;
    font-family: Arial, sans-serif;
    position: sticky;
    top: 0;
    z-index: 1000;
}

.header.dark {
    background: #1e1e1e;
    border-bottom: 1px solid #333;
}

.header-container {
    width: 90%;
    max-width: 1200px;
    margin: auto;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.header-logo h2 {
    margin: 0;
    font-size: 22px;
    color: #007bff;
}

.header-logo a {
    text-decoration: none;
}

.header-nav a {
    margin: 0 10px;
    text-decoration: none;
    font-size: 15px;
    color: #555;
    transition: color 0.3s;
}

.header-nav a:hover {
    color: #007bff;
}

.header.dark .header-nav a {
    color: #ddd;
}

.header-actions {
    display: flex;
    align-items: center;
    gap: 10px;
}

.welcome {
    font-size: 14px;
    color: #555;
}

.btn-login,
.btn-logout {
    background: #007bff;
    color: #fff;
    padding: 6px 14px;
    border-radius: 6px;
    text-decoration: none;
    font-size: 14px;
    transition: background 0.3s;
}

.btn-login:hover,
.btn-logout:hover {
    background: #0056b3;
}

/* Dark Mode Button */
.btn-dark {
    background: none;
    border: none;
    font-size: 18px;
    cursor: pointer;
    transition: transform 0.3s;
}

.btn-dark:hover {
    transform: rotate(20deg);
}
.modal {
  position: fixed;
  top: 0; left: 0;
  width: 100%; height: 100%;
  background: rgba(0,0,0,0.6);
  display: flex;
  justify-content: center;
  align-items: center;
}
.modal-content {
  background: #fff;
  padding: 20px;
  border-radius: 10px;
  width: 500px;
  max-height: 80vh;
  overflow-y: auto;
  box-shadow: 0 5px 15px rgba(0,0,0,0.3);
}
.close {
  float: right;
  font-size: 22px;
  cursor: pointer;
}
</style>

