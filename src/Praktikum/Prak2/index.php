<?php
declare(strict_types=1);

header('Content-Type: text/html; charset=utf-8');

// Autoloader für Klassen
spl_autoload_register(function ($class) {
    $file = __DIR__ . '/App/Core/' . $class . '.php';
    if (file_exists($file)) {
        require_once $file;
        return;
    }
    
    $file = __DIR__ . '/App/Controller/' . $class . '.php';
    if (file_exists($file)) {
        require_once $file;
        return;
    }
    
    $file = __DIR__ . '/App/Model/' . $class . '.php';
    if (file_exists($file)) {
        require_once $file;
        return;
    }
});

// Routing light:
// .htaccess rewrites "/something" to "index.php?route=something"
$router = new Router();

try {
    switch ($router->getRoute()) {
        case '':
        case 'order':
            $controller = new OrderController();
            break;
        case 'customer':
            $controller = new CustomerController();
            break;
        case 'baker':
            $controller = new BakerController();
            break;
        case 'driver':
            $controller = new DriverController();
            break;
        default:
            http_response_code(404);
            echo '<h1>404 - Page not found</h1>';
            exit;
    }

    if (!isset($controller)) {
        http_response_code(404);
        throw new Exception('No controller selected for this route.');
    }

    $controller->handleRequest();
} catch (Exception $e) {
    header('Content-type: text/html; charset=UTF-8');
    echo '<div style="background-color: #f8d7da; color: #721c24; padding: 12px; border-radius: 4px; margin: 20px;">';
    echo '<h1>Unexpected error occurred</h1>';
    echo '<p>' . htmlspecialchars($e->getMessage()) . '</p>';
    echo '</div>';
}
