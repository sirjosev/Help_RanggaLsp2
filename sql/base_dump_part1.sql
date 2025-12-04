-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 04, 2025 at 08:11 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dks`
--

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `featured_image` varchar(255) DEFAULT NULL,
  `publish_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` enum('draft','published') DEFAULT 'draft'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`id`, `title`, `author`, `content`, `featured_image`, `publish_date`, `created_at`, `updated_at`, `status`) VALUES
(1, 'tes', 'tes', '<p>ssdfsf<img src=\"assets/content/684a918a08a82.jpeg\"></p>', 'assets/img/684a918a0aec6.jpg', '2025-06-12', '2025-06-12 08:36:26', '2025-11-28 10:47:01', 'published'),
(2, 'annjay', 'penulis', '<p>safafsaijadwjiadjaw</p>', 'assets/img/684aec3bbcfe2.png', '2025-06-12', '2025-06-12 15:03:24', '2025-11-26 09:45:49', 'published');

-- --------------------------------------------------------

--
-- Table structure for table `dokumen_persyaratan`
--

CREATE TABLE `dokumen_persyaratan` (
  `id` int(11) NOT NULL,
  `skema_id` int(11) NOT NULL,
  `nama_dokumen` varchar(255) NOT NULL,
  `wajib` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dokumen_persyaratan`
--

INSERT INTO `dokumen_persyaratan` (`id`, `skema_id`, `nama_dokumen`, `wajib`, `created_at`) VALUES
(51, 9, 'ASD', 0, '2025-06-12 07:40:31'),
(54, 1, 'Fotokopi Ijazah terakhir', 1, '2025-06-12 07:46:01'),
(55, 1, 'Fotokopi KTP', 1, '2025-06-12 07:46:01'),
(56, 1, 'Pas Foto 3x4 (2 lembar)', 1, '2025-06-12 07:46:01'),
(57, 1, 'Portofolio (jika ada pengalaman)', 0, '2025-06-12 07:46:01'),
(64, 12, 'BN,MN', 1, '2025-06-12 08:07:01'),
(65, 12, 'ASD', 1, '2025-06-12 08:07:01'),
(66, 20, 'adw', 1, '2025-06-12 14:57:27'),
(68, 21, 'v v', 1, '2025-06-12 14:59:56'),
(69, 22, 'ktp', 1, '2025-06-23 09:09:11'),
(71, 24, 'nds', 1, '2025-06-23 12:06:08'),
(72, 25, 'fadfs', 0, '2025-10-29 15:11:57');

-- --------------------------------------------------------

--
-- Table structure for table `metode_asesmen`
--

