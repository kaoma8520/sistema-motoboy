<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'deliverer') {
    header('Location: login.php');
    exit;
}
require_once __DIR__ . '/../../config/database.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $area = trim($_POST['area'] ?? '');
    if ($area) {
        $sql = "INSERT INTO deliverer_areas (deliverer_id, area) VALUES (?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_SESSION['user_id'], $area]);
    }
}
$sql = "SELECT area FROM deliverer_areas WHERE deliverer_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$_SESSION['user_id']]);
$areas = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head><meta charset="UTF-8"><title>Áreas de Atuação</title></head>
<body>
    <h2>Minhas Áreas de Atuação</h2>
    <form method="POST">
        <input type="text" name="area" placeholder="Ex: Centro, Zona Sul" required>
        <button type="submit">Adicionar</button>
    </form>
    <ul>
    <?php foreach($areas as $a) echo '<li>'.htmlspecialchars($a['area']).'</li>'; ?>
    </ul>
    <a href="index.php">Voltar</a>
</body>
</html>
