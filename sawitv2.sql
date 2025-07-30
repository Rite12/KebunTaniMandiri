-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 28, 2025 at 10:13 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sawitv2`
--

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hutang`
--

CREATE TABLE `hutang` (
  `id` int(11) NOT NULL,
  `karyawan_id` int(11) DEFAULT NULL,
  `jumlah` decimal(10,2) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hutang`
--

INSERT INTO `hutang` (`id`, `karyawan_id`, `jumlah`, `keterangan`, `tanggal`, `created_at`, `updated_at`) VALUES
(1, 3, 100000.00, 'makan', '2025-06-02', '2025-06-02 16:07:39', '2025-06-02 16:07:39'),
(2, 4, 10000.00, NULL, '2025-07-05', '2025-07-05 16:32:43', '2025-07-05 16:32:43'),
(3, 3, 100000.00, 'sabun', '2025-07-08', '2025-07-08 06:49:33', '2025-07-08 06:49:33'),
(4, 3, 3500.00, 'bensin', '2025-07-08', '2025-07-08 06:49:49', '2025-07-08 06:49:49'),
(5, 3, 42000000.00, NULL, '2025-07-27', '2025-07-27 14:18:14', '2025-07-27 14:18:14'),
(6, 3, 4000.00, 'minum', '2025-07-28', '2025-07-28 06:05:31', '2025-07-28 06:05:31'),
(7, 3, 100000.00, 'rokok', '2025-07-28', '2025-07-28 06:06:00', '2025-07-28 06:06:00'),
(8, 3, 600000.00, 'beli sempak', '2025-07-28', '2025-07-28 06:22:46', '2025-07-28 06:22:46'),
(9, 3, 10000000.00, 'awwww', '2025-07-28', '2025-07-28 06:23:13', '2025-07-28 06:23:13');

-- --------------------------------------------------------

--
-- Table structure for table `karyawans`
--

CREATE TABLE `karyawans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_lengkap` varchar(255) DEFAULT NULL,
  `jabatan` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `nomor_telepon` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `karyawans`
--

INSERT INTO `karyawans` (`id`, `nama_lengkap`, `jabatan`, `status`, `nomor_telepon`, `alamat`, `created_at`, `updated_at`) VALUES
(3, 'Baron', 'Petani Aktif', 'Aktif', '0823-8309-6243', 'Muara Tembesi', '2025-06-02 11:08:25', '2025-07-27 23:33:16'),
(4, 'Husni', 'Petani Aktif', 'Aktif', '0821-8564-6748', 'Muara Tembesi', '2025-06-02 11:08:25', '2025-06-02 11:08:25'),
(5, 'Mairus', 'Petani Aktif', 'Aktif', '0822-7468-1364', 'Muara Tembesi', '2025-06-02 11:08:25', '2025-06-02 11:08:25'),
(6, 'Eko', 'Petani Aktif', 'Aktif', '0818-4078-0015', 'Muara Tembesi', '2025-06-02 11:08:25', '2025-06-02 11:08:25'),
(7, 'Rizal', 'Petani Aktif', 'Aktif', '0812-6143-1668', 'Muara Tembesi', '2025-06-02 11:08:25', '2025-06-02 11:08:25'),
(8, 'Idul', 'Petani Aktif', 'Aktif', '0813-6176-7110', 'Muara Tembesi', '2025-06-02 11:08:25', '2025-06-02 11:08:25'),
(9, 'Karpin', 'Petani Aktif', 'Aktif', '0823-5029-3889', 'Muara Tembesi', '2025-06-02 11:08:25', '2025-06-02 11:08:25'),
(10, 'Adun', 'Petani Aktif', 'Aktif', '0853-6899-5032', 'Muara Tembesi', '2025-06-02 11:08:25', '2025-06-02 11:08:25'),
(11, 'Anwan', 'Petani Aktif', 'Aktif', '0820-8350-0405', 'Muara Tembesi', '2025-06-02 11:08:25', '2025-06-02 11:08:25'),
(12, 'Mas kurus', 'Petani Aktif', 'Aktif', '0822-6992-8074', 'Muara Tembesi', '2025-06-02 11:08:25', '2025-07-26 22:18:24'),
(13, 'Uda IL', 'Petani Aktif', 'Aktif', '0858-6313-3205', 'Muara Tembesi', '2025-06-02 11:08:25', '2025-06-02 11:08:25'),
(14, 'Rasikun', 'Mandor', 'Aktif', '02840824820424', 'Muara Tembesi', '2025-06-02 06:33:23', '2025-06-02 06:33:23'),
(15, 'Zulfikar', 'Mandor', 'Aktif', '8585865858585', 'Muara Tembesi', '2025-06-02 06:34:09', '2025-06-02 06:34:09'),
(25, 'Fajar Kun', 'Petani Aktif', 'Aktif', '082288580371', 'Jl. Ir. H. Juanda No.367, Dago, Kecamatan Coblong, Kota Bandung, Jawa Barat 40135', '2025-07-26 21:48:07', '2025-07-26 21:48:07');

-- --------------------------------------------------------

--
-- Table structure for table `kegiatans`
--

CREATE TABLE `kegiatans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `banyak` decimal(10,2) NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `jumlah` decimal(10,2) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `tanggal` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kegiatans`
--

INSERT INTO `kegiatans` (`id`, `name`, `banyak`, `harga`, `jumlah`, `keterangan`, `created_at`, `updated_at`, `tanggal`) VALUES
(2, 'transportasi', 2.00, 4000.00, 8000.00, 'gwggw', '2025-06-02 13:42:53', '2025-06-02 13:42:53', NULL),
(3, 'gerinda', 5.00, 2000.00, 10000.00, 'j9iji9ji9ji', '2025-06-02 17:04:20', '2025-06-02 17:04:20', '2025-06-03');

-- --------------------------------------------------------

--
-- Table structure for table `kehadiran`
--

CREATE TABLE `kehadiran` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `karyawan_id` bigint(20) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `status` varchar(50) NOT NULL,
  `waktu_masuk` time NOT NULL,
  `waktu_keluar` time NOT NULL,
  `jam_kerja` decimal(5,2) NOT NULL,
  `jam_lembur` decimal(5,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kehadirans`
--

CREATE TABLE `kehadirans` (
  `id` int(11) NOT NULL,
  `karyawan_id` bigint(20) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `status` enum('Hadir','Izin','Sakit') NOT NULL,
  `waktu_masuk` time NOT NULL,
  `waktu_keluar` time NOT NULL,
  `jam_kerja` decimal(5,2) NOT NULL,
  `jam_lembur` decimal(5,2) DEFAULT 0.00,
  `gaji_lembur` decimal(15,2) DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `total_gaji_lembur` decimal(15,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kehadirans`
--

INSERT INTO `kehadirans` (`id`, `karyawan_id`, `tanggal`, `status`, `waktu_masuk`, `waktu_keluar`, `jam_kerja`, `jam_lembur`, `gaji_lembur`, `created_at`, `updated_at`, `total_gaji_lembur`) VALUES
(36, 3, '2025-07-27', 'Hadir', '07:00:00', '19:00:00', 12.00, 4.00, 100000.00, '2025-07-26 22:05:05', '2025-07-26 22:05:05', 400000.00);

-- --------------------------------------------------------

--
-- Table structure for table `lokasi_sawit`
--

CREATE TABLE `lokasi_sawit` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_lokasi` varchar(255) NOT NULL,
  `luas_lahan` decimal(10,2) NOT NULL,
  `jenis_tanaman` varchar(255) NOT NULL,
  `kondisi_tanaman` varchar(255) NOT NULL,
  `latitude` decimal(10,7) NOT NULL,
  `longitude` decimal(10,7) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lokasi_sawit`
--

INSERT INTO `lokasi_sawit` (`id`, `nama_lokasi`, `luas_lahan`, `jenis_tanaman`, `kondisi_tanaman`, `latitude`, `longitude`, `created_at`, `updated_at`) VALUES
(1, 'Manis madu', 1000.00, 'Kelapa Sawit', 'Produktif', -1.7272010, 103.1048450, '2025-05-31 02:51:35', '2025-05-31 02:51:35'),
(2, 'Pal 3', 13.00, 'Kelapa Sawit', 'Produktif', -1.5723890, 103.0866670, '2025-06-02 04:23:07', '2025-06-02 04:23:07'),
(3, 'Talang Lado', 12.00, 'Sawit', 'Produktif', -1.5723890, 103.0866670, '2025-06-02 11:24:39', '2025-06-02 11:24:39'),
(4, 'Hamparan 14/24', 6.00, 'Sawit', 'Produktif', -1.5735000, 103.0870000, '2025-06-02 11:24:39', '2025-06-02 11:24:39'),
(5, 'Pal 8', 8.00, 'Sawit', 'Produktif', -1.5740000, 103.0875000, '2025-06-02 11:24:39', '2025-06-02 11:24:39'),
(6, 'Hamparan 22', 2.00, 'Sawit', 'Produktif', -1.5745000, 103.0880000, '2025-06-02 11:24:39', '2025-06-02 11:24:39'),
(7, 'Hamparan 60', 8.00, 'Sawit', 'Produktif', -1.5750000, 103.0885000, '2025-06-02 11:24:39', '2025-06-02 11:24:39'),
(8, 'Hamparan 62', 2.00, 'Sawit', 'Produktif', -1.5755000, 103.0890000, '2025-06-02 11:24:39', '2025-06-02 11:24:39'),
(9, 'Hamparan 56', 2.00, 'Sawit', 'Produktif', -1.5760000, 103.0895000, '2025-06-02 11:24:39', '2025-06-02 11:24:39'),
(10, 'Masijau', 8.00, 'Sawit', 'Produktif', -1.5765000, 103.0900000, '2025-06-02 11:24:39', '2025-06-02 11:24:39'),
(11, 'jambi', 1000.00, 'kelapa sawit', 'aktif', 1.6099720, 103.6072540, '2025-06-21 02:34:56', '2025-06-21 02:34:56'),
(12, 'Jambi', 1000.00, 'Kelapa sawit', 'produktif', 103.6072540, 1.6099720, '2025-06-21 02:42:08', '2025-06-21 02:42:08'),
(13, 'ijau', 1000.00, 'kelapa sawit', 'Produktif', -1.5765000, 103.0900000, '2025-06-21 02:45:20', '2025-06-21 02:45:20'),
(14, 'ijau', 1000.00, 'kelapa sawit', 'Produktif', -1.5765000, 103.0900000, '2025-06-21 02:47:55', '2025-06-21 02:47:55');

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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2014_10_12_200000_add_two_factor_columns_to_users_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2025_05_27_065420_create_permission_tables', 1),
(6, '2025_05_27_084549_create_karyawans_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(3, 'App\\Models\\User', 3),
(3, 'App\\Models\\User', 4),
(3, 'App\\Models\\User', 6),
(4, 'App\\Models\\User', 5),
(4, 'App\\Models\\User', 8),
(4, 'App\\Models\\User', 9);

-- --------------------------------------------------------

--
-- Table structure for table `panens`
--

CREATE TABLE `panens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `lokasi_sawit_id` bigint(20) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `berat` decimal(10,2) NOT NULL,
  `harga_tbs` decimal(10,0) NOT NULL,
  `total_nilai` decimal(10,2) NOT NULL,
  `termin` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `panens`
--

INSERT INTO `panens` (`id`, `lokasi_sawit_id`, `tanggal`, `berat`, `harga_tbs`, `total_nilai`, `termin`, `created_at`, `updated_at`) VALUES
(6, 1, '2025-03-01', 12.00, 3087, 37044.00, 'Termin 1', '2025-06-02 02:24:55', '2025-06-02 17:39:46'),
(51, 1, '2025-03-01', 14214.00, 3087, 43878618.00, 'Termin 1', '2025-06-02 11:31:07', '2025-06-02 17:39:46'),
(52, 1, '2025-03-01', 0.00, 3087, 0.00, 'Termin 2', '2025-06-02 11:31:07', '2025-06-02 11:47:08'),
(53, 1, '2025-03-01', 15802.00, 3087, 48780774.00, 'Termin 3', '2025-06-02 11:31:07', '2025-06-02 17:39:46'),
(54, 2, '2025-03-01', 10761.00, 3087, 33219207.00, 'Termin 1', '2025-06-02 11:31:07', '2025-06-02 17:39:46'),
(55, 2, '2025-03-01', 0.00, 3087, 0.00, 'Termin 2', '2025-06-02 11:31:07', '2025-06-02 11:47:08'),
(56, 2, '2025-03-01', 10501.00, 3087, 32416587.00, 'Termin 3', '2025-06-02 11:31:07', '2025-06-02 17:39:46'),
(57, 3, '2025-03-01', 0.00, 3087, 0.00, 'Termin 1', '2025-06-02 11:31:07', '2025-06-02 11:47:08'),
(58, 4, '2025-03-01', 8530.00, 3087, 26332110.00, 'Termin 1', '2025-06-02 11:31:07', '2025-06-02 17:39:46'),
(59, 4, '2025-03-01', 0.00, 3087, 0.00, 'Termin 2', '2025-06-02 11:31:07', '2025-06-02 11:47:08'),
(60, 4, '2025-03-01', 3255.00, 3087, 10048185.00, 'Termin 3', '2025-06-02 11:31:07', '2025-06-02 17:39:46'),
(61, 5, '2025-03-01', 858.00, 3087, 2648646.00, 'Termin 1', '2025-06-02 11:31:07', '2025-06-02 17:39:46'),
(62, 5, '2025-03-01', 0.00, 3087, 0.00, 'Termin 2', '2025-06-02 11:31:07', '2025-06-02 11:47:08'),
(63, 5, '2025-03-01', 4907.00, 3087, 15147909.00, 'Termin 3', '2025-06-02 11:31:07', '2025-06-02 17:39:46'),
(64, 6, '2025-03-01', 1857.00, 3087, 5732559.00, 'Termin 1', '2025-06-02 11:31:07', '2025-06-02 17:39:46'),
(65, 6, '2025-03-01', 0.00, 3087, 0.00, 'Termin 2', '2025-06-02 11:31:07', '2025-06-02 11:47:08'),
(66, 6, '2025-03-01', 817.00, 3087, 2522079.00, 'Termin 3', '2025-06-02 11:31:07', '2025-06-02 17:39:46'),
(67, 7, '2025-03-01', 4484.00, 3087, 13842108.00, 'Termin 1', '2025-06-02 11:31:07', '2025-06-02 17:39:46'),
(68, 7, '2025-03-01', 0.00, 3087, 0.00, 'Termin 2', '2025-06-02 11:31:07', '2025-06-02 11:47:08'),
(69, 7, '2025-03-01', 5973.00, 3087, 18438651.00, 'Termin 3', '2025-06-02 11:31:07', '2025-06-02 17:39:46'),
(70, 8, '2025-03-01', 0.00, 3087, 0.00, 'Termin 1', '2025-06-02 11:31:07', '2025-06-02 11:47:08'),
(71, 9, '2025-03-01', 847.00, 3087, 2614689.00, 'Termin 1', '2025-06-02 11:31:07', '2025-06-02 17:39:46'),
(73, 2, '2025-06-28', 1000.00, 2500, 2500000.00, 'Termin 3', '2025-06-21 02:49:36', '2025-06-21 02:49:36'),
(74, 2, '2025-07-01', 12.00, 1200, 14400.00, 'Termin 1', '2025-06-21 02:50:02', '2025-06-21 02:50:02'),
(75, 3, '2026-01-10', 100.00, 2000, 200000.00, 'Termin 1', '2025-06-21 02:52:26', '2025-06-21 02:52:26'),
(76, 13, '2025-07-03', 100.00, 3500, 350000.00, 'Termin 1', '2025-07-03 04:09:54', '2025-07-03 04:09:54'),
(77, 2, '2025-07-08', 1000.00, 2500, 2500000.00, 'Termin 3', '2025-07-07 23:42:28', '2025-07-07 23:42:28'),
(79, 3, '2025-07-28', 100.00, 3000, 300000.00, 'Termin 3', '2025-07-26 22:57:52', '2025-07-27 12:23:52'),
(80, 1, '2025-07-27', 10.00, 3500, 35000.00, 'Termin 1', '2025-07-26 22:58:43', '2025-07-26 22:58:43'),
(81, 2, '2025-07-27', 1000.00, 2500, 2500000.00, 'Termin 3', '2025-07-27 05:03:43', '2025-07-27 05:03:43');

-- --------------------------------------------------------

--
-- Table structure for table `password_otps`
--

CREATE TABLE `password_otps` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `otp` varchar(10) NOT NULL,
  `expires_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `password_otps`
--

INSERT INTO `password_otps` (`id`, `email`, `otp`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'fajarkurkur24@gmail.com', '125866', '2025-07-26 11:41:48', '2025-07-26 10:49:54', '2025-07-26 18:31:48'),
(2, 'fajarkurkur24@gmail.com', '105660', '2025-07-26 11:02:18', '2025-07-26 10:52:18', '2025-07-26 10:52:18'),
(3, 'fajarkurkur24@gmail.com', '625896', '2025-07-26 11:07:21', '2025-07-26 17:57:21', '2025-07-26 17:57:21'),
(4, 'fajarkurkur24@gmail.com', '779084', '2025-07-26 11:07:41', '2025-07-26 17:57:41', '2025-07-26 17:57:41'),
(5, 'fajarkurkur24@gmail.com', '720589', '2025-07-26 11:08:25', '2025-07-26 17:58:25', '2025-07-26 17:58:25'),
(6, 'fajarkurkur24@gmail.com', '333392', '2025-07-26 11:15:49', '2025-07-26 18:05:49', '2025-07-26 18:05:49');

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
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'view features', 'web', '2025-07-05 03:55:26', '2025-07-05 03:55:26'),
(2, 'create features', 'web', '2025-07-05 03:55:26', '2025-07-05 03:55:26'),
(3, 'update features', 'web', '2025-07-05 03:55:26', '2025-07-05 03:55:26'),
(4, 'delete features', 'web', '2025-07-05 03:55:26', '2025-07-05 03:55:26'),
(5, 'view karyawan', 'web', '2025-07-05 05:39:59', '2025-07-05 05:39:59'),
(6, 'create karyawan', 'web', '2025-07-05 05:39:59', '2025-07-05 05:39:59'),
(7, 'update karyawan', 'web', '2025-07-05 05:39:59', '2025-07-05 05:39:59'),
(8, 'delete karyawan', 'web', '2025-07-05 05:39:59', '2025-07-05 05:39:59');

-- --------------------------------------------------------

--
-- Table structure for table `rawats`
--

CREATE TABLE `rawats` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `banyak` decimal(10,2) DEFAULT NULL,
  `harga` decimal(10,2) NOT NULL,
  `jumlah` decimal(10,2) DEFAULT NULL,
  `keterangan` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `tanggal` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rawats`
--

INSERT INTO `rawats` (`id`, `name`, `banyak`, `harga`, `jumlah`, `keterangan`, `created_at`, `updated_at`, `tanggal`) VALUES
(1, 'pupuk', 1.00, 3500.00, 3500.00, 'pupuk', '2025-06-02 13:00:27', '2025-06-02 13:00:27', NULL),
(3, 'gerinda', 1.00, 11111.00, 11111.00, 'rawrtt', '2025-06-02 14:28:23', '2025-06-02 14:28:23', NULL),
(4, 'transportasi', 1.00, 10000.00, 10000.00, 'enak', '2025-06-02 16:33:38', '2025-06-02 16:33:38', '2025-06-07'),
(5, 'gerinda', 12.00, 3500.00, 42000.00, 'bagus', '2025-07-03 04:19:21', '2025-07-03 04:19:21', '2025-07-03'),
(6, 'mupuk', 10.00, 350000.00, 3500000.00, 'mupuk sawit', '2025-07-05 08:56:09', '2025-07-05 08:56:09', '2025-07-04'),
(7, 'gerinda', 2.00, 15000.00, 30000.00, 'bagyus', '2025-07-27 05:24:40', '2025-07-27 05:24:40', '2025-07-26');

-- --------------------------------------------------------

--
-- Table structure for table `rekap_kerja`
--

CREATE TABLE `rekap_kerja` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `karyawan_id` bigint(20) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `jenis_kerjaan` varchar(255) NOT NULL,
  `banyak` varchar(50) NOT NULL,
  `upah` decimal(10,2) NOT NULL,
  `jumlah` decimal(10,2) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `lokasi_sawit_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rekap_kerja`
--

INSERT INTO `rekap_kerja` (`id`, `karyawan_id`, `tanggal`, `jenis_kerjaan`, `banyak`, `upah`, `jumlah`, `keterangan`, `lokasi_sawit_id`, `created_at`, `updated_at`) VALUES
(3, 3, '2025-06-02', 'panen', '123.000', 11.00, 1353.00, '13131313131', 1, '2025-06-02 04:39:34', '2025-06-02 04:39:34'),
(4, 3, '2025-06-02', 'panen', '34.000', 23242.00, 790228.00, 'gsgsgsgw', 1, '2025-06-02 04:39:53', '2025-06-02 04:39:53'),
(5, 3, '2025-06-02', 'panen', '3.500 kg', 100.00, 350.00, 'Baik', 1, '2025-06-02 06:20:28', '2025-06-02 06:20:28'),
(9, 3, '2025-06-21', 'Panen', '35 kg', 1000.00, 35000.00, 'bagus', 13, '2025-06-21 04:14:53', '2025-06-21 04:14:53'),
(10, 3, '2025-06-21', 'pupuk', '3,5 kg', 10000.00, 35000.00, 'hiuhini', 9, '2025-06-21 04:17:19', '2025-06-21 04:17:19'),
(11, 3, '2025-06-21', 'pupuk', '3,5 kg', 10000.00, 35000.00, 'hiuhini', 9, '2025-06-21 04:30:17', '2025-06-21 04:30:17'),
(12, 3, '2025-06-21', 'pupuk', '3,5 kg', 10000.00, 35000.00, 'hiuhini', 9, '2025-06-21 04:31:59', '2025-06-21 04:31:59'),
(13, 3, '2025-07-05', 'Panen', '3.500 kg', 1000.00, 3500.00, 'bagus', 12, '2025-07-05 09:43:22', '2025-07-05 09:43:22'),
(14, 3, '2025-06-28', 'panen', '3.500 kg', 1000.00, 3500.00, 'bagus', 12, '2025-07-27 11:38:58', '2025-07-27 11:38:58'),
(15, 3, '2025-07-29', 'panen', '100', 5000.00, 500000.00, 'yyyyy', 9, '2025-07-27 11:48:45', '2025-07-27 11:48:45'),
(16, 3, '2025-07-31', 'Panen', '20', 10000.00, 200000.00, 'yyy', 8, '2025-07-27 11:49:30', '2025-07-27 11:49:30');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'web', '2025-07-05 03:06:56', '2025-07-05 03:06:56'),
(2, 'owner', 'web', '2025-07-05 03:06:56', '2025-07-05 03:06:56'),
(3, 'pemilik', 'web', '2025-07-05 10:09:52', '2025-07-05 10:09:52'),
(4, 'mandor', 'web', '2025-07-05 10:09:52', '2025-07-05 10:09:52');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 3),
(1, 4),
(2, 4),
(3, 4),
(4, 4),
(5, 3),
(5, 4),
(6, 4),
(7, 4),
(8, 4);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `two_factor_secret` text DEFAULT NULL,
  `two_factor_recovery_codes` text DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `last_name`, `email`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `remember_token`, `created_at`, `updated_at`) VALUES
