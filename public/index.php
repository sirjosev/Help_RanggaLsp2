<?php
// Start the session if it hasn't been started yet
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// 1. Include all necessary files once at the top
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/config.php';

use App\Model\SkemaManager;
use App\Model\BlogManager;
use App\Helper\UrlHelper;

// 2. Fetch all data needed for the page
$db_error = '';
$skema_list = [];
$latestBlogs = [];
$header_photos = [];

try {
    // Fetch skema data
    $skemaManager = new SkemaManager($conn);
    $skema_list = array_slice($skemaManager->getAllSkema(), 0, 6); // Get first 6 skema

    // Fetch blog data
    $blogManager = new BlogManager($conn);
    $latestBlogs = $blogManager->getAllBlogs('publish_date DESC', 3); // Get latest 3 blogs

    // Fetch published photos for the header carousel
    try {
        $photo_stmt = $conn->query("SELECT * FROM photos WHERE status = 'published' ORDER BY uploaded_at DESC");
        if ($photo_stmt) {
            $header_photos = $photo_stmt->fetchAll();
        }
    } catch (PDOException $e) {
        // Ignore error if photos table doesn't exist or query fails
        error_log("Error fetching photos: " . $e->getMessage());
    }

} catch (PDOException $e) {
    $db_error = "Error accessing database: " . $e->getMessage();
    // Log the error for admin, don't show to public
    error_log($db_error);
} catch (Exception $e) {
    $db_error = "An unexpected error occurred: " . $e->getMessage();
    error_log($db_error);
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
    <link rel="icon" type="image/x-icon" href="assets/img/logo-digitalcreativesolusi.png" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet"
        type="text/css" />
    <link href="css/styles.css" rel="stylesheet" />
    <link href="css/custom.css" rel="stylesheet" />
</head>

<body id="page-top">
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg text-uppercase fixed-top" id="mainNav">
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
                    <li class="nav-item mx-0 mx-lg-1">
                        <a class="nav-link py-3 px-0 px-lg-3 rounded" href="blog">Blog</a>
                    </li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <?php if (isset($_SESSION['is_super_admin']) && $_SESSION['is_super_admin']): ?>
                            <li class="nav-item mx-0 mx-lg-1">
                                <a class="nav-link py-3 px-0 px-lg-3 rounded" href="<?= ADMIN_PATH_PREFIX ?>/admin">Dashboard</a>
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

    <!-- Masthead-->
    <header class="masthead text-white text-center <?php if (!empty($header_photos)) echo 'masthead-with-carousel'; ?>">
        <div id="headerCarousel" class="carousel slide" data-bs-ride="carousel">
            <?php if (!empty($header_photos)): ?>
                <div class="carousel-indicators">
                    <?php foreach ($header_photos as $i => $photo): ?>
                        <button type="button" data-bs-target="#headerCarousel" data-bs-slide-to="<?= $i ?>" class="<?= $i == 0 ? 'active' : '' ?>" aria-current="true" aria-label="Slide <?= $i + 1 ?>"></button>
                    <?php endforeach; ?>
                </div>
                <div class="carousel-inner">
                    <?php foreach ($header_photos as $i => $photo): ?>
                        <div class="carousel-item <?= $i == 0 ? 'active' : '' ?>">
                            <img src="<?= htmlspecialchars($photo['file_path']) ?>" class="d-block w-100" alt="<?= htmlspecialchars($photo['alt_text']) ?>">
                        </div>
                    <?php endforeach; ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#headerCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#headerCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            <?php else: ?>
                <!-- Fallback to original content if no photos -->
                <div class="container d-flex align-items-center flex-column">
                    <img class="masthead-avatar mb-5" src="assets/img/avataaars.svg" alt="..." />
                    <h1 class="masthead-heading text-uppercase mb-0">LSP-DKS</h1>
                    <div class="divider-custom divider-light">
                        <div class="divider-custom-line"></div>
                        <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                        <div class="divider-custom-line"></div>
                    </div>
                    <p class="masthead-subheading font-weight-light mb-0">Graphic Artist - Web Designer - Illustrator</p>
                </div>
            <?php endif; ?>
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
                    <p class="text-muted">
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
    <section class="page-section portfolio bg-light" id="skema-sertifikasi">
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
                <?php if (!empty($db_error)): ?>
                    <div class="col-lg-12 text-center"><p class="text-danger">Gagal memuat data skema. Silakan coba lagi nanti.</p></div>
                <?php elseif (empty($skema_list)): ?>
                    <div class="col-lg-12 text-center"><p class="lead text-muted">Belum ada skema sertifikasi yang tersedia.</p></div>
                <?php else: ?>
                    <?php foreach ($skema_list as $skema): ?>
                    <div class="col-md-6 col-lg-4 mb-5">
                        <div class="portfolio-item-wrapper">
                            <a href="skema.php?id=<?php echo UrlHelper::encrypt($skema['id']); ?>" class="portfolio-item-link">
                                <div class="portfolio-item mx-auto">
                                    <div class="portfolio-item-caption d-flex align-items-center justify-content-center h-100 w-100">
                                        <div class="portfolio-item-caption-content text-center text-white"><i class="fas fa-eye fa-3x"></i></div>
                                    </div>
                                    <?php
                                        $imagePath = !empty($skema['gambar']) ? $skemaManager->getGambarPath($skema['gambar']) : 'assets/img/portfolio/game.png';
                                    ?>
                                    <img class="img-fluid" src="<?php echo $imagePath; ?>" alt="<?php echo htmlspecialchars($skema['nama']); ?>" />
                                </div>
                            </a>
                            <div class="text-center mt-3 portfolio-item-details">
                                <h5 class="portfolio-item-title"><?php echo htmlspecialchars($skema['nama']); ?></h5>
                                <a href="skema.php?id=<?php echo UrlHelper::encrypt($skema['id']); ?>" class="btn btn-sm btn-primary btn-gradient">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <div style="text-align: right;">
                <a href="sertifikasi" class="back-button">Lihat Semua Skema →</a>
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
            <?php if (!empty($db_error)): ?>
                <div class="col-lg-12 text-center"><p class="text-danger">Gagal memuat data artikel. Silakan coba lagi nanti.</p></div>
            <?php elseif (empty($latestBlogs)): ?>
                <div class="col-lg-12 text-center">
                    <p class="lead text-muted">Tidak ada berita atau artikel yang ditemukan. Silakan periksa koneosi database dan pastikan tabel 'blog' berisi data.</p>
                </div>
            <?php else: ?>
                <?php foreach ($latestBlogs as $blog): ?>
                    <div class="col-md-6 col-lg-4 mb-5">
                        <div class="portfolio-item-wrapper">
                            <a href="blog_detail.php?id=<?php echo UrlHelper::encrypt($blog['id']); ?>" class="portfolio-item-link">
                                <div class="portfolio-item mx-auto">
                                    <div class="portfolio-item-caption d-flex align-items-center justify-content-center h-100 w-100">
                                        <div class="portfolio-item-caption-content text-center text-white"><i class="fas fa-eye fa-3x"></i></div>
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
                                <p class="text-muted portfolio-item-summary"><?php echo BlogManager::generateSummary($blog['content'], 20); // Shorter summary ?></p>
                                <a href="blog_detail.php?id=<?php echo UrlHelper::encrypt($blog['id']); ?>" class="btn btn-sm btn-primary btn-gradient">Baca Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <div style="text-align: right;">
            <a href="blog" class="back-button">Lihat Semua Blog →</a>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../src/View/partials/footer.php'; ?>
