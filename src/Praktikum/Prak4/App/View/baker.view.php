<?php include __DIR__ . '/partials/head.php'; ?>
<div class="container">
    <?php include __DIR__ . '/partials/header.php'; ?>
    <?php include __DIR__ . '/partials/navigation.php'; ?>

    <main>
        <h1>Pizzabäcker - Bestellungsübersicht</h1>

        <form method="post" action="<?= Router::generateUrl('baker') ?>" id="baker-form">
            <?php if (!empty($orders)): ?>
                <?php foreach ($orders as $order): ?>
                    <section class="order-card">
                        <h2>Bestellung #<?= (int) $order['id'] ?></h2>

                        <article class="order-articles">
                            <h3>Bestellartikel</h3>
                            <?php if (!empty($order['articles'])): ?>
                                <?php foreach ($order['articles'] as $article): ?>
                                    <div class="article-item">
                                        <p><strong><?= htmlspecialchars($article['name']) ?></strong></p>
                                        <p>Status:</p>
                                        <div class="status-options">
                                            <label>
                                                <input type="radio" class="auto-submit" name="article_<?= (int) $article['id'] ?>" value="0" <?= ($article['status'] == 0 || $article['status'] === null) ? 'checked' : '' ?>>
                                                Bestellt
                                            </label>
                                            <label>
                                                <input type="radio" class="auto-submit" name="article_<?= (int) $article['id'] ?>" value="1" <?= $article['status'] == 1 ? 'checked' : '' ?>>
                                                Im Ofen
                                            </label>
                                            <label>
                                                <input type="radio" class="auto-submit" name="article_<?= (int) $article['id'] ?>" value="2" <?= $article['status'] == 2 ? 'checked' : '' ?>>
                                                Fertig
                                            </label>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </article>
                    </section>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="alert-empty">
                    Keine offenen Bestellungen
                </p>
            <?php endif; ?>
        </form>
    </main>
</div>

<script>
    const form   = document.getElementById("baker-form");
    const radios = form.querySelectorAll(".auto-submit");

    radios.forEach(radio => {
        radio.addEventListener("click", () => {
            form.submit();
        });
    });
</script>

<?php include __DIR__ . '/partials/footer.php'; ?>