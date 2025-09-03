<?php
// Start the session if it hasn't been started yet
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>blog</title>
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
                        <a class="nav-link py-3 px-0 px-lg-3 rounded" href="index.php">Home</a>
                    </li>
                    <li class="nav-item mx-0 mx-lg-1">
                        <a class="nav-link py-3 px-0 px-lg-3 rounded" href="sertifikasi.php">Sertifikasi</a>
                    </li>
                    <li class="nav-item mx-0 mx-lg-1">
                        <a class="nav-link py-3 px-0 px-lg-3 rounded" href="profile.php">Profile</a>
                    </li>
                    <li class="nav-item mx-0 mx-lg-1">
                        <a class="nav-link py-3 px-0 px-lg-3 rounded" href="blog.php">Blog</a>
                    </li>
                    <li class="nav-item mx-0 mx-lg-1">
                        <a class="btn btn-outline-light ms-3" href="https://sertifikasi.lspdks.co.id" target="_blank">Register</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <?php
    require_once 'config.php'; // For $conn
    require_once 'includes/blog_functions.php'; // For blog data functions

    try {
        $allBlogs = getAllBlogs($conn); // Fetch all blogs
        // var_dump($allBlogs); // Uncomment for debugging
    } catch (PDOException $e) {
        echo "<div class='container text-center'><p class='text-danger'>Error accessing database: " . $e->getMessage() . "</p></div>";
        $allBlogs = []; // Ensure variable exists to prevent further errors
    }
    ?>

    <div class="page-section"> <!-- Using page-section for consistent padding -->
        <div class="container berita-container"> <!-- berita-container for specific blog layout if needed -->
            <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">Berita & Artikel Terbaru</h2>
            <div class="divider-custom">
                <div class="divider-custom-line"></div>
                <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                <div class="divider-custom-line"></div>
            </div>

            <?php if (empty($allBlogs)): ?>
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <p class="lead">Belum ada berita atau artikel yang dipublikasikan.</p>
                    </div>
                </div>
            <?php else: ?>
                <?php foreach ($allBlogs as $blog): ?>
                    <div class="card-berita">
                        <?php
                        $imagePath = htmlspecialchars($blog['featured_image']);
                        // Prepend 'http' or 'https' if it's an external URL, otherwise assume it's a local path
                        if (strpos($imagePath, 'http') !== 0 && !empty($imagePath)) {
                            // No specific prefix needed as path is assets/img/....jpg
                        } elseif (empty($imagePath)) {
                            $imagePath = 'https://via.placeholder.com/200x130?text=No+Image'; // Placeholder if no image
                        }
                        ?>
                        <img src="<?php echo $imagePath; ?>" alt="<?php echo htmlspecialchars($blog['title']); ?>" class="gambar-berita">
                        <div class="konten-berita">
                            <h3 class="judul"><a href="blog_detail.php?id=<?php echo $blog['id']; ?>"><?php echo htmlspecialchars($blog['title']); ?></a></h3>
                            <p class="tanggal"><small><?php echo formatBlogDate($blog['publish_date']); ?></small></p>
                            <p class="deskripsi">
                                <?php echo generateSummary($blog['content'], 50); // Show a summary of ~50 words ?>
                            </p>
                            <a href="blog_detail.php?id=<?php echo $blog['id']; ?>" class="btn btn-primary btn-sm mt-auto">Baca Selengkapnya</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

        </div>
    </div>
<?php include 'includes/footer.php'; ?>