<?php
require_once __DIR__ . '/../../config/database.php';
class RatingController {
    public static function avaliar($order_id, $client_id, $deliverer_id, $rating, $comment = null) {
        global $pdo;
        $sql = "INSERT INTO ratings (order_id, client_id, deliverer_id, rating, comment) VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$order_id, $client_id, $deliverer_id, $rating, $comment]);
    }
    public static function mediaEntregador($deliverer_id) {
        global $pdo;
        $sql = "SELECT AVG(rating) as media FROM ratings WHERE deliverer_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$deliverer_id]);
        return $stmt->fetchColumn();
    }
}
