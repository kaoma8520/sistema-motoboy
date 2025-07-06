<?php
require_once __DIR__ . '/../../src/Controllers/AuthController.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $senha = $_POST['senha'] ?? '';
    $telefone = trim($_POST['telefone'] ?? '');
    if ($nome && $email && $senha) {
        $ok = AuthController::register($nome, $email, $senha, 'deliverer', $telefone);
        if ($ok) {
            header('Location: login.php');
            exit;
        } else {
            $erro = 'Erro ao cadastrar. E-mail já utilizado?';
        }
    } else {
        $erro = 'Preencha todos os campos corretamente.';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro Entregador</title>
    <style>body{font-family:Arial;margin:40px;}form{max-width:300px;margin:auto;}input{width:100%;margin-bottom:10px;padding:8px;}</style>
</head>
<body>
    <h2>Cadastro Entregador</h2>
    <?php if (!empty($erro)) echo '<p style="color:red">'.$erro.'</p>'; ?>
    <form method="POST">
        <input type="text" name="nome" placeholder="Nome" required>
        <input type="email" name="email" placeholder="E-mail" required>
        <input type="password" name="senha" placeholder="Senha" required>
        <input type="text" name="telefone" placeholder="Telefone">
        <button type="submit">Cadastrar</button>
    </form>
    <a href="login.php">Já tenho conta</a>
</body>
</html>
