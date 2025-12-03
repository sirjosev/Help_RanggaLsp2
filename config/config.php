<?php
// Database configuration
$db_host = 'localhost';
$db_name = 'dks';
$username = 'root';
$password = '';

// Encryption Key (Should be complex and kept secret in production)
define('ENCRYPTION_KEY', 'your-secret-key-change-this-in-production-1234567890');

// Super Admin Email
define('SUPER_ADMIN_EMAILS', ['admin@lspdks.co.id', 'tes2@gmail.com']);

// Secret Admin Path Prefix
// Secret Admin Path Prefix
define('ADMIN_PATH_PREFIX', 'secure-panel');

// Define Base URL
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
$host = $_SERVER['HTTP_HOST'];
$script_name = $_SERVER['SCRIPT_NAME'];
$public_pos = strpos($script_name, '/public/');
if ($public_pos !== false) {
    $base_path = substr($script_name, 0, $public_pos + 7); // +7 to include '/public'
} else {
    $base_path = dirname($script_name);
}
define('BASE_URL', $protocol . "://" . $host . $base_path);

try {
    $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $username, $password);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    die(); // Stop execution if connection fails
}
?>
