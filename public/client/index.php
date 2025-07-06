<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'client') {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Solicitar Entrega</title>
    <style>
        body { font-family: Arial; margin: 40px; }
        form { max-width: 400px; margin: auto; }
        input, select { width: 100%; margin-bottom: 10px; padding: 8px; }
        button { padding: 10px 20px; }
    </style>
</head>
<body>
    <h2>Solicitar Entrega</h2>
    <form method="POST" action="solicitar.php">
        <input type="text" name="origem_lat" placeholder="Latitude de origem" required>
        <input type="text" name="origem_lng" placeholder="Longitude de origem" required>
        <input type="text" name="destino_lat" placeholder="Latitude de destino" required>
        <input type="text" name="destino_lng" placeholder="Longitude de destino" required>
        <input type="number" name="peso" placeholder="Peso (kg)" step="0.1" required>
        <select name="pagamento">
            <option value="PIX">PIX</option>
            <option value="CARTAO">Cartão</option>
        </select>
        <input type="text" name="cupom" placeholder="Cupom de desconto">
        <button type="submit">Solicitar</button>
    </form>
    <a href="mapa_entrega.php">Acompanhar Entrega (Exemplo)</a>
    <a href="avaliar.php">Avaliar Entregador (Exemplo)</a>
    <a href="historico.php">Histórico de Pedidos</a>
    <a href="logout.php" style="display:block;margin:20px auto 0;width:fit-content;">Sair</a>
</body>
</html>
