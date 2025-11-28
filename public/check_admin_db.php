<?php
require_once __DIR__ . '/../config/config.php';

echo "<h1>Database Admin Check</h1>";
echo "SUPER_ADMIN_EMAILS constant: " . implode(', ', SUPER_ADMIN_EMAILS) . "<br>";

try {
    $stmt = $conn->prepare("SELECT * FROM users");
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<h2>Users in Database:</h2>";
    echo "<table border='1'><tr><th>ID</th><th>Email</th><th>Is Match?</th></tr>";
    foreach ($users as $user) {
        $is_match = in_array(strtolower($user['email']), array_map('strtolower', SUPER_ADMIN_EMAILS)) ? "YES" : "NO";
        echo "<tr>";
        echo "<td>" . $user['id'] . "</td>";
        echo "<td>'" . $user['email'] . "'</td>";
        echo "<td>" . $is_match . "</td>";
        echo "</tr>";
    }
    echo "</table>";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
