-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 09, 2024 at 12:03 PM
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
  `mapel_kode` varchar(10) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `no_telp` varchar(100) NOT NULL,
  `jkelamin` enum('L','P') NOT NULL,
  `alamat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `guru`
--

INSERT INTO `guru` (`id`, `kode_guru`, `mapel_kode`, `nama`, `password`, `no_telp`, `jkelamin`, `alamat`) VALUES
(4, 'GUR00001', 'MAP00010', 'Andika Pratama', '518894ae1e3013a7a34ae390fcf20ad5', '+628979352138', 'L', 'Jalan Utama 1, Desa Kolam, Sei Rotan, Kecamatan Percut Sei Tuan, Kabupaten Deli Serdang, Sumatera Utara'),
(5, 'GUR00005', 'MAP00001', 'Mali', '', '+628979352138', 'L', 'Ki. Rumah Sakit No. 740, Cilegon 40148, Kalteng'),
(6, 'GUR00006', 'MAP00011', 'Gilang', '', '+6283199348860', 'L', 'Dk. Gambang No. 136, Pagar Alam 36407, Maluku'),
(13, 'GUR35155', 'MAP00009', 'Mari', '202cb962ac59075b964b07152d234b70', '08365487921', 'P', 'Jalan Utama 1, Desa Kolam, Sei Rotan, Kecamatan Percut Sei Tuan, Kabupaten Deli Serdang, Sumatera Utara'),
(14, 'GUR11347', 'MAP00001', 'Mami', '202cb962ac59075b964b07152d234b70', '+628979352138', 'P', 'Kampung Kolam Jalan Utama 1');

-- --------------------------------------------------------

--
-- Table structure for table `guru_kelas`
--

CREATE TABLE `guru_kelas` (
  `guru_kode` varchar(10) NOT NULL,
  `kelas_kode` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `guru_kelas`
--

INSERT INTO `guru_kelas` (`guru_kode`, `kelas_kode`) VALUES
('GUR00001', 'KEL00001'),
('GUR00005', 'KEL00001'),
('GUR00006', 'KEL00001'),
('GUR11347', 'KEL00001'),
('GUR35155', 'KEL00001'),
('GUR00001', 'KEL00002'),
('GUR00005', 'KEL00002'),
('GUR00006', 'KEL00002'),
('GUR35155', 'KEL00002'),
('GUR00001', 'KEL00004'),
('GUR00005', 'KEL00004'),
('GUR00006', 'KEL00004'),
('GUR11347', 'KEL00004'),
('GUR35155', 'KEL00004'),
('GUR00001', 'KEL00005'),
('GUR11347', 'KEL00005'),
('GUR35155', 'KEL00005'),
('GUR00001', 'KEL00011'),
('GUR35155', 'KEL00011');

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `id` int NOT NULL COMMENT 'Primary Key',
  `kode_kelas` varchar(10) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `jurusan` enum('RPL','TJKT','AKL','PM','MPLB') NOT NULL,
  `ta` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`id`, `kode_kelas`, `nama`, `jurusan`, `ta`) VALUES
(1, 'KEL00001', 'XI-RPL', 'RPL', '2023-2024'),
(3, 'KEL00002', 'XII-TJKT 1', 'TJKT', '2019-2020'),
(4, 'KEL00004', 'XII-TJKT 2', 'TJKT', '2021-2022'),
(10, 'KEL00005', 'XI-MPLB 1', 'MPLB', '2023-2024'),
(11, 'KEL00011', 'X-MPLB 1', 'MPLB', '2023-2024');

-- --------------------------------------------------------

--
-- Table structure for table `mata_pelajaran`
--

CREATE TABLE `mata_pelajaran` (
  `id` int NOT NULL,
  `kode_mapel` varchar(10) DEFAULT NULL,
  `nama` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `mata_pelajaran`
--

INSERT INTO `mata_pelajaran` (`id`, `kode_mapel`, `nama`) VALUES
(3, 'MAP00001', 'Matematika'),
(4, 'MAP00004', 'IPA'),
(5, 'MAP00005', 'IPS'),
(6, 'MAP00006', 'Bahasa Indonesia'),
(7, 'MAP00007', 'Bahasa Inggris'),
(8, 'MAP00008', 'PKN'),
(9, 'MAP00009', 'Sejarah'),
(10, 'MAP00010', 'Informatika'),
(11, 'MAP00011', 'Pemrograman'),
(12, 'MAP00012', 'Jaringan'),
(13, 'MAP00013', 'Penjas'),
(14, 'MAP00014', 'SBK'),
(15, 'MAP00015', 'Konsentrasi Keashlian'),
(16, 'MAP00016', 'Pendidikan Agama Islam'),
(17, 'MAP00017', 'Pendidikan Agama Kristen');

-- --------------------------------------------------------

--
-- Table structure for table `nilai`
--

CREATE TABLE `nilai` (
  `id` int NOT NULL,
  `siswa_kode` varchar(10) NOT NULL,
  `guru_kode` varchar(10) NOT NULL,
  `mapel_kode` varchar(10) NOT NULL,
  `nilai` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `id` int NOT NULL,
  `kode_siswa` varchar(10) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jkelamin` enum('L','P') NOT NULL,
  `no_telp` varchar(100) NOT NULL,
  `kelas` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`id`, `kode_siswa`, `nama`, `jkelamin`, `no_telp`, `kelas`) VALUES
