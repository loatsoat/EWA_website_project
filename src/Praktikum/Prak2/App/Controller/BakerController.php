<?php

class BakerController extends BaseController {
    
    private $orderingModel;
    
    public function __construct() {
        require_once __DIR__ . '/../Model/OrderingModel.php';
        $this->orderingModel = new OrderingModel();
    }
    
    protected function getData() {
        $orders = $this->orderingModel->getAllOrders();

        foreach ($orders as &$order) {
            $order['articles'] = $this->orderingModel->getOrderedArticles($order['id']);
        }
        unset($order);

        return $orders;
    }

    protected function processData() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Verarbeite Statusänderungen für Artikel
            foreach ($_POST as $key => $value) {
                if (strpos($key, 'article_') === 0) {
                    $article_id = str_replace('article_', '', $key);
                    $this->orderingModel->updateArticleStatus($article_id, $value);
                }
            }
            
            header('Location: ' . Router::generateUrl('baker'));
            exit;
        }
    }
    
    public function generateResponse(): string {
        $orders = $this->getData();

        ob_start();
        $this->renderHtml('baker.view.php', [
            'orders' => $orders
        ]);
        return ob_get_clean();
    }

    public function handleRequest(): void {
        $this->processData();
        echo $this->generateResponse();
    }
}
