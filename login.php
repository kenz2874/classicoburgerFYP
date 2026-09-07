<?php
session_start();
require 'db.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = trim($_POST['username'] ?? '');
    $pass = trim($_POST['password'] ?? '');

    if (empty($user) || empty($pass)) {
        echo json_encode(['success' => false, 'message' => 'Sila masukkan ID dan Password!']);
        exit();
    }

    // Query database for matching username
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :user LIMIT 1");
    $stmt->execute(['user' => $user]);
    $account = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verify hashed password
    if ($account && password_verify($pass, $account['password_hash'])) {
        $_SESSION['user_id'] = $account['id'];
        $_SESSION['username'] = $account['username'];
        $_SESSION['role'] = $account['role'];

        echo json_encode(['success' => true, 'message' => 'Log masuk berjaya!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'ID atau Password salah!']);
    }
}
?>