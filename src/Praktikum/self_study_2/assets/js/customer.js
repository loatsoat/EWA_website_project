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
        container.innerHTML =
            'Keine aktuelle Bestellung vorhanden.</p>';
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
                    a.name + " \u2013 " + price + " \u20ac" +
                        "(Status: " + status + ")" +
                    "</span>" +
                "</li>";
        });
    } else {
        rows = '<li style="padding:10px;">Keine Artikel in dieser Bestellung</li>';
    }

    container.innerHTML =
        "<section>" +
            "<h2>Ihre aktuelle Bestellung</h2>" +
            '<article style="border:1px solid #ddd; padding:15px; margin-bottom:15px;' +
                ' border-radius:5px; background-color:#f9f9f9;">' +
                '<h3 class="visually-hidden">Bestellinformation</h3>' +
                "<p><strong>Bestellnummer:</strong> #" + order.id + "</p>" +
                "<p><strong>Lieferadresse:</strong> " + order.address + "</p>" +
            "</article>" +
            "<h3>Bestellte Artikel</h3>" +
            '<ul style="list-style:none; padding:0;">' + rows + "</ul>" +
        "</section>";
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
