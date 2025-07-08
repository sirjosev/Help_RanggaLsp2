<?php
// Start the session if it hasn't been started yet
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>lsp-dks</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet"
        type="text/css" />
    <link href="css/styles.css" rel="stylesheet" />
</head>

<body id="page-top">
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg bg-secondary text-uppercase fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand navbar-brand-logos" href="#page-top">
                <img src="assets/img/logo-bnsp.png" alt="BNSP Logo">
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
                        <a class="btn btn-outline-light ms-3" href="#register">Register</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Masthead-->
    <header class="masthead bg-primary text-white text-center">
        <div class="container d-flex align-items-center flex-column">
            <!-- Masthead Avatar Image-->
            <img class="masthead-avatar mb-5" src="assets/img/avataaars.svg" alt="..." />
            <!-- Masthead Heading-->
            <h1 class="masthead-heading text-uppercase mb-0">LSP-DKS</h1>
            <!-- Icon Divider-->
            <div class="divider-custom divider-light">
                <div class="divider-custom-line"></div>
                <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                <div class="divider-custom-line"></div>
            </div>
            <!-- Masthead Subheading-->
            <p class="masthead-subheading font-weight-light mb-0">Graphic Artist - Web Designer - Illustrator</p>
        </div>
    </header>

    <!-- About Us Section -->
    <section class="page-section bg-light">
        <div class="container">
            <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">About Us</h2>
            <div class="divider-custom">
                <div class="divider-custom-line"></div>
                <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                <div class="divider-custom-line"></div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <p class="text-muted">
                        LSP-DKS adalah lembaga sertifikasi yang berfokus pada penyelenggaraan pelatihan dan sertifikasi
                        di berbagai bidang keahlian. Kami bertujuan untuk meningkatkan kualitas sumber daya manusia
                        melalui program-program pelatihan yang terstruktur dan relevan dengan kebutuhan pasar. Dengan
                        didukung oleh para ahli di bidangnya, kami memastikan peserta mendapatkan pelatihan terbaik yang
                        dapat memperkuat keterampilan mereka.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Visi & Misi Section -->
    <section class="page-section">
        <div class="container">
            <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">Visi & Misi</h2>
            <div class="divider-custom">
                <div class="divider-custom-line"></div>
                <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                <div class="divider-custom-line"></div>
            </div>
            <div class="row">
                <!-- Visi -->
                <div class="col-lg-6 mb-5">
                    <h3 class="text-center text-uppercase">Visi</h3>
                    <p class="text-muted text-center">
                        Mewujudkan penyelenggaraan pelatihan dan sertifikasi yang berkualitas untuk meningkatkan
                        kompetensi di berbagai bidang.
                    </p>
                </div>
                <!-- Misi -->
                <div class="col-lg-6 mb-5">
                    <h3 class="text-center text-uppercase">Misi</h3>
                    <ul class="text-muted">
                        <li>Menyediakan program pelatihan yang relevan dan berkualitas untuk pengembangan profesional.
                        </li>
                        <li>Menyelenggarakan sertifikasi kompetensi untuk memvalidasi keahlian di berbagai industri.
                        </li>
                        <li>Mendukung pengembangan individu untuk memajukan karier dan bisnis mereka.</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <div style="margin-bottom: 50px;"></div>

    <!-- SKEMA SERIFIKASI Section-->
    <section class="page-section bg-light">
        <div class="container">
            <!-- Portfolio Section Heading-->
            <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">SKEMA SERTIFIKASI</h2>
            <!-- Icon Divider-->
            <div class="divider-custom">
                <div class="divider-custom-line"></div>
                <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                <div class="divider-custom-line"></div>
            </div>
            <!-- Portfolio Grid Items-->
            <div class="row justify-content-center">
                <!-- Portfolio Item 1-->
                <div class="col-md-6 col-lg-4 mb-5">
                    <div class="portfolio-item mx-auto" data-bs-toggle="modal" data-bs-target="#portfolioModal1">
                        <div
                            class="portfolio-item-caption d-flex align-items-center justify-content-center h-100 w-100">
                            <div class="portfolio-item-caption-content text-center text-white"><i
                                    class="fas fa-plus fa-3x"></i></div>
                        </div>
                        <img class="img-fluid" src="assets/img/portfolio/cabin.png" alt="..." />
                    </div>
                </div>
                <!-- Portfolio Item 2-->
                <div class="col-md-6 col-lg-4 mb-5">
                    <div class="portfolio-item mx-auto" data-bs-toggle="modal" data-bs-target="#portfolioModal2">
                        <div
                            class="portfolio-item-caption d-flex align-items-center justify-content-center h-100 w-100">
                            <div class="portfolio-item-caption-content text-center text-white"><i
                                    class="fas fa-plus fa-3x"></i></div>
                        </div>
                        <img class="img-fluid" src="assets/img/portfolio/cake.png" alt="..." />
                    </div>
                </div>
                <!-- Portfolio Item 3-->
                <div class="col-md-6 col-lg-4 mb-5">
                    <div class="portfolio-item mx-auto" data-bs-toggle="modal" data-bs-target="#portfolioModal3">
                        <div
                            class="portfolio-item-caption d-flex align-items-center justify-content-center h-100 w-100">
                            <div class="portfolio-item-caption-content text-center text-white"><i
                                    class="fas fa-plus fa-3x"></i></div>
                        </div>
                        <img class="img-fluid" src="assets/img/portfolio/circus.png" alt="..." />
                    </div>
                </div>
                <!-- Portfolio Item 4-->
                <div class="col-md-6 col-lg-4 mb-5 mb-lg-0">
                    <div class="portfolio-item mx-auto" data-bs-toggle="modal" data-bs-target="#portfolioModal4">
                        <div
                            class="portfolio-item-caption d-flex align-items-center justify-content-center h-100 w-100">
                            <div class="portfolio-item-caption-content text-center text-white"><i
                                    class="fas fa-plus fa-3x"></i></div>
                        </div>
                        <img class="img-fluid" src="assets/img/portfolio/game.png" alt="..." />
                    </div>
                </div>
                <!-- Portfolio Item 5-->
                <div class="col-md-6 col-lg-4 mb-5 mb-md-0">
                    <div class="portfolio-item mx-auto" data-bs-toggle="modal" data-bs-target="#portfolioModal5">
                        <div
                            class="portfolio-item-caption d-flex align-items-center justify-content-center h-100 w-100">
                            <div class="portfolio-item-caption-content text-center text-white"><i
                                    class="fas fa-plus fa-3x"></i></div>
                        </div>
                        <img class="img-fluid" src="assets/img/portfolio/safe.png" alt="..." />
                    </div>
                </div>
                <!-- Portfolio Item 6-->
                <div class="col-md-6 col-lg-4">
                    <div class="portfolio-item mx-auto" data-bs-toggle="modal" data-bs-target="#portfolioModal6">
                        <div
                            class="portfolio-item-caption d-flex align-items-center justify-content-center h-100 w-100">
                            <div class="portfolio-item-caption-content text-center text-white"><i
                                    class="fas fa-plus fa-3x"></i></div>
                        </div>
                        <img class="img-fluid" src="assets/img/portfolio/submarine.png" alt="..." />
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- berita & artikel Section-->
   <section class="page-section portfolio" id="berita-artikel">
    <div class="container">
        <!-- Portfolio Section Heading -->
        <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">BERITA & ARTIKEL</h2>

        <!-- Icon Divider -->
        <div class="divider-custom">
            <div class="divider-custom-line"></div>
            <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
            <div class="divider-custom-line"></div>
        </div>

        <!-- Portfolio Grid Items -->
        <div class="row justify-content-center">
            <?php
            require_once 'config.php'; // Ensure database connection is available
            if (!function_exists('getAllBlogs')) { // Ensure functions are only included once
                require_once 'includes/blog_functions.php';
            }

            $latestBlogs = getAllBlogs($conn, 'publish_date DESC', 3); // Get latest 3 blogs

            if (empty($latestBlogs)): ?>
                <div class="col-lg-12 text-center">
                    <p class="lead text-muted">Belum ada berita atau artikel yang dipublikasikan.</p>
                </div>
            <?php else: ?>
                <?php foreach ($latestBlogs as $blog): ?>
                    <div class="col-md-6 col-lg-4 mb-5">
                        <div class="portfolio-item-wrapper">
                            <a href="blog_detail.php?id=<?php echo $blog['id']; ?>" class="portfolio-item-link">
                                <div class="portfolio-item mx-auto">
                                    <div class="portfolio-item-caption d-flex align-items-center justify-content-center h-100 w-100">
                                        <div class="portfolio-item-caption-content text-center text-white"><i class="fas fa-eye fa-3x"></i></div> {/* Changed icon */}
                                    </div>
                                    <?php
                                    $imagePath = htmlspecialchars($blog['featured_image']);
                                    if (strpos($imagePath, 'http') !== 0 && !empty($imagePath)) {
                                        // Path is relative like assets/img/...
                                    } elseif (empty($imagePath)) {
                                        $imagePath = 'https://via.placeholder.com/700x500?text=No+Image'; // Placeholder
                                    }
                                    ?>
                                    <img class="img-fluid" src="<?php echo $imagePath; ?>" alt="<?php echo htmlspecialchars($blog['title']); ?>" />
                                </div>
                            </a>
                            <div class="text-center mt-3 portfolio-item-details">
                                <h5 class="portfolio-item-title"><?php echo htmlspecialchars($blog['title']); ?></h5>
                                <p class="text-muted portfolio-item-summary"><?php echo generateSummary($blog['content'], 20); // Shorter summary ?></p>
                                <a href="blog_detail.php?id=<?php echo $blog['id']; ?>" class="btn btn-sm btn-primary">Baca Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<<<<<<< HEAD
<<<<<<< HEAD


    <footer class="footer"> <!-- Kelas text-center mungkin akan dihapus atau di-override oleh CSS custom -->
            <div class="container mb2rem">
=======
    <footer class="footer">
            <div class="container">
>>>>>>> repo/jules/standardize-admin-styles
=======
    <footer class="footer">
            <div class="container">
>>>>>>> repo/master
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
                    </div>

                    <!-- Kolom 2: Peta -->
                    <div class="col-lg-4 footer-col">
                        <h4 class="text-uppercase mb-4">Our Location on Map</h4>
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
                            Phone: <a href="tel:+6281188809565">081188809565</a>
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
    <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
    <!-- * *                               SB Forms JS                               * *-->
    <!-- * * Activate your form at https://startbootstrap.com/solution/contact-forms * *-->
    <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
    <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
</body>

</html>