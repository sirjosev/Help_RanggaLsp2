<?php
// Database configuration
$host = 'localhost';
$db_name = 'dks';
$username = 'root';
$password = '';

// Encryption Key (Should be complex and kept secret in production)
define('ENCRYPTION_KEY', 'your-secret-key-change-this-in-production-1234567890');

// Super Admin Email
define('SUPER_ADMIN_EMAIL', 'admin@lspdks.co.id');

// Secret Admin Path Prefix
define('ADMIN_PATH_PREFIX', 'secure-panel');

try {
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    die(); // Stop execution if connection fails
}
?>
