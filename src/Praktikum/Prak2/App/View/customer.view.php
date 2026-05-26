<?php include __DIR__ . '/partials/head.php'; ?>
<div class="container">
    <?php include __DIR__ . '/partials/header.php'; ?>
    <?php include __DIR__ . '/partials/navigation.php'; ?>
    
    <main>
        <h1>Kundenstatus</h1>
        
        <?php if ($message === 'success'): ?>
            <div style="background-color: #d4edda; color: #155724; padding: 12px; border-radius: 4px; margin-bottom: 20px;">
                ✓ Bestellung erfolgreich aufgegeben!
            </div>
        <?php endif; ?>
        
        <?php if ($order): ?>
            <section>
                <h2>Ihre aktuelle Bestellung</h2>
                
                <article style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 5px; background-color: #f9f9f9;">
                    <h3 class="visually-hidden">Bestellinformation</h3>
                    <p><strong>Bestellnummer:</strong> #<?= $order['id'] ?></p>
                    <p><strong>Lieferadresse:</strong> <?= htmlspecialchars($order['address']) ?></p>
                </article>
                
                <h3>Bestellte Artikel</h3>
                <ul style="list-style: none; padding: 0;">
                    <?php if (!empty($articles)): ?>
                        <?php foreach ($articles as $article): ?>
                            <li style="padding: 10px; border-bottom: 1px solid #eee;">
                                <?= htmlspecialchars($article['name']) ?> - <?= number_format($article['price'], 2, ',', '.') ?>€
                                <span style="color: #666; font-size: 12px;">
                                    (Status: <?php
                                        $statusMap = [
                                            0 => 'Bestellt',
                                            1 => 'Im Ofen',
                                            2 => 'Fertig',
                                            3 => 'Unterwegs',
                                            null => 'Bestellt'
                                        ];
                                        echo htmlspecialchars($statusMap[$article['status']] ?? 'Bestellt');
                                    ?>)
                                </span>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li style="padding: 10px;">Keine Artikel in dieser Bestellung</li>
                    <?php endif; ?>
                </ul>
            </section>
        <?php else: ?>
            <p style="padding: 20px; background-color: #fff3cd; border-radius: 4px;">
                Keine aktuelle Bestellung vorhanden. <a href="<?= Router::generateUrl('order') ?>">Neue Bestellung aufgeben</a>
            </p>
        <?php endif; ?>
    </main>
</div>
<?php include __DIR__ . '/partials/footer.php'; ?>
