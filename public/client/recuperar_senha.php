<?php
require_once __DIR__ . '/../../src/Helpers/EmailHelper.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    if ($email) {
        // Gera token simples
        $token = bin2hex(random_bytes(16));
        file_put_contents(__DIR__.'/../../tmp/token_'.$token, $email);
        $link = 'http://localhost/client/resetar_senha.php?token='.$token;
        EmailHelper::enviar($email, 'Recuperação de senha', 'Clique para resetar: <a href="'.$link.'">'.$link.'</a>');
        echo '<p>Instruções enviadas para seu e-mail.</p>';
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head><meta charset="UTF-8"><title>Recuperar Senha</title></head>
<body>
    <h2>Recuperar Senha</h2>
    <form method="POST">
        <input type="email" name="email" placeholder="Seu e-mail" required>
        <button type="submit">Enviar</button>
    </form>
    <a href="login.php">Voltar</a>
</body>
</html>
