<?php

class OrderController extends BaseController
{
    private ArticleModel $articleModel;
    private OrderingModel $orderingModel;

    public function __construct()
    {
        require_once __DIR__ . '/../Model/ArticleModel.php';
        require_once __DIR__ . '/../Model/OrderingModel.php';

        $this->articleModel  = new ArticleModel();
        $this->orderingModel = new OrderingModel();
    }

    protected function getData(): array
    {
        return $this->articleModel->getAllArticles();
    }

    protected function processData(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['pizzen'])) {
            return;
        }

        // [T3] Store current order in session.
        $adresse   = trim((string) ($_POST['adresse'] ?? ''));
        $articles  = is_array($_POST['pizzen']) ? array_values(array_filter(array_map('intval', $_POST['pizzen']), fn($id) => $id > 0)) : [];
        $quantities = is_array($_POST['menge'] ?? null) ? $_POST['menge'] : [];

        if ($adresse === '' || empty($articles)) {
            return;
        }

        $ordering_id = $this->orderingModel->createOrder($adresse);
        $_SESSION['customer_order_id'] = $ordering_id;

        foreach ($articles as $article_id) {
            $qty = max(1, min(20, intval($quantities[$article_id] ?? 1)));
            for ($i = 0; $i < $qty; $i++) {
                $this->orderingModel->addOrderedArticle($ordering_id, $article_id);
            }
        }

        header('Location: ' . Router::generateUrl('customer') . '?message=success');
        exit;
    }

    public function generateResponse(): string
    {
        ob_start();
        $this->renderHtml('order.view.php', ['articles' => $this->getData(), 'includeScript' => true]);
        return ob_get_clean();
    }

    public function handleRequest(): void
    {
        $this->processData();
        echo $this->generateResponse();
    }
}
