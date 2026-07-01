const statusMap = {
    0: "Bestellt",
    1: "Im Ofen",
    2: "Fertig",
    3: "Unterwegs"
};

function process(data) {
    const container = document.getElementById("order");
    if (!container) return;

    container.innerHTML = "";

    if (!data.order) {
        const p = document.createElement("p");
        p.textContent = "Keine aktuelle Bestellung vorhanden.";
        container.appendChild(p);
        return;
    }

    const order    = data.order;
    const articles = Array.isArray(data.articles) ? data.articles : [];

    const section = document.createElement("section");

    const h2 = document.createElement("h2");
    h2.textContent = "Ihre aktuelle Bestellung";
    section.appendChild(h2);

    const article = document.createElement("article");
    article.style.cssText = "border:1px solid #ddd; padding:15px; margin-bottom:15px; border-radius:5px; background-color:#f9f9f9;";

    const h3Hidden = document.createElement("h3");
    h3Hidden.className = "visually-hidden";
    h3Hidden.textContent = "Bestellinformation";
    article.appendChild(h3Hidden);

    const pNr = document.createElement("p");
    const strongNr = document.createElement("strong");
    strongNr.textContent = "Bestellnummer: ";
    pNr.appendChild(strongNr);
    pNr.appendChild(document.createTextNode("#" + order.id));
    article.appendChild(pNr);

    const pAddr = document.createElement("p");
    const strongAddr = document.createElement("strong");
    strongAddr.textContent = "Lieferadresse: ";
    pAddr.appendChild(strongAddr);
    pAddr.appendChild(document.createTextNode(order.address));
    article.appendChild(pAddr);

    section.appendChild(article);

    const h3Articles = document.createElement("h3");
    h3Articles.textContent = "Bestellte Artikel";
    section.appendChild(h3Articles);

    const ul = document.createElement("ul");
    ul.style.cssText = "list-style:none; padding:0;";

    if (articles.length > 0) {
        articles.forEach(function (a) {
            const price  = parseFloat(a.price || 0)
                .toLocaleString("de-DE", { minimumFractionDigits: 2, maximumFractionDigits: 2 });
            const status = statusMap[parseInt(a.status, 10)] ?? "Unbekannt";

            const li = document.createElement("li");
            li.style.cssText = "padding:10px; border-bottom:1px solid #eee;";

            li.appendChild(document.createTextNode(a.name + " \u2013 " + price + " \u20ac "));

            const span = document.createElement("span");
            span.style.cssText = "color:#666; font-size:12px;";
            span.textContent = "(Status: " + status + ")";
            li.appendChild(span);

            ul.appendChild(li);
        });
    } else {
        const li = document.createElement("li");
        li.style.cssText = "padding:10px;";
        li.textContent = "Keine Artikel in dieser Bestellung";
        ul.appendChild(li);
    }

    section.appendChild(ul);
    container.appendChild(section);
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
