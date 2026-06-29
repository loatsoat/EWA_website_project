<nav class="site-nav">
    <a href="<?= Router::generateUrl('order') ?>"><i class="fa-solid fa-clipboard-list"></i> Bestellung</a>
    <a href="<?= Router::generateUrl('customer') ?>"><i class="fa-solid fa-user"></i> Kunde</a>
    <a href="<?= Router::generateUrl('baker') ?>"><i class="fa-solid fa-fire-burner"></i> Pizzabäcker</a>
    <a href="<?= Router::generateUrl('driver') ?>"><i class="fa-solid fa-truck"></i> Fahrer</a>
    <?php if (AuthHelper::isLoggedIn()): ?>
        <span>Angemeldet als <?= htmlspecialchars(AuthHelper::getRole()) ?></span>
        <a href="<?= Router::generateUrl('logout') ?>"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
    <?php endif; ?>
</nav>
