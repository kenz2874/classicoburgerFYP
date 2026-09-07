<?php
require 'db.php';

// Generate a fresh, guaranteed hash for 'admin1234'
$new_pass = 'admin1234';
$fresh_hash = password_hash($new_pass, PASSWORD_DEFAULT);

try {
    // Force update the admin row
    $stmt = $pdo->prepare("UPDATE users SET password_hash = :hash WHERE username = 'admin'");
    $stmt->execute(['hash' => $fresh_hash]);

    echo "<h1 style='color:green;'>SUCCESS! Password for 'admin' has been reset to: admin1234</h1>";
    echo "<p>Fresh Hash generated: <code>$fresh_hash</code></p>";
} catch (PDOException $e) {
    echo "<h1 style='color:red;'>Error resetting password: " . $e->getMessage() . "</h1>";
}
?>