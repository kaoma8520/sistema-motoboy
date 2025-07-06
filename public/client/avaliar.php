<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'client') {
    header('Location: login.php');
    exit;
}
require_once __DIR__ . '/../../src/Controllers/RatingController.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = (int)$_POST['order_id'];
    $deliverer_id = (int)$_POST['deliverer_id'];
    $rating = (int)$_POST['rating'];
    $comment = trim($_POST['comment'] ?? '');
    RatingController::avaliar($order_id, $_SESSION['user_id'], $deliverer_id, $rating, $comment);
    echo '<h3>Avaliação enviada!</h3><a href="index.php">Voltar</a>';
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head><meta charset="UTF-8"><title>Avaliar Entregador</title></head>
<body>
    <h2>Avaliar Entregador</h2>
    <form method="POST">
        <input type="hidden" name="order_id" value="1"><!-- Substitua pelo pedido real -->
        <input type="hidden" name="deliverer_id" value="2"><!-- Substitua pelo entregador real -->
        <label>Nota (1 a 5): <input type="number" name="rating" min="1" max="5" required></label><br>
        <label>Comentário: <input type="text" name="comment"></label><br>
        <button type="submit">Enviar Avaliação</button>
    </form>
</body>
</html>
