-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 17, 2024 at 11:08 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lpmd`
--

-- --------------------------------------------------------

--
-- Table structure for table `anggotaa`
--

CREATE TABLE `anggotaa` (
  `id_anggota` int(10) NOT NULL,
  `nama_anggota` varchar(30) NOT NULL,
  `jabatan` varchar(20) NOT NULL,
  `alamat` varchar(25) NOT NULL,
  `nomor_telepon` varchar(15) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `level` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `anggotaa`
--

INSERT INTO `anggotaa` (`id_anggota`, `nama_anggota`, `jabatan`, `alamat`, `nomor_telepon`, `username`, `password`, `level`) VALUES
(1567, 'Sofyan Abdul, S.Pd', 'Ketua', 'Dusun IV Desa Bulila', '85276451237', 'sofyanabd12', 'sofya12', 1),
(1678, 'Sapriono Hadati', 'Wakil Ketua', 'Dusun III Desa Bulila', '85285241386', 'saprio123', 'saprhada123', 2),
(1789, 'Tadjudin Abdillah, M.Kom', 'Sekretaris', 'Dusun I Desa Bulila', '8124466687', 'tadjudin123', 'tadjuabdil123', 3),
(1890, 'HJ. Sarintan Lihawa', 'Bendahara', 'Dusun V Desa Bulila', '89516925402', 'sarintan234', 'sari234', 3),
(1901, 'H. Hima Adu', 'Anggota', 'Dusun II Desa Bulila', '85277428102', 'himaadu', '123hima', 3),
(2012, 'Moh. Rendy S Dude', 'Anggota', 'Dusun III Desa Bulila', '85299312256', 'rendy20', 'rennn12', 3),
(2134, 'Isnawati Ahmad', 'Anggota', 'Dusun II Desa Bulila', '89515983426', 'isnawa123', 'isna003', 3);

-- --------------------------------------------------------

--
-- Table structure for table `kegiatan`
--

CREATE TABLE `kegiatan` (
  `id_kegiatan` int(10) NOT NULL,
  `nama_kegiatan` varchar(100) NOT NULL,
  `tanggal_kegiatan` date NOT NULL,
  `deskripsi` varchar(250) NOT NULL,
  `gambar` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kegiatan`
--

INSERT INTO `kegiatan` (`id_kegiatan`, `nama_kegiatan`, `tanggal_kegiatan`, `deskripsi`, `gambar`) VALUES
(8765, 'Sosialisasi Anak Muda', '2021-11-20', 'meningkatkan kesadaran kepada anak muda tentang bahaya penyalahgunaan lem', ''),
(9876, 'Sosialisasi Kadar Hukum', '2021-10-07', 'membahas permasalahan tanah, batas tanah, dan sengketa tanah.', ''),
(9887, 'Sosialisasi dan simulasi pengelolaan sampah zero', '2021-10-29', 'Sosialisasi dan simulasi pengelolaan sampah zero', 'kegiatan_9887_desabulila-keg1.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `lembaga`
--

CREATE TABLE `lembaga` (
  `id_lembaga` int(10) NOT NULL,
  `nama_lembaga` varchar(30) NOT NULL,
  `kontak` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lembaga`
--

INSERT INTO `lembaga` (`id_lembaga`, `nama_lembaga`, `kontak`) VALUES
(2341, 'Pemerintah Desa', '85266759213'),
(4576, 'Karang Taruna', '85232998565');

-- --------------------------------------------------------

--
-- Table structure for table `level`
--

CREATE TABLE `level` (
  `id_level` int(11) NOT NULL,
  `nama_level` varchar(50) NOT NULL,
  `level` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `level`
--

INSERT INTO `level` (`id_level`, `nama_level`, `level`) VALUES
(1, 'Admin', 1),
(2, 'Moderator', 2),
(3, 'User', 3);

-- --------------------------------------------------------

--
-- Table structure for table `lpmd`
--

CREATE TABLE `lpmd` (
  `id_lpmd` int(10) NOT NULL,
  `id_anggota` int(10) NOT NULL,
  `id_kegiatan` int(10) NOT NULL,
  `id_lembaga` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lpmd`
--

INSERT INTO `lpmd` (`id_lpmd`, `id_anggota`, `id_kegiatan`, `id_lembaga`) VALUES
(1234, 1567, 9887, 2341),
(1235, 1789, 9876, 2341),
(1236, 2012, 9876, 2341),
(1237, 1901, 9887, 2341),
(3465, 1678, 9887, 4576),
(3466, 1890, 9887, 4576),
(3467, 2134, 8765, 4576),
(3468, 1901, 9876, 4576);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `anggotaa`
--
ALTER TABLE `anggotaa`
  ADD PRIMARY KEY (`id_anggota`),
  ADD KEY `id_level` (`level`);

--
-- Indexes for table `kegiatan`
--
ALTER TABLE `kegiatan`
  ADD PRIMARY KEY (`id_kegiatan`);

--
-- Indexes for table `lembaga`
--
ALTER TABLE `lembaga`
  ADD PRIMARY KEY (`id_lembaga`);

--
-- Indexes for table `level`
--
ALTER TABLE `level`
  ADD PRIMARY KEY (`id_level`);

--
-- Indexes for table `lpmd`
--
ALTER TABLE `lpmd`
  ADD PRIMARY KEY (`id_lpmd`),
  ADD KEY `lpmd_ibfk_1` (`id_anggota`),
  ADD KEY `lpmd_ibfk_2` (`id_kegiatan`),
  ADD KEY `lpmd_ibfk_3` (`id_lembaga`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `anggotaa`
--
ALTER TABLE `anggotaa`
  MODIFY `id_anggota` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121217;

--
-- AUTO_INCREMENT for table `kegiatan`
--
ALTER TABLE `kegiatan`
  MODIFY `id_kegiatan` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9889;

--
-- AUTO_INCREMENT for table `lembaga`
--
ALTER TABLE `lembaga`
  MODIFY `id_lembaga` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4580;

--
-- AUTO_INCREMENT for table `level`
--
ALTER TABLE `level`
  MODIFY `id_level` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `lpmd`
--
ALTER TABLE `lpmd`
  MODIFY `id_lpmd` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3471;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `anggotaa`
--
ALTER TABLE `anggotaa`
  ADD CONSTRAINT `anggotaa_ibfk_1` FOREIGN KEY (`level`) REFERENCES `level` (`id_level`);

--
-- Constraints for table `lpmd`
--
ALTER TABLE `lpmd`
  ADD CONSTRAINT `lpmd_ibfk_1` FOREIGN KEY (`id_anggota`) REFERENCES `anggotaa` (`id_anggota`),
  ADD CONSTRAINT `lpmd_ibfk_2` FOREIGN KEY (`id_kegiatan`) REFERENCES `kegiatan` (`id_kegiatan`),
  ADD CONSTRAINT `lpmd_ibfk_3` FOREIGN KEY (`id_lembaga`) REFERENCES `lembaga` (`id_lembaga`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
