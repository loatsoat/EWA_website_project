<?php

class BakerController extends BaseController
{
    private OrderingModel $orderingModel;

    public function __construct()
    {
        require_once __DIR__ . '/../Model/OrderingModel.php';
        $this->orderingModel = new OrderingModel();
    }

    protected function getData(): array
    {
        $orders = $this->orderingModel->getAllOrders();

        foreach ($orders as &$order) {
            $order['articles'] = $this->orderingModel->getOrderedArticles($order['id']);
        }
        unset($order);

        return $orders;
    }

    protected function processData(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }

        foreach ($_POST as $key => $value) {
            if (strpos($key, 'article_') === 0) {
                $article_id = (int) str_replace('article_', '', $key);
                $this->orderingModel->updateArticleStatus($article_id, (int) $value);
            }
        }

        header('Location: ' . Router::generateUrl('baker'));
        exit;
    }

    public function generateResponse(): string
    {
        ob_start();
        $this->renderHtml('baker.view.php', ['orders' => $this->getData()]);
        return ob_get_clean();
    }

    public function handleRequest(): void
    {
        AuthHelper::requireRole('baker');
        $this->processData();
        echo $this->generateResponse();
    }
}
