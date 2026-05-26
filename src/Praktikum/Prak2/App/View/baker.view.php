<?php include __DIR__ . '/partials/head.php'; ?>
<div class="container">
    <?php include __DIR__ . '/partials/header.php'; ?>
    <?php include __DIR__ . '/partials/navigation.php'; ?>
    
    <main>
        <h1>Pizzabäcker - Bestellungsübersicht</h1>
        
        <form method="post" action="<?= Router::generateUrl('baker') ?>">
            <?php if (!empty($orders)): ?>
                <?php foreach ($orders as $order): ?>
                    <section style="border: 1px solid #ddd; padding: 15px; margin-bottom: 20px; border-radius: 5px; background-color: #f9f9f9;">
                        <h2>Bestellung #<?= $order['id'] ?></h2>
                        
                        <article style="margin: 15px 0;">
                            <h3 class="visually-hidden">Bestellartikel</h3>
                            <?php if (!empty($order['articles'])): ?>
                                <?php foreach ($order['articles'] as $article): ?>
                                    <div style="border-left: 4px solid #333; padding: 10px; margin-bottom: 10px; background-color: white;">
                                        <p><strong><?= htmlspecialchars($article['name']) ?></strong></p>
                                        <p style="margin: 10px 0;">Status:</p>
                                        <div>
                                            <label style="margin-right: 15px;">
                                                <input type="radio" name="article_<?= $article['id'] ?>" value="0" <?= ($article['status'] == 0 || $article['status'] === NULL) ? 'checked' : '' ?>>
                                                Bestellt
                                            </label>
                                            <label style="margin-right: 15px;">
                                                <input type="radio" name="article_<?= $article['id'] ?>" value="1" <?= $article['status'] == 1 ? 'checked' : '' ?>>
                                                Im Ofen
                                            </label>
                                            <label>
                                                <input type="radio" name="article_<?= $article['id'] ?>" value="2" <?= $article['status'] == 2 ? 'checked' : '' ?>>
                                                Fertig
                                            </label>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </article>
                    </section>
                <?php endforeach; ?>
                
                <div style="text-align: right;">
                    <button type="submit" style="padding: 10px 20px; background-color: #333; color: white; border: none; border-radius: 3px; cursor: pointer;">Status speichern</button>
                </div>
            <?php else: ?>
                <p style="padding: 20px; background-color: #fff3cd; border-radius: 4px;">
                    Keine offenen Bestellungen
                </p>
            <?php endif; ?>
        </form>
    </main>
</div>
<?php include __DIR__ . '/partials/footer.php'; ?>