(2, 'Fajar', 'Kun', 'orekihoutaru10@gmail.com', NULL, '$2y$10$ZZ7Iy7EIFbtvw3FP9CChuOaRAgiq30Z6Qlrz.2uwGMxcsff4ObDe6', NULL, NULL, 'Dfz3rrQ4WoBkeNU2v4MtbAJShmXsvHl67VZvyKZUsZ4Aae3UKkD9DR0Q495m', '2025-05-31 02:26:22', '2025-06-02 13:27:22'),
(3, 'irwan', 'kamil', 'abangiwan@gmail.com', NULL, '$2y$10$4AIXB9NfE7xAZLrHnG9G7uaw1C2bUijdAlzdmycinUP/oK0jDre3S', NULL, NULL, NULL, '2025-07-05 03:13:06', '2025-07-05 03:13:06'),
(4, 'Pemilik', 'Contoh', 'pemilik@example.com', NULL, '$2y$10$dtrHEFz2UHW/XswWGQawtuIaKzDcyVZE23LZw2YOm7B/MwIhtjrpW', NULL, NULL, NULL, '2025-07-05 03:55:27', '2025-07-05 03:55:27'),
(5, 'Mandor', 'Contoh', 'mandor@example.com', NULL, '$2y$10$d4SywdZnR.hlKQmEQ7t6nOSB3HJedTF1nyg5oj.aBmudLP8kiOJp2', NULL, NULL, NULL, '2025-07-05 03:55:27', '2025-07-05 03:55:27'),
(6, 'fajri', 'kun', 'jri@co.id', NULL, '$2y$10$6GcQWgYT6oP71iOsIEA8aOsZx41DN6FkG6ADZYI2hpWgHZ.ZqL9gC', NULL, NULL, NULL, '2025-07-05 04:08:06', '2025-07-05 04:08:06'),
(8, 'zulfikar', 'ganteng', 'fikarsavage@123gmail', NULL, '$2y$10$w5h/Hkp5mxewT17.PGoYmupPSRnDze39NbIX8qgaD3bEOE4bYI55a', NULL, NULL, 'eMVMZCjhgzu4wPymRgQsIcPVK2zdPfCAUfjh9tH0edCeiXncYgQDfNePInqx', '2025-07-05 05:15:47', '2025-07-05 05:15:47'),
(9, 'icibos', 'tua', 'koamofamo@gmail.com', NULL, '$2y$10$koEBzaLWZ.VdJbW4mhAi8uoRWCw0htdSoml4/TdRFXQMB4/KCcQlS', NULL, NULL, NULL, '2025-07-05 05:16:38', '2025-07-05 05:16:38'),
(10, 'Fajarkurniawan', '', 'Fajarkurkur24@gmail.com', NULL, '$2y$10$ZZ7Iy7EIFbtw3FP9CQChuQaRA.gic30Z6Qlrz.2uwGMxYj4gceH2jK', NULL, NULL, NULL, '2025-07-26 17:48:16', '2025-07-26 17:48:16');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hutang`
--
ALTER TABLE `hutang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `karyawans`
--
ALTER TABLE `karyawans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kegiatans`
--
ALTER TABLE `kegiatans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kehadiran`
--
ALTER TABLE `kehadiran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kehadirans`
--
ALTER TABLE `kehadirans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `karyawan_id` (`karyawan_id`);

--
-- Indexes for table `lokasi_sawit`
--
ALTER TABLE `lokasi_sawit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `panens`
--
ALTER TABLE `panens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lokasi_sawit_id` (`lokasi_sawit_id`);

