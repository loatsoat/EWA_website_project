<?php $pageScripts = ['assets/js/customer.js']; // Nur die Kundenseite lädt das Polling für den Live-Status. ?>
<?php include __DIR__ . '/partials/head.php'; ?>
<div class="container">
    <?php include __DIR__ . '/partials/header.php'; ?>
    <?php include __DIR__ . '/partials/navigation.php'; ?>

    <main>
        <h1>Kundenstatus</h1>

        <?php if ($message === 'success'): ?>
            <div class="alert alert-success">Bestellung erfolgreich aufgegeben!</div>
        <?php endif; ?>

        <!-- Der Bestellbereich wird clientseitig aus der API-Antwort aufgebaut. -->
        <div id="order"></div>
    </main>
</div>
<?php include __DIR__ . '/partials/footer.php'; ?>
