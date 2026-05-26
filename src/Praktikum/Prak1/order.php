<?php
header("Content-type: text/html; charset=UTF-8");
$title = 'Pizzaservice - Bestellung';
require_once __DIR__ . '/partials/head.php';
require_once __DIR__ . '/partials/nav.php';
?>
<header>
    <h1>Pizzaservice</h1>
</header>
<main>
    <section>
        <h2>Speisekarte</h2>
        <article>
            <h3 class="visually-hidden">Margherita</h3>
            <img src="assets/images/margherita.jpg" alt="Pizza Margherita" width="200" height="200">
            <p><strong>Margherita</strong> - 4,00 €</p>
        </article>
        <article>
            <h3 class="visually-hidden">Salami</h3>
            <img src="assets/images/salami.jpg" alt="Pizza Salami" width="200" height="200">
            <p><strong>Salami</strong> - 4,50 €</p>
        </article>
        <article>
            <h3 class="visually-hidden">Prosciutto</h3>
            <img src="assets/images/hawaii.jpg" alt="Pizza Prosciutto" width="200" height="200">
            <p><strong>Prosciutto</strong> - 4,80 €</p>
        </article>
        <article>
            <h3 class="visually-hidden">Tonno</h3>
            <img src="assets/images/hawaii.jpg" alt="Pizza Tonno" width="200" height="200">
            <p><strong>Tonno</strong> - 5,00 €</p>
        </article>
    </section>

    <hr>

    <section>
        <h2>Warenkorb</h2>
        <form action="https://echo.hofmann-thomas.de/" method="post">
            <select name="pizzen[]" size="5" multiple tabindex="0">
                <option value="margherita">Margherita</option>
                <option value="salami">Salami</option>
                <option value="prosciutto">Prosciutto</option>
                <option value="tonno">Tonno</option>
            </select>
            <p>Gesamtpreis: 14,50 €</p>

            <p>
                <label for="adresse">Lieferadresse:</label><br>
                <input type="text" id="adresse" name="adresse" placeholder="Ihre Adresse..." required>
            </p>

            <div>
                <button type="button" tabindex="1">Alle Löschen</button>
                <button type="button" tabindex="2">Auswahl Löschen</button>
                <button type="submit" tabindex="3">Bestellen</button>
            </div>
        </form>
    </section>
</main>
<?php
require_once __DIR__ . '/partials/footer.php';
?>