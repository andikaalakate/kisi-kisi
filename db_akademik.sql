-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 08, 2024 at 05:53 AM
-- Server version: 8.0.30
-- PHP Version: 8.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_akademik`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `role` enum('super_admin','admin','user','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `email`, `username`, `password`, `role`) VALUES
(1, 'andikaalakate@gmail.com', 'andika46710', '518894ae1e3013a7a34ae390fcf20ad5', 'super_admin'),
(2, 'alakateandika@gmail.com', 'alakatee', 'd41d8cd98f00b204e9800998ecf8427e', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `guru`
--

CREATE TABLE `guru` (
  `id` int NOT NULL,
  `kode_guru` varchar(10) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `mapel` enum('IPA','IPS','Matematika','Bahasa Indonesia','Bahasa Inggris','PKN','Sejarah','Informatika','Pemrograman','Jaringan','Penjas','SBK','Konsentrasi Keahlian','Pendidikan Agama') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `kelas` json NOT NULL COMMENT 'Kelas-kelas mana saja yang dimasuki oleh Guru tersebut',
  `no_telp` varchar(100) NOT NULL,
  `jkelamin` enum('L','P') NOT NULL,
  `alamat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `guru`
--

INSERT INTO `guru` (`id`, `kode_guru`, `nama`, `password`, `mapel`, `kelas`, `no_telp`, `jkelamin`, `alamat`) VALUES
(4, 'GUR00001', 'Andika Pratama', '518894ae1e3013a7a34ae390fcf20ad5', 'Pemrograman', '[\"KEL00001\", \"KEL00002\", \"KEL00004\"]', '+628979352138', 'P', 'Jalan Utama 1, Desa Kolam, Sei Rotan, Kecamatan Percut Sei Tuan, Kabupaten Deli Serdang, Sumatera Utara'),
(5, 'GUR00005', 'Mali', '', 'Matematika', '[\"KEL00001\", \"KEL00002\"]', '+628979352138', 'L', 'Ki. Rumah Sakit No. 740, Cilegon 40148, Kalteng'),
(6, 'GUR00006', 'Gilang', '', 'Bahasa Indonesia', '[\"KEL00004\", \"KEL00002\", \"KEL00001\"]', '+6283199348860', 'L', 'Dk. Gambang No. 136, Pagar Alam 36407, Maluku'),
(8, 'GUR00007', 'Mari', 'd41d8cd98f00b204e9800998ecf8427e', 'Matematika', '[\"KEL00001\", \"KEL00002\"]', '+6283199348860', 'P', 'Kpg. Baranang Siang No. 532, Gorontalo 42960, Sulut');

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `id` int NOT NULL COMMENT 'Primary Key',
  `kode_kelas` varchar(10) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `ta` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`id`, `kode_kelas`, `nama`, `ta`) VALUES
(1, 'KEL00001', 'XI-RPL', '2023-2024'),
(3, 'KEL00002', 'XII-TJKT 1', '2019-2020'),
(4, 'KEL00004', 'XII-TJKT 2', '2021-2022');

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `id` int NOT NULL,
  `kode_siswa` varchar(10) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jurusan` enum('RPL','TJKT','AKL','PM','MPLB') NOT NULL,
  `jkelamin` enum('L','P') NOT NULL,
  `no_telp` varchar(100) NOT NULL,
  `kelas` enum('10','11','12') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`id`, `kode_siswa`, `nama`, `jurusan`, `jkelamin`, `no_telp`, `kelas`) VALUES
(1, 'SIS00001', 'Andika Pratama', 'RPL', 'L', '089505722187', '11'),
(3, 'SIS00002', 'Mali', 'RPL', 'L', '+628979352138', '12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `guru`
--
ALTER TABLE `guru`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `guru`
--
ALTER TABLE `guru`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT COMMENT 'Primary Key', AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
