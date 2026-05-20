<?php
header("Content-type: text/html; charset=UTF-8");
$title = 'Pizza Service - Übersicht';
require_once __DIR__ . '/partials/head.php';
require_once __DIR__ . '/partials/nav.php';
?>
<h1>Übersicht Pizzaservice</h1>
<ul>
    <li><a href="order.php">Bestellung</a></li>
    <li><a href="customer.php">Kunde</a></li>
    <li><a href="baker.php">Pizzabäcker</a></li>
    <li><a href="driver.php">Fahrer</a></li>
</ul>
<?php
require_once __DIR__ . '/partials/footer.php';
?>