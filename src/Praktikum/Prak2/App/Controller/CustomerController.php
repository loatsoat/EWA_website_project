<?php
declare(strict_types=1);

require_once __DIR__ . '/../Core/BaseController.php';

class CustomerController extends BaseController {
    
    private $orderingModel;
    
    public function __construct() {
        require_once __DIR__ . '/../Model/OrderingModel.php';
        $this->orderingModel = new OrderingModel();
    }
    
    protected function getData() {
        $orders = $this->orderingModel->getAllOrders();
        $order = $orders ? $orders[0] : null;
        $articles = $order ? $this->orderingModel->getOrderedArticles($order['id']) : [];

        return [
            'order' => $order,
            'articles' => $articles,
        ];
    }

    protected function processData() {
    }

    public function generateResponse(): string {
        $data = $this->getData();
        $order = $data['order'];
        $articles = $data['articles'];

        $message = isset($_GET['message']) ? $_GET['message'] : '';

        ob_start();
        $this->renderHtml('customer.view.php', [
            'order' => $order,
            'articles' => $articles,
            'message' => $message
        ]);
        return ob_get_clean();
    }

    public function handleRequest(): void {
        $this->processData();
        echo $this->generateResponse();
    }
}
