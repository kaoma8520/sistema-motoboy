<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}
require_once __DIR__ . '/../../config/database.php';
$sql = "SELECT * FROM whatsapp_notifications ORDER BY created_at DESC LIMIT 100";
$notificacoes = $pdo->query($sql)->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head><meta charset="UTF-8"><title>Notificações WhatsApp</title></head>
<body>
    <h2>Notificações WhatsApp</h2>
    <table border="1"><tr><th>ID</th><th>Número</th><th>Mensagem</th><th>Status</th><th>Enviada em</th><th>Resposta</th></tr>
    <?php foreach($notificacoes as $n): ?>
    <tr>
        <td><?= $n['id'] ?></td>
        <td><?= htmlspecialchars($n['numero']) ?></td>
        <td><?= htmlspecialchars($n['mensagem']) ?></td>
        <td><?= $n['status'] ?></td>
        <td><?= $n['sent_at'] ?></td>
        <td><?= htmlspecialchars(substr($n['response'],0,100)) ?></td>
    </tr>
    <?php endforeach; ?>
    </table>
    <a href="index.php">Voltar</a>
</body>
</html>