--
-- Indexes for table `password_otps`
--
ALTER TABLE `password_otps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `rawats`
--
ALTER TABLE `rawats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rekap_kerja`
--
ALTER TABLE `rekap_kerja`
  ADD PRIMARY KEY (`id`),
  ADD KEY `karyawan_id` (`karyawan_id`),
  ADD KEY `lokasi_sawit_id` (`lokasi_sawit_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

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
-- AUTO_INCREMENT for table `hutang`
--
ALTER TABLE `hutang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `karyawans`
--
ALTER TABLE `karyawans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `kegiatans`
--
ALTER TABLE `kegiatans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `kehadiran`
--
ALTER TABLE `kehadiran`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kehadirans`
--
ALTER TABLE `kehadirans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `lokasi_sawit`
--
ALTER TABLE `lokasi_sawit`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `panens`
--
ALTER TABLE `panens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `password_otps`
--
ALTER TABLE `password_otps`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `rawats`
--
ALTER TABLE `rawats`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `rekap_kerja`
--
ALTER TABLE `rekap_kerja`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1002;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1002;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `kehadirans`
--
ALTER TABLE `kehadirans`
  ADD CONSTRAINT `kehadirans_ibfk_1` FOREIGN KEY (`karyawan_id`) REFERENCES `karyawans` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `panens`
--
ALTER TABLE `panens`
  ADD CONSTRAINT `panens_ibfk_1` FOREIGN KEY (`lokasi_sawit_id`) REFERENCES `lokasi_sawit` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `rekap_kerja`
--
ALTER TABLE `rekap_kerja`
  ADD CONSTRAINT `rekap_kerja_ibfk_1` FOREIGN KEY (`karyawan_id`) REFERENCES `karyawans` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `rekap_kerja_ibfk_2` FOREIGN KEY (`lokasi_sawit_id`) REFERENCES `lokasi_sawit` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
