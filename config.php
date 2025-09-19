<?php
// config.php - Make sure this file exists and has proper database connection

// Define the super admin email
define('SUPER_ADMIN_EMAIL', 'admin@example.com');

try {
    $host = 'localhost';
    $dbname = 'dks';
    $username = 'root';
    $password = '';
    
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>