CREATE TABLE `metode_asesmen` (
  `id` int(11) NOT NULL,
  `skema_id` int(11) NOT NULL,
  `jenis_peserta` enum('Berpengalaman','Belum Berpengalaman') NOT NULL,
  `metode` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `metode_asesmen`
--

INSERT INTO `metode_asesmen` (`id`, `skema_id`, `jenis_peserta`, `metode`, `deskripsi`, `created_at`) VALUES
(40, 9, 'Belum Berpengalaman', 'ASD', 'ASD', '2025-06-12 07:40:31'),
(43, 1, 'Berpengalaman', 'Asesmen Portofolio dan Wawancara', 'Untuk peserta yang sudah memiliki pengalaman di bidang digital marketing', '2025-06-12 07:46:01'),
(44, 1, 'Belum Berpengalaman', 'Observasi Demonstrasi dan Tes Lisan', 'Untuk peserta yang belum memiliki pengalaman kerja di bidang digital marketing', '2025-06-12 07:46:01'),
(51, 12, 'Berpengalaman', 'asdaasda', 'NKJJNJKN', '2025-06-12 08:07:01'),
(52, 12, 'Berpengalaman', 'QADA', 'SADAD', '2025-06-12 08:07:01'),
(53, 20, 'Berpengalaman', 'sfawa', 'vkamfsldsd', '2025-06-12 14:57:27'),
(55, 21, 'Berpengalaman', '124sfdg', 'mhkjhi', '2025-06-12 14:59:56'),
(56, 22, 'Berpengalaman', 'sfawa', 'adaf', '2025-06-23 09:09:11'),
(58, 24, 'Berpengalaman', 'fds', 'gfds', '2025-06-23 12:06:08'),
(59, 25, 'Berpengalaman', 'fasfs', 'fadfa', '2025-10-29 15:11:57');

-- --------------------------------------------------------

--
-- Table structure for table `pemeliharaan`
--

CREATE TABLE `pemeliharaan` (
  `id` int(11) NOT NULL,
  `skema_id` int(11) NOT NULL,
  `deskripsi` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pemeliharaan`
--

INSERT INTO `pemeliharaan` (`id`, `skema_id`, `deskripsi`, `created_at`, `updated_at`) VALUES
(26, 9, 'ZZ', '2025-06-12 07:40:31', '2025-06-12 07:40:31'),
(31, 12, 'JHBHBKASDADAD', '2025-06-12 08:07:01', '2025-06-12 08:07:01'),
(32, 20, 'sa dwmdmqwlmldq', '2025-06-12 14:57:27', '2025-06-12 14:57:27'),
(34, 21, 'cxxhcgcjjc ', '2025-06-12 14:59:56', '2025-06-12 14:59:56'),
(35, 22, 'hjkl', '2025-06-23 09:09:11', '2025-06-23 09:09:11'),
(37, 24, 'gfdsasx', '2025-06-23 12:06:08', '2025-06-23 12:06:08'),
(38, 25, 'fsadfasf', '2025-10-29 15:11:57', '2025-10-29 15:11:57');

-- --------------------------------------------------------

--
-- Table structure for table `persyaratan`
--

CREATE TABLE `persyaratan` (
  `id` int(11) NOT NULL,
  `skema_id` int(11) NOT NULL,
  `deskripsi` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `persyaratan`
--

INSERT INTO `persyaratan` (`id`, `skema_id`, `deskripsi`, `created_at`) VALUES
(39, 9, 'ASD', '2025-06-12 07:40:31'),
(42, 1, 'Minimal Lulusan SMA/SMK Sederajat', '2025-06-12 07:46:01'),
(43, 1, 'Berpengalaman kerja atau pelatihan bidang terkait', '2025-06-12 07:46:01'),
(50, 12, 'JHGJHGJH', '2025-06-12 08:07:01'),
(51, 12, 'ASDD', '2025-06-12 08:07:01'),
(52, 20, 'wada', '2025-06-12 14:57:27'),
(54, 21, 'cxfgfxxhxgcgj', '2025-06-12 14:59:56'),
(55, 22, 'faf', '2025-06-23 09:09:11'),
(57, 24, 'jvkclds', '2025-06-23 12:06:08'),
(58, 25, 'faf', '2025-10-29 15:11:57');

-- --------------------------------------------------------

--
-- Table structure for table `photos`
--

CREATE TABLE `photos` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `file_path` varchar(255) NOT NULL,
  `alt_text` varchar(255) DEFAULT NULL,
  `status` enum('draft','published') NOT NULL DEFAULT 'draft',
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `skema`
--

CREATE TABLE `skema` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `kode` varchar(50) NOT NULL,
  `jenis` enum('Klaster','Okupasi','Mandiri') NOT NULL,
  `harga` decimal(12,2) NOT NULL,
  `unit_kompetensi` int(11) NOT NULL,
  `ringkasan` text DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `masa_berlaku` int(11) DEFAULT 3,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `skema`
--

INSERT INTO `skema` (`id`, `nama`, `kode`, `jenis`, `harga`, `unit_kompetensi`, `ringkasan`, `gambar`, `masa_berlaku`, `created_at`, `updated_at`) VALUES
(1, 'Digital Marketing', 'SKM-LSPTD-036', 'Klaster', 1000000.00, 11, 'Melakukan aktivitas promosi untuk sebuah produk atau brand menggunakan media digital. Profesi terkait dengan bidang pemasaran digital, social media specialist, content creator, dan digital advertising specialist.', 'skema_684a85b966a8b.png', 3, '2025-05-29 14:47:14', '2025-06-12 07:46:01'),
(9, 'es kobok', 'asd', 'Klaster', 12121212.00, 12, 'dda', 'skema_684a846f75de4.png', 3, '2025-06-07 11:10:49', '2025-06-12 07:40:31'),
(12, 'es doger', '12asdajdads', 'Klaster', 20000.00, 12, 'ASNLkmaskNSLknaslnKASNLlnslANSsasAAS', 'skema_684a8aa598481.png', 5, '2025-06-09 14:07:49', '2025-06-12 08:07:01'),
(20, 'wdq', 'qwe213', 'Okupasi', 1232313.00, 1, 'adwafawfwa', 'skema_684aead748c8a.png', 3, '2025-06-12 14:57:27', '2025-06-12 14:57:27'),
(21, 'vcvchcj', '2135', 'Mandiri', 12233455.00, 123, 'gfhgfjudytd', 'skema_684aeb6cccfa4.png', 3, '2025-06-12 14:59:29', '2025-06-12 14:59:56'),
(22, 'fhaf', '567', 'Okupasi', 232.00, 2, 'yaayay', 'skema_685919b768224.png', 3, '2025-06-23 09:09:11', '2025-06-23 09:09:11'),
(24, 'es doger', 'sdakdk21', 'Okupasi', 344.00, 22, 'gfds', 'skema_68594330cae42.png', 3, '2025-06-23 12:06:08', '2025-06-23 12:06:08'),
(25, 'JUNIOR WEB PROGRAMMER', 'SKM-TIK-001-2022', 'Klaster', 8.00, 23, '234rt', 'skema_69022ebdbacdd.jpg', 3, '2025-10-29 15:10:05', '2025-10-29 15:11:57'),
(26, 'DIGITAL MARKETING', 'SKM-PEM-001-2022', 'Klaster', 0.00, 0, NULL, NULL, 3, '2025-10-29 15:10:05', '2025-10-29 15:10:05'),
(27, 'NETWORK ADMINISTRATOR MUDA', 'SKM-TIK-002-2022', 'Klaster', 0.00, 0, NULL, NULL, 3, '2025-10-29 15:10:05', '2025-10-29 15:10:05'),
(28, 'PENGEMBANGAN APLIKASI BASIS DATA', 'SKM-TIK-003-2022', 'Klaster', 0.00, 0, NULL, NULL, 3, '2025-10-29 15:10:05', '2025-10-29 15:10:05'),
(29, 'ANALIS PROGRAM', 'SKM-TIK-004-2022', 'Klaster', 0.00, 0, NULL, NULL, 3, '2025-10-29 15:10:05', '2025-10-29 15:10:05'),
(30, 'PERANCANGAN SISTEM INFORMASI', 'SKM-TIK-005-2022', 'Klaster', 0.00, 0, NULL, NULL, 3, '2025-10-29 15:10:05', '2025-10-29 15:10:05'),
(31, 'JUNIOR OFFICE OPERATOR', 'SKM-TIK-006-2022', 'Klaster', 0.00, 0, NULL, NULL, 3, '2025-10-29 15:10:05', '2025-10-29 15:10:05'),
(32, 'DESAIN GRAFIS MUDA', 'SKM-DKV-001-2022', 'Klaster', 0.00, 0, NULL, NULL, 3, '2025-10-29 15:10:05', '2025-10-29 15:10:05'),
(33, 'DESAINER GRAFIS UTAMA', 'SKM-DKV-002-2022', 'Klaster', 0.00, 0, NULL, NULL, 3, '2025-10-29 15:10:05', '2025-10-29 15:10:05'),
(34, 'WEB DEVELOPER', 'SKM-TIK-007-2022', 'Klaster', 0.00, 0, NULL, NULL, 3, '2025-10-29 15:10:05', '2025-10-29 15:10:05'),
(35, 'VIDEO EDITOR', 'SKM-DKV-003-2022', 'Klaster', 0.00, 0, NULL, NULL, 3, '2025-10-29 15:10:05', '2025-10-29 15:10:05'),
(36, 'FOTOGRAFER', 'SKM-DKV-004-2022', 'Klaster', 0.00, 0, NULL, NULL, 3, '2025-10-29 15:10:05', '2025-10-29 15:10:05'),
(37, 'MOBILE PROGRAMMER', 'SKM-TIK-008-2022', 'Klaster', 0.00, 0, NULL, NULL, 3, '2025-10-29 15:10:05', '2025-10-29 15:10:05'),
(38, 'ANIMATOR MUDA', 'SKM-DKV-005-2022', 'Klaster', 0.00, 0, NULL, NULL, 3, '2025-10-29 15:10:05', '2025-10-29 15:10:05'),
(39, 'COMPUTER TECHNICAL SUPPORT', 'SKM-TIK-009-2022', 'Klaster', 0.00, 0, NULL, NULL, 3, '2025-10-29 15:10:05', '2025-10-29 15:10:05'),
(40, 'PENGELOLAAN ADMINISTRASI PERKANTORAN', 'SKM-ADM-001-2022', 'Klaster', 0.00, 0, NULL, NULL, 3, '2025-10-29 15:10:05', '2025-10-29 15:10:05'),
(41, 'PENGOPERASIAN PERALATAN KANTOR', 'SKM-ADM-002-2022', 'Klaster', 0.00, 0, NULL, NULL, 3, '2025-10-29 15:10:05', '2025-10-29 15:10:05'),
(42, 'PENYELESAIAN SIKLUS AKUNTANSI', 'SKM-AKT-001-2022', 'Klaster', 0.00, 0, NULL, NULL, 3, '2025-10-29 15:10:05', '2025-10-29 15:10:05'),
(43, 'PENGOPERASIAN APLIKASI KOMPUTER AKUNTANSI', 'SKM-AKT-002-2022', 'Klaster', 0.00, 0, NULL, NULL, 3, '2025-10-29 15:10:05', '2025-10-29 15:10:05'),
(44, 'TEKNISI AKUNTANSI MUDA', 'SKM-AKT-003-2022', 'Klaster', 0.00, 0, NULL, NULL, 3, '2025-10-29 15:10:05', '2025-10-29 15:10:05'),
(45, 'CONTENT CREATOR', 'SKM-DKV-006-2022', 'Klaster', 0.00, 0, NULL, NULL, 3, '2025-10-29 15:10:05', '2025-10-29 15:10:05'),
(46, 'JUNIOR MULTIMEDIA DESIGNER', 'SKM-DKV-007-2022', 'Klaster', 0.00, 0, NULL, NULL, 3, '2025-10-29 15:10:05', '2025-10-29 15:10:05'),
(47, 'PEMROGRAMAN WEB', 'SKM-TIK-010-2022', 'Klaster', 0.00, 0, NULL, NULL, 3, '2025-10-29 15:10:05', '2025-10-29 15:10:05'),
(48, 'PENGEMBANGAN WEB PRATAMA', 'SKM-TIK-011-2022', 'Klaster', 0.00, 0, NULL, NULL, 3, '2025-10-29 15:10:05', '2025-10-29 15:10:05'),
(49, 'CLOUD COMPUTING', 'SKM-TIK-012-2022', 'Klaster', 0.00, 0, NULL, NULL, 3, '2025-10-29 15:10:05', '2025-10-29 15:10:05');
