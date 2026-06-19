<?php

class OrderingModel extends BaseModel
{
    public function createOrder(string $adresse): int
    {
        $adresse = $this->db->real_escape_string($adresse);

        if (!$this->db->query("INSERT INTO ordering (address) VALUES ('$adresse')")) {
            die('Fehler beim Erstellen der Bestellung: ' . $this->db->error);
        }

        return (int) $this->db->insert_id;
    }

    public function addOrderedArticle(int $ordering_id, int $article_id): void
    {
        $ordering_id = intval($ordering_id);
        $article_id  = intval($article_id);

        if (!$this->db->query("INSERT INTO ordered_article (ordering_id, article_id) VALUES ($ordering_id, $article_id)")) {
            die('Fehler beim Hinzufügen des Artikels: ' . $this->db->error);
        }
    }

    public function getAllOrders(): array
    {
        $result = $this->db->query(
            'SELECT o.ordering_id AS id, o.address, o.ordering_time,
                    GROUP_CONCAT(a.name) AS articles,
                    GROUP_CONCAT(oa.ordered_article_id) AS article_ids
             FROM ordering o
             LEFT JOIN ordered_article oa ON o.ordering_id = oa.ordering_id
             LEFT JOIN article a ON oa.article_id = a.article_id
             GROUP BY o.ordering_id, o.address, o.ordering_time
             ORDER BY o.ordering_id DESC'
        );

        if (!$result) {
            die('Fehler beim Abrufen der Bestellungen: ' . $this->db->error);
        }

        $orders = [];
        while ($row = $result->fetch_assoc()) {
            $orders[] = [
                'id' => (int) $row['id'],
                'address' => $row['address'],
                'ordering_time' => $row['ordering_time'],
                'articles' => $row['articles'],
                'article_ids' => $row['article_ids'],
            ];
        }
        
        return $orders;
    }

    public function getOrderById(int $id): ?array
    {
        $id     = intval($id);
        $result = $this->db->query(
            "SELECT ordering_id AS id, address, ordering_time FROM ordering WHERE ordering_id = $id"
        );

        if (!$result) {
            die('Fehler beim Abrufen der Bestellung: ' . $this->db->error);
        }

        $row = $result->fetch_assoc();
        return $row ? [
            'id' => (int) $row['id'],
            'address' => $row['address'],
            'ordering_time' => $row['ordering_time'],
        ] : null;
    }

    public function getOrderedArticles(int $ordering_id): array
    {
        $ordering_id = intval($ordering_id);
        $result      = $this->db->query(
            "SELECT oa.ordered_article_id AS id, a.article_id, a.name, a.price, oa.status
             FROM ordered_article oa
             JOIN article a ON oa.article_id = a.article_id
             WHERE oa.ordering_id = $ordering_id"
        );

        if (!$result) {
            die('Fehler beim Abrufen der Bestellartikel: ' . $this->db->error);
        }

        $articles = [];
        while ($row = $result->fetch_assoc()) {
            $articles[] = $row;
        }

        return $articles;
    }

    public function updateArticleStatus(int $article_id, int $status): void
    {
        $article_id = intval($article_id);
        $status     = intval($status);

        if (!$this->db->query("UPDATE ordered_article SET status = $status WHERE ordered_article_id = $article_id")) {
            die('Fehler beim Aktualisieren des Artikels: ' . $this->db->error);
        }
    }

    public function updateOrderArticlesStatus(int $ordering_id, int $status): void
    {
        $ordering_id = intval($ordering_id);
        $status      = intval($status);

        if (!$this->db->query("UPDATE ordered_article SET status = $status WHERE ordering_id = $ordering_id")) {
            die('Fehler beim Aktualisieren des Bestellstatus: ' . $this->db->error);
        }
    }

    public function deleteOrder(int $id): void
    {
        $id = intval($id);

        if (!$this->db->query("DELETE FROM ordered_article WHERE ordering_id = $id")) {
            die('Fehler beim Löschen der Bestellartikel: ' . $this->db->error);
        }

        if (!$this->db->query("DELETE FROM ordering WHERE ordering_id = $id")) {
            die('Fehler beim Löschen der Bestellung: ' . $this->db->error);
        }
    }

    public function getReadyOrders(): array
    {
        $result = $this->db->query(
            'SELECT o.ordering_id AS id, o.address, o.ordering_time,
                    COUNT(oa.ordered_article_id) AS article_count
             FROM ordering o
             JOIN ordered_article oa ON o.ordering_id = oa.ordering_id
             GROUP BY o.ordering_id, o.address, o.ordering_time
             HAVING COUNT(oa.ordered_article_id) > 0
                AND MIN(COALESCE(oa.status, 0)) = 2
                AND MAX(COALESCE(oa.status, 0)) = 2
             ORDER BY o.ordering_id ASC'
        );

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
