<?php $pageScripts = ['assets/js/script.js']; ?>
<?php include __DIR__ . '/partials/head.php'; ?>
<div class="container">
    <?php include __DIR__ . '/partials/header.php'; ?>
    <?php include __DIR__ . '/partials/navigation.php'; ?>

    <main>
        <section>
            <h2>Speisekarte</h2>
            <div class="menu-grid">
                <?php foreach ($articles as $article): ?>
                    <article
                        class="menu-item"
                        data-id="<?= (int) $article['id'] ?>"
                        data-name="<?= htmlspecialchars($article['name']) ?>"
                        data-price="<?= htmlspecialchars($article['price']) ?>">
                        
                        <h3><?= htmlspecialchars($article['name']) ?></h3>
                        <img
                            src="<?= htmlspecialchars($article['picture']) ?>"
                            alt="Pizza <?= htmlspecialchars($article['name']) ?>"
                            width="180" height="180">
                        <p><strong><?= htmlspecialchars($article['name']) ?></strong></p>
                        <p><?= number_format((float) $article['price'], 2, ',', '.') ?> €</p>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>

        <hr>

        <section>
            <h2>Warenkorb</h2>
            <form method="post" action="<?= Router::generateUrl('order') ?>" id="order-form">
                <div>

                    <div>
                        <label for="adresse">Lieferadresse</label><br>
                        <input type="text" id="adresse" name="adresse" placeholder="Adresse eingeben">
                    </div>

                    <div>
                        <strong>Auswahl</strong>
                        <div id="cart-items">
                            <p id="cart-empty">Noch keine Pizza ausgewählt.</p>
                        </div>
                    </div>

                    <p>
                        Gesamtpreis: <span id="total-price">0,00</span> €
                    </p>

                    <div id="hidden-order-fields"></div>

                    <div>
                        <button type="button" id="clear-selection">Auswahl löschen</button>
                        <button type="button" id="clear-all">Alles löschen</button>
                        <button type="submit" id="order-submit" disabled>Bestellen</button>
                    </div>

                </div>
            </form>
        </section>
    </main>
</div>
<?php include __DIR__ . '/partials/footer.php'; ?>