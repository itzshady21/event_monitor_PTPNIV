-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 21, 2024 at 02:07 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laravel`
--

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `laporan`
--

CREATE TABLE `laporan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `gol_darah` varchar(255) NOT NULL,
  `jumlah_donor` int(11) NOT NULL DEFAULT 0,
  `jumlah_pengambilan` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(5, '2024_08_21_032341_create_tbl_event', 1),
(6, '2024_08_21_035716_add_jabatan_to_tbl_event_table', 1),
(7, '2024_08_21_050642_add_lokasi_pelatihan_to_tbl_event_table', 1),
(8, '2024_08_27_085900_add_penyelenggara_to_tbl_event_table', 2),
(9, '2024_09_03_005459_create_tbl_karyawan_table', 3),
(10, '2024_09_03_005849_add_karyawan_id_to_tbl_event_table', 4),
(15, '2024_06_20_075511_create_sidoja_table', 5),
(16, '2024_06_20_083903_create_darah_table', 5),
(17, '2024_07_14_141822_create_tbl_amdar_table', 5),
(18, '2024_07_14_145740_add_jumlah_to_tbl_sidoja', 5),
(19, '2024_07_14_153412_create_tbl_stok_darah', 5),
(20, '2024_07_17_141157_create_tbl_laporan_table', 5),
(21, '2024_07_17_144401_create_laporan_table', 5),
(22, '2024_07_17_161107_add_date_to_tbl_sidoja', 5),
(23, '2014_10_12_000000_create_users_table', 6),
(24, '2014_10_12_100000_create_password_resets_table', 6),
(25, '2019_08_19_000000_create_failed_jobs_table', 6),
(26, '2019_12_14_000001_create_personal_access_tokens_table', 6),
(27, '2024_09_24_005947_add_biaya_to_tbl_event', 7),
(28, '2024_09_24_011910_alter_biaya_column_in_tbl_event', 8),
(29, '2024_09_24_020320_add_jenis_kelamin_to_tbl_karyawan_table', 9),
(30, '2024_09_24_020743_add_pendidikan_to_tbl_karyawan_table', 10),
(31, '2024_09_24_021444_add_bod_to_tbl_karyawan_table', 11),
(32, '2024_09_24_022945_add_unit_usaha_to_tbl_karyawan_table', 12),
(33, '2024_09_24_041235_add_unit_usaha_to_tbl_event_table', 13);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_amdar`
--

CREATE TABLE `tbl_amdar` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `gol_darah` varchar(255) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_darah`
--

CREATE TABLE `tbl_darah` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `golongan_darah` varchar(255) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_event`
--

CREATE TABLE `tbl_event` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nik` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `jabatan` varchar(255) NOT NULL,
  `bagian` varchar(255) NOT NULL,
  `unit_usaha` text DEFAULT NULL,
  `tgl_awal` date NOT NULL,
  `tgl_akhir` date NOT NULL,
  `judul_pelatihan` varchar(255) NOT NULL,
  `jenis_pelatihan` varchar(255) NOT NULL,
  `lokasi_pelatihan` varchar(255) DEFAULT NULL,
  `metode_pelatihan` varchar(255) NOT NULL,
  `penyelenggara` varchar(255) NOT NULL,
  `biaya` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `karyawan_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_event`
--

