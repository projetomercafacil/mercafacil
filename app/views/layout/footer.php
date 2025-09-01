<style>
    .bottom-nav {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        display: flex;
        justify-content: space-around;
        align-items: center;
        background: #fff;
        border-top: 1px solid #ddd;
        padding: 8px 0;
        z-index: 1000;
    }

    .bottom-nav a {
        text-decoration: none;
        color: #444;
        font-size: 12px;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 4px;
        transition: all 0.2s ease;
    }

    .bottom-nav a svg {
        width: 22px;
        height: 22px;
        stroke: #444;
        transition: stroke 0.2s ease;
    }

    .bottom-nav a.active {
        color: #007bff;
        font-weight: bold;
    }

    .bottom-nav a.active svg {
        stroke: #007bff;
    }
</style>

<div class="bottom-nav">
    <a href="router.php?page=dashboard" class="<?= ($_GET['page'] ?? '') === 'dashboard' ? 'active' : '' ?>">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M3 9.5L12 3l9 6.5V21a1 1 0 0 1-1 1h-5v-6H9v6H4a1 1 0 0 1-1-1V9.5z"/>
        </svg>
        <span>Início</span>
    </a>
    <a href="router.php?page=products" class="<?= ($_GET['page'] ?? '') === 'products' ? 'active' : '' ?>">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M3 3h18v4H3zM3 7h18v13H3z"/>
        </svg>
        <span>Produtos</span>
    </a>
    <a href="router.php?page=favorites" class="<?= ($_GET['page'] ?? '') === 'favorites' ? 'active' : '' ?>">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M12 21l-1.5-1.3C5 15 2 12 2 8.5A5.5 5.5 0 0 1 12 5a5.5 5.5 0 0 1 10 3.5c0 3.5-3 6.5-8.5 11.2L12 21z"/>
        </svg>
        <span>Favoritos</span>
    </a>
    <a href="router.php?page=profile" class="<?= ($_GET['page'] ?? '') === 'profile' ? 'active' : '' ?>">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <circle cx="12" cy="7" r="4"/>
            <path d="M5.5 21a8.38 8.38 0 0 1 13 0"/>
        </svg>
        <span>Perfil</span>
    </a>
</div>
