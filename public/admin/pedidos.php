<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../client/login.php');
    exit;
}

require_once __DIR__ . '/../../config/database.php';

$sql = "SELECT o.id, c.name as cliente, d.name as entregador, o.status, o.price FROM orders o
        LEFT JOIN users c ON o.client_id = c.id
        LEFT JOIN users d ON o.deliverer_id = d.id
        ORDER BY o.created_at DESC";
$stmt = $pdo->query($sql);
$pedidos = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Pedidos - Admin</title>
    <style>
        body { font-family: Arial; margin: 40px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ccc; padding: 8px; }
    </style>
</head>
<body>
    <h2>Lista de Pedidos</h2>
    <table>
        <tr><th>ID</th><th>Cliente</th><th>Entregador</th><th>Status</th><th>Valor</th></tr>
        <?php foreach ($pedidos as $p): ?>
        <tr>
            <td><?= htmlspecialchars($p['id']) ?></td>
            <td><?= htmlspecialchars($p['cliente']) ?></td>
            <td><?= htmlspecialchars($p['entregador']) ?></td>
            <td><?= htmlspecialchars($p['status']) ?></td>
            <td>R$ <?= number_format($p['price'], 2, ',', '.') ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <a href="index.php">Voltar</a>
    <a href="logout.php">Sair</a>
</body>
</html>
