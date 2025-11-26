<?php

declare(strict_types=1);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once 'config.php';
require_once 'skema_functions.php';

$skemaManager = new SkemaManager($conn);

$skema_list = $skemaManager->getAllSkema();

$filter_jenis = isset($_GET['jenis']) ? $_GET['jenis'] : '';
if ($filter_jenis) {
    $skema_list = array_filter($skema_list, function ($skema) use ($filter_jenis) {
        return $skema['jenis'] === $filter_jenis;
    });
}

$search_term = isset($_GET['search']) ? trim($_GET['search']) : '';
if ($search_term) {
    $skema_list = array_filter($skema_list, function ($skema) use ($search_term) {
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
</head>

<body id="page-top">
    <nav class="navbar navbar-expand-lg text-uppercase fixed-top" id="mainNav">
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

    <div class="container">
        <aside>
            <h3>Skema Sertifikasi</h3>
            <p><strong>Filter by</strong></p>
            <div class="filter-section">
                <select class="filter-select" onchange="filterByJenis(this.value)">
                    <option value="">Semua Jenis</option>
                    <option value="Klaster" <?= $filter_jenis === 'Klaster' ? 'selected' : ''; ?>>Klaster</option>
                    <option value="Okupasi" <?= $filter_jenis === 'Okupasi' ? 'selected' : ''; ?>>Okupasi</option>
                    <option value="Mandiri" <?= $filter_jenis === 'Mandiri' ? 'selected' : ''; ?>>Mandiri</option>
                </select>
            </div>
            <ul>
                <li class="bold-item"><a href="sertifikasi.php" style="text-decoration: none; color: inherit;">Semua Skema:</a></li>
                <li><a href="sertifikasi.php?jenis=Klaster" style="text-decoration: none; color: inherit;">Skema Klaster</a></li>
                <li><a href="sertifikasi.php?jenis=Okupasi" style="text-decoration: none; color: inherit;">Skema Okupasi</a></li>
                <li><a href="sertifikasi.php?jenis=Mandiri" style="text-decoration: none; color: inherit;">Skema Mandiri</a></li>
            </ul>
        </aside>

        <main>
            <form method="GET" action="sertifikasi.php" style="margin-bottom: 2rem;">
                <input type="text" class="search-box" name="search" value="<?= htmlspecialchars($search_term); ?>" placeholder="Cari skema sertifikasi berdasarkan nama, kode, atau deskripsi">
                <?php if ($filter_jenis) : ?>
                    <input type="hidden" name="jenis" value="<?= htmlspecialchars($filter_jenis); ?>">
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
                    (<?= count($skema_list); ?> skema ditemukan)
                </span>
            </h2>

            <?php if (empty($skema_list)) : ?>
                <div class="no-results">
                    <h3>Tidak ada skema yang ditemukan</h3>
                    <p>Silakan coba dengan kata kunci atau filter yang berbeda.</p>
                    <a href="sertifikasi.php" style="color: #3498db; text-decoration: none;">← Kembali ke semua skema</a>
                </div>
            <?php else : ?>
                <div class="card-grid">
                    <?php foreach ($skema_list as $skema) : ?>
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title"><?= htmlspecialchars($skema['nama']); ?></div>
                                <div class="card-code">Kode: <?= htmlspecialchars($skema['kode']); ?></div>
                            </div>

                            <div class="card-info">
                                <div class="info-item">
                                    <span class="info-label">Jenis</span>
                                    <span class="info-value"><?= htmlspecialchars($skema['jenis']); ?></span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Unit Kompetensi</span>
                                    <span class="info-value"><?= $skema['unit_kompetensi']; ?></span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Harga</span>
                                    <span class="info-value price">Rp <?= number_format((float)$skema['harga'], 0, ',', '.'); ?></span>
                                </div>
                            </div>

                            <div class="card-description">
                                <?= htmlspecialchars(substr($skema['ringkasan'], 0, 120)) . (strlen($skema['ringkasan']) > 120 ? '...' : ''); ?>
                            </div>

                            <button onclick="window.location.href='skema.php?id=<?= $skema['id']; ?>'">
                                Lihat Skema
                            </button>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </main>
    </div>

    <script>
        function filterByJenis(jenis) {
            const url = new URL(window.location.href);
            if (jenis) {
                url.searchParams.set('jenis', jenis);
            } else {
                url.searchParams.delete('jenis');
            }
            window.location.href = url.toString();
        }
    </script>


    <?php include 'includes/footer.php'; ?>
</body>

</html>
