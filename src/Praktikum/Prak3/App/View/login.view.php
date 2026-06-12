<?php include __DIR__ . '/partials/head.php'; ?>
<div class="container">
    <?php include __DIR__ . '/partials/header.php'; ?>
    <?php include __DIR__ . '/partials/navigation.php'; ?>

    <main>
        <h1>Login</h1>

        <?php if (!empty($_GET['logout'])): ?>
            <p style="padding: 12px; background: #e8f5e9; border-radius: 4px; margin-bottom: 16px;">Du wurdest abgemeldet.</p>
        <?php endif; ?>

        <?php if (!empty($message)): ?>
            <p style="padding: 12px; background: #fdecea; border-radius: 4px; margin-bottom: 16px;"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>

        <form method="post" action="<?= Router::generateUrl('login') ?>" style="max-width: 420px; padding: 18px; border: 1px solid #ddd; border-radius: 6px; background: #fafafa;">
            <input type="hidden" name="redirect" value="<?= htmlspecialchars($redirect ?? 'baker') ?>">
            <input type="hidden" name="role" value="<?= htmlspecialchars($role ?? 'baker') ?>">

            <p style="margin-bottom: 16px;">Login als <?= htmlspecialchars($role ?? 'baker') ?></p>

            <label style="display:block; margin-bottom: 8px;">Benutzername</label>
            <input type="text" name="username" required style="width:100%; padding: 8px; margin-bottom: 14px;">

            <label style="display:block; margin-bottom: 8px;">Passwort</label>
            <input type="password" name="password" required style="width:100%; padding: 8px; margin-bottom: 18px;">

            <button type="submit" style="padding: 10px 16px; background: #333; color: white; border: 0; border-radius: 4px;">Anmelden</button>
        </form>

        <p style="margin-top: 16px;">Testzugang: <strong>baker / baker123</strong> oder <strong>driver / driver123</strong></p>
    </main>
</div>
<?php include __DIR__ . '/partials/footer.php'; ?>