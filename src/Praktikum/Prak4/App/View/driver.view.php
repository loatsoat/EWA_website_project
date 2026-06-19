<?php include __DIR__ . '/partials/head.php'; ?>
<div class="container">
    <?php include __DIR__ . '/partials/header.php'; ?>
    <?php include __DIR__ . '/partials/navigation.php'; ?>
    
    <main>
        <h1>Fahrer - Auslieferungsübersicht</h1>
        
        <form method="post" action="<?= Router::generateUrl('driver') ?>">
            <?php if (!empty($orders)): ?>
                <?php foreach ($orders as $order): ?>
                    <article style="border: 1px solid #ddd; padding: 15px; margin-bottom: 20px; border-radius: 5px; background-color: #f9f9f9;">
                        <h3 class="visually-hidden">Bestellung <?= $order['id'] ?></h3>
                        
                        <p><strong>Bestellung #<?= $order['id'] ?></strong></p>
                        <p><strong>Adresse:</strong> <?= htmlspecialchars($order['address']) ?></p>
                        <p style="margin-bottom: 15px;"><strong>Anzahl Artikel:</strong> <?= $order['article_count'] ?></p>
                        
                        <p style="margin: 10px 0; font-weight: bold;">Lieferstatus:</p>
                        <div>
                            <label style="margin-right: 15px;">
                                <input type="radio" name="order_<?= $order['id'] ?>" value="3">
                                Unterwegs
                            </label>
                            <label>
                                <input type="radio" name="order_<?= $order['id'] ?>" value="delivered">
                                Geliefert (löschen)
                            </label>
                        </div>
                    </article>
                <?php endforeach; ?>
                
                <div style="text-align: right;">
                    <button type="submit" style="padding: 10px 20px; background-color: #333; color: white; border: none; border-radius: 3px; cursor: pointer;">Status aktualisieren</button>
                </div>
            <?php else: ?>
                <p style="padding: 20px; background-color: #fff3cd; border-radius: 4px;">
                    Keine Bestellungen zur Auslieferung bereit
                </p>
            <?php endif; ?>
        </form>
    </main>
</div>
<?php include __DIR__ . '/partials/footer.php'; ?>
