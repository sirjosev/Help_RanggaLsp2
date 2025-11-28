<?php
session_start();
require_once '../config/config.php';

// Redirect to login if not authenticated
if (!isset($_SESSION['user_id'])) {
    header('Location: login');
    exit();
}

// Redirect if not super admin
if (!isset($_SESSION['is_super_admin']) || !$_SESSION['is_super_admin']) {
    header('Location: index');
    exit();
}

$admin_id = $_GET['id'] ?? null;
if (!$admin_id) {
    header('Location: manage_admins.php');
    exit();
}

// Fetch admin details
$stmt = $conn->prepare("SELECT id, username, email FROM users WHERE id = :id");
$stmt->bindParam(':id', $admin_id, PDO::PARAM_INT);
$stmt->execute();
$admin = $stmt->fetch();

if (!$admin) {
    header('Location: manage_admins.php');
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];

    $update_stmt = $conn->prepare("UPDATE users SET username = :username, email = :email WHERE id = :id");
    $update_stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $update_stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $update_stmt->bindParam(':id', $admin_id, PDO::PARAM_INT);

    if ($update_stmt->execute()) {
        header('Location: manage_admins.php');
        exit();
    } else {
        $error = "Failed to update admin details.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Admin</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
    <?php require_once 'includes/sidebar.php'; ?>

    <div class="main-content">
        <header>
            <h1>Edit Admin</h1>
        </header>

        <section class="admin-management">
            <form method="POST">
                <?php if (isset($error)): ?>
                    <p style="color: red;"><?= $error ?></p>
                <?php endif; ?>
                <div>
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" value="<?= htmlspecialchars($admin['username']) ?>" required>
                </div>
                <div>
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?= htmlspecialchars($admin['email']) ?>" required>
                </div>
                <button type="submit">Update Admin</button>
            </form>
        </section>
    </div>
</body>
</html>
