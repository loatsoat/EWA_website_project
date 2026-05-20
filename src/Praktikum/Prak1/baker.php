<?php
header("Content-type: text/html; charset=UTF-8");
$title = 'Pizzaservice - Bäcker';
require_once __DIR__ . '/partials/head.php';
require_once __DIR__ . '/partials/nav.php';
?>
<h1>Pizzabäcker Übersicht</h1>
<form action="https://echo.hofmann-thomas.de/" method="post">
    <section>
        <h2>Offene Bestellungen</h2>
        <article>
            <h3 class="visually-hidden">Bestellung 1</h3>
            <p>Salami Pizza - Bestellt</p>
            <label><input type="radio" name="pizza1" value="bestellt" checked> Bestellt</label>
            <label><input type="radio" name="pizza1" value="im_ofen"> Im Ofen</label>
            <label><input type="radio" name="pizza1" value="fertig"> Fertig</label>
        </article>
        <article>
            <h3 class="visually-hidden">Bestellung 2</h3>
            <p>Margherita Pizza - Im Ofen</p>
            <label><input type="radio" name="pizza2" value="bestellt"> Bestellt</label>
            <label><input type="radio" name="pizza2" value="im_ofen" checked> Im Ofen</label>
            <label><input type="radio" name="pizza2" value="fertig"> Fertig</label>
        </article>
    </section>
    <br>
    <button type="submit">Status aktualisieren</button>
</form>
<?php
require_once __DIR__ . '/partials/footer.php';
?>