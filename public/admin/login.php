<?php
require_once __DIR__ . '/../../src/Controllers/AuthController.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $senha = $_POST['senha'] ?? '';
    $user = AuthController::login($email, $senha);
    if ($user && $user['role'] === 'admin') {
        header('Location: index.php');
        exit;
    } else {
        $erro = 'E-mail ou senha inválidos ou não é admin.';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login Admin</title>
    <style>body{font-family:Arial;margin:40px;}form{max-width:300px;margin:auto;}input{width:100%;margin-bottom:10px;padding:8px;}</style>
</head>
<body>
    <h2>Login Admin</h2>
    <?php if (!empty($erro)) echo '<p style="color:red">'.$erro.'</p>'; ?>
    <form method="POST">
        <input type="email" name="email" placeholder="E-mail" required>
        <input type="password" name="senha" placeholder="Senha" required>
        <button type="submit">Entrar</button>
    </form>
</body>
</html>
