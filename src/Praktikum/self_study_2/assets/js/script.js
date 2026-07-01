/* Main JavaScript file for Prak4. */

document.addEventListener("DOMContentLoaded", () => {
    // [T4] Order page starts after DOM load.
    const menuItems = document.querySelectorAll('.menu-item');
    const cartItemsElement = document.getElementById('cart-items');
    const cartEmptyElement = document.getElementById('cart-empty');
    const totalElement = document.getElementById('total-price');
    const hiddenFieldsElement = document.getElementById('hidden-order-fields');
    const clearSelectionButton = document.getElementById('clear-selection');
    const clearAllButton = document.getElementById('clear-all');

    if (!menuItems || !cartItemsElement) {
        return;
    }

    const cartState = {};
    let selectedArticleId = null;
    const addressInput = document.getElementById('adresse');
    const submitButton = document.getElementById('order-submit');
    const orderForm = document.getElementById('order-form');

    function formatPrice(price) {
        return Number(price).toLocaleString('de-DE', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

    function calculateTotal() {
        // [T4] Total = price x quantity.
        return Object.values(cartState).reduce((sum, item) => sum + (item.price * item.quantity), 0);
    }

    function renderCart() {
        // [T4] Rebuild cart on every change.
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
                row.className = 'cart-row';
                row.dataset.articleId = item.id;

                const nameElement = document.createElement('strong');
                nameElement.textContent = item.name;

                const quantityText = document.createTextNode(' x ' + item.quantity + ' ');

                const priceElement = document.createElement('span');
                priceElement.className = 'cart-price';
                priceElement.textContent = '(' + formatPrice(item.price * item.quantity) + ' €)';

                row.appendChild(nameElement);
                row.appendChild(quantityText);
                row.appendChild(priceElement);

                if (String(item.id) === String(selectedArticleId)) {
                    row.classList.add('cart-row--selected');
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
            // [T4] Hidden inputs send cart data.
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
        updateSubmitState();
    }

    function updateSubmitState() {
        if (!submitButton) return;

        // [T4] Enable submit only with address and items.
        const hasItems = Object.keys(cartState).length > 0;
        const addressPresent = addressInput && addressInput.value.trim() !== '';

        submitButton.disabled = !(hasItems && addressPresent);
    }

    function addPizza(articleElement) {
        // [T4] Add pizza to cart.
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

    if (addressInput) {
        addressInput.addEventListener('input', updateSubmitState);
    }

    if (clearSelectionButton) {
        clearSelectionButton.addEventListener('click', () => {
            // [T4] Remove one selected item.
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
    }

    if (clearAllButton) {
        clearAllButton.addEventListener('click', () => {
            // [T4] Clear cart.
            Object.keys(cartState).forEach((key) => {
                delete cartState[key];
            });

            selectedArticleId = null;
            renderCart();
        });
    }

    renderCart();
    updateSubmitState();

    if (orderForm) {
        // [T4] Select all options before submit.
        orderForm.addEventListener('submit', () => {
            const selects = orderForm.querySelectorAll('select');
            selects.forEach((sel) => {
                Array.from(sel.options).forEach((opt) => { opt.selected = true; });
            });
        });
    }
});