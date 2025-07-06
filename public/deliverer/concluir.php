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
    $ok = StatusController::concluirEntrega($order_id);
    if ($ok) {
        echo '<h3>Entrega concluída! Saldo atualizado.</h3>';
    } else {
        echo '<p style="color:red">Erro ao concluir entrega.</p>';
    }
    echo '<a href="index.php">Voltar</a>';
} else {
    header('Location: index.php');
    exit;
}
