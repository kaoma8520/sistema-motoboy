<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'deliverer') {
    header('Location: login.php');
    exit;
}
require_once __DIR__ . '/../../config/database.php';
$sql = "SELECT balance FROM wallets WHERE user_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$_SESSION['user_id']]);
$saldo = $stmt->fetchColumn();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head><meta charset="UTF-8"><title>Painel Financeiro</title></head>
<body>
    <h2>Painel Financeiro</h2>
    <p>Saldo disponível: <strong>R$ <?= number_format($saldo,2,',','.') ?></strong></p>
    <a href="index.php">Voltar</a>
</body>
</html>
