<?php
// Enable full PHP error display
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'db.php';
echo "<h1 style='color:green;'>SUCCESS: Connected to classico_db! 🎉</h1>";

$host = '127.0.0.1';
$dbname = 'classico_db';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Sambungan Database Gagal: " . $e->getMessage());
}
?>