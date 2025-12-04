<?php
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_super_admin']) || !$_SESSION['is_super_admin']) {
    header("Location: login");
    exit();
}

require_once __DIR__ . '/../config/manual_loader.php';
require_once __DIR__ . '/../config/config.php';

use App\Model\BlogManager;
use App\Model\SkemaManager;
use App\Helper\UrlHelper;

$blogManager = new BlogManager($conn);
$skemaManager = new SkemaManager($conn);

// Fetch total blogs
$total_blogs = $blogManager->getTotalBlogs();

// Fetch total skema
$total_skema = $skemaManager->getTotalSkema();

// Fetch latest 5 blogs
$latest_blogs = $blogManager->getAllBlogs('publish_date DESC', 5);

// Fetch latest 5 skema
$latest_skema = $skemaManager->getAllSkema(); // Assuming getAllSkema is ordered by latest first, and we can slice it. Let's get the first 5.
$latest_skema = array_slice($latest_skema, 0, 5);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/admin.css" />
</head>

<body>
    <?php require_once __DIR__ . '/../src/View/partials/sidebar.php'; ?>

    <div class="main-content">
        <header>
            <div class="header-content">
                <h1>Welcome to Admin Dashboard</h1>
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
                        <p class="blog-summary"><?= BlogManager::generateSummary($blog['content'], 15) ?>...</p>
                        <a href="blog_detail.php?id=<?= UrlHelper::encrypt($blog['id']) ?>" target="_blank">Read more</a>
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
                         <a href="skema.php?id=<?= UrlHelper::encrypt($skema['id']) ?>" target="_blank">Read more</a>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </section>

</body>

</html>
