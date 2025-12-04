
-- --------------------------------------------------------

--
-- Table structure for table `skema_metode_pengujian`
--

CREATE TABLE `skema_metode_pengujian` (
  `id` int(11) NOT NULL,
  `skema_id` int(11) NOT NULL,
  `metode_pengujian` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `skema_metode_pengujian`
--

INSERT INTO `skema_metode_pengujian` (`id`, `skema_id`, `metode_pengujian`) VALUES
(2, 25, 'Metode Paperless (non-kertas)');

-- --------------------------------------------------------

--
-- Table structure for table `unit_kompetensi`
--

CREATE TABLE `unit_kompetensi` (
  `id` int(11) NOT NULL,
  `skema_id` int(11) NOT NULL,
  `no_urut` int(11) NOT NULL,
  `kode_unit` varchar(50) NOT NULL,
  `judul_unit` varchar(255) NOT NULL,
  `standar_kompetensi` varchar(255) DEFAULT NULL,
  `lampiran_file` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `unit_kompetensi`
--

INSERT INTO `unit_kompetensi` (`id`, `skema_id`, `no_urut`, `kode_unit`, `judul_unit`, `standar_kompetensi`, `lampiran_file`, `created_at`) VALUES
(65, 9, 1, '12', '12', 'AS', NULL, '2025-06-12 07:40:31'),
(69, 1, 1, 'I.630PRO.001.2', 'Menggunakan Perangkat Komputer', 'SKKNI Pengoperasian Komputer Nomor 56 Tahun 2018', NULL, '2025-06-12 07:46:01'),
(79, 12, 1, '122ASSD', 'as', 'ADADS', NULL, '2025-06-12 08:07:01'),
(80, 12, 2, 'ASDASD212', 'asd', 'SAD', NULL, '2025-06-12 08:07:01'),
(81, 12, 3, 'ASDA', 'asd', 'ASDASD', NULL, '2025-06-12 08:07:01'),
(82, 20, 0, '1231241', 'dsacfaf', 'saa', NULL, '2025-06-12 14:57:27'),
(84, 21, 1, '12343', 'fsdff', '132', NULL, '2025-06-12 14:59:56'),
(85, 22, 2, '123', 'auf', 'ADADS', NULL, '2025-06-23 09:09:11'),
(87, 24, 1, '2', 'fghjk', '3124', NULL, '2025-06-23 12:06:08'),
(101, 26, 0, 'M.701001.001.02', '', NULL, NULL, '2025-10-29 15:10:05'),
(103, 26, 0, 'M.701001.002.02', '', NULL, NULL, '2025-10-29 15:10:05'),
(105, 26, 0, 'M.701001.005.02', '', NULL, NULL, '2025-10-29 15:10:05'),
(107, 26, 0, 'M.701001.015.01', '', NULL, NULL, '2025-10-29 15:10:05'),
(109, 26, 0, 'M.702090.009.01', '', NULL, NULL, '2025-10-29 15:10:05'),
(111, 26, 0, 'M.702090.019.01', '', NULL, NULL, '2025-10-29 15:10:05'),
(113, 26, 0, 'M.702090.021.01', '', NULL, NULL, '2025-10-29 15:10:05'),
(115, 26, 0, 'M.702090.022.01', '', NULL, NULL, '2025-10-29 15:10:05'),
(117, 26, 0, 'M.702090.025.01', '', NULL, NULL, '2025-10-29 15:10:05'),
(119, 26, 0, 'TIK.OP02.004.01', '', NULL, NULL, '2025-10-29 15:10:05'),
(121, 26, 0, 'TIK.OP02.005.01', '', NULL, NULL, '2025-10-29 15:10:05'),
(123, 27, 0, 'J.611000.003.02', '', NULL, NULL, '2025-10-29 15:10:05'),
(125, 27, 0, 'J.611000.005.02', '', NULL, NULL, '2025-10-29 15:10:05'),
(127, 27, 0, 'J.611000.010.02', '', NULL, NULL, '2025-10-29 15:10:05'),
(129, 27, 0, 'J.611000.011.02', '', NULL, NULL, '2025-10-29 15:10:05'),
(131, 27, 0, 'J.611000.014.02', '', NULL, NULL, '2025-10-29 15:10:05'),
(133, 28, 0, 'J.62DBI00.001.1', '', NULL, NULL, '2025-10-29 15:10:05'),
(135, 28, 0, 'J.62DBI00.002.1', '', NULL, NULL, '2025-10-29 15:10:05'),
(137, 28, 0, 'J.62DBI00.003.1', '', NULL, NULL, '2025-10-29 15:10:05'),
(139, 28, 0, 'J.62DBI00.004.1', '', NULL, NULL, '2025-10-29 15:10:05'),
(141, 28, 0, 'J.62DBI00.005.1', '', NULL, NULL, '2025-10-29 15:10:05'),
(143, 28, 0, 'J.62DBI00.006.1', '', NULL, NULL, '2025-10-29 15:10:05'),
(145, 28, 0, 'J.62DBI00.008.1', '', NULL, NULL, '2025-10-29 15:10:05'),
(147, 28, 0, 'J.62DBI00.010.1', '', NULL, NULL, '2025-10-29 15:10:05'),
(149, 28, 0, 'J.62DBI00.011.1', '', NULL, NULL, '2025-10-29 15:10:05'),
(151, 28, 0, 'J.62DBI00.012.1', '', NULL, NULL, '2025-10-29 15:10:05'),
(153, 29, 0, 'J.620100.001.01', '', NULL, NULL, '2025-10-29 15:10:05'),
(155, 29, 0, 'J.620100.002.01', '', NULL, NULL, '2025-10-29 15:10:05'),
(157, 29, 0, 'J.620100.003.01', '', NULL, NULL, '2025-10-29 15:10:05'),
(159, 29, 0, 'J.620100.004.01', '', NULL, NULL, '2025-10-29 15:10:05'),
(161, 29, 0, 'J.620100.005.01', '', NULL, NULL, '2025-10-29 15:10:05'),
(163, 29, 0, 'J.620100.006.01', '', NULL, NULL, '2025-10-29 15:10:05'),
(165, 29, 0, 'J.620100.007.01', '', NULL, NULL, '2025-10-29 15:10:05'),
(167, 30, 0, 'J.62SAD00.001.1', '', NULL, NULL, '2025-10-29 15:10:05'),
(169, 30, 0, 'J.62SAD00.002.1', '', NULL, NULL, '2025-10-29 15:10:05'),
(171, 30, 0, 'J.62SAD00.003.1', '', NULL, NULL, '2025-10-29 15:10:05'),
(173, 30, 0, 'J.62SAD00.004.1', '', NULL, NULL, '2025-10-29 15:10:05'),
(175, 30, 0, 'J.62SAD00.005.1', '', NULL, NULL, '2025-10-29 15:10:05'),
(177, 30, 0, 'J.62SAD00.006.1', '', NULL, NULL, '2025-10-29 15:10:05'),
(179, 30, 0, 'J.62SAD00.008.1', '', NULL, NULL, '2025-10-29 15:10:05'),
(181, 30, 0, 'J.62SAD00.009.1', '', NULL, NULL, '2025-10-29 15:10:05'),
(183, 30, 0, 'J.62SAD00.010.1', '', NULL, NULL, '2025-10-29 15:10:05'),
(185, 31, 0, 'J.63OPR00.001.2', '', NULL, NULL, '2025-10-29 15:10:05'),
(187, 31, 0, 'J.63OPR00.002.2', '', NULL, NULL, '2025-10-29 15:10:05'),
(189, 31, 0, 'J.63OPR00.003.2', '', NULL, NULL, '2025-10-29 15:10:05'),
(191, 31, 0, 'J.63OPR00.004.2', '', NULL, NULL, '2025-10-29 15:10:05'),
(193, 31, 0, 'J.63OPR00.005.2', '', NULL, NULL, '2025-10-29 15:10:05'),
(195, 31, 0, 'J.63OPR00.006.2', '', NULL, NULL, '2025-10-29 15:10:05'),
(197, 31, 0, 'J.63OPR00.007.2', '', NULL, NULL, '2025-10-29 15:10:05'),
(199, 32, 0, 'M.74100.001.02', '', NULL, NULL, '2025-10-29 15:10:05'),
(201, 32, 0, 'M.74100.002.02', '', NULL, NULL, '2025-10-29 15:10:05'),
(203, 32, 0, 'M.74100.005.02', '', NULL, NULL, '2025-10-29 15:10:05'),
(205, 32, 0, 'M.74100.009.02', '', NULL, NULL, '2025-10-29 15:10:05'),
(207, 32, 0, 'M.74100.010.01', '', NULL, NULL, '2025-10-29 15:10:05'),
(209, 33, 0, 'M.74100.001.02', '', NULL, NULL, '2025-10-29 15:10:05'),
(211, 33, 0, 'M.74100.002.02', '', NULL, NULL, '2025-10-29 15:10:05'),
(213, 33, 0, 'M.74100.005.02', '', NULL, NULL, '2025-10-29 15:10:05'),
(215, 33, 0, 'M.74100.009.02', '', NULL, NULL, '2025-10-29 15:10:05'),
(217, 33, 0, 'M.74100.010.01', '', NULL, NULL, '2025-10-29 15:10:05'),
(219, 33, 0, 'M.74DKV01.006.1', '', NULL, NULL, '2025-10-29 15:10:05'),
(221, 33, 0, 'M.74DKV01.011.1', '', NULL, NULL, '2025-10-29 15:10:05'),
(223, 33, 0, 'M.74DKV01.012.1', '', NULL, NULL, '2025-10-29 15:10:05'),
(225, 33, 0, 'M.74DKV01.016.1', '', NULL, NULL, '2025-10-29 15:10:05'),
(227, 33, 0, 'M.74DKV01.020.1', '', NULL, NULL, '2025-10-29 15:10:05'),
(229, 34, 0, 'J.620100.002.02', '', NULL, NULL, '2025-10-29 15:10:05'),
(231, 34, 0, 'J.620100.004.02', '', NULL, NULL, '2025-10-29 15:10:05'),
(233, 34, 0, 'J.620100.005.02', '', NULL, NULL, '2025-10-29 15:10:05'),
(235, 34, 0, 'J.620100.016.02', '', NULL, NULL, '2025-10-29 15:10:05'),
(237, 34, 0, 'J.620100.020.02', '', NULL, NULL, '2025-10-29 15:10:05'),
(239, 34, 0, 'J.620100.025.02', '', NULL, NULL, '2025-10-29 15:10:05'),
(241, 34, 0, 'J.620100.041.01', '', NULL, NULL, '2025-10-29 15:10:05'),
(243, 34, 0, 'J.620100.045.01', '', NULL, NULL, '2025-10-29 15:10:05'),
(245, 35, 0, 'TIK.MM01.003.01', '', NULL, NULL, '2025-10-29 15:10:05'),
(247, 35, 0, 'TIK.MM02.052.01', '', NULL, NULL, '2025-10-29 15:10:05'),
(249, 35, 0, 'TIK.MM02.062.01', '', NULL, NULL, '2025-10-29 15:10:05'),
(251, 35, 0, 'TIK.MM02.064.01', '', NULL, NULL, '2025-10-29 15:10:05'),
(253, 35, 0, 'TIK.MM02.067.01', '', NULL, NULL, '2025-10-29 15:10:05'),
(255, 35, 0, 'TIK.MM02.072.01', '', NULL, NULL, '2025-10-29 15:10:05'),
(257, 36, 0, 'OP.02.001.01', '', NULL, NULL, '2025-10-29 15:10:05'),
(259, 36, 0, 'OP.02.002.01', '', NULL, NULL, '2025-10-29 15:10:05'),
(261, 36, 0, 'OP.02.003.01', '', NULL, NULL, '2025-10-29 15:10:05'),
(263, 36, 0, 'OP.02.004.01', '', NULL, NULL, '2025-10-29 15:10:05'),
(265, 36, 0, 'OP.02.005.01', '', NULL, NULL, '2025-10-29 15:10:05'),
(267, 37, 0, 'J.620100.002.02', '', NULL, NULL, '2025-10-29 15:10:05'),
(269, 37, 0, 'J.620100.004.02', '', NULL, NULL, '2025-10-29 15:10:05'),
(271, 37, 0, 'J.620100.005.02', '', NULL, NULL, '2025-10-29 15:10:05'),
(273, 37, 0, 'J.620100.016.02', '', NULL, NULL, '2025-10-29 15:10:05'),
(275, 37, 0, 'J.620100.020.02', '', NULL, NULL, '2025-10-29 15:10:05'),
(277, 37, 0, 'J.620100.025.02', '', NULL, NULL, '2025-10-29 15:10:05'),
(279, 38, 0, 'TIK.AM01.001.01', '', NULL, NULL, '2025-10-29 15:10:05'),
(281, 38, 0, 'TIK.AM02.001.01', '', NULL, NULL, '2025-10-29 15:10:05'),
(283, 38, 0, 'TIK.AM02.002.01', '', NULL, NULL, '2025-10-29 15:10:05'),
(285, 38, 0, 'TIK.AM02.003.01', '', NULL, NULL, '2025-10-29 15:10:05'),
(287, 38, 0, 'TIK.AM02.004.01', '', NULL, NULL, '2025-10-29 15:10:05'),
(289, 38, 0, 'TIK.AM02.006.01', '', NULL, NULL, '2025-10-29 15:10:05'),
(291, 38, 0, 'TIK.AM02.007.01', '', NULL, NULL, '2025-10-29 15:10:05'),
(293, 39, 0, 'TIK.TE02.001.01', '', NULL, NULL, '2025-10-29 15:10:05'),
(295, 39, 0, 'TIK.TE02.002.01', '', NULL, NULL, '2025-10-29 15:10:05'),
(297, 39, 0, 'TIK.TE02.003.01', '', NULL, NULL, '2025-10-29 15:10:05'),
(299, 39, 0, 'TIK.TE02.004.01', '', NULL, NULL, '2025-10-29 15:10:05'),
(301, 39, 0, 'TIK.TE02.006.01', '', NULL, NULL, '2025-10-29 15:10:05'),
(303, 39, 0, 'TIK.TE02.010.01', '', NULL, NULL, '2025-10-29 15:10:05'),
(305, 39, 0, 'TIK.TE02.012.01', '', NULL, NULL, '2025-10-29 15:10:05'),
(307, 39, 0, 'TIK.TE02.013.01', '', NULL, NULL, '2025-10-29 15:10:05'),
(309, 40, 0, 'N.821100.001.02', '', NULL, NULL, '2025-10-29 15:10:05'),
(311, 40, 0, 'N.821100.002.02', '', NULL, NULL, '2025-10-29 15:10:05'),
(313, 40, 0, 'N.821100.003.02', '', NULL, NULL, '2025-10-29 15:10:05'),
(315, 40, 0, 'N.821100.004.02', '', NULL, NULL, '2025-10-29 15:10:05'),
(317, 40, 0, 'N.821100.005.02', '', NULL, NULL, '2025-10-29 15:10:05'),
(319, 40, 0, 'N.821100.006.02', '', NULL, NULL, '2025-10-29 15:10:05'),
(321, 41, 0, 'N.821100.007.02', '', NULL, NULL, '2025-10-29 15:10:05'),
(323, 41, 0, 'N.821100.008.02', '', NULL, NULL, '2025-10-29 15:10:05'),
(325, 41, 0, 'N.821100.009.02', '', NULL, NULL, '2025-10-29 15:10:05'),
(327, 41, 0, 'N.821100.010.02', '', NULL, NULL, '2025-10-29 15:10:05'),
(329, 41, 0, 'N.821100.011.02', '', NULL, NULL, '2025-10-29 15:10:05'),
(331, 42, 0, 'M.692000.001.02', '', NULL, NULL, '2025-10-29 15:10:05'),
(333, 42, 0, 'M.692000.002.02', '', NULL, NULL, '2025-10-29 15:10:05'),
(335, 42, 0, 'M.692000.007.02', '', NULL, NULL, '2025-10-29 15:10:05'),
(337, 42, 0, 'M.692000.008.02', '', NULL, NULL, '2025-10-29 15:10:05'),
(339, 42, 0, 'M.692000.013.02', '', NULL, NULL, '2025-10-29 15:10:05'),
(341, 43, 0, 'M.692000.018.02', '', NULL, NULL, '2025-10-29 15:10:05'),
(343, 43, 0, 'M.692000.019.02', '', NULL, NULL, '2025-10-29 15:10:05'),
(345, 43, 0, 'M.692000.020.02', '', NULL, NULL, '2025-10-29 15:10:05'),
(347, 43, 0, 'M.692000.021.02', '', NULL, NULL, '2025-10-29 15:10:05'),
(349, 43, 0, 'M.692000.022.02', '', NULL, NULL, '2025-10-29 15:10:05'),
(351, 43, 0, 'M.692000.023.02', '', NULL, NULL, '2025-10-29 15:10:05'),
(353, 44, 0, 'M.692000.001.02', '', NULL, NULL, '2025-10-29 15:10:05'),
(355, 44, 0, 'M.692000.002.02', '', NULL, NULL, '2025-10-29 15:10:05'),
(357, 44, 0, 'M.692000.007.02', '', NULL, NULL, '2025-10-29 15:10:05'),
(359, 44, 0, 'M.692000.008.02', '', NULL, NULL, '2025-10-29 15:10:05'),
(361, 44, 0, 'M.692000.013.02', '', NULL, NULL, '2025-10-29 15:10:05'),
(363, 44, 0, 'M.692000.018.02', '', NULL, NULL, '2025-10-29 15:10:05'),
(365, 44, 0, 'M.692000.019.02', '', NULL, NULL, '2025-10-29 15:10:05'),
(367, 45, 0, 'J.59TLM00.001.2', '', NULL, NULL, '2025-10-29 15:10:05'),
(369, 45, 0, 'J.59TLM00.003.2', '', NULL, NULL, '2025-10-29 15:10:05'),
(371, 45, 0, 'J.59TLM00.005.2', '', NULL, NULL, '2025-10-29 15:10:05'),
(373, 45, 0, 'J.59TLM00.009.2', '', NULL, NULL, '2025-10-29 15:10:05'),
(375, 45, 0, 'J.59TLM00.011.2', '', NULL, NULL, '2025-10-29 15:10:05'),
(377, 45, 0, 'J.59TLM00.012.2', '', NULL, NULL, '2025-10-29 15:10:05'),
(379, 46, 0, 'TIK.MM01.005.01', '', NULL, NULL, '2025-10-29 15:10:05'),
(381, 46, 0, 'TIK.MM02.012.01', '', NULL, NULL, '2025-10-29 15:10:05'),
(383, 46, 0, 'TIK.MM02.015.01', '', NULL, NULL, '2025-10-29 15:10:05'),
(385, 46, 0, 'TIK.MM02.016.01', '', NULL, NULL, '2025-10-29 15:10:05'),
(387, 46, 0, 'TIK.MM02.025.01', '', NULL, NULL, '2025-10-29 15:10:05'),
(389, 46, 0, 'TIK.MM02.031.01', '', NULL, NULL, '2025-10-29 15:10:05'),
(391, 46, 0, 'TIK.MM02.074.01', '', NULL, NULL, '2025-10-29 15:10:05'),
(393, 46, 0, 'TIK.MM02.075.01', '', NULL, NULL, '2025-10-29 15:10:05'),
(395, 47, 0, 'J.62WEB00.001.2', '', NULL, NULL, '2025-10-29 15:10:05'),
(397, 47, 0, 'J.62WEB00.002.2', '', NULL, NULL, '2025-10-29 15:10:05'),
(399, 47, 0, 'J.62WEB00.003.2', '', NULL, NULL, '2025-10-29 15:10:05'),
(401, 47, 0, 'J.62WEB00.004.2', '', NULL, NULL, '2025-10-29 15:10:05'),
(403, 47, 0, 'J.62WEB00.005.2', '', NULL, NULL, '2025-10-29 15:10:05'),
(405, 47, 0, 'J.62WEB00.006.2', '', NULL, NULL, '2025-10-29 15:10:05'),
(407, 47, 0, 'J.62WEB00.007.2', '', NULL, NULL, '2025-10-29 15:10:05'),
(409, 47, 0, 'J.62WEB00.008.2', '', NULL, NULL, '2025-10-29 15:10:05'),
(411, 48, 0, 'J.620100.002.02', '', NULL, NULL, '2025-10-29 15:10:05'),
(413, 48, 0, 'J.620100.004.02', '', NULL, NULL, '2025-10-29 15:10:05'),
(415, 48, 0, 'J.620100.005.02', '', NULL, NULL, '2025-10-29 15:10:05'),
(417, 48, 0, 'J.620100.020.02', '', NULL, NULL, '2025-10-29 15:10:05'),
(419, 48, 0, 'J.62WEB00.002.2', '', NULL, NULL, '2025-10-29 15:10:05'),
(421, 48, 0, 'J.62WEB00.007.2', '', NULL, NULL, '2025-10-29 15:10:05'),
(423, 48, 0, 'J.62WEB00.008.2', '', NULL, NULL, '2025-10-29 15:10:05'),
(425, 49, 0, 'J.612000.001.1', '', NULL, NULL, '2025-10-29 15:10:05'),
(427, 49, 0, 'J.612000.002.1', '', NULL, NULL, '2025-10-29 15:10:05'),
(429, 49, 0, 'J.612000.003.1', '', NULL, NULL, '2025-10-29 15:10:05'),
(431, 49, 0, 'J.612000.004.1', '', NULL, NULL, '2025-10-29 15:10:05'),
(433, 49, 0, 'J.612000.005.1', '', NULL, NULL, '2025-10-29 15:10:05'),
(435, 49, 0, 'J.612000.006.1', '', NULL, NULL, '2025-10-29 15:10:05'),
(437, 49, 0, 'J.612000.007.1', '', NULL, NULL, '2025-10-29 15:10:05'),
(438, 25, 1, 'J.620100.002.02', 'faffaf', 'fdas', NULL, '2025-10-29 15:11:57'),
(439, 25, 2, 'J.620100.004.02', 'dfa', 'fsda', NULL, '2025-10-29 15:11:57'),
(440, 25, 3, 'J.620100.005.02', 'fasd', 'fdfdaf', NULL, '2025-10-29 15:11:57'),
(441, 25, 4, 'J.620100.016.02', 'fdas', 'fdas', NULL, '2025-10-29 15:11:57'),
(442, 25, 5, 'J.620100.020.02', 'dsaf', 'fdas', NULL, '2025-10-29 15:11:57'),
(443, 25, 6, 'J.620100.025.02', 'fdas', 'fdas', NULL, '2025-10-29 15:11:57');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`) VALUES
('', 'tes', 'tes@gmail.com', '123'),
('', 'test2', 'tes2@gmail.com', '$2y$10$pnpptOF1Vn3VQnHIWMzcqeG9XWUmGqu4R.9c4hO33dV3KAapOkcxW');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dokumen_persyaratan`
--
ALTER TABLE `dokumen_persyaratan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `skema_id` (`skema_id`);

--
-- Indexes for table `metode_asesmen`
--
ALTER TABLE `metode_asesmen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `skema_id` (`skema_id`);

--
-- Indexes for table `pemeliharaan`
--
ALTER TABLE `pemeliharaan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `skema_id` (`skema_id`);

--
-- Indexes for table `persyaratan`
--
ALTER TABLE `persyaratan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `skema_id` (`skema_id`);

--
-- Indexes for table `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `skema`
--
ALTER TABLE `skema`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode` (`kode`);

--
-- Indexes for table `skema_metode_pengujian`
--
ALTER TABLE `skema_metode_pengujian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_skema_metode_pengujian_skema` (`skema_id`);

--
-- Indexes for table `unit_kompetensi`
--
ALTER TABLE `unit_kompetensi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `skema_id` (`skema_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `dokumen_persyaratan`
--
ALTER TABLE `dokumen_persyaratan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `metode_asesmen`
--
ALTER TABLE `metode_asesmen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `pemeliharaan`
--
ALTER TABLE `pemeliharaan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `persyaratan`
--
ALTER TABLE `persyaratan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `photos`
--
ALTER TABLE `photos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `skema`
--
ALTER TABLE `skema`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `skema_metode_pengujian`
--
ALTER TABLE `skema_metode_pengujian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `unit_kompetensi`
--
ALTER TABLE `unit_kompetensi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=444;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dokumen_persyaratan`
--
ALTER TABLE `dokumen_persyaratan`
  ADD CONSTRAINT `dokumen_persyaratan_ibfk_1` FOREIGN KEY (`skema_id`) REFERENCES `skema` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `metode_asesmen`
--
ALTER TABLE `metode_asesmen`
  ADD CONSTRAINT `metode_asesmen_ibfk_1` FOREIGN KEY (`skema_id`) REFERENCES `skema` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pemeliharaan`
--
ALTER TABLE `pemeliharaan`
  ADD CONSTRAINT `pemeliharaan_ibfk_1` FOREIGN KEY (`skema_id`) REFERENCES `skema` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `persyaratan`
--
ALTER TABLE `persyaratan`
  ADD CONSTRAINT `persyaratan_ibfk_1` FOREIGN KEY (`skema_id`) REFERENCES `skema` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `skema_metode_pengujian`
--
ALTER TABLE `skema_metode_pengujian`
  ADD CONSTRAINT `fk_skema_metode_pengujian_skema` FOREIGN KEY (`skema_id`) REFERENCES `skema` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `unit_kompetensi`
--
ALTER TABLE `unit_kompetensi`
  ADD CONSTRAINT `unit_kompetensi_ibfk_1` FOREIGN KEY (`skema_id`) REFERENCES `skema` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
