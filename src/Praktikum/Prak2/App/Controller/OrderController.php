<?php

class OrderController extends BaseController {
    
    private $articleModel;
    private $orderingModel;
    private $articles = [];
    
    public function __construct() {
        require_once __DIR__ . '/../Model/ArticleModel.php';
        require_once __DIR__ . '/../Model/OrderingModel.php';
        
        $this->articleModel = new ArticleModel();
        $this->orderingModel = new OrderingModel();
    }
    
    public function getData() {
        return $this->articleModel->getAllArticles();
    }
    
    public function processData() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pizzen'])) {
            $adresse = isset($_POST['adresse']) ? trim((string)$_POST['adresse']) : '';
            $articles = is_array($_POST['pizzen']) ? array_map('intval', $_POST['pizzen']) : [];
            $articles = array_values(array_filter($articles, function ($id) {
                return $id > 0;
            }));
            $quantities = isset($_POST['menge']) && is_array($_POST['menge']) ? $_POST['menge'] : [];

            if ($adresse === '' || empty($articles)) {
                return;
            }
            
            // Bestellung erstellen
            $ordering_id = $this->orderingModel->createOrder($adresse);
            
            // Artikel hinzufügen
            foreach ($articles as $article_id) {
                $qty = isset($quantities[$article_id]) ? intval($quantities[$article_id]) : 1;
                $qty = max(1, min(20, $qty));

                for ($i = 0; $i < $qty; $i++) {
                    $this->orderingModel->addOrderedArticle($ordering_id, $article_id);
                }
            }
            
            // Weiterleitung nach erfolgreichem Speichern (PRG-Pattern)
            header('Location: ' . Router::generateUrl('customer') . '?message=success');
            exit;
        }
    }
    
    public function generateResponse(): string {
        $articles = $this->getData();
        
        ob_start();
        $this->renderHtml('order.view.php', [
            'articles' => $articles
        ]);
        return ob_get_clean();
    }

    public function handleRequest(): void {
        $this->processData();
        echo $this->generateResponse();
    }
}
