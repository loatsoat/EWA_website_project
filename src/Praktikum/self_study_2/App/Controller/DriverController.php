<?php

class DriverController extends BaseController
{
    private OrderingModel $orderingModel;

    public function __construct()
    {
        // [T3] Driver uses the order model.
        require_once __DIR__ . '/../Model/OrderingModel.php';
        $this->orderingModel = new OrderingModel();
    }

    protected function getData(): array
    {
        // [T3] Show ready orders only.
        return $this->orderingModel->getReadyOrders();
    }

    protected function processData(): void
    {
        // [T3] Handle POST status updates.
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }

        foreach ($_POST as $key => $value) {
            if (strpos($key, 'order_') !== 0) {
                continue;
            }

            $order_id = (int) str_replace('order_', '', $key);

            if ((int) $value === 3) {
                $this->orderingModel->updateOrderArticlesStatus($order_id, 3);
            } elseif ($value === 'delivered') {
                $this->orderingModel->deleteOrder($order_id);
            }
        }

        header('Location: ' . Router::generateUrl('driver'));
        exit;
    }

    public function generateResponse(): string
    {
        ob_start();
        $this->renderHtml('driver.view.php', ['orders' => $this->getData()]);
        return ob_get_clean();
    }

    public function handleRequest(): void
    {
        // [T3] Require driver session.
        AuthHelper::requireRole('driver');
        $this->processData();
        echo $this->generateResponse();
    }
}
