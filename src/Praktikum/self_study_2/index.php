<?php
declare(strict_types=1);

header('Content-Type: text/html; charset=utf-8');

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require_once __DIR__ . '/App/Core/Router.php';
require_once __DIR__ . '/App/Core/DebugHelper.php';
require_once __DIR__ . '/App/Core/BaseController.php';
require_once __DIR__ . '/App/Core/AuthHelper.php';
require_once __DIR__ . '/App/Controller/ApiController.php';

spl_autoload_register(function (string $class): void {
    foreach (['Core', 'Controller', 'Model'] as $dir) {
        $file = __DIR__ . "/App/$dir/$class.php";
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

$router   = new Router();
$segments = $router->getRouteSegments();
$route    = $segments[0] ?? '';

try {
    // [T3] Route dispatcher.
    switch ($route) {
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
        case 'login':
            $controller = new LoginController();
            break;
        case 'logout':
            $controller = new LogoutController();
            break;
        case 'api':
            $controller  = new ApiController();
            $apiResource = $segments[1] ?? '';
            $apiId       = isset($segments[2]) ? (int) $segments[2] : 0;
            break;
        default:
            http_response_code(404);
            echo '<h1>404 - Seite nicht gefunden</h1>';
            exit;
    }

    if ($route === 'api') {
        // [T3] Pass API args to controller.
        /** @var ApiController $controller */
        $controller->handleRequest($apiResource, $apiId);
    } else {
        $controller->handleRequest();
    }

} catch (Exception $e) {
    http_response_code(500);
    echo '<div style="background:#f8d7da; color:#721c24; padding:12px; border-radius:4px; margin:20px;">';
    echo '<h1>Unerwarteter Fehler</h1>';
    echo '<p>' . htmlspecialchars($e->getMessage()) . '</p>';
    echo '</div>';
}
