<?php
session_start();
require_once __DIR__ . '/../../src/Controllers/StatusController.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'deliverer') {
    header('Location: ../client/login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'])) {
    $order_id = (int) $_POST['order_id'];
    // Aqui você pode validar se o entregador está logado e autorizado
    $status = StatusController::updateStatus($order_id, 'EM_ROTA');
    if ($status) {
        echo '<h3>Pedido aceito! Agora está em rota.</h3>';
    } else {
        echo '<p style="color:red">Erro ao atualizar status do pedido.</p>';
    }
    echo '<a href="index.php">Voltar</a>';
} else {
    header('Location: index.php');
    exit;
}
