<?php

declare(strict_types=1);

require_once 'config.php';
require_once 'skema_functions.php';

$skemaManager = new SkemaManager($conn);

$skema_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if (!$skema_id) {
    header('Location: sertifikasi.php');
    exit;
}

$skema = $skemaManager->getSkemaById($skema_id);

if (!$skema) {
    header('Location: sertifikasi.php');
    exit;
}

$unit_kompetensi = $skemaManager->getUnitKompetensiBySkemaId($skema_id);
$persyaratan = $skemaManager->getPersyaratanBySkemaId($skema_id);
$dokumen_persyaratan = $skemaManager->getDokumenPersyaratanBySkemaId($skema_id);
$metode_asesmen = $skemaManager->getMetodeAsesmenBySkemaId($skema_id);
$metode_pengujian_list = $skemaManager->getMetodePengujianBySkemaId($skema_id);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= htmlspecialchars($skema['nama']); ?> - LSP DKS</title>
    <link rel="stylesheet" href="css/styles.css" />
    <link rel="stylesheet" href="css/skema.css" />
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-secondary text-uppercase fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand" href="#page-top">lsp-dks</a>
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

    <div class="container" style="margin-top: 120px; padding: 20px;">
        <a href="sertifikasi.php" class="back-button">← Kembali ke Daftar Sertifikasi</a>

        <section class="skema-section">
            <div class="text-center mb-4">
                <img src="<?= $skemaManager->getGambarPath($skema['gambar']); ?>" alt="<?= htmlspecialchars($skema['nama']); ?>" class="img-fluid rounded" style="max-height: 300px;">
            </div>
            <h2 class="skema-title"><?= htmlspecialchars($skema['nama']); ?></h2>
            <table class="skema-info-table">
                <tr>
                    <td>Nama</td>
                    <td>: <?= htmlspecialchars($skema['nama']); ?></td>
                </tr>
                <tr>
                    <td>Kode</td>
                    <td>: <?= htmlspecialchars($skema['kode']); ?></td>
                </tr>
                <tr>
                    <td>Jenis</td>
                    <td>: <?= htmlspecialchars($skema['jenis']); ?></td>
                </tr>
                <tr>
                    <td>Harga</td>
                    <td>: <span class="price">Rp <?= number_format((float)$skema['harga'], 0, ',', '.'); ?></span></td>
                </tr>
                <tr>
                    <td>Unit Kompetensi</td>
                    <td>: <?= $skema['unit_kompetensi']; ?> Unit</td>
                </tr>
                <tr>
                    <td>Masa Berlaku Sertifikat</td>
                    <td>: <?= htmlspecialchars($skema['masa_berlaku']); ?></td>
                </tr>
                <tr style="vertical-align: top;">
                    <td>Ringkasan</td>
                    <td>: <?= nl2br(htmlspecialchars($skema['ringkasan'])); ?></td>
                </tr>
            </table>

            <a href="https://sertifikasi.lspdks.co.id" target="_blank" class="register-button">Daftar Sekarang</a>
        </section>

        <section class="tab-section">
            <div class="tab-scroll" style="display: flex; gap: 10px; overflow-x: auto;">
                <div class="tabs" style="display: flex; gap: 5px;">
                    <div class="tab tab-active" onclick="showTab(event, 'unit')">Unit Kompetensi</div>
                    <div class="tab" onclick="showTab(event, 'persyaratan')">Persyaratan</div>
                    <div class="tab" onclick="showTab(event, 'dokumen')">Dokumen Persyaratan</div>
                    <div class="tab" onclick="showTab(event, 'asesmen')">Metode Asesmen</div>
                    <div class="tab" onclick="showTab(event, 'metode_pengujian')">Metode Pengujian</div>
                    <div class="tab" onclick="showTab(event, 'pemeliharaan')">Pemeliharaan</div>
                </div>
            </div>

            <div style="margin-top: 20px;">
                <div class="tab-content-box active" id="tab-unit">
                    <?php if (!empty($unit_kompetensi)) : ?>
                        <table class="unit-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Unit</th>
                                    <th>Judul Unit</th>
                                    <th>Standar Kompetensi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($unit_kompetensi as $index => $unit) : ?>
                                    <tr>
                                        <td><?= $index + 1; ?></td>
                                        <td><?= htmlspecialchars($unit['kode_unit']); ?></td>
                                        <td><?= htmlspecialchars($unit['judul_unit']); ?></td>
                                        <td><?= htmlspecialchars($unit['standar_kompetensi'] ?? '-'); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else : ?>
                        <p>Informasi unit kompetensi belum tersedia.</p>
                    <?php endif; ?>
                </div>

                <div class="tab-content-box" id="tab-persyaratan">
                    <?php if (!empty($persyaratan)) : ?>
                        <ul class="requirement-list">
                            <?php foreach ($persyaratan as $syarat) : ?>
                                <li><?= htmlspecialchars($syarat['deskripsi']); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else : ?>
                        <ul class="requirement-list">
                            <li>Minimal Lulusan SMA/SMK Sederajat</li>
                            <li>Berpengalaman kerja atau pelatihan bidang terkait</li>
                        </ul>
                    <?php endif; ?>
                </div>

                <div class="tab-content-box" id="tab-dokumen">
                    <?php if (!empty($dokumen_persyaratan)) : ?>
                        <ul class="requirement-list">
                            <?php foreach ($dokumen_persyaratan as $dokumen) : ?>
                                <li><?= htmlspecialchars($dokumen['nama_dokumen']); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else : ?>
                        <ul class="requirement-list">
                            <li>Fotokopi Ijazah terakhir</li>
                            <li>Fotokopi KTP</li>
                            <li>Pas Foto 3x4 (2 lembar)</li>
                            <li>Portofolio (jika ada pengalaman)</li>
                        </ul>
                    <?php endif; ?>
                </div>

                <div class="tab-content-box" id="tab-asesmen">
                    <?php if (!empty($metode_asesmen)) : ?>
                        <?php
                        $grouped_methods = [];
                        foreach ($metode_asesmen as $metode) {
                            $grouped_methods[$metode['jenis_peserta']][] = $metode;
                        }
                        ?>
                        <?php foreach ($grouped_methods as $kategori => $methods) : ?>
                            <div class="method-section">
                                <h4><?= htmlspecialchars($kategori); ?></h4>
                                <?php foreach ($methods as $method) : ?>
                                    <p><strong>Metode:</strong> <?= htmlspecialchars($method['metode']); ?></p>
                                    <?php if ($method['deskripsi']) : ?>
                                        <p><?= nl2br(htmlspecialchars($method['deskripsi'])); ?></p>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <div class="method-section">
                            <h4>Berpengalaman</h4>
                            <p><strong>Metode:</strong> Asesmen Portofolio dan Wawancara</p>
                        </div>
                        <div class="method-section">
                            <h4>Belum Berpengalaman</h4>
                            <p><strong>Metode:</strong> Observasi Demonstrasi dan Tes Lisan</p>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="tab-content-box" id="tab-pemeliharaan">
                    <?php
                    $pemeliharaan = $skemaManager->getPemeliharaanBySkemaId($skema_id);

                    if (!empty($pemeliharaan)) : ?>
                        <?php foreach ($pemeliharaan as $item) : ?>
                            <div class="method-section">
                                <?= nl2br(htmlspecialchars($item['deskripsi'])); ?>
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <div class="method-section">
                            <h4>Pemeliharaan Sertifikasi</h4>
                            <p>Untuk mempertahankan sertifikasi, pemegang sertifikat dapat mengikuti kegiatan asesmen ulang (re-asesmen) sebelum masa berlaku habis.</p>
                            <p><strong>Masa Berlaku Sertifikat:</strong> <?= htmlspecialchars($skema['masa_berlaku']); ?></p>
                            <p><strong>Proses Pemeliharaan:</strong></p>
                            <ul>
                                <li>Pengajuan permohonan re-asesmen 3 bulan sebelum masa berlaku habis</li>
                                <li>Penyerahan bukti pengembangan kompetensi berkelanjutan</li>
                                <li>Mengikuti asesmen pemeliharaan sesuai dengan metode yang ditentukan</li>
                            </ul>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="tab-content-box" id="tab-metode_pengujian">
                    <h3>Metode Pengujian yang Dapat Dipilih</h3>
                    <?php if (!empty($metode_pengujian_list)) : ?>
                        <ul class="requirement-list">
                            <?php foreach ($metode_pengujian_list as $metode_uji) : ?>
                                <li><?= htmlspecialchars($metode_uji); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else : ?>
                        <p>Informasi metode pengujian belum ditentukan untuk skema ini.</p>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    </div>

    <script>
        function showTab(event, tabName) {
            document.querySelectorAll('.tab').forEach(tab => tab.classList.remove('tab-active'));
            document.querySelectorAll('.tab-content-box').forEach(content => content.classList.remove('active'));
            document.querySelector(`#tab-${tabName}`).classList.add('active');
            event.target.classList.add('tab-active');
        }
    </script>

    <?php include 'includes/footer.php'; ?>
</body>

</html>
