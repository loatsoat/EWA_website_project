<?php
header("Content-type: text/html; charset=UTF-8");
$title = 'Pizzaservice - Kundenstatus';
require_once __DIR__ . '/partials/head.php';
require_once __DIR__ . '/partials/nav.php';
?>
<h1>Ihre Bestellung</h1>
<section>
    <article>
        <h2 class="visually-hidden">Bestellposition 1</h2>
        <p>Salami Pizza: <strong>Im Ofen</strong></p>
    </article>
    <article>
        <h2 class="visually-hidden">Bestellposition 2</h2>
        <p>Cola: <strong>Bestellt</strong></p>
    </article>
</section>
<p>Diese Seite aktualisiert sich bald automatisch...</p>
<?php
require_once __DIR__ . '/partials/footer.php';
?>