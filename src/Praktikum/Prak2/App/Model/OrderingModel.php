<?php

class OrderingModel extends BaseModel {
    
    public function createOrder($adresse) {
        $adresse = $this->db->real_escape_string($adresse);
        
        $query = "INSERT INTO ordering (address) VALUES ('$adresse')";
        
        if (!$this->db->query($query)) {
            die('Fehler beim Erstellen der Bestellung: ' . $this->db->error);
        }
        
        return $this->db->insert_id;
    }
    
    public function addOrderedArticle($ordering_id, $article_id) {
        $ordering_id = intval($ordering_id);
        $article_id = intval($article_id);
        
        $query = "INSERT INTO ordered_article (ordering_id, article_id) VALUES ($ordering_id, $article_id)";
        
        if (!$this->db->query($query)) {
            die('Fehler beim Hinzufügen des Artikels: ' . $this->db->error);
        }
        
        return true;
    }
    
    public function getAllOrders() {
        $query = "SELECT o.ordering_id as id, o.address, o.ordering_time, GROUP_CONCAT(a.name) as articles, GROUP_CONCAT(oa.ordered_article_id) as article_ids
                  FROM ordering o
                  LEFT JOIN ordered_article oa ON o.ordering_id = oa.ordering_id
                  LEFT JOIN article a ON oa.article_id = a.article_id
                  GROUP BY o.ordering_id, o.address, o.ordering_time
                  ORDER BY o.ordering_id DESC";
        
        $result = $this->db->query($query);
        
        if (!$result) {
            die('Fehler beim Abrufen der Bestellungen: ' . $this->db->error);
        }
        
        $orders = [];
        while ($row = $result->fetch_assoc()) {
            $orders[] = $row;
        }
        
        return $orders;
    }
    
    public function getOrderById($id) {
        $id = intval($id);
        
        $query = "SELECT ordering_id as id, address, ordering_time FROM ordering WHERE ordering_id = $id";
        $result = $this->db->query($query);
        
        if (!$result) {
            die('Fehler beim Abrufen der Bestellung: ' . $this->db->error);
        }
        
        return $result->fetch_assoc();
    }
    
    public function updateOrderStatus($id, $status) {
        // Ordering table doesn't have a status column in this schema
        // This is a placeholder for future use
        return true;
    }
    
    public function getOrderedArticles($ordering_id) {
        $ordering_id = intval($ordering_id);
        
        $query = "SELECT oa.ordered_article_id as id, a.article_id, a.name, a.price, oa.status FROM ordered_article oa
                  JOIN article a ON oa.article_id = a.article_id
                  WHERE oa.ordering_id = $ordering_id";
        
        $result = $this->db->query($query);
        
        if (!$result) {
            die('Fehler beim Abrufen der Bestellartikel: ' . $this->db->error);
        }
        
        $articles = [];
        while ($row = $result->fetch_assoc()) {
            $articles[] = $row;
        }
        
        return $articles;
    }
    
    public function updateArticleStatus($article_id, $status) {
        $article_id = intval($article_id);
        $status = intval($status);
        
        $query = "UPDATE ordered_article SET status = $status WHERE ordered_article_id = $article_id";
        
        if (!$this->db->query($query)) {
            die('Fehler beim Aktualisieren des Artikels: ' . $this->db->error);
        }
        
        return true;
    }

    public function updateOrderArticlesStatus($ordering_id, $status) {
        $ordering_id = intval($ordering_id);
        $status = intval($status);

        $query = "UPDATE ordered_article SET status = $status WHERE ordering_id = $ordering_id";

        if (!$this->db->query($query)) {
            die('Fehler beim Aktualisieren des Bestellstatus: ' . $this->db->error);
        }

        return true;
    }
    
    public function deleteOrder($id) {
        $id = intval($id);
        
        // Zunächst alle Bestellartikel löschen
        $query = "DELETE FROM ordered_article WHERE ordering_id = $id";
        if (!$this->db->query($query)) {
            die('Fehler beim Löschen der Bestellartikel: ' . $this->db->error);
        }
        
        // Dann die Bestellung löschen
        $query = "DELETE FROM ordering WHERE ordering_id = $id";
        if (!$this->db->query($query)) {
            die('Fehler beim Löschen der Bestellung: ' . $this->db->error);
        }
        
        return true;
    }
    
    public function getReadyOrders() {
        $query = "SELECT o.ordering_id as id, o.address, o.ordering_time, COUNT(oa.ordered_article_id) as article_count
                  FROM ordering o
                  JOIN ordered_article oa ON o.ordering_id = oa.ordering_id
                  GROUP BY o.ordering_id, o.address, o.ordering_time
                  HAVING COUNT(oa.ordered_article_id) > 0
                     AND MIN(COALESCE(oa.status, 0)) = 2
                     AND MAX(COALESCE(oa.status, 0)) = 2
                  ORDER BY o.ordering_id ASC";
        
        $result = $this->db->query($query);
        
        if (!$result) {
            die('Fehler beim Abrufen der Bestellungen: ' . $this->db->error);
        }
        
        $orders = [];
        while ($row = $result->fetch_assoc()) {
            $orders[] = $row;
        }
        
        return $orders;
    }
}
