<?php
require_once __DIR__ . '/../../config/database.php';

class StatusController {
    // Atualiza o status da entrega
    public static function updateStatus($order_id, $status) {
        global $pdo;
        $sql = "UPDATE orders SET status = ?, updated_at = NOW() WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$status, $order_id]);
    }

    // Conclui a entrega e distribui ganhos
    public static function concluirEntrega($order_id) {
        global $pdo;
        // Atualiza status
        self::updateStatus($order_id, 'CONCLUIDO');
        // Busca valores
        $sql = "SELECT deliverer_id, price FROM orders WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$order_id]);
        $order = $stmt->fetch();
        if ($order) {
            $ganho_entregador = $order['price'] * 0.8;
            $sql2 = "UPDATE wallets SET balance = balance + ? WHERE user_id = ?";
            $stmt2 = $pdo->prepare($sql2);
            $stmt2->execute([$ganho_entregador, $order['deliverer_id']]);
            return true;
        }
        return false;
    }
}
