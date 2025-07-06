<?php
require_once __DIR__ . '/../../config/database.php';

class PaymentController {
    // Cria um registro de pagamento (mock para PIX ou cartão)
    public static function createPayment($order_id, $user_id, $method, $amount) {
        global $pdo;
        $status = 'PENDENTE';
        $transaction_id = uniqid('tx_');
        $sql = "INSERT INTO payments (order_id, user_id, method, amount, status, transaction_id) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$order_id, $user_id, $method, $amount, $status, $transaction_id]);
        return $pdo->lastInsertId();
    }

    // Confirma pagamento (simulação de webhook)
    public static function confirmPayment($payment_id) {
        global $pdo;
        $sql = "UPDATE payments SET status = 'CONFIRMADO' WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$payment_id]);
        // Atualiza status do pedido
        $sql2 = "UPDATE orders SET status = 'PAGO' WHERE id = (SELECT order_id FROM payments WHERE id = ?)";
        $stmt2 = $pdo->prepare($sql2);
        $stmt2->execute([$payment_id]);
        return true;
    }

    // Calcula valor final com taxa de cartão
    public static function calcularValorFinal($valor, $metodo) {
        if ($metodo === 'CARTAO') {
            return round($valor * 1.06, 2); // acréscimo de 6%
        }
        return $valor;
    }
}
