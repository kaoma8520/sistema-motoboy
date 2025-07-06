<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'deliverer') {
    header('Location: login.php');
    exit;
}
require_once __DIR__ . '/../../config/database.php';
$sql = "SELECT o.*, u.name as cliente FROM orders o LEFT JOIN users u ON o.client_id = u.id WHERE o.deliverer_id = ? ORDER BY o.created_at DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute([$_SESSION['user_id']]);
$pedidos = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head><meta charset="UTF-8"><title>Histórico de Entregas</title></head>
<body>
    <h2>Histórico de Entregas</h2>
    <table border="1"><tr><th>ID</th><th>Cliente</th><th>Status</th><th>Valor</th><th>Data</th></tr>
    <?php foreach($pedidos as $p): ?>
    <tr>
        <td><?= $p['id'] ?></td>
        <td><?= htmlspecialchars($p['cliente']) ?></td>
        <td><?= $p['status'] ?></td>
        <td>R$ <?= number_format($p['price'],2,',','.') ?></td>
        <td><?= $p['created_at'] ?></td>
    </tr>
    <?php endforeach; ?>
    </table>
    <a href="index.php">Voltar</a>
</body>
</html>
