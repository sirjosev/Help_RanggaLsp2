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
    <title>Profile - LSP DKS</title>
    <link rel="icon" type="image/x-icon" href="assets/img/logo-digitalcreativesolusi.png" />
    <link rel="stylesheet" href="css/styles.css" />
    <link rel="stylesheet" href="css/profile.css" />
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
                   <li class="nav-item mx-0 mx-lg-1">
                        <a class="btn btn-outline-light ms-3" href="https://sertifikasi.lspdks.co.id" target="_blank">Register</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Sejarah Singkat Section -->
    <section class="page-section bg-light first-page-section-after-nav" id="sejarah">
        <div class="container">
            <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">Profil & Sejarah Singkat</h2>
            <div class="divider-custom">
                <div class="divider-custom-line"></div>
                <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                <div class="divider-custom-line"></div>
            </div>
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <p class="lead text-muted">
                        LSP Digital Kreatif Solusi (LSP DKS) Memiliki Surat Dukungan B-6/BPSDM/HM.03.04/01/2024 dan dibentuk
                        atas
                        inisiasi dari Perkumpulan Ahli Digital TIK Modern (PERDITIKOM) yang didukung juga oleh Ikatan Ahli
                        Informatika Indonesia (IAII) dan Perkumpulan Trainer Digital Marketing Indonesia dengan Surat Keputusan
                        Nomor: 01/ PERDITIKOM/KEP/VII/2023 tanggal 21 Juli 2023 tentang Pembentukan Lembaga Sertifikasi Profesi
                        (LSP)
                        Digital Kreatif Solusi.
                    </p>
                    <p class="lead text-muted">
                        Adapun dukungan dari instansi pembina sektor TIK dalam hal ini KOMINFO RI sedang dalam proses pengajuan
                        (draft surat dan lampirannya sdh kami siapkan).
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Tujuan dan Sasaran Mutu Section -->
    <section class="page-section" id="tujuan-sasaran">
        <div class="container">
            <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">Tujuan Dan Sasaran Mutu</h2>
            <div class="divider-custom">
                <div class="divider-custom-line"></div>
                <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                <div class="divider-custom-line"></div>
            </div>
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <p class="lead text-muted">
                        LSP DKS (Lembaga Sertifikasi Profesi Digital Kreatif Solusi) melaksanakan kegiatan sesuai tugas pokok
                        dan
                        fungsi (tupoksi) yang ditetapkan Badan Nasional Sertifikasi Profesi (BNSP). Tupoksi yang dilaksanakan
                        LSP
                        DKS antara lain:
                    </p>
                    <ul class="lead text-muted" style="list-style-position: inside;">
                        <li>Penyusunan dan pengembangan skema sertifikasi.</li>
                        <li>Penyusunan perangkat asesmen dan materi uji kompetensi.</li>
                        <li>Penyediaan tenaga asesor.</li>
                        <li>Pelaksanaan dan pemeliharaan sertifikasi.</li>
                        <li>Penetapan persyaratan, verifikasi dan penetapan Tempat Uji Kompetensi (TUK).</li>
                        <li>Pemeliharaan kinerja asesor dan TUK.</li>
                        <li>Pengembangan pelayanan sertifikasi.</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

<?php include __DIR__ . '/../src/View/partials/footer.php'; ?>