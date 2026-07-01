<?php include __DIR__ . '/partials/head.php'; ?>
<div class="container">
    <?php include __DIR__ . '/partials/header.php'; ?>
    <?php include __DIR__ . '/partials/navigation.php'; ?>

    <main>
        <h1>Fahrer - Auslieferungsübersicht</h1>

        <form method="post" action="<?= Router::generateUrl('driver') ?>" id="driver-form">
            <?php if (!empty($orders)): ?>
                <?php foreach ($orders as $order): ?>
                    <article class="order-card">
                        <h3>Bestellung #<?= (int) $order['id'] ?></h3>

                        <p><strong>Adresse:</strong> <?= htmlspecialchars($order['address']) ?></p>
                        <p><strong>Anzahl Artikel:</strong> <?= (int) $order['article_count'] ?></p>

                        <p><strong>Lieferstatus:</strong></p>
                        <div class="status-options">
                            <label>
                                <input type="radio" class="auto-submit" name="order_<?= (int) $order['id'] ?>" value="3" <?= (int) $order['status'] === 3 ? 'checked' : '' ?>>
                                Unterwegs
                            </label>
                            <label>
                                <input type="radio" class="auto-submit" name="order_<?= (int) $order['id'] ?>" value="delivered">
                                Geliefert (löschen)
                            </label>
                        </div>
                    </article>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="alert-empty">Keine Bestellungen zur Auslieferung bereit</p>
            <?php endif; ?>
        </form>
    </main>
</div>

<script>
    const form   = document.getElementById("driver-form");
    const radios = form.querySelectorAll(".auto-submit");

    radios.forEach(radio => {
        radio.addEventListener("click", () => {
            form.submit();
        });
    });
</script>

<?php include __DIR__ . '/partials/footer.php'; ?>
