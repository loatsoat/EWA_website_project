<?php $pageScripts = ['assets/js/customer.js']; ?>
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

        <div id="order"></div>
    </main>
</div>
<?php include __DIR__ . '/partials/footer.php'; ?>
