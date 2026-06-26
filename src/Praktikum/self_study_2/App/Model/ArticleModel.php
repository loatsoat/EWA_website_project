<?php

class ArticleModel extends BaseModel
{
    public function getAllArticles(): array
    {
        $result = $this->db->query(
            'SELECT article_id AS id, name, picture, price FROM article ORDER BY article_id ASC'
        );

        if (!$result) {
            die('Fehler beim Abrufen der Artikel: ' . $this->db->error);
        }

        $articles = [];
        while ($row = $result->fetch_assoc()) {
            $articles[] = $row;
        }

        return $articles;
    }

    public function getArticleById(int $id): ?array
    {
        $id     = intval($id);
        $result = $this->db->query(
            "SELECT article_id AS id, name, picture, price FROM article WHERE article_id = $id"
        );

        if (!$result) {
            die('Fehler beim Abrufen des Artikels: ' . $this->db->error);
        }

        return $result->fetch_assoc() ?: null;
    }
}
