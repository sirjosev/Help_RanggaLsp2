<?php
// Start the session if it hasn't been started yet
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/manual_loader.php';
require_once __DIR__ . '/../config/config.php';

use App\Model\BlogManager;
use App\Helper\UrlHelper;

?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Blog - LSP DKS</title>
    <link rel="icon" type="image/x-icon" href="assets/img/logo-digitalcreativesolusi.png" />
    <link rel="stylesheet" href="css/styles.css" />
    <link rel="stylesheet" href="css/blog.css" />
</head>

<body id="page-top">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg bg-secondary text-uppercase fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand navbar-brand-logos" href="#page-top">
                <img src="assets/img/logo-digitalcreativesolusi.png" alt="Digital Creative Solusi Logo">
            </a>
            <button class="navbar-toggler text-uppercase font-weight-bold bg-primary text-white rounded" type="button"
                data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive"
                aria-expanded="false" aria-label="Toggle navigation">
                Menu
                <i class="fas fa-bars"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item mx-0 mx-lg-1">
                        <a class="nav-link py-3 px-0 px-lg-3 rounded" href="landingPage">Home</a>
                    </li>
                    <li class="nav-item mx-0 mx-lg-1">
                        <a class="nav-link py-3 px-0 px-lg-3 rounded" href="sertifikasi">Sertifikasi</a>
                    </li>
                    <li class="nav-item mx-0 mx-lg-1">
                        <a class="nav-link py-3 px-0 px-lg-3 rounded" href="profile">Profile</a>
                    </li>
                    <li class="nav-item mx-0 mx-lg-1">
                        <a class="nav-link py-3 px-0 px-lg-3 rounded" href="blog">Blog</a>
                    </li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <?php if (isset($_SESSION['is_super_admin']) && $_SESSION['is_super_admin']): ?>
                            <li class="nav-item mx-0 mx-lg-1">
                                <a class="nav-link py-3 px-0 px-lg-3 rounded" href="<?= defined('ADMIN_PATH_PREFIX') ? ADMIN_PATH_PREFIX : '' ?>/admin">Dashboard</a>
                            </li>
                        <?php endif; ?>
                        <li class="nav-item mx-0 mx-lg-1">
                            <a class="btn btn-outline-light ms-3" href="logout.php">Logout</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item mx-0 mx-lg-1">
                            <a class="btn btn-outline-light ms-3" href="https://sertifikasi.lspdks.co.id">Login</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <?php
    $allBlogs = [];
    try {
        $blogManager = new BlogManager($conn);
        $allBlogs = $blogManager->getAllBlogs(); // Fetch all blogs
    } catch (PDOException $e) {
        echo "<div class='container text-center'><p class='text-danger'>Error accessing database: " . $e->getMessage() . "</p></div>";
    }
    ?>

    <div class="page-section"> <!-- Using page-section for consistent padding -->
        <div class="container berita-container"> <!-- berita-container for specific blog layout if needed -->
            <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">Berita & Artikel Terbaru</h2>
            <div class="divider-custom">
                <div class="divider-custom-line" style="max-width: 20rem; width: 100%;"></div>
            </div>
            
            <?php if (isset($_SESSION['is_super_admin']) && $_SESSION['is_super_admin']): ?>
                <div class="mb-4 text-end">
                    <a href="admin_blog.php" class="btn btn-primary">
                        <i class="fas fa-cog me-2"></i>Manage Blog
                    </a>
                </div>
            <?php endif; ?>

            <?php if (empty($allBlogs)): ?>
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <p class="lead">Belum ada berita atau artikel yang dipublikasikan.</p>
                    </div>
                </div>
            <?php else: ?>
                <div class="row justify-content-center">
                    <?php foreach ($allBlogs as $blog): ?>
                        <div class="col-md-6 col-lg-4 mb-5">
                            <div class="portfolio-item-wrapper">
                                <a href="blog_detail.php?id=<?php echo UrlHelper::encrypt($blog['id']); ?>" class="portfolio-item-link">
                                    <div class="portfolio-item mx-auto">
                                        <div class="portfolio-item-caption d-flex align-items-center justify-content-center h-100 w-100">
                                            <div class="portfolio-item-caption-content text-center text-white"><i class="fas fa-eye fa-3x"></i></div>
                                        </div>
                                        <?php
                                        $imagePath = htmlspecialchars($blog['featured_image']);
                                        if (empty($imagePath)) {
                                            $imagePath = 'https://via.placeholder.com/400x300?text=No+Image'; // Placeholder
                                        }
                                        ?>
                                        <img class="img-fluid" src="<?php echo $imagePath; ?>" alt="<?php echo htmlspecialchars($blog['title']); ?>">
                                    </div>
                                </a>
                                <div class="text-center mt-3 portfolio-item-details">
                                    <h5 class="portfolio-item-title"><?php echo htmlspecialchars($blog['title']); ?></h5>
                                    <p class="text-muted portfolio-item-summary">
                                        <?php echo BlogManager::generateSummary($blog['content'], 20); // Shorter summary for card layout ?>
                                    </p>
                                    <a href="blog_detail.php?id=<?php echo UrlHelper::encrypt($blog['id']); ?>" class="btn btn-sm btn-primary">Baca Selengkapnya</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

        </div>
    </div>
<?php include __DIR__ . '/../src/View/partials/footer.php'; ?>
