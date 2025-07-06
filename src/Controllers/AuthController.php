<?php
require_once __DIR__ . '/../../config/database.php';

class AuthController {
    public static function register($name, $email, $password, $role, $phone = null) {
        global $pdo;
        $sql = "INSERT INTO users (name, email, password, role, phone) VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $hash = password_hash($password, PASSWORD_DEFAULT);
        return $stmt->execute([$name, $email, $hash, $role, $phone]);
    }

    public static function login($email, $password) {
        global $pdo;
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        if ($user && password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            return $user;
        }
        return false;
    }
}
