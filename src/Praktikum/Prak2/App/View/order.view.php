<?php include __DIR__ . '/partials/head.php'; ?>
<div class="container">
    <?php include __DIR__ . '/partials/header.php'; ?>
    <?php include __DIR__ . '/partials/navigation.php'; ?>
    
    <main>
        <section>
            <h2>Speisekarte</h2>
            <div class="menu-grid" style="display: grid; gap: 12px; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));">
                <?php foreach ($articles as $article): ?>
                    <article class="menu-item" data-id="<?= (int) $article['id'] ?>" data-name="<?= htmlspecialchars($article['name']) ?>" data-price="<?= htmlspecialchars($article['price']) ?>" style="border: 1px solid #ddd; border-radius: 6px; padding: 12px; cursor: pointer; background: #fff;">
                        <h3 class="visually-hidden"><?= htmlspecialchars($article['name']) ?></h3>
                        <img src="<?= htmlspecialchars($article['picture']) ?>" alt="Pizza <?= htmlspecialchars($article['name']) ?>" width="180" height="180" style="display:block; width:100%; height:auto; object-fit:cover; border-radius: 4px;">
                        <p style="margin: 10px 0 0;"><strong><?= htmlspecialchars($article['name']) ?></strong></p>
                        <p style="margin: 4px 0 0; color: #444;"><?= number_format((float) $article['price'], 2, ',', '.') ?> €</p>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>

        <hr>

        <section>
            <h2>Warenkorb</h2>
            <form method="post" action="<?= Router::generateUrl('order') ?>" id="order-form">
                <div style="display: grid; gap: 14px; max-width: 420px;">
                    <div>
                        <label for="adresse">Lieferadresse</label><br>
                        <input type="text" id="adresse" name="adresse" placeholder="Adresse eingeben" required style="width: 100%; padding: 8px; box-sizing: border-box;">
                    </div>

                    <div>
                        <strong>Auswahl</strong>
                        <div id="cart-items" style="border: 1px solid #ddd; min-height: 72px; padding: 8px; margin-top: 6px; background: #fff;">
                            <p id="cart-empty" style="margin: 0; color: #666;">Noch keine Pizza ausgewählt.</p>
                        </div>
                    </div>

                    <p style="margin: 0; font-size: 1.1rem;">
                        Gesamtpreis: <span id="total-price">0,00</span> €
                    </p>

                    <div id="hidden-order-fields"></div>

                    <div style="display: flex; gap: 8px; flex-wrap: wrap; align-items: center;">
                        <button type="button" id="clear-selection">Auswahl löschen</button>
                        <button type="button" id="clear-all">Alles löschen</button>
                        <button type="submit">Bestellen</button>
                    </div>
                </div>
            </form>
        </section>
    </main>
</div>
<?php include __DIR__ . '/partials/footer.php'; ?>

<script>
    const menuItems = document.querySelectorAll('.menu-item');
    const cartItemsElement = document.getElementById('cart-items');
    const cartEmptyElement = document.getElementById('cart-empty');
    const totalElement = document.getElementById('total-price');
    const hiddenFieldsElement = document.getElementById('hidden-order-fields');
    const clearSelectionButton = document.getElementById('clear-selection');
    const clearAllButton = document.getElementById('clear-all');

    const cartState = {};
    let selectedArticleId = null;

    function formatPrice(price) {
        return Number(price).toLocaleString('de-DE', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

    function calculateTotal() {
        return Object.values(cartState).reduce((sum, item) => sum + (item.price * item.quantity), 0);
    }

    function renderCart() {
        cartItemsElement.innerHTML = '';

        const entries = Object.values(cartState);

        if (entries.length === 0) {
            cartItemsElement.appendChild(cartEmptyElement);
            cartEmptyElement.style.display = 'block';
        } else {
            cartEmptyElement.style.display = 'none';

            entries.forEach((item) => {
                const row = document.createElement('button');
                row.type = 'button';
                row.style.cssText = 'display:block; width:100%; text-align:left; border:0; background:transparent; padding:6px 0; cursor:pointer;';
                row.dataset.articleId = item.id;
                row.innerHTML = '<strong>' + item.name + '</strong> x ' + item.quantity + ' <span style="color:#666;">(' + formatPrice(item.price * item.quantity) + ' €)</span>';

                if (String(item.id) === String(selectedArticleId)) {
                    row.style.background = '#f2f2f2';
                }

                row.addEventListener('click', () => {
                    selectedArticleId = item.id;
                    renderCart();
                });

                cartItemsElement.appendChild(row);
            });
        }

        totalElement.textContent = formatPrice(calculateTotal());

        hiddenFieldsElement.innerHTML = '';
        Object.values(cartState).forEach((item) => {
            const pizzaInput = document.createElement('input');
            pizzaInput.type = 'hidden';
            pizzaInput.name = 'pizzen[]';
            pizzaInput.value = item.id;
            hiddenFieldsElement.appendChild(pizzaInput);

            const quantityInput = document.createElement('input');
            quantityInput.type = 'hidden';
            quantityInput.name = 'menge[' + item.id + ']';
            quantityInput.value = item.quantity;
            hiddenFieldsElement.appendChild(quantityInput);
        });
    }

    function addPizza(articleElement) {
        const id = String(articleElement.dataset.id);
        const name = articleElement.dataset.name;
        const price = parseFloat(articleElement.dataset.price || '0');

        if (!cartState[id]) {
            cartState[id] = { id: id, name: name, price: price, quantity: 0 };
        }

        cartState[id].quantity += 1;
        selectedArticleId = id;
        renderCart();
    }

    menuItems.forEach((item) => {
        item.addEventListener('click', () => addPizza(item));
    });

    clearSelectionButton.addEventListener('click', () => {
        if (!selectedArticleId || !cartState[selectedArticleId]) {
            return;
        }

        cartState[selectedArticleId].quantity -= 1;

        if (cartState[selectedArticleId].quantity <= 0) {
            delete cartState[selectedArticleId];
        }

        const remainingIds = Object.keys(cartState);
        selectedArticleId = remainingIds.length > 0 ? remainingIds[remainingIds.length - 1] : null;
        renderCart();
    });

    clearAllButton.addEventListener('click', () => {
        Object.keys(cartState).forEach((key) => {
            delete cartState[key];
        });

        selectedArticleId = null;
        renderCart();
    });

    renderCart();
</script>
