<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../client/login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Painel Admin</title>
    <style>
        body { font-family: Arial; margin: 40px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ccc; padding: 8px; }
    </style>
</head>
<body>
    <h2>Painel Administrativo</h2>
    <table>
        <tr><th>ID</th><th>Cliente</th><th>Entregador</th><th>Status</th><th>Valor</th></tr>
        <tr><td>123</td><td>João</td><td>Maria</td><td>PAGO</td><td>R$ 25,00</td></tr>
        <!-- Aqui listaria os pedidos reais -->
    </table>
    <a href="dashboard.php">Dashboard</a>
    <a href="financeiro.php">Painel Financeiro</a>
    <a href="notificacoes.php">Notificações WhatsApp</a>
    <a href="logout.php" style="display:block;margin:20px auto 0;width:fit-content;">Sair</a>
</body>
</html>
