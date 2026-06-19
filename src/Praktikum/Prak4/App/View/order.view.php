<?php include __DIR__ . '/partials/head.php'; ?>
<div class="container">
    <?php include __DIR__ . '/partials/header.php'; ?>
    <?php include __DIR__ . '/partials/navigation.php'; ?>
    
    <main>
        <section>
            <h2>Speisekarte</h2>
            <div class="menu-grid" style="display: grid; gap: 12px; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));">
                <?php foreach ($articles as $article): ?>
                    <article class="menu-item" data-id="<?= (int) $article['id'] ?>" data-name="<?= htmlspecialchars($article['name']) ?>" data-price="<?= htmlspecialchars($article['price']) ?>" style="border: 1px solid #ddd; border-radius: 6px; padding: 12px; cursor: pointer; background: #fff;">
                        <h3 class="visually-hidden"><?= htmlspecialchars($article['name']) ?></h3>
                        <img src="<?= htmlspecialchars($article['picture']) ?>" alt="Pizza <?= htmlspecialchars($article['name']) ?>" width="180" height="180" style="display:block; width:100%; height:auto; object-fit:cover; border-radius: 4px;">
                        <p style="margin: 10px 0 0;"><strong><?= htmlspecialchars($article['name']) ?></strong></p>
                        <p style="margin: 4px 0 0; color: #444;"><?= number_format((float) $article['price'], 2, ',', '.') ?> €</p>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>

        <hr>

        <section>
            <h2>Warenkorb</h2>
            <form method="post" action="<?= Router::generateUrl('order') ?>" id="order-form">
                <div style="display: grid; gap: 14px; max-width: 420px;">
                    <div>
                        <label for="adresse">Lieferadresse</label><br>
                        <input type="text" id="adresse" name="adresse" placeholder="Adresse eingeben" required style="width: 100%; padding: 8px; box-sizing: border-box;">
                    </div>

                    <div>
                        <strong>Auswahl</strong>
                        <div id="cart-items" style="border: 1px solid #ddd; min-height: 72px; padding: 8px; margin-top: 6px; background: #fff;">
                            <p id="cart-empty" style="margin: 0; color: #666;">Noch keine Pizza ausgewählt.</p>
                        </div>
                    </div>

                    <p style="margin: 0; font-size: 1.1rem;">
                        Gesamtpreis: <span id="total-price">0,00</span> €
                    </p>

                    <div id="hidden-order-fields"></div>

                    <div style="display: flex; gap: 8px; flex-wrap: wrap; align-items: center;">
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
 
