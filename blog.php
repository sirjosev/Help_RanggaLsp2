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
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <!-- Kolom 1: Alamat (Location) -->
                    <div class="col-lg-4 footer-col">
                        <h4 class="text-uppercase mb-4">Location</h4>
                        <p class="lead mb-0">
                            Alamanda Tower Lantai 2 Unit-H1 Jl. TB. Simatupang No. 23 - 24 RT 001 RW 001,
                            Kelurahan Cilandak Barat, Kecamatan Cilandak, Jakarta Selatan, DKI Jakarta
                            <br />
                            Kode Pos 1243
                        </p>
                         <div class="map-responsive">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d966.3195365153447!2d106.80471588299955!3d-6.2909179536907365!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f1f275c8afc3%3A0x7a3084e60947f99a!2sAlamanda%20Tower%2C%20Building%20Management.!5e0!3m2!1sid!2sid!4v1744843896947!5m2!1sid!2sid"
                                width="100%" height="250" style="border:0; border-radius: 0.5rem;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>

                    <!-- Kolom 3: Kontak (Contact Us) -->
                    <div class="col-lg-4 footer-col">
                        <h4 class="text-uppercase mb-4">Contact Us</h4>
                        <p class="lead mb-1">
                            <i class="fas fa-envelope me-2"></i> <!-- Contoh ikon jika FontAwesome tersedia -->
                            Email: <a href="mailto:admin@lspdks.co.id">admin@lspdks.co.id</a>
                        </p>
                        <p class="lead mb-0">
                            <i class="fas fa-phone me-2"></i> <!-- Contoh ikon jika FontAwesome tersedia -->
                            Phone: <a href="https://wa.me/+6281188809565">081188809565</a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="copyright py-4 text-center text-white">
                <div class="container">
                    <small>Copyright &copy; LSP DIGITAL KREATIF SOLUSI 2023. All Rights Reserved</small>
                </div>
            </div>
        </footer>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
    <!-- SB Forms JS -->
    <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
    </body>

</html>