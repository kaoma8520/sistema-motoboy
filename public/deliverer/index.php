<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'deliverer') {
    header('Location: ../client/login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Painel do Entregador</title>
    <style>
        body { font-family: Arial; margin: 40px; }
        .pedido { border: 1px solid #ccc; padding: 10px; margin-bottom: 10px; }
    </style>
</head>
<body>
    <h2>Pedidos Disponíveis</h2>
    <!-- Aqui listaria os pedidos em aberto para o entregador aceitar -->
    <div class="pedido">
        <strong>Pedido #123</strong><br>
        Origem: -23.5, -46.6<br>
        Destino: -23.6, -46.7<br>
        <form method="POST" action="aceitar.php">
            <input type="hidden" name="order_id" value="123">
            <button type="submit">Aceitar</button>
        </form>
    </div>
    <h3>Saldo: R$ 0,00</h3>
    <a href="historico.php">Histórico de Entregas</a><br>
    <a href="financeiro.php">Painel Financeiro</a><br>
    <a href="areas.php">Minhas Áreas de Atuação</a><br>
    <a href="logout.php" style="display:block;margin:20px auto 0;width:fit-content;">Sair</a>
</body>
</html>
