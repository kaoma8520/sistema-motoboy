<?php
// Instalador automático do sistema motoboy
session_start();
$erro = '';
$ok = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $host = $_POST['host'] ?? 'localhost';
    $db = $_POST['db'] ?? '';
    $user = $_POST['user'] ?? '';
    $pass = $_POST['pass'] ?? '';
    $admin = $_POST['admin'] ?? '';
    $admin_email = $_POST['admin_email'] ?? '';
    $admin_senha = $_POST['admin_senha'] ?? '';
    try {
        $pdo = new PDO("mysql:host=$host", $user, $pass, [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);
        $pdo->exec("CREATE DATABASE IF NOT EXISTS `$db` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        $pdo->exec("USE `$db`");
        $sql = file_get_contents(__DIR__.'/../sql/create_tables.sql');
        $pdo->exec($sql);
        // Cria admin
        $hash = password_hash($admin_senha, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT IGNORE INTO users (name, email, password, role) VALUES (?, ?, ?, 'admin')");
        $stmt->execute([$admin, $admin_email, $hash]);
        // Gera config/database.php
        $conf = "<?php\n$host = '$host';\n$db = '$db';\n$user = '$user';\n$pass = '$pass';\n$charset = 'utf8mb4';\n$dsn = \"mysql:host=$host;dbname=$db;charset=$charset\";\n$options = [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,PDO::ATTR_EMULATE_PREPARES=>false,];\ntry { $pdo = new PDO(
$dsn, $user, $pass, $options); } catch (\\PDOException $e) { throw new \\PDOException($e->getMessage(), (int)$e->getCode()); }\n?>";
        file_put_contents(__DIR__.'/../config/database.php', $conf);
        $ok = true;
    } catch (Exception $e) {
        $erro = $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head><meta charset="UTF-8"><title>Instalador Sistema Motoboy</title></head>
<body>
<h2>Instalador do Sistema Motoboy</h2>
<?php if ($ok): ?>
    <p style="color:green">Instalação concluída! <a href="../public/client/login.php">Acessar sistema</a></p>
<?php else: ?>
    <?php if ($erro) echo '<p style="color:red">'.$erro.'</p>'; ?>
    <form method="POST">
        <label>Host do MySQL: <input name="host" value="localhost"></label><br>
        <label>Banco de dados: <input name="db" required></label><br>
        <label>Usuário MySQL: <input name="user" required></label><br>
        <label>Senha MySQL: <input name="pass" type="password"></label><br>
        <label>Nome Admin: <input name="admin" required></label><br>
        <label>Email Admin: <input name="admin_email" type="email" required></label><br>
        <label>Senha Admin: <input name="admin_senha" type="password" required></label><br>
        <button type="submit">Instalar</button>
    </form>
<?php endif; ?>
</body>
</html>
