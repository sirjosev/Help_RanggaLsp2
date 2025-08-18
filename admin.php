<?php
require_once 'config.php';

// Fetch total blogs
$total_blogs_stmt = $conn->query("SELECT COUNT(*) FROM blogs");
$total_blogs = $total_blogs_stmt->fetchColumn();

// Fetch total skema
$total_skema_stmt = $conn->query("SELECT COUNT(*) FROM skema");
$total_skema = $total_skema_stmt->fetchColumn();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/admin.css" />
</head>

<body>
    <?php require_once 'includes/sidebar.php'; ?>

    <div class="main-content">
        <header>
            <div class="header-content">
                <h1>Welcome to Admin Dashboard</h1>
                <a href="logout.php" class="signout-btn">Sign Out</a>
            </div>
        </header>

        <section class="stats">
            <div class="schema-card">
                <h3>Total Blogs</h3>
                <p><?= $total_blogs ?></p>
            </div>
            <div class="schema-card">
                <h3>Total Skema</h3>
                <p><?= $total_skema ?></p>
            </div>
        </section>

    </div>

</body>

</html>