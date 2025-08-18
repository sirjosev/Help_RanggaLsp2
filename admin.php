<?php
require_once 'config.php';

// Fetch total blogs
$total_blogs_stmt = $conn->query("SELECT COUNT(*) FROM blogs");
$total_blogs = $total_blogs_stmt->fetchColumn();

// Fetch total skema
$total_skema_stmt = $conn->query("SELECT COUNT(*) FROM skema");
$total_skema = $total_skema_stmt->fetchColumn();

// Fetch latest 5 blogs
$latest_blogs_stmt = $conn->query("SELECT * FROM blogs ORDER BY publish_date DESC LIMIT 5");
$latest_blogs = $latest_blogs_stmt->fetchAll();

// Fetch latest 5 skema
$latest_skema_stmt = $conn->query("SELECT * FROM skema ORDER BY id DESC LIMIT 5");
$latest_skema = $latest_skema_stmt->fetchAll();
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

        <section class="stats blog-list-section">
            <div class="blog-list">
                <div class="schema-card">
                    <h3>Total Blogs</h3>
                    <p><?= $total_blogs ?></p>
                </div>
                <div class="schema-card">
                    <h3>Total Skema</h3>
                    <p><?= $total_skema ?></p>
                </div>
            </div>
        </section>

        <section class="blog-list-section">
            <h2>Latest Blogs</h2>
            <div class="blog-list">
                <?php if (empty($latest_blogs)): ?>
                    <div class="blog-card">
                        <p>No blogs found.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($latest_blogs as $blog): ?>
                    <div class="blog-card">
                        <h3><?= htmlspecialchars($blog['title']) ?></h3>
                        <p class="blog-summary"><?= substr(strip_tags($blog['content']), 0, 100) ?>...</p>
                        <a href="blog_detail.php?id=<?= $blog['id'] ?>" target="_blank">Read more</a>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </section>

        <section class="schema-section">
            <h2>Skema yang Tersedia</h2>
            <div class="schema-container">
                <?php if (empty($latest_skema)): ?>
                    <div class="schema-card">
                        <p>No skema found.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($latest_skema as $skema): ?>
                    <div class="schema-card">
                        <h3><?= htmlspecialchars($skema['nama']) ?></h3>
                        <p><?= htmlspecialchars(substr($skema['ringkasan'], 0, 100)) ?>...</p>
                         <a href="skema.php?id=<?= $skema['id'] ?>" target="_blank">Read more</a>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </section>

</body>

</html>