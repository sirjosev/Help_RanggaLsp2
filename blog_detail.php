<?php
require_once 'config.php'; // For $conn
require_once 'includes/blog_functions.php'; // For blog data functions

$blog_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$blog_post = null;
$page_title = "Detail Berita"; // Default title

if ($blog_id > 0) {
    $blog_post = getBlogById($conn, $blog_id);
    if ($blog_post) {
        $page_title = htmlspecialchars($blog_post['title']);
    } else {
        $page_title = "Berita Tidak Ditemukan";
    }
} else {
    $page_title = "ID Berita Tidak Valid";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?php echo $page_title; ?> - LSP DKS</title>
  <link href="css/styles.css" rel="stylesheet" />
  <link rel="stylesheet" href="css/detail.css" /> <!-- Assuming detail.css has specific styles for blog details -->
  <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body id="page-top">
    <!-- Navigation-->
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
                    <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded" href="index.php">Home</a></li>
                    <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded" href="sertifikasi.php">Sertifikasi</a></li>
                    <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded" href="profile.php">Profile</a></li>
                    <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded" href="blog.php">Blog</a></li>
                    <li class="nav-item mx-0 mx-lg-1">
                        <a class="btn btn-outline-light ms-3" href="https://sertifikasi.lspdks.co.id" target="_blank">Register</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

  <section class="page-section berita-detail-section">
    <div class="container">
      <?php if ($blog_post): ?>
        <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0"><?php echo htmlspecialchars($blog_post['title']); ?></h2>
        <div class="divider-custom">
            <div class="divider-custom-line"></div>
            <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
            <div class="divider-custom-line"></div>
        </div>

        <div class="berita-meta text-center mb-4">
          <small><i class="fas fa-calendar-alt"></i> <?php echo formatBlogDate($blog_post['publish_date']); ?></small>
          <!-- Add author if available in DB and needed:
          <span class="ms-3"><i class="fas fa-user"></i> <?php echo htmlspecialchars($blog_post['author']); ?></span>
          -->
        </div>

        <?php
        $imagePath = htmlspecialchars($blog_post['featured_image']);
        if (strpos($imagePath, 'http') !== 0 && !empty($imagePath)) {
            // Path is relative like assets/img/...
        } elseif (empty($imagePath)) {
            $imagePath = ''; // Don't show placeholder on detail page, or use a different one.
        }
        ?>
        <?php if (!empty($imagePath)): ?>
            <img src="<?php echo $imagePath; ?>" alt="<?php echo htmlspecialchars($blog_post['title']); ?>" class="img-fluid rounded mx-auto d-block mb-4" style="max-height: 400px;" />
        <?php endif; ?>

        <div class="isi-berita lead">
          <?php echo nl2br(htmlspecialchars($blog_post['content'])); // Using htmlspecialchars and nl2br for basic formatting ?>
        </div>
      <?php else: ?>
        <h2 class="page-section-heading text-center text-uppercase text-danger mb-0">Berita Tidak Ditemukan</h2>
        <div class="divider-custom">
            <div class="divider-custom-line"></div>
            <div class="divider-custom-icon"><i class="fas fa-exclamation-triangle"></i></div>
            <div class="divider-custom-line"></div>
        </div>
        <p class="lead text-center">Maaf, berita yang Anda cari tidak dapat ditemukan atau ID tidak valid.</p>
        <div class="text-center mt-4">
            <a href="blog.php" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Kembali ke Daftar Berita</a>
        </div>
      <?php endif; ?>
    </div>
  </section>

  <footer class="footer">
        <div class="container">
            <div class="row">
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
                <div class="col-lg-4 footer-col">
                    <h4 class="text-uppercase mb-4">Contact Us</h4>
                    <p class="lead mb-1">
                        <i class="fas fa-envelope me-2"></i>
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
            <div class="container"><small>Copyright &copy; LSP DIGITAL KREATIF SOLUSI 2023. All Rights Reserved</small></div>
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
