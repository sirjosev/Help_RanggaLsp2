<?php
// Start the session if it hasn't been started yet
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once 'config.php';
require_once 'skema_functions.php';

$skemaManager = new SkemaManager($conn);

// Get all skema for listing
$skema_list = $skemaManager->getAllSkema();

// Filter by jenis if provided
$filter_jenis = isset($_GET['jenis']) ? $_GET['jenis'] : '';
if ($filter_jenis) {
    $skema_list = array_filter($skema_list, function($skema) use ($filter_jenis) {
        return $skema['jenis'] === $filter_jenis;
    });
}

// Search functionality
$search_term = isset($_GET['search']) ? trim($_GET['search']) : '';
if ($search_term) {
    $skema_list = array_filter($skema_list, function($skema) use ($search_term) {
        return stripos($skema['nama'], $search_term) !== false || 
               stripos($skema['kode'], $search_term) !== false ||
               stripos($skema['ringkasan'], $search_term) !== false;
    });
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Halaman Sertifikasi</title>
    <link rel="stylesheet" href="css/styles.css" />
    <link rel="stylesheet" href="css/sertifikasi.css" />
    <style>
        /* Additional styles for enhanced cards */
        .card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            padding: 1.5rem;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            /* text-align: left; /* Diterapkan di css/sertifikasi.css */
            display: flex; /* Memastikan flexbox diterapkan dari sini jika override */
            flex-direction: column;
            justify-content: space-between;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        .card-header {
            margin-bottom: 1rem;
        }

        .card-header {
            text-align: left; /* Pastikan header card rata kiri */
        }

        .card-title {
            font-size: 1.2rem;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 0.25rem; /* Kurangi margin bawah sedikit */
            word-break: break-word; /* Cegah overflow kata panjang */
        }

        .card-code {
            font-size: 0.85rem; /* Sedikit lebih kecil */
            color: #7f8c8d;
            margin-bottom: 0.75rem; /* Kurangi margin bawah */
            text-align: left; /* Pastikan rata kiri */
        }

        .card-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1rem;
            font-size: 0.85rem; /* Sesuaikan ukuran font info */
            text-align: left; /* Info item rata kiri secara default */
        }

        .info-item {
             /* text-align: center; /* Dihapus, default ke left dari .card-info */
             /* Jika ingin per item bisa diatur terpisah, tapi left lebih umum */
        }

        .info-label {
            color: #7f8c8d;
            font-size: 0.75rem; /* Sedikit lebih kecil */
            display: block;
            margin-bottom: 0.1rem;
        }

        .info-value {
            font-weight: bold;
            color: #2c3e50;
        }

        .price {
            color: #e74c3c;
            font-size: 1rem; /* Sesuaikan ukuran harga */
        }

        .card-description {
            color: #555; /* Sedikit lebih gelap untuk keterbacaan */
            line-height: 1.6; /* Sedikit lebih lega */
            margin-bottom: 1.5rem;
            text-align: left; /* Pastikan deskripsi rata kiri */
            font-size: 0.88rem; /* Sesuaikan ukuran font deskripsi */
            word-break: break-word; /* Cegah overflow kata panjang */
            flex-grow: 1; /* Biarkan deskripsi mengambil ruang tersedia */

            /* Properti untuk membatasi 2 baris dengan elipsis */
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 2;
            overflow: hidden;
            /* Pertimbangkan max-height sebagai fallback jika diperlukan, berdasarkan line-height * 2 */
             max-height: 2.816rem; /* (0.88rem * 1.6 line-height) * 2 baris */
        }

        .card button {
            width: 100%;
            padding: 0.7rem;
            background: linear-gradient(45deg, #3498db, #2c3e50);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .card button:hover {
            background: linear-gradient(45deg, #2980b9, #34495e);
            transform: translateY(-2px);
        }

        .search-box {
            width: 100%;
            padding: 0.8rem;
            margin-bottom: 2rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
        }
        body {
             padding-top: 140px; /* tinggi navbar (120px) + extra ruang */
        }

        .filter-section {
            margin-bottom: 2rem;
        }

        .filter-select {
            padding: 0.5rem 1rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: white;
            margin-bottom: 1rem;
        }

        .no-results {
            text-align: center;
            padding: 3rem;
            color: #7f8c8d;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .card-info {
                flex-direction: column;
                gap: 0.5rem;
            }
            
            .info-item {
                text-align: left; /* Sudah diatur di atas, ini untuk mobile override jika perlu */
            }
             .card-info .info-item { /* Pastikan info item di mobile juga rata kiri */
                text-align: left;
            }
            .card-title, .card-code, .card-description {
                text-align: left; /* Pastikan rata kiri di mobile juga */
            }
        }
    </style>
</head>

<body id="page-top">
    <!-- Navigation -->
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

    <!-- Content -->
    <div class="container">
        <!-- Sidebar -->
        <aside>
            <h3>Skema Sertifikasi</h3>
            <p><strong>Filter by</strong></p>
            <div class="filter-section">
                <select class="filter-select" onchange="filterByJenis(this.value)">
                    <option value="">Semua Jenis</option>
                    <option value="Klaster" <?php echo $filter_jenis === 'Klaster' ? 'selected' : ''; ?>>Klaster</option>
                    <option value="Okupasi" <?php echo $filter_jenis === 'Okupasi' ? 'selected' : ''; ?>>Okupasi</option>
                    <option value="Mandiri" <?php echo $filter_jenis === 'Mandiri' ? 'selected' : ''; ?>>Mandiri</option>
                </select>
            </div>
            <ul>
                <li><a href="sertifikasi.php" style="text-decoration: none; color: inherit;">Semua Skema</a></li>
                <li><a href="sertifikasi.php?jenis=Klaster" style="text-decoration: none; color: inherit;">Skema Klaster</a></li>
                <li><a href="sertifikasi.php?jenis=Okupasi" style="text-decoration: none; color: inherit;">Skema Okupasi</a></li>
                <li><a href="sertifikasi.php?jenis=Mandiri" style="text-decoration: none; color: inherit;">Skema Mandiri</a></li>
            </ul>
        </aside>

        <!-- Main -->
        <main>
            <form method="GET" action="sertifikasi.php" style="margin-bottom: 2rem;">
                <input type="text" 
                       class="search-box" 
                       name="search" 
                       value="<?php echo htmlspecialchars($search_term); ?>"
                       placeholder="Cari skema sertifikasi berdasarkan nama, kode, atau deskripsi">
                <?php if ($filter_jenis): ?>
                    <input type="hidden" name="jenis" value="<?php echo htmlspecialchars($filter_jenis); ?>">
                <?php endif; ?>
            </form>

            <h2>
                <?php 
                if ($search_term) {
                    echo "Hasil Pencarian untuk: \"" . htmlspecialchars($search_term) . "\"";
                } elseif ($filter_jenis) {
                    echo "Skema " . htmlspecialchars($filter_jenis);
                } else {
                    echo "Semua Skema";
                }
                ?>
                <span style="font-size: 0.8rem; color: #7f8c8d; font-weight: normal;">
                    (<?php echo count($skema_list); ?> skema ditemukan)
                </span>
            </h2>

            <?php if (empty($skema_list)): ?>
                <div class="no-results">
                    <h3>Tidak ada skema yang ditemukan</h3>
                    <p>Silakan coba dengan kata kunci atau filter yang berbeda.</p>
                    <a href="sertifikasi.php" style="color: #3498db; text-decoration: none;">← Kembali ke semua skema</a>
                </div>
            <?php else: ?>
                <div class="card-grid">
                    <?php foreach ($skema_list as $skema): ?>
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title"><?php echo htmlspecialchars($skema['nama']); ?></div>
                                <div class="card-code">Kode: <?php echo htmlspecialchars($skema['kode']); ?></div>
                            </div>
                            
                            <div class="card-info">
                                <div class="info-item">
                                    <span class="info-label">Jenis</span>
                                    <span class="info-value"><?php echo htmlspecialchars($skema['jenis']); ?></span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Unit Kompetensi</span>
                                    <span class="info-value"><?php echo $skema['unit_kompetensi']; ?></span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Harga</span>
                                    <span class="info-value price">Rp <?php echo number_format($skema['harga'], 0, ',', '.'); ?></span>
                                </div>
                            </div>
                            
                            <div class="card-description">
                                <?php echo htmlspecialchars(substr($skema['ringkasan'], 0, 120)) . (strlen($skema['ringkasan']) > 120 ? '...' : ''); ?>
                            </div>
                            
                            <button onclick="window.location.href='skema.php?id=<?php echo $skema['id']; ?>'">
                                Lihat Skema
                            </button>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </main>
    </div>

    <!-- Footer -->
    <footer class="footer"> <!-- Kelas text-center mungkin akan dihapus atau di-override oleh CSS custom -->
            <div class="container mb2rem">
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
                                width="100%" height="100" style="border:0; border-radius: 0.5rem;" allowfullscreen="" loading="lazy"
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

    <script>
        function filterByJenis(jenis) {
            const urlParams = new URLSearchParams(window.location.search);
            if (jenis) {
                urlParams.set('jenis', jenis);
            } else {
                urlParams.delete('jenis');
            }
            window.location.href = 'sertifikasi.php?' + urlParams.toString();
        }

        // Auto-submit search form on Enter
        document.querySelector('.search-box').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                this.form.submit();
            }
        });
    </script>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
    <!-- SB Forms JS -->
    <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
</body>

</html>