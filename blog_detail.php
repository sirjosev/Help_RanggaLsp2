<?php

declare(strict_types=1);

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
    <title><?= $page_title; ?> - LSP DKS</title>
    <link href="css/styles.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/detail.css" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body id="page-top">
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg bg-secondary text-uppercase fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand navbar-brand-logos" href="#page-top">
                <img src="assets/img/logo-digitalcreativesolusi.png" alt="Digital Creative Solusi Logo">
            </a>
            <button class="navbar-toggler text-uppercase font-weight-bold bg-primary text-white rounded" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
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
            <?php if ($blog_post) : ?>
                <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0"><?= htmlspecialchars($blog_post['title']); ?></h2>
                <div class="divider-custom">
                    <div class="divider-custom-line"></div>
                    <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                    <div class="divider-custom-line"></div>
                </div>

                <div class="berita-meta text-center mb-4">
                    <small><i class="fas fa-calendar-alt"></i> <?= formatBlogDate($blog_post['publish_date']); ?></small>
                </div>

                <?php
                $imagePath = htmlspecialchars($blog_post['featured_image']);
                if (strpos($imagePath, 'http') !== 0 && !empty($imagePath)) {
                    // Path is relative like assets/img/...
                } elseif (empty($imagePath)) {
                    $imagePath = ''; // Don't show placeholder on detail page, or use a different one.
                }
                ?>
                <?php if (!empty($imagePath)) : ?>
                    <img src="<?= $imagePath; ?>" alt="<?= htmlspecialchars($blog_post['title']); ?>" class="img-fluid rounded mx-auto d-block mb-4" style="max-height: 400px;" />
                <?php endif; ?>

                <div class="isi-berita lead">
                    <?= nl2br(htmlspecialchars($blog_post['content'])); ?>
                </div>
            <?php else : ?>
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

    <?php include 'includes/footer.php'; ?>
</body>

</html>
