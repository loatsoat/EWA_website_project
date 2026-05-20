<?php
header("Content-type: text/html; charset=UTF-8");
$title = 'Pizzaservice - Fahrer';
require_once __DIR__ . '/partials/head.php';
require_once __DIR__ . '/partials/nav.php';
?>
<h1>Fahrer Übersicht</h1>
<form action="https://echo.hofmann-thomas.de/" method="post">
    <section>
        <h2>Bereit zur Auslieferung</h2>
        <article>
            <h3 class="visually-hidden">Lieferung 1</h3>
            <p><strong>Kunde: Max Mustermann</strong><br>
            Hauptstraße 10, Darmstadt<br>
            Status: Fertig</p>
            <label><input type="radio" name="order1" value="fertig" checked> Fertig</label>
            <label><input type="radio" name="order1" value="unterwegs"> Unterwegs</label>
            <label><input type="radio" name="order1" value="geliefert"> Geliefert</label>
        </article>
    </section>
    <br>
    <button type="submit">Status aktualisieren</button>
</form>
<?php
require_once __DIR__ . '/partials/footer.php';
?>