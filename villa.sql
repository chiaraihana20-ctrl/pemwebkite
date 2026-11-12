-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 12, 2026 at 05:15 PM
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
-- Database: `villa`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `id_booking` int(10) NOT NULL,
  `id_user` int(30) NOT NULL,
  `id_villa` int(20) NOT NULL,
  `tanggal_masuk` date NOT NULL,
  `tanggal_kelaur` date NOT NULL,
  `jumlah_tamu` int(10) NOT NULL,
  `harga` int(20) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(10) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `email` varchar(40) NOT NULL,
  `no_hp` varchar(15) NOT NULL,
  `password` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `villa`
--

CREATE TABLE `villa` (
  `id_villa` int(10) NOT NULL,
  `nama_villa` varchar(30) NOT NULL,
  `deskripsi` text NOT NULL,
  `harga` varchar(20) NOT NULL,
  `kapasitas` varchar(10) NOT NULL,
  `jumlah_kamar` varchar(10) NOT NULL,
  `gambar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `villa`
--

INSERT INTO `villa` (`id_villa`, `nama_villa`, `deskripsi`, `harga`, `kapasitas`, `jumlah_kamar`, `gambar`) VALUES
(1, 'Villa Ocean Paradise', 'Villa mewah yang berada tepat di pinggir pantai dengan pemandangan laut yang indah. Dilengkapi kolam renang pribadi, AC, WiFi, dapur lengkap, ruang keluarga, balkon menghadap laut, dan akses langsung ke pantai. Cocok untuk liburan bersama keluarga.', 'Rp2.500.000 / malam', '6 orang', '3 kamar ti', 'villa1.jpg'),
(2, 'Villa Sunset Beach', 'Villa modern dengan suasana romantis dan pemandangan matahari terbenam. Dilengkapi kolam renang pribadi, AC, WiFi, TV, dapur kecil, balkon menghadap laut, dan area bersantai di tepi pantai. Cocok untuk pasangan maupun keluarga kecil.', 'Rp1.500.000 / malam', '4 orang', '2 kamar ti', 'villa2.jpg'),
(3, 'Villa Coconut Bay', 'Villa bernuansa tropis dengan desain kayu dan pepohonan kelapa di sekitarnya. Menyediakan ruang keluarga, AC, WiFi, dapur lengkap, area BBQ, taman pribadi, gazebo, dan akses langsung menuju pantai. Cocok untuk liburan bersama keluarga besar.', 'Rp3.000.000 / malam', '8 orang', '4 kamar ti', 'villa3.jpg'),
(4, 'Villa Blue Horizon', 'Villa eksklusif dengan desain modern dan jendela kaca yang menghadap langsung ke laut. Dilengkapi infinity pool, AC, WiFi, smart TV, dapur modern, ruang karaoke, ruang makan, dan area BBQ. Cocok untuk rombongan besar.', 'Rp4.500.000 / malam', '10 orang', '5 kamar ti', 'villa4.jpg'),
(5, 'Villa Coral Breeze', 'Villa dengan desain minimalis dan suasana pantai yang tenang. Memiliki jacuzzi pribadi, AC, WiFi, TV, minibar, dapur kecil, balkon menghadap laut, dan area bersantai. Cocok untuk pasangan yang ingin menikmati liburan dengan suasana lebih privat.', 'Rp1.200.000 / malam', '4 orang', '2 kamar ti', 'villa5.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`id_booking`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- Indexes for table `villa`
--
ALTER TABLE `villa`
  ADD PRIMARY KEY (`id_villa`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `id_booking` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `villa`
--
ALTER TABLE `villa`
  MODIFY `id_villa` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
