<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}
require_once __DIR__ . '/../../config/database.php';

// Total de entregas
$total = $pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn();
// Total entregue
$concluidos = $pdo->query("SELECT COUNT(*) FROM orders WHERE status = 'CONCLUIDO'")->fetchColumn();
// Receita total
$receita = $pdo->query("SELECT SUM(price) FROM orders WHERE status = 'CONCLUIDO'")->fetchColumn();
// Top entregadores
$top = $pdo->query("SELECT u.name, COUNT(o.id) as total FROM orders o JOIN users u ON o.deliverer_id = u.id WHERE o.status = 'CONCLUIDO' GROUP BY o.deliverer_id ORDER BY total DESC LIMIT 5")->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>body{font-family:Arial;margin:40px;} .box{display:inline-block;width:200px;padding:20px;margin:10px;border:1px solid #ccc;text-align:center;}</style>
</head>
<body>
    <h2>Dashboard Administrativo</h2>
    <div class="box"><strong>Total de Entregas</strong><br><?= $total ?></div>
    <div class="box"><strong>Entregas Concluídas</strong><br><?= $concluidos ?></div>
    <div class="box"><strong>Receita Total</strong><br>R$ <?= number_format($receita,2,',','.') ?></div>
    <div class="box"><strong>Top Entregadores</strong><br>
        <ul>
        <?php foreach($top as $t) echo '<li>'.htmlspecialchars($t['name']).' ('.$t['total'].')</li>'; ?>
        </ul>
    </div>
    <canvas id="grafico" width="600" height="200"></canvas>
    <script>
    fetch('dados_grafico.php').then(r=>r.json()).then(d=>{
        new Chart(document.getElementById('grafico'), {
            type: 'line',
            data: { labels: d.labels, datasets: [{ label: 'Entregas por dia', data: d.data, borderColor: '#36a2eb', fill: false }] },
        });
    });
    </script>
    <a href="index.php">Voltar</a>
</body>
</html>
