const statusMap = {
    0: "Bestellt",
    1: "Im Ofen",
    2: "Fertig",
    3: "Unterwegs"
};

function process(data) {
    const container = document.getElementById("order");
    if (!container) return;

    if (!data.order) {
        container.innerHTML = '<p class="alert-empty">Keine aktuelle Bestellung vorhanden.</p>';
        return;
    }

    const order    = data.order;
    const articles = data.articles;

    let rows = "";
    if (Array.isArray(articles) && articles.length > 0) {
        articles.forEach(function (a) {
            const price  = parseFloat(a.price || 0)
                .toLocaleString("de-DE", { minimumFractionDigits: 2, maximumFractionDigits: 2 });
            const status = statusMap[parseInt(a.status, 10)] ?? "Unbekannt";

            rows +=
                '<li>' +
                    a.name + " – " + price + " € " +
                    "(Status: " + status + ")" +
                '</li>';
        });
    } else {
        rows = '<li>Keine Artikel in dieser Bestellung</li>';
    }

    container.innerHTML =
        '<section class="order-card">' +
            '<h2>Ihre aktuelle Bestellung</h2>' +
            '<article class="article-item">' +
                '<h3 class="visually-hidden">Bestellinformation</h3>' +
                '<p><strong>Bestellnummer:</strong> #' + order.id + '</p>' +
                '<p><strong>Lieferadresse:</strong> ' + order.address + '</p>' +
            '</article>' +
            '<h3>Bestellte Artikel</h3>' +
            '<ul class="order-list">' + rows + '</ul>' +
        '</section>';
}

async function requestData() {
    try {
        const response = await fetch("api");

        if (!response.ok) {
            throw new Error(`Fehler: ${response.status}`);
        }

        const data = await response.json();
        process(data);
    } catch (error) {
        console.error("Übertragung fehlgeschlagen:", error);
    }
}

document.addEventListener("DOMContentLoaded", () => {
    requestData();
    setInterval(requestData, 2000);
});
