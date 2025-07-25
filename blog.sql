CREATE TABLE `blog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `featured_image` varchar(255) DEFAULT NULL,
  `publish_date` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `blog` (`id`, `title`, `content`, `featured_image`, `publish_date`) VALUES
(1, 'Selamat Datang di LSP-DKS', 'Ini adalah artikel pertama di blog kami. Kami akan berbagi informasi terbaru tentang sertifikasi dan pelatihan di sini.', 'assets/img/portfolio/cabin.png', '2025-07-23 10:00:00'),
(2, 'Skema Sertifikasi Baru: Digital Marketing', 'Kami telah meluncurkan skema sertifikasi baru untuk para profesional pemasaran digital. Pelajari lebih lanjut tentang bagaimana Anda dapat meningkatkan karir Anda dengan sertifikasi ini.', 'assets/img/portfolio/cake.png', '2025-07-24 11:00:00'),
(3, 'Tips Sukses Ujian Sertifikasi', 'Berikut adalah beberapa tips untuk membantu Anda mempersiapkan dan lulus ujian sertifikasi Anda dengan percaya diri.', 'assets/img/portfolio/circus.png', '2025-07-25 12:00:00');
