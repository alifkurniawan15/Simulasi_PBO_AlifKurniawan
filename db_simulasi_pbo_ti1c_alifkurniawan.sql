-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 17, 2026 at 02:54 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_simulasi_pbo_ti1c_alifkurniawan`
--

-- --------------------------------------------------------

--
-- Table structure for table `tabel_pendaftaran`
--

CREATE TABLE `tabel_pendaftaran` (
  `id_pendaftaran` int NOT NULL,
  `nama_calon` varchar(150) NOT NULL,
  `asal_sekolah` varchar(100) NOT NULL,
  `nilai_ujian` decimal(5,2) NOT NULL,
  `biaya_pendaftaran_dasar` decimal(10,2) NOT NULL,
  `jalur_pendaftaran` enum('Reguler','Prestasi','Kedinasan') NOT NULL,
  `pilihan_prodi` varchar(100) DEFAULT NULL,
  `lokasi_kampus` varchar(50) DEFAULT NULL,
  `jenis_prestasi` varchar(100) DEFAULT NULL,
  `tingkat_prestasi` varchar(50) DEFAULT NULL,
  `sk_ikatan_dinas` varchar(50) DEFAULT NULL,
  `instansi_sponsor` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tabel_pendaftaran`
--

INSERT INTO `tabel_pendaftaran` (`id_pendaftaran`, `nama_calon`, `asal_sekolah`, `nilai_ujian`, `biaya_pendaftaran_dasar`, `jalur_pendaftaran`, `pilihan_prodi`, `lokasi_kampus`, `jenis_prestasi`, `tingkat_prestasi`, `sk_ikatan_dinas`, `instansi_sponsor`) VALUES
(1, 'Rian Hidayat', 'SMA Negeri 1 Cilacap', '85.50', '250000.00', 'Reguler', 'Teknik Informatika', 'Kampus Utama', NULL, NULL, NULL, NULL),
(2, 'Dinda Lestari', 'SMA Negeri 2 Purwokerto', '79.25', '250000.00', 'Reguler', 'Sistem Informasi', 'Kampus Utama', NULL, NULL, NULL, NULL),
(3, 'Fajar Nugraha', 'SMK Negeri 1 Purbalingga', '82.00', '250000.00', 'Reguler', 'Teknik Elektro', 'Kampus 2', NULL, NULL, NULL, NULL),
(4, 'Amalia Putri', 'SMA Negeri 3 Cilacap', '88.75', '250000.00', 'Reguler', 'Akuntansi', 'Kampus Utama', NULL, NULL, NULL, NULL),
(5, 'Bagus Saputra', 'SMA Negeri 1 Banyumas', '76.00', '250000.00', 'Reguler', 'Manajemen Pemasaran', 'Kampus 2', NULL, NULL, NULL, NULL),
(6, 'Citra Dewi', 'SMA Negeri 1 Kebumen', '84.10', '250000.00', 'Reguler', 'Teknik Informatika', 'Kampus Utama', NULL, NULL, NULL, NULL),
(7, 'Dimas Prayoga', 'SMK Negeri 2 Cilacap', '80.50', '250000.00', 'Reguler', 'Teknik Mesin', 'Kampus 2', NULL, NULL, NULL, NULL),
(8, 'Siti Nurhaliza', 'MAN 2 Banyumas', '92.00', '250000.00', 'Prestasi', NULL, NULL, 'Olimpiade Matematika', 'Nasional', NULL, NULL),
(9, 'Eko Prasetyo', 'SMA Negeri 1 Slawi', '89.50', '250000.00', 'Prestasi', NULL, NULL, 'Futsal Beregu', 'Provinsi', NULL, NULL),
(10, 'Gita Gutawa', 'SMA Christian Purwokerto', '91.25', '250000.00', 'Prestasi', NULL, NULL, 'Solo Song Pop', 'Nasional', NULL, NULL),
(11, 'Hendra Wijaya', 'SMK Tekkom Cilacap', '87.80', '250000.00', 'Prestasi', NULL, NULL, 'LKS Web Technologies', 'Provinsi', NULL, NULL),
(12, 'Indah Permata', 'SMA Negeri 1 Banjarnegara', '95.00', '250000.00', 'Prestasi', NULL, NULL, 'Karya Ilmiah Remaja', 'Internasional', NULL, NULL),
(13, 'Joko Susilo', 'SMA Negeri 4 Cilacap', '86.00', '250000.00', 'Prestasi', NULL, NULL, 'Pencak Silat Seni', 'Kabupaten', NULL, NULL),
(14, 'Kurniawati', 'MAN 1 Cilacap', '93.40', '250000.00', 'Prestasi', NULL, NULL, 'Tahfidz Al-Qur\'an 10 Juz', 'Nasional', NULL, NULL),
(15, 'Budi Utomo', 'SMK Negeri 2 Purwokerto', '88.25', '250000.00', 'Kedinasan', NULL, NULL, NULL, NULL, 'SK-990/IKD/2026', 'Dinas Perhubungan'),
(16, 'Lestari Ningsih', 'SMA Negeri 1 Kroya', '86.75', '250000.00', 'Kedinasan', NULL, NULL, NULL, NULL, 'SK-102/DISDIK/2026', 'Dinas Pendidikan'),
(17, 'Muhammad Rizky', 'SMA Negeri 2 Cilacap', '89.90', '250000.00', 'Kedinasan', NULL, NULL, NULL, NULL, 'SK-554/KOMINFO/2026', 'Dinas Kominfo'),
(18, 'Nadia Utami', 'SMA Negeri 1 Majenang', '85.40', '250000.00', 'Kedinasan', NULL, NULL, NULL, NULL, 'SK-041/BAPPEDA/2026', 'Bappeda Regional'),
(19, 'Oki Setiawan', 'SMK Negeri 1 Cilacap', '87.15', '250000.00', 'Kedinasan', NULL, NULL, NULL, NULL, 'SK-882/DINKES/2026', 'Dinas Kesehatan'),
(20, 'Putri Rahayu', 'SMA Negeri 1 Maos', '91.00', '250000.00', 'Kedinasan', NULL, NULL, NULL, NULL, 'SK-312/DISNAKER/2026', 'Dinas Tenaga Kerja'),
(21, 'Rendra Amin', 'SMA Al-Irsyad Purwokerto', '88.50', '250000.00', 'Kedinasan', NULL, NULL, NULL, NULL, 'SK-119/PU-PR/2026', 'Dinas Pekerjaan Umum');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tabel_pendaftaran`
--
ALTER TABLE `tabel_pendaftaran`
  ADD PRIMARY KEY (`id_pendaftaran`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tabel_pendaftaran`
--
ALTER TABLE `tabel_pendaftaran`
  MODIFY `id_pendaftaran` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
