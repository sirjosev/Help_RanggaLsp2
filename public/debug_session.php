<?php
session_start();
echo "<h1>Session Debug</h1>";
echo "<pre>";
print_r($_SESSION);
echo "</pre>";

require_once '../config/config.php';
echo "<h2>Config Constants</h2>";
echo "SUPER_ADMIN_EMAILS: " . implode(', ', SUPER_ADMIN_EMAILS) . "<br>";

if (isset($_SESSION['email'])) {
    echo "<h2>Check</h2>";
    echo "User Email: " . $_SESSION['email'] . "<br>";
    $is_admin = in_array(strtolower($_SESSION['email']), array_map('strtolower', SUPER_ADMIN_EMAILS));
    echo "Is Super Admin (Check): " . ($is_admin ? 'YES' : 'NO') . "<br>";
}
?>
