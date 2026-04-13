-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 13, 2026 at 12:24 PM
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
-- Database: `db_monitoring_pkl`
--

-- --------------------------------------------------------

--
-- Table structure for table `absensis`
--

CREATE TABLE `absensis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `siswa_id` bigint(20) UNSIGNED DEFAULT NULL,
  `kelompok_siswa_id` bigint(20) UNSIGNED DEFAULT NULL,
  `tanggal` date NOT NULL,
  `jam_masuk` time DEFAULT NULL,
  `jam_keluar` time DEFAULT NULL,
  `status` enum('hadir','izin','sakit','alpha') NOT NULL DEFAULT 'hadir',
  `keterangan` text DEFAULT NULL,
  `bukti_foto` varchar(255) DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `lokasi_absen` varchar(255) DEFAULT NULL,
  `is_valid_location` tinyint(1) NOT NULL DEFAULT 0,
  `dosen_id` bigint(20) UNSIGNED DEFAULT NULL,
  `dosen_absen_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `absensis`
--

INSERT INTO `absensis` (`id`, `siswa_id`, `kelompok_siswa_id`, `tanggal`, `jam_masuk`, `jam_keluar`, `status`, `keterangan`, `bukti_foto`, `latitude`, `longitude`, `lokasi_absen`, `is_valid_location`, `dosen_id`, `dosen_absen_at`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, '2026-04-05', '12:55:32', '12:55:47', 'alpha', NULL, NULL, -6.57838798, 107.78354492, NULL, 0, NULL, NULL, '2026-04-05 05:55:32', '2026-04-05 05:55:47'),
(2, NULL, NULL, '2026-04-06', '07:40:58', NULL, 'hadir', NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-04-06 00:40:58', '2026-04-06 00:40:58', '2026-04-06 00:40:58'),
(3, NULL, NULL, '2026-04-06', '07:41:03', '08:13:03', 'hadir', NULL, NULL, NULL, NULL, NULL, 1, NULL, '2026-04-06 00:41:03', '2026-04-06 00:41:03', '2026-04-06 01:13:03'),
(4, 9, 3, '2026-04-07', '04:14:02', '04:14:14', 'hadir', NULL, NULL, -6.57757804, 107.78323657, NULL, 1, NULL, NULL, '2026-04-06 21:14:02', '2026-04-06 21:14:14');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-2f3c86e81c3526a4d074d1dcbf447839', 'i:1;', 1776075741),
('laravel-cache-2f3c86e81c3526a4d074d1dcbf447839:timer', 'i:1776075741;', 1776075741),
('laravel-cache-3a13743629773064212ab096f7a2cc49', 'i:1;', 1776075685),
('laravel-cache-3a13743629773064212ab096f7a2cc49:timer', 'i:1776075685;', 1776075685),
('laravel-cache-a34e63348b27358c0a4235e57d32f112', 'i:1;', 1776075723),
('laravel-cache-a34e63348b27358c0a4235e57d32f112:timer', 'i:1776075723;', 1776075723);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dosens`
--

CREATE TABLE `dosens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nidn` varchar(255) NOT NULL,
  `nama_dosen` varchar(255) NOT NULL,
  `gelar_depan` varchar(255) DEFAULT NULL,
  `gelar_belakang` varchar(255) DEFAULT NULL,
  `jurusan` varchar(255) NOT NULL,
  `fakultas` varchar(255) NOT NULL,
  `telepon` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dosens`
--

INSERT INTO `dosens` (`id`, `nidn`, `nama_dosen`, `gelar_depan`, `gelar_belakang`, `jurusan`, `fakultas`, `telepon`, `email`, `foto`, `user_id`, `is_active`, `created_at`, `updated_at`) VALUES
(2, '123456789', 'adila', 'S.KOM', 'M.H', 'TBSM', 'IPA', '0800000', 'guru1@test.com', 'dosens/foto/NSY5I6OmYWik1vUX0qfgFE3npj7Gv2oIRGzAfJGI.jpg', 11, 1, '2026-04-06 01:55:28', '2026-04-13 01:36:59'),
(3, '999999', 'kurniawan', NULL, 'S.kom', 'TKJ', 'komputer', '111111', 'guru2@test.com', NULL, 14, 1, '2026-04-06 21:10:32', '2026-04-13 01:37:31');

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
-- Table structure for table `ijin_sakit`
--

CREATE TABLE `ijin_sakit` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `siswa_id` bigint(20) UNSIGNED DEFAULT NULL,
  `kelompok_siswa_id` bigint(20) UNSIGNED DEFAULT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `jenis` enum('izin','sakit') NOT NULL,
  `alasan` text NOT NULL,
  `bukti_foto` varchar(255) DEFAULT NULL,
  `status` enum('pending','disetujui','ditolak') NOT NULL DEFAULT 'pending',
  `catatan_dosen` text DEFAULT NULL,
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kelompok_pkls`
--

CREATE TABLE `kelompok_pkls` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_kelompok` varchar(255) NOT NULL,
  `dosen_id` bigint(20) UNSIGNED DEFAULT NULL,
  `perusahaan_id` bigint(20) UNSIGNED DEFAULT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `status` enum('pending','aktif','selesai','dibatalkan') NOT NULL DEFAULT 'pending',
  `catatan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kelompok_pkls`
--

INSERT INTO `kelompok_pkls` (`id`, `nama_kelompok`, `dosen_id`, `perusahaan_id`, `tanggal_mulai`, `tanggal_selesai`, `status`, `catatan`, `created_at`, `updated_at`) VALUES
(2, 'haji', 3, 3, '2026-04-07', '2026-04-08', 'selesai', NULL, '2026-04-06 21:12:09', '2026-04-10 23:18:05');

-- --------------------------------------------------------

--
-- Table structure for table `kelompok_siswas`
--

CREATE TABLE `kelompok_siswas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kelompok_pkl_id` bigint(20) UNSIGNED DEFAULT NULL,
  `siswa_id` bigint(20) UNSIGNED DEFAULT NULL,
  `nim` varchar(255) NOT NULL,
  `kelas` varchar(255) NOT NULL,
  `prodi` varchar(255) NOT NULL,
  `status_anggota` enum('ketua','anggota') NOT NULL DEFAULT 'anggota',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kelompok_siswas`
--

INSERT INTO `kelompok_siswas` (`id`, `kelompok_pkl_id`, `siswa_id`, `nim`, `kelas`, `prodi`, `status_anggota`, `created_at`, `updated_at`) VALUES
(3, 2, 9, '01010101', '12', 'tkj', 'ketua', '2026-04-06 21:12:09', '2026-04-06 21:12:09');

-- --------------------------------------------------------

--
-- Table structure for table `laporans`
--

CREATE TABLE `laporans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kelompok_siswa_id` bigint(20) UNSIGNED DEFAULT NULL,
  `judul_laporan` varchar(255) NOT NULL,
  `abstrak` text NOT NULL,
  `file_laporan` varchar(255) NOT NULL,
  `file_presentasi` varchar(255) DEFAULT NULL,
  `status` enum('draft','diajukan','direview','direvisi','disetujui','ditolak') NOT NULL DEFAULT 'draft',
  `catatan_revisi` text DEFAULT NULL,
  `reviewer_dosen_id` bigint(20) UNSIGNED DEFAULT NULL,
  `reviewed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `laporans`
--

INSERT INTO `laporans` (`id`, `kelompok_siswa_id`, `judul_laporan`, `abstrak`, `file_laporan`, `file_presentasi`, `status`, `catatan_revisi`, `reviewer_dosen_id`, `reviewed_at`, `created_at`, `updated_at`) VALUES
(1, 3, 'laporan magang di pt abc', 'asdkadnoakknsndaksndkaosndoka', 'laporan/3/6D4qTCAGle991Hdu26poG1pav4O3Dn0zvauOTLFN.pdf', 'presentasi/3/qa52Xt2CQcfkQuMthZv7YLgeYSA7z0vO7d40b99k.pdf', 'disetujui', NULL, 14, '2026-04-09 07:03:18', '2026-04-09 06:58:55', '2026-04-09 07:03:18');

-- --------------------------------------------------------

--
-- Table structure for table `logbooks`
--

CREATE TABLE `logbooks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kelompok_siswa_id` bigint(20) UNSIGNED DEFAULT NULL,
  `tanggal` date NOT NULL,
  `kegiatan` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `dokumentasi` varchar(255) DEFAULT NULL,
  `status` enum('pending','disetujui','ditolak') NOT NULL DEFAULT 'pending',
  `status_hari` enum('normal','izin','sakit') NOT NULL DEFAULT 'normal',
  `ijin_sakit_id` bigint(20) UNSIGNED DEFAULT NULL,
  `catatan_dosen` text DEFAULT NULL,
  `catatan_pt` text DEFAULT NULL,
  `approved_by_dosen` bigint(20) UNSIGNED DEFAULT NULL,
  `approved_by_pt` bigint(20) UNSIGNED DEFAULT NULL,
  `approved_at_dosen` timestamp NULL DEFAULT NULL,
  `approved_at_pt` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `approval_dosen` enum('pending','disetujui','ditolak') DEFAULT 'pending',
  `approval_pt` enum('pending','disetujui','ditolak') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `logbooks`
--

INSERT INTO `logbooks` (`id`, `kelompok_siswa_id`, `tanggal`, `kegiatan`, `deskripsi`, `jam_mulai`, `jam_selesai`, `dokumentasi`, `status`, `status_hari`, `ijin_sakit_id`, `catatan_dosen`, `catatan_pt`, `approved_by_dosen`, `approved_by_pt`, `approved_at_dosen`, `approved_at_pt`, `created_at`, `updated_at`, `approval_dosen`, `approval_pt`) VALUES
(1, 3, '2026-04-07', 'membuat program', 'adasdsadadasdadadad', '08:00:00', '17:00:00', 'logbook-dokumentasi/m6eK43vPaxF8GeotSpTrKLMdyK4TpjX4YeZtw7jo.png', 'disetujui', 'normal', NULL, NULL, NULL, 14, 13, '2026-04-07 09:17:38', '2026-04-07 09:18:23', '2026-04-07 07:46:54', '2026-04-07 09:18:23', 'disetujui', 'pending');

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
(1, '2026_03_03_032458_create_users_table', 1),
(2, '2026_03_03_032508_create_password_reset_tokens_table', 1),
(3, '2026_03_03_032515_create_sessions_table', 1),
(4, '2026_03_03_032521_create_perusahaans_table', 1),
(5, '2026_03_03_032527_create_dosens_table', 1),
(6, '2026_03_03_032531_create_kelompok_pkls_table', 1),
(7, '2026_03_03_032536_create_kelompok_siswas_table', 1),
(8, '2026_03_03_032541_create_logbooks_table', 1),
(9, '2026_03_03_032547_create_laporans_table', 1),
(10, '2026_03_03_032554_create_penilaians_table', 1),
(11, '2026_03_03_032559_create_notifikasis_table', 1),
(12, '2026_03_03_032605_create_failed_jobs_table', 1),
(13, '2026_03_03_032611_create_personal_access_tokens_table', 1),
(14, '2026_03_03_035319_create_cache_table', 1),
(21, '2026_04_05_103338_add_keterangan_to_logbooks_table', 3),
(22, '2026_04_05_102754_add_location_to_perusahaans_table', 4),
(23, '2026_04_05_104513_create_absensis_table', 5),
(24, '2026_04_05_104544_create_ijin_sakit_table', 5),
(25, '2026_04_06_071915_add_missing_columns_to_dosens', 6),
(26, '2026_04_06_075015_add_coordinates_to_perusahaans_table', 7),
(27, '2026_04_06_082724_make_dosen_id_nullable_in_kelompok_pkls', 8),
(28, '2026_04_07_140017_sync_dosen_foto_to_users', 9),
(29, '2026_04_07_150228_add_approval_status_to_logbooks_table', 10);

-- --------------------------------------------------------

--
-- Table structure for table `notifikasis`
--

CREATE TABLE `notifikasis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `judul` varchar(255) NOT NULL,
  `pesan` text NOT NULL,
  `tipe` varchar(255) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifikasis`
--

INSERT INTO `notifikasis` (`id`, `user_id`, `judul`, `pesan`, `tipe`, `url`, `is_read`, `created_at`, `updated_at`) VALUES
(2, NULL, 'Status Kelompok PKL', 'Kelompok adawda telah aktif', 'success', NULL, 0, '2026-04-05 05:51:41', '2026-04-05 05:51:41'),
(3, NULL, 'Status Kelompok PKL', 'Kelompok adawda telah aktif', 'success', NULL, 0, '2026-04-05 05:51:41', '2026-04-05 05:51:41'),
(4, NULL, 'Absensi oleh Dosen', 'Anda telah diabsensi oleh dosen pembimbing pada hari ini', 'success', 'http://127.0.0.1:8000/siswa/absensi', 0, '2026-04-06 00:40:58', '2026-04-06 00:40:58'),
(5, NULL, 'Absensi oleh Dosen', 'Anda telah diabsensi oleh dosen pembimbing pada hari ini', 'success', 'http://127.0.0.1:8000/siswa/absensi', 0, '2026-04-06 00:41:03', '2026-04-06 00:41:03'),
(6, 14, 'Kelompok PKL Baru', 'Anda ditugaskan sebagai pembimbing kelompok haji', 'info', 'http://127.0.0.1:8000/dosen/bimbingan/2', 1, '2026-04-06 21:12:09', '2026-04-09 07:22:47'),
(7, 13, 'Kelompok PKL Baru', 'Kelompok haji akan PKL di perusahaan Anda', 'info', 'http://127.0.0.1:8000/pt/monitoring/2', 0, '2026-04-06 21:12:09', '2026-04-06 21:12:09'),
(8, 9, 'Status Kelompok PKL', 'Kelompok haji telah aktif', 'success', NULL, 1, '2026-04-06 21:12:16', '2026-04-13 01:45:49'),
(9, 14, 'Logbook Baru', 'AGUS mengirim logbook baru untuk tanggal 07/04/2026', 'info', 'http://127.0.0.1:8000/dosen/logbook/1/review', 1, '2026-04-07 07:46:54', '2026-04-09 07:22:47'),
(10, 13, 'Logbook Baru', 'AGUS mengirim logbook baru untuk tanggal 07/04/2026', 'info', 'http://127.0.0.1:8000/pt/logbook/1/review', 0, '2026-04-07 07:46:54', '2026-04-07 07:46:54'),
(11, 9, 'Logbook Disetujui', 'Logbook tanggal 07/04/2026 telah disetujui oleh pembimbing PT.', 'success', 'http://127.0.0.1:8000/siswa/logbook/1', 1, '2026-04-07 07:48:03', '2026-04-13 01:45:49'),
(12, 9, 'Logbook Disetujui oleh Dosen', 'Logbook tanggal 07/04/2026 telah disetujui oleh dosen pembimbing.', 'success', 'http://127.0.0.1:8000/siswa/logbook/1', 1, '2026-04-07 08:29:26', '2026-04-13 01:45:49'),
(13, 9, 'Logbook Disetujui oleh Dosen', 'Logbook tanggal 07/04/2026 telah disetujui oleh dosen pembimbing.', 'success', 'http://127.0.0.1:8000/siswa/logbook/1', 1, '2026-04-07 08:29:43', '2026-04-13 01:45:49'),
(14, 9, 'Logbook Disetujui oleh Dosen', 'Logbook tanggal 07/04/2026 telah disetujui oleh dosen pembimbing.', 'success', 'http://127.0.0.1:8000/siswa/logbook/1', 1, '2026-04-07 08:30:01', '2026-04-13 01:45:49'),
(15, 9, 'Logbook Disetujui', 'Logbook tanggal 07/04/2026 telah disetujui oleh pembimbing PT.', 'success', 'http://127.0.0.1:8000/siswa/logbook/1', 1, '2026-04-07 08:30:28', '2026-04-13 01:45:49'),
(16, 9, 'Logbook Disetujui', 'Logbook tanggal 07/04/2026 telah disetujui oleh pembimbing PT.', 'success', 'http://127.0.0.1:8000/siswa/logbook/1', 1, '2026-04-07 08:53:42', '2026-04-13 01:45:49'),
(17, 9, 'Logbook Disetujui oleh Dosen', 'Logbook tanggal 07/04/2026 telah disetujui oleh dosen pembimbing.', 'success', 'http://127.0.0.1:8000/siswa/logbook/1', 1, '2026-04-07 09:17:27', '2026-04-13 01:45:49'),
(18, 9, 'Logbook Disetujui oleh Dosen', 'Logbook tanggal 07/04/2026 telah disetujui oleh dosen pembimbing.', 'success', 'http://127.0.0.1:8000/siswa/logbook/1', 1, '2026-04-07 09:17:38', '2026-04-13 01:45:49'),
(19, 9, 'Logbook Disetujui', 'Logbook tanggal 07/04/2026 telah disetujui oleh pembimbing PT.', 'success', 'http://127.0.0.1:8000/siswa/logbook/1', 1, '2026-04-07 09:18:23', '2026-04-13 01:45:49'),
(20, 14, 'Pengajuan Sakit', 'AGUS mengajukan sakit dari 09/04/2026 s/d 09/04/2026', 'info', 'http://127.0.0.1:8000/dosen/ijin-sakit', 1, '2026-04-09 06:57:45', '2026-04-09 07:22:47'),
(21, 14, 'Laporan Baru', 'AGUS mengajukan laporan untuk direview.', 'info', 'http://127.0.0.1:8000/dosen/laporan/1/review', 1, '2026-04-09 06:59:06', '2026-04-09 07:22:47'),
(22, 9, 'Pengajuan Sakit Disetujui', 'Pengajuan Anda telah disetujui oleh dosen pembimbing.', 'success', NULL, 1, '2026-04-09 07:00:04', '2026-04-13 01:45:49'),
(23, 9, 'Penilaian Dosen', 'Nilai PKL dari dosen pembimbing telah diinput.', 'success', 'http://127.0.0.1:8000/siswa/penilaian', 1, '2026-04-10 23:23:25', '2026-04-13 01:45:49'),
(24, 9, 'Penilaian dari PT', 'Nilai PKL dari pembimbing PT telah diinput.', 'success', 'http://127.0.0.1:8000/siswa/penilaian', 1, '2026-04-10 23:28:35', '2026-04-13 01:45:49');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `penilaians`
--

CREATE TABLE `penilaians` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kelompok_siswa_id` bigint(20) UNSIGNED DEFAULT NULL,
  `penilai` enum('dosen','pt') NOT NULL,
  `nilai_laporan` int(11) DEFAULT NULL,
  `nilai_presentasi` int(11) DEFAULT NULL,
  `nilai_sikap` int(11) DEFAULT NULL,
  `nilai_kinerja` int(11) DEFAULT NULL,
  `nilai_kedisiplinan` int(11) DEFAULT NULL,
  `nilai_kerjasama` int(11) DEFAULT NULL,
  `nilai_inisiatif` int(11) DEFAULT NULL,
  `nilai_akhir` double DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `penilai_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `penilaians`
--

INSERT INTO `penilaians` (`id`, `kelompok_siswa_id`, `penilai`, `nilai_laporan`, `nilai_presentasi`, `nilai_sikap`, `nilai_kinerja`, `nilai_kedisiplinan`, `nilai_kerjasama`, `nilai_inisiatif`, `nilai_akhir`, `catatan`, `penilai_id`, `created_at`, `updated_at`) VALUES
(1, 3, 'dosen', 68, 80, 80, NULL, NULL, NULL, NULL, 76, 'yang baik ya', 14, '2026-04-10 23:23:25', '2026-04-10 23:23:25'),
(2, 3, 'pt', NULL, NULL, NULL, 90, 80, 90, 89, 87.25, 'cukup baik', 13, '2026-04-10 23:28:35', '2026-04-10 23:28:35');

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
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `perusahaans`
--

CREATE TABLE `perusahaans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_perusahaan` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `telepon` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `bidang_usaha` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `kontak_person` varchar(255) NOT NULL,
  `jabatan_kontak` varchar(255) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `perusahaans`
--

INSERT INTO `perusahaans` (`id`, `nama_perusahaan`, `alamat`, `latitude`, `longitude`, `telepon`, `email`, `bidang_usaha`, `deskripsi`, `kontak_person`, `jabatan_kontak`, `logo`, `user_id`, `is_active`, `created_at`, `updated_at`) VALUES
(2, 'Pt.bengkel', 'Subang, West Java, Java, 41215, Indonesia', -6.57865671, 107.78350711, '0808080', 'pt5@test.com', 'mesin', NULL, 'azis', 'manager', 'perusahaan/logo/1775572036_iron-man-4k-wallpaper-uhdpaper.com-5335h.jpg', 10, 1, '2026-04-06 01:53:46', '2026-04-07 07:27:16'),
(3, 'PT.MSKOM', 'Universitas Subang, Jalan Raden Ajeng. Kartini, Kelurahan Soklat, Wanareja, Subang, West Java, Java, 41215, Indonesia', -6.57734389, 107.78301073, '000000', 'iwen@test.com', 'KOMPUTER JARINGAN', NULL, 'IWEN', 'manager', 'perusahaan/logo/1775572152_iron-man-4k-wallpaper-uhdpaper.com-5335h.jpg', 13, 1, '2026-04-06 21:08:30', '2026-04-07 07:29:12');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('DnBOpNeD8vPXohlocFl3jsDW6KcsXtgYdacKeuYe', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZEJNRmF0ZnNYaUhWazlXbmRTWHU3VHFZUVUxYTA5UGR4Q2h3b3BOaSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9fQ==', 1776075819);

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
  `nomor_induk` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `role` enum('admin','dosen','pt','siswa') NOT NULL DEFAULT 'siswa',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `profile_photo_path` varchar(2048) DEFAULT NULL,
  `two_factor_secret` text DEFAULT NULL,
  `two_factor_recovery_codes` text DEFAULT NULL,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `nomor_induk`, `phone`, `address`, `foto`, `role`, `is_active`, `profile_photo_path`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin Sistem', 'admin@monitoring.test', NULL, '$2y$12$q1CVL5rMW9G5OUa1c9PhpuoVT9q.gZe8K3qcG/58JFldROoKM4G/i', 'ADM001', '081234567890', 'Jl. Contoh No. 1', NULL, 'admin', 1, NULL, NULL, NULL, NULL, '7ebRiQsmfMYV6h3TATjuRBa71V0pP7Qo8GNZOkcPM8HjiYLpMxRXi3HyTHf2', '2026-03-31 22:43:29', '2026-03-31 22:43:29'),
(9, 'AGUS', 'siswa1@test.com', NULL, '$2y$12$lMTq.EY0JtdT8lhobyAkEuC5rgncVowSJWyeKkZfeTt8gRfRISnka', '01010101', '01010101', 'SUBANG', 'users/foto/IzFCYsmFYEbObhl6mz7OnlmAF2ZFCxSL6LkpbfSc.jpg', 'siswa', 1, NULL, NULL, NULL, NULL, NULL, '2026-04-06 01:41:21', '2026-04-07 07:39:10'),
(10, 'Pt.bengkel', 'pt5@test.com', NULL, '$2y$12$b4jsvAGox51Ich7BRH/m4OasrvsjmekJhFEZpIiXNtg6HBBP52ZNK', 'PT1775465626', '0808080', 'Subang, West Java, Java, 41215, Indonesia', 'perusahaan/logo/1775572036_iron-man-4k-wallpaper-uhdpaper.com-5335h.jpg', 'pt', 1, NULL, NULL, NULL, NULL, NULL, '2026-04-06 01:53:46', '2026-04-07 07:27:16'),
(11, 'adila', 'guru1@test.com', NULL, '$2y$12$8UAeFcb/EvDQH1SGMz6ByemSmVM.keiBQC3ykWCXGEt8WpofvLKky', '123456789', '0800000', NULL, 'dosens/foto/NSY5I6OmYWik1vUX0qfgFE3npj7Gv2oIRGzAfJGI.jpg', 'dosen', 1, NULL, NULL, NULL, NULL, 'psfP2TJMhIlKyntBHS7pL7142djHKvwulqscqHUGs8022ISsUDcFLhLKxwVp', '2026-04-06 01:55:28', '2026-04-13 01:36:59'),
(13, 'PT.MSKOM', 'iwen@test.com', NULL, '$2y$12$AtnZq8m0EsWEk8NlKin.yeJnML8GHbCBZ2sACQUQe651Q0ND63jCi', 'PT1775534910', '000000', 'Universitas Subang, Jalan Raden Ajeng. Kartini, Kelurahan Soklat, Wanareja, Subang, West Java, Java, 41215, Indonesia', 'perusahaan/logo/1775572152_iron-man-4k-wallpaper-uhdpaper.com-5335h.jpg', 'pt', 1, NULL, NULL, NULL, NULL, 'aVKyEbyGDedqyJXNxGLcdCEcOhiHB3k17LfVXzGUmkeRcoTMEMYXAJiUwCzo', '2026-04-06 21:08:30', '2026-04-07 07:29:12'),
(14, 'kurniawan', 'guru2@test.com', NULL, '$2y$12$rqd5juO6vFltsSivccs70uR//HkZGAee.4eDe2WUDxY.2A3zbFpvC', '999999', '111111', NULL, NULL, 'dosen', 1, NULL, NULL, NULL, NULL, NULL, '2026-04-06 21:10:32', '2026-04-13 01:37:30'),
(15, 'faris', 'faris@gmail.com', NULL, '$2y$12$Pe3YbXdAyUQHUKGkxvVOhejFFJXBPzymliLDK/gJb0.A0zoTy9piK', NULL, NULL, NULL, NULL, 'siswa', 1, NULL, NULL, NULL, NULL, NULL, '2026-04-06 21:20:49', '2026-04-06 21:20:49'),
(16, 'zidan', 'siswa3@test.com', NULL, '$2y$12$.zv2K48NU2SgTNJ47.NCLemocukA0EHAZs9bmUN6dTemSUAlr292C', '9292922929292929', '0000000000', 'subang', NULL, 'siswa', 1, NULL, NULL, NULL, NULL, NULL, '2026-04-13 00:54:59', '2026-04-13 00:54:59');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absensis`
--
ALTER TABLE `absensis`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `absensis_siswa_id_tanggal_unique` (`siswa_id`,`tanggal`),
  ADD KEY `absensis_kelompok_siswa_id_foreign` (`kelompok_siswa_id`),
  ADD KEY `absensis_dosen_id_foreign` (`dosen_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `dosens`
--
ALTER TABLE `dosens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `dosens_nidn_unique` (`nidn`),
  ADD UNIQUE KEY `dosens_email_unique` (`email`),
  ADD KEY `dosens_user_id_foreign` (`user_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `ijin_sakit`
--
ALTER TABLE `ijin_sakit`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ijin_sakit_siswa_id_foreign` (`siswa_id`),
  ADD KEY `ijin_sakit_kelompok_siswa_id_foreign` (`kelompok_siswa_id`),
  ADD KEY `ijin_sakit_approved_by_foreign` (`approved_by`);

--
-- Indexes for table `kelompok_pkls`
--
ALTER TABLE `kelompok_pkls`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kelompok_pkls_dosen_id_foreign` (`dosen_id`),
  ADD KEY `kelompok_pkls_perusahaan_id_foreign` (`perusahaan_id`);

--
-- Indexes for table `kelompok_siswas`
--
ALTER TABLE `kelompok_siswas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kelompok_siswas_nim_unique` (`nim`),
  ADD KEY `kelompok_siswas_kelompok_pkl_id_foreign` (`kelompok_pkl_id`),
  ADD KEY `kelompok_siswas_siswa_id_foreign` (`siswa_id`);

--
-- Indexes for table `laporans`
--
ALTER TABLE `laporans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `laporans_kelompok_siswa_id_foreign` (`kelompok_siswa_id`),
  ADD KEY `laporans_reviewer_dosen_id_foreign` (`reviewer_dosen_id`);

--
-- Indexes for table `logbooks`
--
ALTER TABLE `logbooks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `logbooks_kelompok_siswa_id_foreign` (`kelompok_siswa_id`),
  ADD KEY `logbooks_approved_by_dosen_foreign` (`approved_by_dosen`),
  ADD KEY `logbooks_approved_by_pt_foreign` (`approved_by_pt`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifikasis`
--
ALTER TABLE `notifikasis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifikasis_user_id_foreign` (`user_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `penilaians`
--
ALTER TABLE `penilaians`
  ADD PRIMARY KEY (`id`),
  ADD KEY `penilaians_kelompok_siswa_id_foreign` (`kelompok_siswa_id`),
  ADD KEY `penilaians_penilai_id_foreign` (`penilai_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `perusahaans`
--
ALTER TABLE `perusahaans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `perusahaans_email_unique` (`email`),
  ADD KEY `perusahaans_user_id_foreign` (`user_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_nomor_induk_unique` (`nomor_induk`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absensis`
--
ALTER TABLE `absensis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `dosens`
--
ALTER TABLE `dosens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ijin_sakit`
--
ALTER TABLE `ijin_sakit`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `kelompok_pkls`
--
ALTER TABLE `kelompok_pkls`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `kelompok_siswas`
--
ALTER TABLE `kelompok_siswas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `laporans`
--
ALTER TABLE `laporans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `logbooks`
--
ALTER TABLE `logbooks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `notifikasis`
--
ALTER TABLE `notifikasis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `penilaians`
--
ALTER TABLE `penilaians`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `perusahaans`
--
ALTER TABLE `perusahaans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `absensis`
--
ALTER TABLE `absensis`
  ADD CONSTRAINT `absensis_dosen_id_foreign` FOREIGN KEY (`dosen_id`) REFERENCES `dosens` (`id`),
  ADD CONSTRAINT `absensis_kelompok_siswa_id_foreign` FOREIGN KEY (`kelompok_siswa_id`) REFERENCES `kelompok_siswas` (`id`),
  ADD CONSTRAINT `absensis_siswa_id_foreign` FOREIGN KEY (`siswa_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `dosens`
--
ALTER TABLE `dosens`
  ADD CONSTRAINT `dosens_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `ijin_sakit`
--
ALTER TABLE `ijin_sakit`
  ADD CONSTRAINT `ijin_sakit_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `ijin_sakit_kelompok_siswa_id_foreign` FOREIGN KEY (`kelompok_siswa_id`) REFERENCES `kelompok_siswas` (`id`),
  ADD CONSTRAINT `ijin_sakit_siswa_id_foreign` FOREIGN KEY (`siswa_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `kelompok_pkls`
--
ALTER TABLE `kelompok_pkls`
  ADD CONSTRAINT `kelompok_pkls_dosen_id_foreign` FOREIGN KEY (`dosen_id`) REFERENCES `dosens` (`id`),
  ADD CONSTRAINT `kelompok_pkls_perusahaan_id_foreign` FOREIGN KEY (`perusahaan_id`) REFERENCES `perusahaans` (`id`);

--
-- Constraints for table `kelompok_siswas`
--
ALTER TABLE `kelompok_siswas`
  ADD CONSTRAINT `kelompok_siswas_kelompok_pkl_id_foreign` FOREIGN KEY (`kelompok_pkl_id`) REFERENCES `kelompok_pkls` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `kelompok_siswas_siswa_id_foreign` FOREIGN KEY (`siswa_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `laporans`
--
ALTER TABLE `laporans`
  ADD CONSTRAINT `laporans_kelompok_siswa_id_foreign` FOREIGN KEY (`kelompok_siswa_id`) REFERENCES `kelompok_siswas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `laporans_reviewer_dosen_id_foreign` FOREIGN KEY (`reviewer_dosen_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `logbooks`
--
ALTER TABLE `logbooks`
  ADD CONSTRAINT `logbooks_approved_by_dosen_foreign` FOREIGN KEY (`approved_by_dosen`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `logbooks_approved_by_pt_foreign` FOREIGN KEY (`approved_by_pt`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `logbooks_kelompok_siswa_id_foreign` FOREIGN KEY (`kelompok_siswa_id`) REFERENCES `kelompok_siswas` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifikasis`
--
ALTER TABLE `notifikasis`
  ADD CONSTRAINT `notifikasis_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `penilaians`
--
ALTER TABLE `penilaians`
  ADD CONSTRAINT `penilaians_kelompok_siswa_id_foreign` FOREIGN KEY (`kelompok_siswa_id`) REFERENCES `kelompok_siswas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `penilaians_penilai_id_foreign` FOREIGN KEY (`penilai_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `perusahaans`
--
ALTER TABLE `perusahaans`
  ADD CONSTRAINT `perusahaans_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
