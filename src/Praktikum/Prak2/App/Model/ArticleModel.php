<?php

class ArticleModel extends BaseModel {
    
    public function getAllArticles() {
        $query = "SELECT article_id as id, name, picture, price FROM article ORDER BY article_id ASC";
        $result = $this->db->query($query);
        
        if (!$result) {
            die('Fehler beim Abrufen der Artikel: ' . $this->db->error);
        }
        
        $articles = [];
        while ($row = $result->fetch_assoc()) {
            $articles[] = $row;
        }
        
        return $articles;
    }
    
    public function getArticleById($id) {
        $query = "SELECT article_id as id, name, picture, price FROM article WHERE article_id = " . intval($id);
        $result = $this->db->query($query);
        
        if (!$result) {
            die('Fehler beim Abrufen des Artikels: ' . $this->db->error);
        }
        
        return $result->fetch_assoc();
    }
}
