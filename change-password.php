<?php
session_start();
require 'db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Akses dilarang! Sila log masuk dahulu.']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old_pass = $_POST['old_password'] ?? '';
    $new_pass = $_POST['new_password'] ?? '';
    $user_id  = $_SESSION['user_id'];

    $stmt = $pdo->prepare("SELECT password_hash FROM users WHERE id = :id");
    $stmt->execute(['id' => $user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($old_pass, $user['password_hash'])) {
        $new_hash = password_hash($new_pass, PASSWORD_DEFAULT);

        $updateStmt = $pdo->prepare("UPDATE users SET password_hash = :hash WHERE id = :id");
        $updateStmt->execute(['hash' => $new_hash, 'id' => $user_id]);

        echo json_encode(['success' => true, 'message' => 'Password berjaya ditukar!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Password lama salah!']);
    }
}
?>