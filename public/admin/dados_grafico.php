<?php
require_once __DIR__ . '/../../config/database.php';
$dados = $pdo->query("SELECT DATE(created_at) as dia, COUNT(*) as total FROM orders GROUP BY dia ORDER BY dia DESC LIMIT 15")->fetchAll();
$labels = array_reverse(array_column($dados, 'dia'));
$data = array_reverse(array_column($dados, 'total'));
echo json_encode(['labels'=>$labels,'data'=>$data]);
