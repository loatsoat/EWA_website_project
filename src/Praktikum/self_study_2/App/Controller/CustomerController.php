<?php
declare(strict_types=1);

class CustomerController extends BaseController
{
    private OrderingModel $orderingModel;

    public function __construct()
    {
        require_once __DIR__ . '/../Model/OrderingModel.php';
        $this->orderingModel = new OrderingModel();
    }

    protected function getData(): array
    {
        $orderId  = (int) ($_SESSION['customer_order_id'] ?? 0);
        $order    = $orderId > 0 ? $this->orderingModel->getOrderById($orderId) : null;
        $articles = $order ? $this->orderingModel->getOrderedArticles($order['id']) : [];

        return ['order' => $order, 'articles' => $articles];
    }

    public function generateResponse(): string
    {
        $data = $this->getData();

        ob_start();
        $this->renderHtml('customer.view.php', [
            'order'    => $data['order'],
            'articles' => $data['articles'],
            'message'  => (string) ($_GET['message'] ?? ''),
        ]);
        return ob_get_clean();
    }

    public function handleRequest(): void
    {
        echo $this->generateResponse();
    }
}