INSERT INTO `tbl_event` (`id`, `nik`, `nama`, `jabatan`, `bagian`, `unit_usaha`, `tgl_awal`, `tgl_akhir`, `judul_pelatihan`, `jenis_pelatihan`, `lokasi_pelatihan`, `metode_pelatihan`, `penyelenggara`, `biaya`, `created_at`, `updated_at`, `karyawan_id`) VALUES
(81, '1503032109020007', 'M. Irsyadi', 'Direktur', 'SDM', 'KANTOR PUSAT', '2024-09-27', '2024-09-27', 'Leadership Training', 'Online', '-', 'Softskill', 'PT Perkebunan Nusantara IV', 200000, '2024-09-23 21:31:15', '2024-09-23 21:31:15', NULL),
(82, '605321456', 'Nabila Agustina', 'Asisten Manajer', 'Sekretariat Perusahaan &  Hukum', 'KB TJ LEBAR', '2024-09-24', '2024-09-25', 'Pelatihan Tahunan PT Perkebunan Nusantara IV', 'Online', '-', 'Sertifikasi', 'LPP AN', 150000, '2024-09-23 21:32:01', '2024-09-23 21:32:01', NULL),
(83, '606109897', 'Jaka Tingkir', 'Asisten Manajer', 'SDM', 'KB OPHIR', '2024-09-24', '2024-09-25', 'Pelatihan Tahunan PT Perkebunan Nusantara IV', 'Online', '-', 'Sertifikasi', 'LPP AN', 150000, '2024-09-23 21:32:01', '2024-09-23 21:32:01', NULL),
(84, '60123140', 'Fahrul Hidayat', 'Direktur', 'TI', 'KANTOR PUSAT', '2024-09-24', '2024-09-25', 'Pelatihan Tahunan PT Perkebunan Nusantara IV', 'Online', '-', 'Sertifikasi', 'LPP AN', 150000, '2024-09-23 21:32:01', '2024-09-23 21:32:01', NULL),
(85, '60170923', 'Zahra Arsinah', 'Asisten Manajer', 'SDM', 'KANTOR PUSAT', '2024-09-25', '2024-09-25', 'Pelatihan Tahunan PT Perkebunan Nusantara IV', 'Online', '-', 'Sertifikasi', 'LPP AN', 150000, '2024-09-23 21:32:01', '2024-09-23 21:33:30', NULL),
(86, '60154467', 'Panca Indra Anugerah Nuwongso', 'Asisten Manajer', 'Sekretariat Perusahaan &  Hukum', 'KB BUKIT KAUSAR', '2024-09-24', '2024-09-25', 'Pelatihan Tahunan PT Perkebunan Nusantara IV', 'Online', '-', 'Sertifikasi', 'LPP AN', 150000, '2024-09-23 21:32:01', '2024-09-23 21:32:01', NULL),
(87, '6012345678', 'Andi Pratama', 'Asisten Manajer', 'SDM', 'PB KAYU ARO', '2024-09-24', '2024-09-25', 'Pelatihan Tahunan PT Perkebunan Nusantara IV', 'Online', '-', 'Sertifikasi', 'LPP AN', 150000, '2024-09-23 21:32:01', '2024-09-23 21:32:01', NULL),
(88, '6011234568', 'Siti Nurhaliza', 'Asisten Manajer', 'SDM', 'KB TJ LEBAR', '2024-09-24', '2024-09-25', 'Pelatihan Tahunan PT Perkebunan Nusantara IV', 'Online', '-', 'Sertifikasi', 'LPP AN', 150000, '2024-09-23 21:32:01', '2024-09-23 21:32:01', NULL),
(89, '6011234569', 'Budi Santoso', 'Asisten Manajer', 'SDM', 'KB LAGAN', '2024-09-24', '2024-09-25', 'Pelatihan Tahunan PT Perkebunan Nusantara IV', 'Online', '-', 'Sertifikasi', 'LPP AN', 150000, '2024-09-23 21:32:01', '2024-09-23 21:32:01', NULL),
(90, '606104354', 'Zahara Puspita', 'Direktur', 'Sekretariat Perusahaan &  Hukum', 'KB LAGAN', '2024-09-24', '2024-09-25', 'Pelatihan Tahunan PT Perkebunan Nusantara IV', 'Online', '-', 'Sertifikasi', 'LPP AN', 150000, '2024-09-23 21:32:01', '2024-09-23 21:32:01', NULL),
(91, '60170923', 'Zahra Arsinah', 'Asisten Manajer', 'SDM', 'KANTOR PUSAT', '2024-09-26', '2024-09-26', 'Pelatihan Tahunan PT Perkebunan Nusantara IV', 'Offline', 'Jambi', 'Softskill', 'LPP AN', 200000, '2024-09-25 06:40:21', '2024-09-25 06:40:21', NULL),
(92, '60154467', 'Panca Indra Anugerah Nuwongso', 'Asisten Manajer', 'Sekretariat Perusahaan &  Hukum', 'KB BUKIT KAUSAR', '2024-09-26', '2024-09-26', 'Pelatihan Tahunan PT Perkebunan Nusantara IV', 'Offline', 'Jambi', 'Softskill', 'LPP AN', 200000, '2024-09-25 06:40:21', '2024-09-25 06:40:21', NULL),
(93, '6012345678', 'Andi Pratama', 'Asisten Manajer', 'SDM', 'PB KAYU ARO', '2024-09-26', '2024-09-26', 'Pelatihan Tahunan PT Perkebunan Nusantara IV', 'Offline', 'Jambi', 'Softskill', 'LPP AN', 200000, '2024-09-25 06:40:21', '2024-09-25 06:40:21', NULL),
(94, '6011234568', 'Siti Nurhaliza', 'Asisten Manajer', 'SDM', 'KB TJ LEBAR', '2024-09-26', '2024-09-26', 'Pelatihan Tahunan PT Perkebunan Nusantara IV', 'Offline', 'Jambi', 'Softskill', 'LPP AN', 200000, '2024-09-25 06:40:21', '2024-09-25 06:40:21', NULL),
(95, '6011234569', 'Budi Santoso', 'Asisten Manajer', 'SDM', 'KB LAGAN', '2024-09-26', '2024-09-26', 'Pelatihan Tahunan PT Perkebunan Nusantara IV', 'Offline', 'Jambi', 'Softskill', 'LPP AN', 200000, '2024-09-25 06:40:21', '2024-09-25 06:40:21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_karyawan`
--

CREATE TABLE `tbl_karyawan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nik` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `jenis_kelamin` varchar(255) NOT NULL,
  `tempat` varchar(255) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `pendidikan` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `jabatan` varchar(255) NOT NULL,
  `bagian` varchar(255) NOT NULL,
  `bod` text NOT NULL,
  `unit_usaha` text NOT NULL,
  `status_perkawinan` varchar(255) NOT NULL,
  `no_telp` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_karyawan`
--

INSERT INTO `tbl_karyawan` (`id`, `nik`, `nama`, `jenis_kelamin`, `tempat`, `tanggal_lahir`, `pendidikan`, `alamat`, `jabatan`, `bagian`, `bod`, `unit_usaha`, `status_perkawinan`, `no_telp`, `email`, `created_at`, `updated_at`) VALUES
(1, '1503032109020007', 'M. Irsyadi', 'Laki-Laki', 'Sarolangun', '2002-09-21', 'S1- Sistem Informasi', 'Kota Baru', 'Direktur', 'SDM', 'BOD-6', 'KANTOR PUSAT', 'Belum menikah', '081325974870', 'irsyadi2109@gmail.com', '2024-09-02 21:35:42', '2024-09-23 20:42:12'),
(2, '605321456', 'Nabila Agustina', 'Perempuan', 'Jambi', '1999-08-14', 'SMA/SLTA SEDERAJAT', 'Kota Baru', 'Asisten Manajer', 'Sekretariat Perusahaan &  Hukum', 'BOD-4', 'KB TJ LEBAR', 'Belum menikah', '089654123421', 'nabilaaa14@gmail.com', '2024-09-05 00:11:23', '2024-09-23 20:43:48'),
(3, '606109897', 'Jaka Tingkir', 'Laki-Laki', 'Jambi', '1996-08-15', 'S1- Ekonomi', 'Kota Baru', 'Asisten Manajer', 'SDM', 'BOD-3', 'KB OPHIR', 'Belum menikah', '081234456665', 'jakatingkir@gmail.com', '2024-09-09 18:58:18', '2024-09-23 20:49:11'),
(4, '60123140', 'Fahrul Hidayat', 'Laki-Laki', 'Jambi', '1976-04-05', 'S1- Teknologi Informasi', 'Kota Baru', 'Direktur', 'TI', 'BOD-5', 'KANTOR PUSAT', 'Menikah', '08997564422', 'fahrul@gmail.com', '2024-09-11 18:39:48', '2024-09-23 20:50:29'),
(5, '60170923', 'Zahra Arsinah', 'Perempuan', 'Jambi', '1996-07-20', 'S1- Psikologi', 'Kota Baru', 'Asisten Manajer', 'SDM', 'BOD-5', 'KANTOR PUSAT', 'Menikah', '087654355212123', 'zahra@gmail.com', '2024-09-11 18:41:30', '2024-09-23 20:51:48'),
(6, '60154467', 'Panca Indra Anugerah Nuwongso', 'Laki-Laki', 'Solo', '1986-08-08', 'S1- Sistem Informasi', 'Kota Baru', 'Asisten Manajer', 'Sekretariat Perusahaan &  Hukum', 'BOD-4', 'KB BUKIT KAUSAR', 'Menikah', '0898767665455', 'panca@gmail.com', '2024-09-11 18:45:58', '2024-09-23 20:52:32'),
(7, '6012345678', 'Andi Pratama', 'Laki-Laki', 'Jakarta', '2000-06-22', 'S1- Ekonomi', 'Jl. Merdeka No. 10, Jakarta', 'Asisten Manajer', 'SDM', 'BOD-5', 'PB KAYU ARO', 'Menikah', '081234567890', 'andi.pratama@gmail.com', '2024-09-11 18:58:25', '2024-09-23 20:53:18'),
(8, '6011234568', 'Siti Nurhaliza', 'Perempuan', 'Bandung', '1997-02-14', 'S1- Psikologi', 'Jl. Pahlawan No. 5, Bandung', 'Asisten Manajer', 'SDM', 'BOD-3', 'KB TJ LEBAR', 'Menikah', '082123456789', 'siti.nurhaliza@gmail.com', '2024-09-11 19:00:08', '2024-09-23 20:54:04'),
(9, '6011234569', 'Budi Santoso', 'Laki-Laki', 'Surabaya', '1979-03-05', 'S1- Ilmu Komunikasi', 'Jl. Raya No. 15, Surabaya', 'Asisten Manajer', 'SDM', 'BOD-3', 'KB LAGAN', 'Belum menikah', '083134567890', 'budi.santoso@gmail.com', '2024-09-11 19:02:05', '2024-09-23 20:54:51'),
(10, '606104354', 'Zahara Puspita', 'Perempuan', 'Jambi', '1996-08-07', 'S1- Sistem Informasi', 'Jambi', 'Direktur', 'Sekretariat Perusahaan &  Hukum', 'BOD-5', 'KB LAGAN', 'Menikah', '0895678943211', 'zahara@gmail.com', '2024-09-23 20:41:25', '2024-09-23 20:41:25');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_laporan`
--

CREATE TABLE `tbl_laporan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `masuk_data_donor_darah` int(11) NOT NULL,
  `ambil_darah` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sidoja`
--

CREATE TABLE `tbl_sidoja` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `jenis_kelamin` varchar(255) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `gol_darah` varchar(255) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `berat_badan` varchar(255) NOT NULL,
  `tekanan_darah` varchar(255) NOT NULL,
  `kadar_hb` varchar(255) NOT NULL,
  `tanggal_input` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_stok_darah`
--

CREATE TABLE `tbl_stok_darah` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `gol_darah` varchar(255) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'M. Irsyadi', 'irsyadi2109@gmail.com', NULL, '$2y$10$yEBRI6INDWvSn0RTRZEaMOeYLJHEffdyBc7qKNOcu5m8pYj4eul9C', NULL, '2024-09-23 17:52:23', '2024-09-23 17:52:23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `laporan`
--
ALTER TABLE `laporan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `tbl_amdar`
--
ALTER TABLE `tbl_amdar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_darah`
--
ALTER TABLE `tbl_darah`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_event`
--
ALTER TABLE `tbl_event`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_event_karyawan_id_foreign` (`karyawan_id`);

--
-- Indexes for table `tbl_karyawan`
--
ALTER TABLE `tbl_karyawan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tbl_karyawan_nik_unique` (`nik`),
  ADD UNIQUE KEY `tbl_karyawan_email_unique` (`email`);

--
-- Indexes for table `tbl_laporan`
--
ALTER TABLE `tbl_laporan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_sidoja`
--
ALTER TABLE `tbl_sidoja`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_stok_darah`
--
ALTER TABLE `tbl_stok_darah`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tbl_stok_darah_gol_darah_unique` (`gol_darah`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `laporan`
--
ALTER TABLE `laporan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_amdar`
--
ALTER TABLE `tbl_amdar`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_darah`
--
ALTER TABLE `tbl_darah`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_event`
--
ALTER TABLE `tbl_event`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT for table `tbl_karyawan`
--
ALTER TABLE `tbl_karyawan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_laporan`
--
ALTER TABLE `tbl_laporan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_sidoja`
--
ALTER TABLE `tbl_sidoja`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_stok_darah`
--
ALTER TABLE `tbl_stok_darah`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_event`
--
ALTER TABLE `tbl_event`
  ADD CONSTRAINT `tbl_event_karyawan_id_foreign` FOREIGN KEY (`karyawan_id`) REFERENCES `tbl_karyawan` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
