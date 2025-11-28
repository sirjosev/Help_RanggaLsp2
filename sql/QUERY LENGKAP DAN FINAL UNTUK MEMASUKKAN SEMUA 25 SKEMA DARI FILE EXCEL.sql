-- =================================================================================
-- QUERY LENGKAP DAN FINAL UNTUK MEMASUKKAN SEMUA 25 SKEMA DARI FILE EXCEL
-- =================================================================================
-- Dibuat berdasarkan file: "SKEMA n UNIT LSP DKS - Copy.xlsx"
-- Setiap blok 'START TRANSACTION' hingga 'COMMIT' adalah untuk satu skema.
-- Jalankan skrip ini untuk memasukkan semua data.

-- ---------------------------------------------------------------------------------
-- SKEMA 1: JUNIOR WEB PROGRAMMER - Kode: SKM-TIK-001-2022
-- ---------------------------------------------------------------------------------
START TRANSACTION;

-- Langkah 1: Masukkan data skema
INSERT INTO skema (kode, nama, created_at)
VALUES ('SKM-TIK-001-2022', 'JUNIOR WEB PROGRAMMER', NOW());
SET @last_skema_id = LAST_INSERT_ID();

-- Langkah 2: Hubungkan unit
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('J.620100.002.02', 'Menggunakan Algoritma Pemrograman Dasar', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'J.620100.002.02', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('J.620100.004.02', 'Mengimplementasikan Pemrograman Berorientasi Objek', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'J.620100.004.02', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('J.620100.005.02', 'Menggunakan Struktur Data', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'J.620100.005.02', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('J.620100.016.02', 'Menulis Kode dengan Prinsip Sesuai Guidelines dan Best Practices', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'J.620100.016.02', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('J.620100.020.02', 'Menggunakan SQL', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'J.620100.020.02', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('J.620100.025.02', 'Melakukan Debugging', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'J.620100.025.02', NOW());

COMMIT;

-- ---------------------------------------------------------------------------------
-- SKEMA 2: DIGITAL MARKETING - Kode: SKM-PEM-001-2022
-- ---------------------------------------------------------------------------------
START TRANSACTION;

-- Langkah 1: Masukkan data skema
INSERT INTO skema (kode, nama, created_at)
VALUES ('SKM-PEM-001-2022', 'DIGITAL MARKETING', NOW());
SET @last_skema_id = LAST_INSERT_ID();

-- Langkah 2: Hubungkan unit
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('M.701001.001.02', 'Mengidentifikasi Elemen Pemasaran Perusahaan', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'M.701001.001.02', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('M.701001.002.02', 'Melaksanakan Komunikasi Efektif', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'M.701001.002.02', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('M.701001.005.02', 'Melakukan Pendekatan kepada Calon Pelanggan', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'M.701001.005.02', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('M.701001.015.01', 'Menyusun Rencana Aktivitas Penjualan', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'M.701001.015.01', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('M.702090.009.01', 'Menggunakan Aplikasi Media Sosial', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'M.702090.009.01', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('M.702090.019.01', 'Melakukan Pemasaran melalui Mesin Pencari (Search Engine Marketing)', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'M.702090.019.01', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('M.702090.021.01', 'Membuat Rencana Konten Pemasaran Digital', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'M.702090.021.01', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('M.702090.022.01', 'Mendistribusikan Konten Pemasaran', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'M.702090.022.01', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('M.702090.025.01', 'Mengukur Kinerja Pemasaran Digital', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'M.702090.025.01', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('TIK.OP02.004.01', 'Mengoperasikan Piranti Lunak Pengolah Kata Tingkat Dasar', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'TIK.OP02.004.01', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('TIK.OP02.005.01', 'Mengoperasikan Piranti Lunak Lembar Sebar Tingkat Dasar', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'TIK.OP02.005.01', NOW());

COMMIT;

-- ---------------------------------------------------------------------------------
-- SKEMA 3: NETWORK ADMINISTRATOR MUDA - Kode: SKM-TIK-002-2022
-- ---------------------------------------------------------------------------------
START TRANSACTION;

-- Langkah 1: Masukkan data skema
INSERT INTO skema (kode, nama, created_at)
VALUES ('SKM-TIK-002-2022', 'NETWORK ADMINISTRATOR MUDA', NOW());
SET @last_skema_id = LAST_INSERT_ID();

-- Langkah 2: Hubungkan unit
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('J.611000.003.02', 'Merancang Pengalamatan Jaringan', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'J.611000.003.02', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('J.611000.005.02', 'Memasang Jaringan Nirkabel', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'J.611000.005.02', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('J.611000.010.02', 'Mengkonfigurasi Switch pada Jaringan', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'J.611000.010.02', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('J.611000.011.02', 'Mengkonfigurasi Routing pada Perangkat Jaringan dalam Satu Autonomous System', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'J.611000.011.02', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('J.611000.014.02', 'Memperbarui Konfigurasi Keamanan Jaringan', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'J.611000.014.02', NOW());

COMMIT;

-- ---------------------------------------------------------------------------------
-- SKEMA 4: PENGEMBANGAN APLIKASI BASIS DATA - Kode: SKM-TIK-003-2022
-- ---------------------------------------------------------------------------------
START TRANSACTION;

-- Langkah 1: Masukkan data skema
INSERT INTO skema (kode, nama, created_at)
VALUES ('SKM-TIK-003-2022', 'PENGEMBANGAN APLIKASI BASIS DATA', NOW());
SET @last_skema_id = LAST_INSERT_ID();

-- Langkah 2: Hubungkan unit
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('J.62DBI00.001.1', 'Mengidentifikasi Kebutuhan Pengguna untuk Aplikasi Basis Data', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'J.62DBI00.001.1', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('J.62DBI00.002.1', 'Membuat Model Data', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'J.62DBI00.002.1', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('J.62DBI00.003.1', 'Membuat Diagram Hubungan Antar Entitas (Entity Relationship Diagram)', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'J.62DBI00.003.1', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('J.62DBI00.004.1', 'Mentransformasikan Model Data Menjadi Skema Basis Data Fisik', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'J.62DBI00.004.1', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('J.62DBI00.005.1', 'Membuat Basis Data', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'J.62DBI00.005.1', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('J.62DBI00.006.1', 'Memanipulasi Data Menggunakan Perintah SQL', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'J.62DBI00.006.1', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('J.62DBI00.008.1', 'Membuat Objek-Objek Basis Data yang Dapat Diprogram (Programmable Objects)', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'J.62DBI00.008.1', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('J.62DBI00.010.1', 'Membuat Struktur Kendali Program (Program Control Structures)', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'J.62DBI00.010.1', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('J.62DBI00.011.1', 'Menggunakan Transaksi-Transaksi pada Basis Data', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'J.62DBI00.011.1', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('J.62DBI00.012.1', 'Membuat Kode Penanganan Kesalahan (Error Handling Code)', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'J.62DBI00.012.1', NOW());

COMMIT;

-- ---------------------------------------------------------------------------------
-- SKEMA 5: ANALIS PROGRAM - Kode: SKM-TIK-004-2022
-- ---------------------------------------------------------------------------------
START TRANSACTION;

-- Langkah 1: Masukkan data skema
INSERT INTO skema (kode, nama, created_at)
VALUES ('SKM-TIK-004-2022', 'ANALIS PROGRAM', NOW());
SET @last_skema_id = LAST_INSERT_ID();

-- Langkah 2: Hubungkan unit
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('J.620100.001.01', 'Menganalisis Tools', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'J.620100.001.01', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('J.620100.002.01', 'Menganalisis Skalabilitas Perangkat Lunak', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'J.620100.002.01', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('J.620100.003.01', 'Menganalisis Kualitas Perangkat Lunak', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'J.620100.003.01', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('J.620100.004.01', 'Menganalisis Arsitektur Perangkat Lunak', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'J.620100.004.01', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('J.620100.005.01', 'Menganalisis Kebutuhan Bisnis', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'J.620100.005.01', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('J.620100.006.01', 'Menganalisis Kebutuhan Fungsional', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'J.620100.006.01', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('J.620100.007.01', 'Menganalisis Kebutuhan Non Fungsional', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'J.620100.007.01', NOW());

COMMIT;

-- ---------------------------------------------------------------------------------
-- SKEMA 6: PERANCANGAN SISTEM INFORMASI - Kode: SKM-TIK-005-2022
-- ---------------------------------------------------------------------------------
START TRANSACTION;

-- Langkah 1: Masukkan data skema
INSERT INTO skema (kode, nama, created_at)
VALUES ('SKM-TIK-005-2022', 'PERANCANGAN SISTEM INFORMASI', NOW());
SET @last_skema_id = LAST_INSERT_ID();

-- Langkah 2: Hubungkan unit
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('J.62SAD00.001.1', 'Mengidentifikasi Kebutuhan Pengguna', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'J.62SAD00.001.1', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('J.62SAD00.002.1', 'Melakukan Analisis Kebutuhan Perangkat Lunak', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'J.62SAD00.002.1', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('J.62SAD00.003.1', 'Merancang Arsitektur Perangkat Lunak', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'J.62SAD00.003.1', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('J.62SAD00.004.1', 'Merancang Antarmuka Pengguna', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'J.62SAD00.004.1', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('J.62SAD00.005.1', 'Merancang Basis Data', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'J.62SAD00.005.1', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('J.62SAD00.006.1', 'Membuat Spesifikasi Kebutuhan Perangkat Lunak', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'J.62SAD00.006.1', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('J.62SAD00.008.1', 'Melakukan Verifikasi Kebutuhan Perangkat Lunak', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'J.62SAD00.008.1', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('J.62SAD00.009.1', 'Melakukan Validasi Kebutuhan Perangkat Lunak', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'J.62SAD00.009.1', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('J.62SAD00.010.1', 'Mengelola Perubahan Kebutuhan Perangkat Lunak', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'J.62SAD00.010.1', NOW());

COMMIT;

-- ---------------------------------------------------------------------------------
-- SKEMA 7: JUNIOR OFFICE OPERATOR - Kode: SKM-TIK-006-2022
-- ---------------------------------------------------------------------------------
START TRANSACTION;

-- Langkah 1: Masukkan data skema
INSERT INTO skema (kode, nama, created_at)
VALUES ('SKM-TIK-006-2022', 'JUNIOR OFFICE OPERATOR', NOW());
SET @last_skema_id = LAST_INSERT_ID();

-- Langkah 2: Hubungkan unit
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('J.63OPR00.001.2', 'Menggunakan Peralatan Periferal', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'J.63OPR00.001.2', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('J.63OPR00.002.2', 'Menggunakan Perangkat Lunak Pengolah Kata Tingkat Dasar', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'J.63OPR00.002.2', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('J.63OPR00.003.2', 'Menggunakan Perangkat Lunak Lembar Sebar Tingkat Dasar', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'J.63OPR00.003.2', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('J.63OPR00.004.2', 'Menggunakan Perangkat Lunak Presentasi Tingkat Dasar', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'J.63OPR00.004.2', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('J.63OPR00.005.2', 'Menggunakan Surel (Email) dan Mesin Pencari Informasi', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'J.63OPR00.005.2', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('J.63OPR00.006.2', 'Mengelola File dan Folder', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'J.63OPR00.006.2', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('J.63OPR00.007.2', 'Menggunakan Sistem Operasi', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'J.63OPR00.007.2', NOW());

COMMIT;

-- ---------------------------------------------------------------------------------
-- SKEMA 8: DESAIN GRAFIS MUDA - Kode: SKM-DKV-001-2022
-- ---------------------------------------------------------------------------------
START TRANSACTION;

-- Langkah 1: Masukkan data skema
INSERT INTO skema (kode, nama, created_at)
VALUES ('SKM-DKV-001-2022', 'DESAIN GRAFIS MUDA', NOW());
SET @last_skema_id = LAST_INSERT_ID();

-- Langkah 2: Hubungkan unit
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('M.74100.001.02', 'Menerapkan Prinsip Dasar Desain', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'M.74100.001.02', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('M.74100.002.02', 'Menerapkan Prinsip Dasar Komunikasi', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'M.74100.002.02', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('M.74100.005.02', 'Mengoperasikan Perangkat Lunak Desain', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'M.74100.005.02', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('M.74100.009.02', 'Menciptakan Karya Desain', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'M.74100.009.02', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('M.74100.010.01', 'Memilih dan Menata Tipografi', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'M.74100.010.01', NOW());

COMMIT;

-- ---------------------------------------------------------------------------------
-- SKEMA 9: DESAINER GRAFIS UTAMA - Kode: SKM-DKV-002-2022
-- ---------------------------------------------------------------------------------
START TRANSACTION;

-- Langkah 1: Masukkan data skema
INSERT INTO skema (kode, nama, created_at)
VALUES ('SKM-DKV-002-2022', 'DESAINER GRAFIS UTAMA', NOW());
SET @last_skema_id = LAST_INSERT_ID();

-- Langkah 2: Hubungkan unit
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('M.74100.001.02', 'Menerapkan Prinsip Dasar Desain', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'M.74100.001.02', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('M.74100.002.02', 'Menerapkan Prinsip Dasar Komunikasi', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'M.74100.002.02', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('M.74100.005.02', 'Mengoperasikan Perangkat Lunak Desain', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'M.74100.005.02', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('M.74100.009.02', 'Menciptakan Karya Desain', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'M.74100.009.02', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('M.74100.010.01', 'Memilih dan Menata Tipografi', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'M.74100.010.01', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('M.74DKV01.006.1', 'Menetapkan Strategi dan Metode Komunikasi', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'M.74DKV01.006.1', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('M.74DKV01.011.1', 'Melakukan Riset dan Analisis Data untuk Perancangan', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'M.74DKV01.011.1', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('M.74DKV01.012.1', 'Menetapkan Konsep Perancangan', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'M.74DKV01.012.1', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('M.74DKV01.016.1', 'Mempresentasikan Hasil Perancangan', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'M.74DKV01.016.1', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('M.74DKV01.020.1', 'Melakukan Evaluasi Hasil Perancangan', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'M.74DKV01.020.1', NOW());

COMMIT;

-- ---------------------------------------------------------------------------------
-- SKEMA 10: WEB DEVELOPER - Kode: SKM-TIK-007-2022
-- ---------------------------------------------------------------------------------
START TRANSACTION;

-- Langkah 1: Masukkan data skema
INSERT INTO skema (kode, nama, created_at)
VALUES ('SKM-TIK-007-2022', 'WEB DEVELOPER', NOW());
SET @last_skema_id = LAST_INSERT_ID();

-- Langkah 2: Hubungkan unit
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('J.620100.002.02', 'Menggunakan Algoritma Pemrograman Dasar', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'J.620100.002.02', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('J.620100.004.02', 'Mengimplementasikan Pemrograman Berorientasi Objek', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'J.620100.004.02', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('J.620100.005.02', 'Menggunakan Struktur Data', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'J.620100.005.02', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('J.620100.016.02', 'Menulis Kode dengan Prinsip Sesuai Guidelines dan Best Practices', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'J.620100.016.02', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('J.620100.020.02', 'Menggunakan SQL', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'J.620100.020.02', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('J.620100.025.02', 'Melakukan Debugging', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'J.620100.025.02', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('J.620100.041.01', 'Melaksanakan Cutover Aplikasi', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'J.620100.041.01', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('J.620100.045.01', 'Melakukan Pemantauan Resource yang Digunakan Aplikasi', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'J.620100.045.01', NOW());

COMMIT;

-- ---------------------------------------------------------------------------------
-- SKEMA 11: VIDEO EDITOR - Kode: SKM-DKV-003-2022
-- ---------------------------------------------------------------------------------
START TRANSACTION;

-- Langkah 1: Masukkan data skema
INSERT INTO skema (kode, nama, created_at)
VALUES ('SKM-DKV-003-2022', 'VIDEO EDITOR', NOW());
SET @last_skema_id = LAST_INSERT_ID();

-- Langkah 2: Hubungkan unit
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('TIK.MM01.003.01', 'Mengidentifikasi Kebutuhan Penyuntingan', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'TIK.MM01.003.01', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('TIK.MM02.052.01', 'Mengoperasikan Piranti Lunak Penyuntingan Audio Digital', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'TIK.MM02.052.01', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('TIK.MM02.062.01', 'Membaca Laporan dan Lembar Kerja Penyuntingan', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'TIK.MM02.062.01', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('TIK.MM02.064.01', 'Melakukan Penyuntingan Suara dan Gambar secara Offline', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'TIK.MM02.064.01', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('TIK.MM02.067.01', 'Menyiapkan Hasil Penyuntingan Gambar dan Suara', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'TIK.MM02.067.01', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('TIK.MM02.072.01', 'Mengoperasikan Piranti Lunak Penyuntingan Video Digital', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'TIK.MM02.072.01', NOW());

COMMIT;

-- ---------------------------------------------------------------------------------
-- SKEMA 12: FOTOGRAFER - Kode: SKM-DKV-004-2022
-- ---------------------------------------------------------------------------------
START TRANSACTION;

-- Langkah 1: Masukkan data skema
INSERT INTO skema (kode, nama, created_at)
VALUES ('SKM-DKV-004-2022', 'FOTOGRAFER', NOW());
SET @last_skema_id = LAST_INSERT_ID();

-- Langkah 2: Hubungkan unit
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('OP.02.001.01', 'Mengoperasikan Kamera Foto Digital', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'OP.02.001.01', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('OP.02.002.01', 'Mengoperasikan Piranti Lunak Pengolah Gambar Digital', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'OP.02.002.01', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('OP.02.003.01', 'Melakukan Fotografi Makro', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'OP.02.003.01', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('OP.02.004.01', 'Melakukan Fotografi Model', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'OP.02.004.01', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('OP.02.005.01', 'Melakukan Fotografi Jurnalistik', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'OP.02.005.01', NOW());

COMMIT;

-- ---------------------------------------------------------------------------------
-- SKEMA 13: MOBILE PROGRAMMER - Kode: SKM-TIK-008-2022
-- ---------------------------------------------------------------------------------
START TRANSACTION;

-- Langkah 1: Masukkan data skema
INSERT INTO skema (kode, nama, created_at)
VALUES ('SKM-TIK-008-2022', 'MOBILE PROGRAMMER', NOW());
SET @last_skema_id = LAST_INSERT_ID();

-- Langkah 2: Hubungkan unit
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('J.620100.002.02', 'Menggunakan Algoritma Pemrograman Dasar', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'J.620100.002.02', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('J.620100.004.02', 'Mengimplementasikan Pemrograman Berorientasi Objek', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'J.620100.004.02', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('J.620100.005.02', 'Menggunakan Struktur Data', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'J.620100.005.02', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('J.620100.016.02', 'Menulis Kode dengan Prinsip Sesuai Guidelines dan Best Practices', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'J.620100.016.02', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('J.620100.020.02', 'Menggunakan SQL', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'J.620100.020.02', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('J.620100.025.02', 'Melakukan Debugging', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'J.620100.025.02', NOW());

COMMIT;

-- ---------------------------------------------------------------------------------
-- SKEMA 14: ANIMATOR MUDA - Kode: SKM-DKV-005-2022
-- ---------------------------------------------------------------------------------
START TRANSACTION;

-- Langkah 1: Masukkan data skema
INSERT INTO skema (kode, nama, created_at)
VALUES ('SKM-DKV-005-2022', 'ANIMATOR MUDA', NOW());
SET @last_skema_id = LAST_INSERT_ID();

-- Langkah 2: Hubungkan unit
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('TIK.AM01.001.01', 'Menyumbang Saran Ide Kreatif dalam Tim Kerja', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'TIK.AM01.001.01', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('TIK.AM02.001.01', 'Membuat Gambar Kunci (Key Drawing)', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'TIK.AM02.001.01', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('TIK.AM02.002.01', 'Membuat Gambar Clean-Up dan Sisip', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'TIK.AM02.002.01', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('TIK.AM02.003.01', 'Menghasilkan Gambar Latar 2 Dimensi (2D)', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'TIK.AM02.003.01', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('TIK.AM02.004.01', 'Membuat Storyboard', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'TIK.AM02.004.01', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('TIK.AM02.006.01', 'Melakukan Proses Scanning', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'TIK.AM02.006.01', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('TIK.AM02.007.01', 'Mewarnai pada Lembar Animasi', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'TIK.AM02.007.01', NOW());

COMMIT;

-- ---------------------------------------------------------------------------------
-- SKEMA 15: COMPUTER TECHNICAL SUPPORT - Kode: SKM-TIK-009-2022
-- ---------------------------------------------------------------------------------
START TRANSACTION;

-- Langkah 1: Masukkan data skema
INSERT INTO skema (kode, nama, created_at)
VALUES ('SKM-TIK-009-2022', 'COMPUTER TECHNICAL SUPPORT', NOW());
SET @last_skema_id = LAST_INSERT_ID();

-- Langkah 2: Hubungkan unit
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('TIK.TE02.001.01', 'Menginstalasi PC', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'TIK.TE02.001.01', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('TIK.TE02.002.01', 'Mendiagnosis Permasalahan Pengoperasian PC yang Tersambung Jaringan', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'TIK.TE02.002.01', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('TIK.TE02.003.01', 'Melakukan Perbaikan dan atau Setting Ulang Sistem PC', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'TIK.TE02.003.01', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('TIK.TE02.004.01', 'Menginstalasi Sistem Operasi Berbasis GUI (Graphical User Interface)', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'TIK.TE02.004.01', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('TIK.TE02.006.01', 'Menginstalasi Perangkat Lunak', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'TIK.TE02.006.01', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('TIK.TE02.010.01', 'Menyambungkan Periferal Menggunakan Software', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'TIK.TE02.010.01', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('TIK.TE02.012.01', 'Mengidentifikasi Kebutuhan Pelanggan', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'TIK.TE02.012.01', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('TIK.TE02.013.01', 'Memperbaharui Pengetahuan Teknis', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'TIK.TE02.013.01', NOW());

COMMIT;

-- ---------------------------------------------------------------------------------
-- SKEMA 16: PENGELOLAAN ADMINISTRASI PERKANTORAN - Kode: SKM-ADM-001-2022
-- ---------------------------------------------------------------------------------
START TRANSACTION;

-- Langkah 1: Masukkan data skema
INSERT INTO skema (kode, nama, created_at)
VALUES ('SKM-ADM-001-2022', 'PENGELOLAAN ADMINISTRASI PERKANTORAN', NOW());
SET @last_skema_id = LAST_INSERT_ID();

-- Langkah 2: Hubungkan unit
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('N.821100.001.02', 'Mengelola Jadwal Kegiatan Pimpinan', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'N.821100.001.02', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('N.821100.002.02', 'Melakukan Komunikasi Melalui Telepon', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'N.821100.002.02', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('N.821100.003.02', 'Mengatur Rapat/Pertemuan', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'N.821100.003.02', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('N.821100.004.02', 'Membuat Notulen Rapat', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'N.821100.004.02', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('N.821100.005.02', 'Mengelola Kas Kecil', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'N.821100.005.02', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('N.821100.006.02', 'Mengelola Dokumen Kantor', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'N.821100.006.02', NOW());

COMMIT;

-- ---------------------------------------------------------------------------------
-- SKEMA 17: PENGOPERASIAN PERALATAN KANTOR - Kode: SKM-ADM-002-2022
-- ---------------------------------------------------------------------------------
START TRANSACTION;

-- Langkah 1: Masukkan data skema
INSERT INTO skema (kode, nama, created_at)
VALUES ('SKM-ADM-002-2022', 'PENGOPERASIAN PERALATAN KANTOR', NOW());
SET @last_skema_id = LAST_INSERT_ID();

-- Langkah 2: Hubungkan unit
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('N.821100.007.02', 'Mengoperasikan Aplikasi Perangkat Lunak', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'N.821100.007.02', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('N.821100.008.02', 'Menggunakan Peralatan Kantor', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'N.821100.008.02', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('N.821100.009.02', 'Melakukan Prosedur Administrasi', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'N.821100.009.02', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('N.821100.010.02', 'Menangani Surat Masuk dan Keluar', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'N.821100.010.02', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('N.821100.011.02', 'Mengelola Arsip', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'N.821100.011.02', NOW());

COMMIT;

-- ---------------------------------------------------------------------------------
-- SKEMA 18: PENYELESAIAN SIKLUS AKUNTANSI - Kode: SKM-AKT-001-2022
-- ---------------------------------------------------------------------------------
START TRANSACTION;

-- Langkah 1: Masukkan data skema
INSERT INTO skema (kode, nama, created_at)
VALUES ('SKM-AKT-001-2022', 'PENYELESAIAN SIKLUS AKUNTANSI', NOW());
SET @last_skema_id = LAST_INSERT_ID();

-- Langkah 2: Hubungkan unit
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('M.692000.001.02', 'Menerapkan Prinsip Praktik Profesional dalam Bekerja', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'M.692000.001.02', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('M.692000.002.02', 'Menerapkan Praktik-Praktik Kesehatan dan Keselamatan di Tempat Kerja', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'M.692000.002.02', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('M.692000.007.02', 'Memproses Entri Jurnal', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'M.692000.007.02', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('M.692000.008.02', 'Memproses Buku Besar', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'M.692000.008.02', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('M.692000.013.02', 'Menyusun Laporan Keuangan', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'M.692000.013.02', NOW());

COMMIT;

-- ---------------------------------------------------------------------------------
-- SKEMA 19: PENGOPERASIAN APLIKASI KOMPUTER AKUNTANSI - Kode: SKM-AKT-002-2022
-- ---------------------------------------------------------------------------------
START TRANSACTION;

-- Langkah 1: Masukkan data skema
INSERT INTO skema (kode, nama, created_at)
VALUES ('SKM-AKT-002-2022', 'PENGOPERASIAN APLIKASI KOMPUTER AKUNTANSI', NOW());
SET @last_skema_id = LAST_INSERT_ID();

-- Langkah 2: Hubungkan unit
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('M.692000.018.02', 'Mengoperasikan Paket Program Pengolah Angka/Spreadsheet', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'M.692000.018.02', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('M.692000.019.02', 'Mengoperasikan Aplikasi Komputer Akuntansi', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'M.692000.019.02', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('M.692000.020.02', 'Mengelola Kartu Piutang', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'M.692000.020.02', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('M.692000.021.02', 'Mengelola Kartu Utang', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'M.692000.021.02', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('M.692000.022.02', 'Mengelola Kartu Persediaan', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'M.692000.022.02', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('M.692000.023.02', 'Mengelola Kartu Aktiva Tetap', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'M.692000.023.02', NOW());

COMMIT;

-- ---------------------------------------------------------------------------------
-- SKEMA 20: TEKNISI AKUNTANSI MUDA - Kode: SKM-AKT-003-2022
-- ---------------------------------------------------------------------------------
START TRANSACTION;

-- Langkah 1: Masukkan data skema
INSERT INTO skema (kode, nama, created_at)
VALUES ('SKM-AKT-003-2022', 'TEKNISI AKUNTANSI MUDA', NOW());
SET @last_skema_id = LAST_INSERT_ID();

-- Langkah 2: Hubungkan unit
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('M.692000.001.02', 'Menerapkan Prinsip Praktik Profesional dalam Bekerja', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'M.692000.001.02', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('M.692000.002.02', 'Menerapkan Praktik-Praktik Kesehatan dan Keselamatan di Tempat Kerja', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'M.692000.002.02', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('M.692000.007.02', 'Memproses Entri Jurnal', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'M.692000.007.02', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('M.692000.008.02', 'Memproses Buku Besar', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'M.692000.008.02', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('M.692000.013.02', 'Menyusun Laporan Keuangan', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'M.692000.013.02', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('M.692000.018.02', 'Mengoperasikan Paket Program Pengolah Angka/Spreadsheet', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'M.692000.018.02', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('M.692000.019.02', 'Mengoperasikan Aplikasi Komputer Akuntansi', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'M.692000.019.02', NOW());

COMMIT;

-- ---------------------------------------------------------------------------------
-- SKEMA 21: CONTENT CREATOR - Kode: SKM-DKV-006-2022
-- ---------------------------------------------------------------------------------
START TRANSACTION;

-- Langkah 1: Masukkan data skema
INSERT INTO skema (kode, nama, created_at)
VALUES ('SKM-DKV-006-2022', 'CONTENT CREATOR', NOW());
SET @last_skema_id = LAST_INSERT_ID();

-- Langkah 2: Hubungkan unit
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('J.59TLM00.001.2', 'Menggunakan Kamera', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'J.59TLM00.001.2', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('J.59TLM00.003.2', 'Menggunakan Perekam Suara', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'J.59TLM00.003.2', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('J.59TLM00.005.2', 'Menata Suara', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'J.59TLM00.005.2', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('J.59TLM00.009.2', 'Menulis Naskah', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'J.59TLM00.009.2', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('J.59TLM00.011.2', 'Menyunting Gambar', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'J.59TLM00.011.2', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('J.59TLM00.012.2', 'Menyunting Suara', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'J.59TLM00.012.2', NOW());

COMMIT;

-- ---------------------------------------------------------------------------------
-- SKEMA 22: JUNIOR MULTIMEDIA DESIGNER - Kode: SKM-DKV-007-2022
-- ---------------------------------------------------------------------------------
START TRANSACTION;

-- Langkah 1: Masukkan data skema
INSERT INTO skema (kode, nama, created_at)
VALUES ('SKM-DKV-007-2022', 'JUNIOR MULTIMEDIA DESIGNER', NOW());
SET @last_skema_id = LAST_INSERT_ID();

-- Langkah 2: Hubungkan unit
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('TIK.MM01.005.01', 'Memperagakan Pengetahuan dan Syarat-Syarat Multimedia', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'TIK.MM01.005.01', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('TIK.MM02.012.01', 'Mengidentifikasi Komponen-Komponen Multimedia', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'TIK.MM02.012.01', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('TIK.MM02.015.01', 'Menggunakan Skenario untuk Memproduksi Multimedia', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'TIK.MM02.015.01', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('TIK.MM02.016.01', 'Membuat, Memanipulasi dan Menggabung Gambar 2D', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'TIK.MM02.016.01', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('TIK.MM02.025.01', 'Membuat, Memanipulasi dan Menggabung Teks ke dalam Sajian Multimedia', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'TIK.MM02.025.01', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('TIK.MM02.031.01', 'Membuat, Memanipulasi dan Menggabung Obyek 2D ke dalam Sajian Multimedia', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'TIK.MM02.031.01', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('TIK.MM02.074.01', 'Menyiapkan dan Menggabungkan Material Audio Digital', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'TIK.MM02.074.01', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('TIK.MM02.075.01', 'Mengedit Suara Digital', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'TIK.MM02.075.01', NOW());

COMMIT;

-- ---------------------------------------------------------------------------------
-- SKEMA 23: PEMROGRAMAN WEB - Kode: SKM-TIK-010-2022
-- ---------------------------------------------------------------------------------
START TRANSACTION;

-- Langkah 1: Masukkan data skema
INSERT INTO skema (kode, nama, created_at)
VALUES ('SKM-TIK-010-2022', 'PEMROGRAMAN WEB', NOW());
SET @last_skema_id = LAST_INSERT_ID();

-- Langkah 2: Hubungkan unit
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('J.62WEB00.001.2', 'Merancang Arsitektur dan Navigasi Web', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'J.62WEB00.001.2', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('J.62WEB00.002.2', 'Menggunakan Bahasa Markup', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'J.62WEB00.002.2', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('J.62WEB00.003.2', 'Membuat Program Sederhana Menggunakan Bahasa Pemrograman', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'J.62WEB00.003.2', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('J.62WEB00.004.2', 'Membuat Halaman Web Dinamis Tingkat Dasar', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'J.62WEB00.004.2', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('J.62WEB00.005.2', 'Membuat Halaman Web Dinamis Tingkat Lanjut', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'J.62WEB00.005.2', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('J.62WEB00.006.2', 'Menggunakan Library atau Komponen Pre-existing', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'J.62WEB00.006.2', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('J.62WEB00.007.2', 'Mengintegrasikan Basis Data dengan Halaman Web', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'J.62WEB00.007.2', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('J.62WEB00.008.2', 'Menggunakan Style Sheet pada Halaman Web', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'J.62WEB00.008.2', NOW());

COMMIT;

-- ---------------------------------------------------------------------------------
-- SKEMA 24: PENGEMBANGAN WEB PRATAMA - Kode: SKM-TIK-011-2022
-- ---------------------------------------------------------------------------------
START TRANSACTION;

-- Langkah 1: Masukkan data skema
INSERT INTO skema (kode, nama, created_at)
VALUES ('SKM-TIK-011-2022', 'PENGEMBANGAN WEB PRATAMA', NOW());
SET @last_skema_id = LAST_INSERT_ID();

-- Langkah 2: Hubungkan unit
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('J.620100.002.02', 'Menggunakan Algoritma Pemrograman Dasar', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'J.620100.002.02', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('J.620100.004.02', 'Mengimplementasikan Pemrograman Berorientasi Objek', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'J.620100.004.02', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('J.620100.005.02', 'Menggunakan Struktur Data', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'J.620100.005.02', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('J.620100.020.02', 'Menggunakan SQL', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'J.620100.020.02', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('J.62WEB00.002.2', 'Menggunakan Bahasa Markup', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'J.62WEB00.002.2', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('J.62WEB00.007.2', 'Mengintegrasikan Basis Data dengan Halaman Web', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'J.62WEB00.007.2', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('J.62WEB00.008.2', 'Menggunakan Style Sheet pada Halaman Web', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'J.62WEB00.008.2', NOW());

COMMIT;

-- ---------------------------------------------------------------------------------
-- SKEMA 25: CLOUD COMPUTING - Kode: SKM-TIK-012-2022
-- ---------------------------------------------------------------------------------
START TRANSACTION;

-- Langkah 1: Masukkan data skema
INSERT INTO skema (kode, nama, created_at)
VALUES ('SKM-TIK-012-2022', 'CLOUD COMPUTING', NOW());
SET @last_skema_id = LAST_INSERT_ID();

-- Langkah 2: Hubungkan unit
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('J.612000.001.1', 'Menerapkan Konsep Dasar Cloud Computing', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'J.612000.001.1', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('J.612000.002.1', 'Menggunakan Layanan Komputasi Awan', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'J.612000.002.1', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('J.612000.003.1', 'Menggunakan Perangkat Lunak Kolaboratif Berbasis Awan', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'J.612000.003.1', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('J.612000.004.1', 'Menyimpan Data di Layanan Penyimpanan Awan', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'J.612000.004.1', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('J.612000.005.1', 'Mengelola Keamanan Dasar pada Layanan Awan', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'J.612000.005.1', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('J.612000.006.1', 'Menggunakan Layanan Jaringan Awan', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'J.612000.006.1', NOW());
INSERT IGNORE INTO unit_kompetensi (kode_unit, judul_unit, created_at) VALUES ('J.612000.007.1', 'Menggunakan Layanan Basis Data Awan', NOW());
INSERT INTO unit_kompetensi (skema_id, kode_unit, created_at) VALUES (@last_skema_id, 'J.612000.007.1', NOW());

COMMIT;