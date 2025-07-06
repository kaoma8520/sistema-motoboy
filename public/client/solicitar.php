<?php
require_once __DIR__ . '/../../src/Controllers/OrderController.php';
require_once __DIR__ . '/../../src/Controllers/PaymentController.php';
require_once __DIR__ . '/../../config/database.php';
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'client') {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitização básica
    $origem_lat = filter_input(INPUT_POST, 'origem_lat', FILTER_VALIDATE_FLOAT);
    $origem_lng = filter_input(INPUT_POST, 'origem_lng', FILTER_VALIDATE_FLOAT);
    $destino_lat = filter_input(INPUT_POST, 'destino_lat', FILTER_VALIDATE_FLOAT);
    $destino_lng = filter_input(INPUT_POST, 'destino_lng', FILTER_VALIDATE_FLOAT);
    $peso = filter_input(INPUT_POST, 'peso', FILTER_VALIDATE_FLOAT);
    $pagamento = $_POST['pagamento'] === 'CARTAO' ? 'CARTAO' : 'PIX';
    $client_id = $_SESSION['user_id']; // Usa o id do usuário logado

    $order = OrderController::createOrder($client_id, $origem_lat, $origem_lng, $destino_lat, $destino_lng, $peso);
    if (isset($order['error'])) {
        echo '<p style="color:red">' . htmlspecialchars($order['error']) . '</p>';
        exit;
    }
    $valor_final = PaymentController::calcularValorFinal($order['price'], $pagamento);
    // Aplica desconto se cupom válido
    if (!empty($_POST['cupom'])) {
        $cupom = trim($_POST['cupom']);
        $sql = "SELECT discount FROM coupons WHERE code = ? AND (expires_at IS NULL OR expires_at > NOW())";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$cupom]);
        $desc = $stmt->fetchColumn();
        if ($desc) {
            $valor_final = $valor_final * (1 - $desc/100);
            echo '<p>Cupom aplicado: -'.(float)$desc.'%</p>';
        }
    }
    $payment_id = PaymentController::createPayment($order['order_id'], $client_id, $pagamento, $valor_final);
    echo '<h3>Pedido criado!</h3>';
    echo '<p>Valor: R$ ' . number_format($valor_final, 2, ',', '.') . '</p>';
    echo '<p>Status: Aguardando pagamento...</p>';
    // Aqui você pode simular a confirmação automática para testes:
    // PaymentController::confirmPayment($payment_id);
    // echo '<p>Pagamento confirmado! Entregador notificado.</p>';
} else {
    header('Location: index.php');
    exit;
}