(1, 'SIS00001', 'Andika Pratama', 'L', '089505722187', 'KEL00001'),
(3, 'SIS00002', 'Mali', 'L', '+628979352138', 'KEL00002');

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
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_guru` (`kode_guru`),
  ADD KEY `mapel_kode` (`mapel_kode`);

--
-- Indexes for table `guru_kelas`
--
ALTER TABLE `guru_kelas`
  ADD PRIMARY KEY (`guru_kode`,`kelas_kode`),
  ADD KEY `kelas_kode` (`kelas_kode`);

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_kelas` (`kode_kelas`);

--
-- Indexes for table `mata_pelajaran`
--
ALTER TABLE `mata_pelajaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kode_mapel` (`kode_mapel`);

--
-- Indexes for table `nilai`
--
ALTER TABLE `nilai`
  ADD PRIMARY KEY (`id`),
  ADD KEY `siswa_kode` (`siswa_kode`),
  ADD KEY `guru_kode` (`guru_kode`),
  ADD KEY `mapel_kode` (`mapel_kode`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_siswa` (`kode_siswa`),
  ADD KEY `kelas` (`kelas`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `guru`
--
ALTER TABLE `guru`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT COMMENT 'Primary Key', AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `mata_pelajaran`
--
ALTER TABLE `mata_pelajaran`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `nilai`
--
ALTER TABLE `nilai`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `guru`
--
ALTER TABLE `guru`
  ADD CONSTRAINT `guru_ibfk_1` FOREIGN KEY (`mapel_kode`) REFERENCES `mata_pelajaran` (`kode_mapel`);

--
-- Constraints for table `guru_kelas`
--
ALTER TABLE `guru_kelas`
  ADD CONSTRAINT `guru_kelas_ibfk_1` FOREIGN KEY (`guru_kode`) REFERENCES `guru` (`kode_guru`),
  ADD CONSTRAINT `guru_kelas_ibfk_2` FOREIGN KEY (`kelas_kode`) REFERENCES `kelas` (`kode_kelas`);

--
-- Constraints for table `nilai`
--
ALTER TABLE `nilai`
  ADD CONSTRAINT `nilai_ibfk_1` FOREIGN KEY (`siswa_kode`) REFERENCES `siswa` (`kode_siswa`),
  ADD CONSTRAINT `nilai_ibfk_2` FOREIGN KEY (`guru_kode`) REFERENCES `guru` (`kode_guru`),
  ADD CONSTRAINT `nilai_ibfk_3` FOREIGN KEY (`mapel_kode`) REFERENCES `mata_pelajaran` (`kode_mapel`);

--
-- Constraints for table `siswa`
--
ALTER TABLE `siswa`
  ADD CONSTRAINT `siswa_ibfk_1` FOREIGN KEY (`kelas`) REFERENCES `kelas` (`kode_kelas`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
