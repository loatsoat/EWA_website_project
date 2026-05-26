<?php

class DriverController extends BaseController {
    
    private $orderingModel;
    
    public function __construct() {
        require_once __DIR__ . '/../Model/OrderingModel.php';
        $this->orderingModel = new OrderingModel();
    }
    
    protected function getData() {
        return $this->orderingModel->getReadyOrders();
    }

    protected function processData() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Verarbeite Statusänderungen für Bestellungen
            foreach ($_POST as $key => $value) {
                if (strpos($key, 'order_') === 0) {
                    $order_id = str_replace('order_', '', $key);

                    if ($value === '3') {
                        // Setze alle Artikel der Bestellung auf "unterwegs"
                        $this->orderingModel->updateOrderArticlesStatus($order_id, 3);
                    } elseif ($value === 'delivered') {
                        // Lösche die Bestellung wenn geliefert
                        $this->orderingModel->deleteOrder($order_id);
                    }
                }
            }
            
            header('Location: ' . Router::generateUrl('driver'));
            exit;
        }
    }
    
    public function generateResponse(): string {
        $orders = $this->getData();

        ob_start();
        $this->renderHtml('driver.view.php', [
            'orders' => $orders
        ]);
        return ob_get_clean();
    }

    public function handleRequest(): void {
        $this->processData();
        echo $this->generateResponse();
    }
}
