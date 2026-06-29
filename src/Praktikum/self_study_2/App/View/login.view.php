<?php include __DIR__ . '/partials/head.php'; ?>
<div class="container">
    <?php include __DIR__ . '/partials/header.php'; ?>
    <?php include __DIR__ . '/partials/navigation.php'; ?>

    <main>
        <h1>Login</h1>

        <?php if (!empty($_GET['logout'])): ?>
            <p class="alert alert-success">Du wurdest abgemeldet.</p>
        <?php endif; ?>

        <?php if (!empty($message)): ?>
            <p class="alert alert-error"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>

        <form method="post" action="<?= Router::generateUrl('login') ?>" class="login-form">
            <input type="hidden" name="redirect" value="<?= htmlspecialchars($redirect ?? 'baker') ?>">
            <input type="hidden" name="role" value="<?= htmlspecialchars($role ?? 'baker') ?>">

            <p class="form-group">Login als <?= htmlspecialchars($role ?? 'baker') ?></p>

            <div class="form-group">
                <label for="username">Benutzername</label>
                <input type="text" id="username" name="username" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="password">Passwort</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Anmelden</button>
        </form>

        <p>Testzugang: <strong>baker / baker123</strong> oder <strong>driver / driver123</strong></p>
    </main>
</div>
<?php include __DIR__ . '/partials/footer.php'; ?>
