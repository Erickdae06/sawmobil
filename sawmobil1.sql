-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 26, 2024 at 03:47 PM
-- Server version: 5.5.32
-- PHP Version: 5.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sawmobil1`
--
 
-- --------------------------------------------------------

--
-- Table structure for table `alternatif`
--

CREATE TABLE IF NOT EXISTS `alternatif` (
  `id_alternatif` int(11) NOT NULL AUTO_INCREMENT,
  `nama_alternatif` varchar(255) NOT NULL,
  `hasil_alternatif` double NOT NULL,
  PRIMARY KEY (`id_alternatif`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `alternatif`
--

INSERT INTO `alternatif` (`id_alternatif`, `nama_alternatif`, `hasil_alternatif`) VALUES
(14, 'Daihatsu Sigra R', 25.5833333333333),
(15, 'Honda Jazz', 26.0833333333333),
(16, 'Daihatsu Ayla M', 24.7),
(17, 'Honda Mobilio E', 0),
(18, 'Honda Brio R5', 0),
(19, 'Honda Brio E', 0),
(20, 'avansa', 8);

-- --------------------------------------------------------

--
-- Table structure for table `kriteria`
--

CREATE TABLE IF NOT EXISTS `kriteria` (
  `id_kriteria` int(11) NOT NULL AUTO_INCREMENT,
  `nama_kriteria` varchar(255) NOT NULL,
  `tipe_kriteria` varchar(10) NOT NULL,
  `bobot_kriteria` double NOT NULL,
  PRIMARY KEY (`id_kriteria`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `kriteria`
--

INSERT INTO `kriteria` (`id_kriteria`, `nama_kriteria`, `tipe_kriteria`, `bobot_kriteria`) VALUES
(1, 'Merk', 'benefit', 5),
(2, 'Tahun', 'cost', 5),
(3, 'Jarak Tempuh', 'cost', 4),
(4, 'Tipe Bahan Bakar', 'benefit', 3),
(5, 'Warna', 'benefit', 2),
(6, 'Sistem Penggerak', 'benefit', 3),
(7, 'Harga', 'benefit', 5),
(8, 'Kapasitas Penumpang', 'cost', 4);

-- --------------------------------------------------------

--
-- Table structure for table `nilai`
--

CREATE TABLE IF NOT EXISTS `nilai` (
  `id_nilai` int(6) NOT NULL AUTO_INCREMENT,
  `ket_nilai` varchar(45) NOT NULL,
  `jum_nilai` double NOT NULL,
  PRIMARY KEY (`id_nilai`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `nilai`
--

INSERT INTO `nilai` (`id_nilai`, `ket_nilai`, `jum_nilai`) VALUES
(14, 'Sangat TInggi', 5),
(15, 'Tinggi', 4),
(16, 'Cukup', 3),
(17, 'Rendah', 2),
(18, 'Sangat Rendah', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE IF NOT EXISTS `pengguna` (
  `id_pengguna` int(11) NOT NULL AUTO_INCREMENT,
  `nama_lengkap` varchar(255) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  PRIMARY KEY (`id_pengguna`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`id_pengguna`, `nama_lengkap`, `username`, `password`) VALUES
(1, 'T Ghazali', 'admin', '21232f297a57a5a743894a0e4a801fc3'),
(2, 'Code Berkas', 'user', 'ee11cbb19052e40b07aac0ca060c23ee');

-- --------------------------------------------------------

--
-- Table structure for table `rangking`
--

CREATE TABLE IF NOT EXISTS `rangking` (
  `id_alternatif` int(11) NOT NULL,
  `id_kriteria` int(11) NOT NULL,
  `nilai_rangking` double NOT NULL,
  `nilai_normalisasi` double NOT NULL,
  `bobot_normalisasi` double NOT NULL,
  PRIMARY KEY (`id_alternatif`,`id_kriteria`),
  KEY `id_kriteria` (`id_kriteria`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rangking`
--

INSERT INTO `rangking` (`id_alternatif`, `id_kriteria`, `nilai_rangking`, `nilai_normalisasi`, `bobot_normalisasi`) VALUES
(14, 1, 5, 1, 5),
(14, 2, 5, 0.4, 2),
(14, 3, 4, 0.75, 3),
(14, 4, 3, 0.75, 2.25),
(14, 5, 2, 0.66666666666667, 1.3333333333333),
(14, 6, 3, 1, 3),
(14, 7, 5, 1, 5),
(14, 8, 4, 1, 4),
(15, 1, 5, 1, 5),
(15, 2, 4, 0.5, 2.5),
(15, 3, 4, 0.75, 3),
(15, 4, 3, 0.75, 2.25),
(15, 5, 2, 0.66666666666667, 1.3333333333333),
(15, 6, 3, 1, 3),
(15, 7, 5, 1, 5),
(15, 8, 4, 1, 4),
(16, 1, 3, 0.6, 3),
(16, 2, 4, 0.5, 2.5),
(16, 3, 3, 1, 4),
(16, 4, 4, 1, 3),
(16, 5, 3, 1, 2),
(16, 6, 2, 0.66666666666667, 2),
(16, 7, 5, 1, 5),
(16, 8, 5, 0.8, 3.2),
(20, 1, 3, 0.6, 3),
(20, 2, 2, 1, 5);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `rangking`
--
ALTER TABLE `rangking`
  ADD CONSTRAINT `rangking_ibfk_1` FOREIGN KEY (`id_alternatif`) REFERENCES `alternatif` (`id_alternatif`),
  ADD CONSTRAINT `rangking_ibfk_2` FOREIGN KEY (`id_kriteria`) REFERENCES `kriteria` (`id_kriteria`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
