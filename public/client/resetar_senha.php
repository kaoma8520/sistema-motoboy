<?php
require_once __DIR__ . '/../../src/Controllers/AuthController.php';
$token = $_GET['token'] ?? '';
$arquivo = __DIR__.'/../../tmp/token_'.$token;
if ($token && file_exists($arquivo)) {
    $email = file_get_contents($arquivo);
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nova = $_POST['nova'] ?? '';
        if ($nova) {
            global $pdo;
            $sql = "UPDATE users SET password = ? WHERE email = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([password_hash($nova, PASSWORD_DEFAULT), $email]);
            unlink($arquivo);
            echo '<p>Senha redefinida!</p><a href="login.php">Login</a>';
            exit;
        }
    }
} else {
    echo '<p>Token inválido ou expirado.</p>';
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head><meta charset="UTF-8"><title>Resetar Senha</title></head>
<body>
    <h2>Resetar Senha</h2>
    <form method="POST">
        <input type="password" name="nova" placeholder="Nova senha" required>
        <button type="submit">Salvar</button>
    </form>
</body>
</html>
