<?php
declare(strict_types=1);

class ApiController extends BaseController
{
    private OrderingModel $orderingModel;

    public function __construct()
    {
        require_once __DIR__ . '/../Model/OrderingModel.php';
        $this->orderingModel = new OrderingModel();
    }

    private function getSessionOrderId(): int
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        return (int) ($_SESSION['customer_order_id'] ?? 0);
    }

    protected function getData(string $resource = '', int $orderId = 0): array
    {
        if ($resource !== '' || $orderId > 0) {
            if ($resource !== 'ordering' || $orderId <= 0) {
                http_response_code(404);
                return ['error' => 'Unbekannte API-Ressource'];
            }

            $sessionOrderId = $this->getSessionOrderId();
            if ($sessionOrderId <= 0 || $sessionOrderId !== $orderId) {
                http_response_code(403);
                return ['error' => 'Zugriff verweigert'];
            }

            $order = $this->orderingModel->getOrderById($orderId);
            return [
                'order'    => $order,
                'articles' => $order ? $this->orderingModel->getOrderedArticles($orderId) : [],
            ];
        }

        $sessionOrderId = $this->getSessionOrderId();
        if ($sessionOrderId <= 0) {
            return ['order' => null, 'articles' => []];
        }

        $order = $this->orderingModel->getOrderById($sessionOrderId);
        return [
            'order'    => $order,
            'articles' => $order ? $this->orderingModel->getOrderedArticles($sessionOrderId) : [],
        ];
    }

    public function generateResponse(string $resource = '', int $orderId = 0): string
    {
        $data = $this->getData($resource, $orderId);
        $this->renderJson($data);
        return '';
    }

    public function handleRequest(string $resource = '', int $orderId = 0): void
    {
        $this->generateResponse($resource, $orderId);
    }
}
