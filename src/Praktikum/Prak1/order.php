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
            <img src="https://tse1.mm.bing.net/th/id/OIP.224fHzqozDU-VkgYGg9HOQHaHa?rs=1&pid=ImgDetMain&o=7&rm=3" alt="Pizza Margherita" width="200" height="200">
            <p><strong>Margherita</strong> - 4,00 €</p>
        </article>
        <article>
            <h3 class="visually-hidden">Salami</h3>
            <img src="https://as2.ftcdn.net/v2/jpg/00/15/12/49/1000_F_15124931_H15Eb1L1s0oDxTAhzxcFDxgv8xyn07k8.jpg" alt="Pizza Salami" width="200" height="200">
            <p><strong>Salami</strong> - 4,50 €</p>
        </article>
        <article>
            <h3 class="visually-hidden">Prosciutto</h3>
            <img src="https://c8.alamy.com/comp/2FKW21R/isolated-prosciutto-pizza-with-tomato-sauce-2FKW21R.jpg" alt="Pizza Prosciutto" width="200" height="200">
            <p><strong>Prosciutto</strong> - 4,80 €</p>
        </article>
        <article>
            <h3 class="visually-hidden">Tonno</h3>
            <img src="https://media.istockphoto.com/photos/italian-pizza-al-tonno-mozzarella-tomato-tuna-on-white-background-picture-id185407849?k=6&m=185407849&s=612x612&w=0&h=l1DRRJE3gbihLxfwKmSp5GF4hiC53cNPn7OfAH-8FKA=" alt="Pizza Tonno" width="200" height="200">
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