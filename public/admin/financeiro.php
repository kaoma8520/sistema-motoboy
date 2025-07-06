<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}
require_once __DIR__ . '/../../config/database.php';
$sql = "SELECT SUM(balance) as total FROM wallets";
$total = $pdo->query($sql)->fetchColumn();
$sql2 = "SELECT SUM(price)*0.2 as receita FROM orders WHERE status = 'CONCLUIDO'";
$receita = $pdo->query($sql2)->fetchColumn();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head><meta charset="UTF-8"><title>Painel Financeiro Admin</title></head>
<body>
    <h2>Painel Financeiro Admin</h2>
    <p>Total em carteiras de entregadores: <strong>R$ <?= number_format($total,2,',','.') ?></strong></p>
    <p>Receita do sistema (20%): <strong>R$ <?= number_format($receita,2,',','.') ?></strong></p>
    <a href="index.php">Voltar</a>
</body>
</html>
